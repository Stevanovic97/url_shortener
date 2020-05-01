<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;
use Str;

class UrlController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, ['original' => 'required|url']);
        $url = new Url;
        $url->original = $request->original;
        $url->short = Str::random(7);
        $url->all_views = 0;
        $url->unique_views = 0;
        $url->save();
        return redirect()->route('urls.details', $url);
        //  return view('details', compact('url'));
    }

    public function details($id)
    {
        $url = Url::find($id);
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
