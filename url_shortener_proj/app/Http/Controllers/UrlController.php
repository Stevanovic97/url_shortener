<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;
use Str;
use App\Visitor;
use Hash;
use Session;
use Illuminate\Support\Facades\Cookie;


class UrlController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'original' => 'required|url'
        ]);

        do {
            $short = Str::random(4);
        } while (Url::where('short', '=', $short)->first() != null);

        do {
            $detail = Str::random(5);
        } while (Url::where('detail', '=', $detail)->first() != null);

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

        $visitor = Visitor::where([['cookie', '=', $cookie], ['url', '=', $url->short]]);

        if (!($visitor->exists())) {
            $visitor = Visitor::create([
                'url' => $url->short,
                'cookie' => $cookie
            ]);
            $url->unique_views++;
        }

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
}
