<?php

namespace App\Http\Controllers;

use App\Models\AbArticle;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AbaloController extends Controller
{
    public function search() {

        $search = $_GET['search'] ?? "";
        $results = DB::table('article_creator as ac')->select(
            'id', 'article_name', 'article_price', 'ab_createdate', 'seller')
            ->where("article_name", "ilike", "%$search%")->get();
        return view('searchView', ["search" => $search, "results" => $results]);
    }

    public function newArticle(Request $request){


        $name = $request->input('name') ?? null;
        $preis = $request->input('preis') ?? null;
        $beschreibung = $request->input('preis') ?? null;

        $hasError = false;
        if($name && $preis && $preis > 0){
            $article = new AbArticle();
            $article->ab_name = $name;
            $article->ab_price = $preis;
            $article->ab_description = $beschreibung;
            $article->ab_createdate = Carbon::now()->toDateString();
            $article->ab_creator_id = 1;
            $article->save();
            $hasError = ! $article->save();
        }

        $message =  $hasError ? "Es ist ein Fehler aufgetreten" : "Erfolgreich";

        return response()->json(["message" => $message]);
    }

    public function newArticleApi(Request $request)
    {
        $name = $request->input('name') ?? null;
        $preis = $request->input('preis') ?? null;
        $beschreibung = $request->input('preis') ?? null;

        $hasError = false;

        $article = null;
        if($name && $preis && $preis > 0){
            $article = new AbArticle();
            $article->ab_name = $name;
            $article->ab_price = $preis;
            $article->ab_description = $beschreibung;
            $article->ab_createdate = Carbon::now()->toDateString();
            $article->ab_creator_id = 1;
            $hasError = ! $article->save();
        }

        return $hasError  ? response()->json(['Error' => 'Es ist ein Fehler aufgetreten']) : response()->json(['id' => $article?->id]);
    }
}
