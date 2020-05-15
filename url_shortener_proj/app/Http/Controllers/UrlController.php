<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;
use Str;
use App\Visitor;
use Hash;
use Session;


class UrlController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'original' => 'required|url'
        ]);
        $url = Url::create([
            'original' => $request->original,
            'short' => Str::random(5)
        ]);
        $short = $url->short;


        Session::flash('success', 'The short URL was generated successfully!');

        return redirect()->route('urls.details', compact('short'));
    }

    public function details($short)
    {
        $url = Url::whereShort($short)->first();
        if (!isset($url)) {
            abort(404);
        }

        $myurl = route('urls.details', $short);

        return view('details')->withUrl($url)->withMyurl($myurl);
    }
//
//    public function all($id)
//    {
//        $url = Url::find($id);
//        $url->all_views++;
//        $url->save();
//        return redirect($url->original);
//    }

}
