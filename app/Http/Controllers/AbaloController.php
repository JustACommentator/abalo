<?php

namespace App\Http\Controllers;

use App\Models\AbArticle;
use App\Models\AbUser;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class AbaloController extends Controller
{
    public function search() {

        $search = $_GET['search'] ?? "";

        $results = AbArticle::query()->where('ab_name', 'ilike', "%$search%")->get();

        return view('searchView', ["search" => $search, "results" => $results]);
    }


    public function searchAPI(Request $request){
        $search = $request->get('searchInput');
        $offset = $request->get('offset');
        if($search){
            $results = AbArticle::query()->where('ab_name', 'ilike', "%$search%")->offset($offset)->get();
        } else{
            $results = AbArticle::query()->offset($offset)->get();
        }

        $limitedResult = collect();
        $results->each(function ($item) use($limitedResult){
            if($limitedResult->count() < 5) {
                $limitedResult->push($item);
            } else {
                return;
            }
        });

        $res = [
            'data_length' => $results->count(),
            'data' => $limitedResult
        ];
        return response()->json($res);
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

        return $hasError  ? response()->json(['Error' => 'Es ist ein Fehler aufgetreten']) : response()->json(['article' => 'Thank you for creating a article']);
    }


    public function shoppingCart(Request $request)
    {
        $id = $request->input("id");

        /** @var AbArticle $article */
        $article = AbArticle::query()->find($id);

        /** @var AbUser $user */
        $user = AbUser::query()->where('ab_name', '=', 'visitor')->first();

        if(Cache::has('shoppingcart_id')){
            $shoppingCart = ShoppingCart::query()->find(Cache::get('shoppingcart_id'));

        } else {
            $shoppingCart = new ShoppingCart();
            $shoppingCart->ab_creator_id = $user->id;
            $shoppingCart->ab_createdate = Carbon::now();
            $shoppingCart->save();
            Cache::put('shoppingcart_id', $shoppingCart->id, 600);
        }

        $shoppingCartItem = ShoppingCartItem::query()
            ->where('ab_shoppingcart_id', '=', $shoppingCart->id)
            ->where('ab_article_id', '=', $article->id)
            ->first();

        if($shoppingCartItem){
            return response()->json();
        } else {
            $shoppingCartItem = new ShoppingCartItem();
            $shoppingCartItem->ab_shoppingcart_id = $shoppingCart->id;
            $shoppingCartItem->ab_article_id = $article->id;
            $shoppingCartItem->ab_createdate = Carbon::now();
            $shoppingCartItem->save();
         }


        return response()->json([
            'id' => $article->id,
            'name' => $article->ab_name,
            'price' => $article->ab_price,
            'shoppingCart' => $shoppingCart->id
        ]);
    }

    public function getCurrentShoppingCart()
    {
        if(Cache::has('shoppingcart_id')) {
            $shoppingCart = Cache::get('shoppingcart_id');

            $shoppingCartItems = ShoppingCartItem::query()->where('ab_shoppingcart_id', '=', Cache::get('shoppingcart_id'))?->get();

            $items = collect();

            $shoppingCartItems?->each(function ($item) use($items){
                $article = AbArticle::query()
                    ->where('id', '=', $item->ab_article_id)
                    ->get();

                if($article){
                    $items->push($article);
                }
            });

            $res = collect([
                'id' => $shoppingCart,
                'items' => $items
            ]);

            return response()->json($res);
        }

        return response()->noContent();
    }
}
