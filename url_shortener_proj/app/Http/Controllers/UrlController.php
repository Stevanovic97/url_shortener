<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;
use App\Visitor;
use Hash;


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
        return redirect()->route('urls.details', $url);
    }

    public function details($id)
    {
        $url = Url::find($id);
        return view('details', compact('url'));
    }

    public function views(Request $request, $id)
    {
        $url = Url::find($id);

        $visitors = Visitor::all();
        if ($visitors->isEmpty()) {
            $visitor = Visitor::create([
                'ip_address' => $request->ip(),
                'url' => $url->short
            ]);
            $url->unique_views++;
        }
//        foreach ($visitors as $visitor) {
//            if ($request->ip() == $visitor->ip_address) {
//                $v = DB::table('visitors')->where('ip_address', $visitor->ip_address)->get();
//            }
//        }
//        dd($v[0]->url);
//        if ($v[0]->url != $url->short) {
//            $visitor = Visitor::create([
//                'ip_address' => $request->ip(),
//                'url' => $url->short
//            ]);
//            $url->unique_views++;
//        }

        $url->all_views++;
        $url->save();
        return redirect($url->original);
    }


//    public function all($id)
//    {
//        $url = Url::find($id);
//        $url->all_views++;
//        $url->save();
//        return redirect($url->original);
////        $all_views = $url->all_views;
////        return json_encode(compact('all_views'));
//    }

}
