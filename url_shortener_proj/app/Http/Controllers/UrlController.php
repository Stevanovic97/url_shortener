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
        $this->validate($request, [
            'original' => 'required|url'
        ]);

        $short = Str::random(4);
        $detail = Str::random(5);

        while (Url::where('short', '=', $short)->first() != null) {
            $short = Str::random(4);
        }
        while (Url::where('detail', '=', $detail)->first() != null) {
            $detail = Str::random(5);
        }
        $url = Url::create([
            'original' => $request->original,
            'short' => $short,
            'detail' => $detail
        ]);

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

    public function views($id)
    {
        $url = Url::find($id);
        $url->all_views++;
        $url->save();
        return redirect($url->original);
    }

}
