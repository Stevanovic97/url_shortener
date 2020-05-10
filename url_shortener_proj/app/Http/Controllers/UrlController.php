<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'short' => Str::random(7)
        ]);
        $short = $url->short;

        Session::flash('success', 'The short URL was generated successfully!');

        return redirect()->route('urls.details', $short);
    }

    public function details($short)
    {
        $urls = Url::all();
        foreach ($urls as $u) {
            if ($u->short == $short)
                $url = $u;
        }

        if (!isset($url)) {
            return view('errors.' . '500');
        }

        return view('details', compact('url'));
    }

    public function all($id)
    {
        $url = Url::find($id);
        $url->all_views++;
        $url->save();
        return redirect($url->original);
    }

}
