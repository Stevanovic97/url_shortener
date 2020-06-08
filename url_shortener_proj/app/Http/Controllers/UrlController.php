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

        $guestCookie = Cookie::has('guest') ? Cookie::get('guest') : Cookie::queue('guest', rand() . rand(), 1000000);

        return view('details')->withUrl($url)->withGusetcookie($guestCookie);
    }


    public function views($id, Request $request)
    {
        $url = Url::find($id);
        $url = $this->urlValidate($request, $url);
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

    public function urlValidate(Request $request, $url)
    {
        if (!isset($url)) {
            $short = substr($request->getRequestUri(), 1, strlen($request->getRequestUri()) - 1);
            $urlcheck = Url::whereShort($short)->first();
            if ($urlcheck != null) {
                return $urlcheck;
            } else {
                abort(404);
            }
        }
        return $url;
    }

    public function cookieValidate(Request $request)
    {
        $cookie = $request->cookie('guest');

        if (!isset($cookie)) {
            $cookie = Cookie::queue('guest', rand() . rand(), 1000000);
        }

        return $cookie;
    }
}
