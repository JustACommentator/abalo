<?php

namespace App\Http\Controllers;

use App\Models\AbArticle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AbaloController extends Controller
{
    public function search() {

        $search = $_GET['search'] ?? null;
        $results = array();
        if($search != null) {
                $results = DB::table('article_creator as ac')->select(
                    'id', 'article_name', 'article_price', 'ab_createdate', 'seller')
                    ->where("article_name", "ilike", "%$search%")->get();
        }
        return view('searchView', ["search" => $search, "results" => $results]);
    }

    public function newArticle(){

        $name = $_POST['name'] ?? null;
        $preis = $_POST["preis"] ?? null;
        $beschreibung = $_POST["beschreibung"] ?? null;
        Log::info("", [$name, $preis]);
        $error = null;
        if($name && $preis && $preis > 0){
            $article = new AbArticle();
            $article->ab_name = $name;
            $article->ab_price = $preis;
            $article->ab_description = $beschreibung;
            $article->ab_createdate = Carbon::now()->toDateString();
            $article->ab_creator_id = 1;
            $article->save();
        }

        return view('newArticle', ['error' => $error ?? null]);
    }
}
