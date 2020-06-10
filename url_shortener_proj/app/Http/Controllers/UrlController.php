<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Url;
use Illuminate\Http\Request;
use Str;
use App\Visitor;
use Hash;
use Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;


class UrlController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'original' => 'required|url'
        ]);

        $short = $this->generateShort();
        $detail = $this->generateDetail();

        if (isset($request->email)) {
            $this->validate($request, ['email' => 'email']);
            Mail::to($request->email)->send(new SendMail($short, $detail));
        }

        $url = Url::create(['original' => $request->original,
            'short' => $short,
            'detail' => $detail]);

        Session::flash('success', 'The short URL was generated successfully!');

        return redirect()->route('urls.details', compact('detail'));
    }

    public function details($detail)
    {
        $url = Url::whereDetail($detail)->first();
        if (!isset($url)) {
            abort(404);
        }

        return view('details')->withUrl($url);
    }

    public function views($short, Request $request)
    {
        $url = Url::whereShort($short)->first();
        $cookie = $this->cookieValidate($request);

        $this->visitorCheckMake($cookie, $url);

        $url->all_views++;
        $url->save();
        return redirect($url->original);
    }

    private function cookieValidate(Request $request)
    {
        $cookie = $request->cookie('guest');

        $cookieExpMinutes = 1000000;
        $cookieVal = rand() . rand();

        if (!isset($cookie)) {
            Cookie::queue('guest', $cookieVal, $cookieExpMinutes);
            return $cookieVal;
        }

        return $cookie;
    }

    private function generateShort()
    {
        do {
            $short = Str::random(4);
        } while (Url::where('short', '=', $short)->first() != null);

        return $short;
    }

    private function generateDetail()
    {
        do {
            $detail = Str::random(5);
        } while (Url::where('detail', '=', $detail)->first() != null);

        return $detail;
    }

    private function visitorCheckMake($cookie, $url)
    {
        $visitor = Visitor::where([['cookie', '=', $cookie], ['url', '=', $url->short]]);

        if (!($visitor->exists())) {
            $visitor = Visitor::create([
                'url' => $url->short,
                'cookie' => $cookie
            ]);
            $url->unique_views++;
        }
    }
}
