<?php

namespace App\Http\Controllers;

use App\Models\AbArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbaloController extends Controller
{
    public function search() {

        $search = $_GET['search']??null;
        $results = array();
        if($search != null) {
            $results = DB::table('article_creator as ac')->select(
                'id', 'article_name', 'article_price', 'ab_createdate', 'seller')
                ->where("article_name", "ilike", "%$search%")->get();
        }
        return view('searchView', ["search" => $search, "results" => $results]);
    }
}
