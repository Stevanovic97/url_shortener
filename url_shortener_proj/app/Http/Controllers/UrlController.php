<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;
use Str;

class UrlController extends Controller
{
    public function index()
    {
        return view('urls.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, ['original' => 'required|url']);
        $url = new Url;
        $url->original = $request->original;
        $url->short = Str::random(7);
        $url->save();
        return redirect()->route('urls.details', $url->id);
    }

    public function details($id)
    {
        $url = Url::find($id);
        return view('details')->withUrl($url);
    }
}
