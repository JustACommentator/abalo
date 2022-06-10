<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/articles', [\App\Http\Controllers\AbaloController::class, 'searchAPI']);

Route::post('/articles', [\App\Http\Controllers\AbaloController::class, 'newArticleApi']);
Route::post('/shoppingcart', [\App\Http\Controllers\AbaloController::class, 'shoppingCart']);
Route::delete('/shoppingcart/{shoppingID}/articles/{articleID}', function ($shoppingID, $articleID){
    info('Shoppingid: ' . $shoppingID . ', Articleid: ' . $articleID);

    /** @var \App\Models\ShoppingCartItem $item */
    $item = \App\Models\ShoppingCartItem::query()
        ->where('ab_shoppingcart_id', '=', $shoppingID)
        ->where('ab_article_id', '=', $articleID)->first();
    info('Item:', $item->toArray());
    $item->forceDelete();

});

Route::post('/own-articles', [\App\Http\Controllers\AbaloController::class, 'getOwnArticles']);

Route::post('/articles/{id}/sold', [\App\Http\Controllers\AbaloController::class, 'soldArticle']);

Route::get('/currentShoppingCart', [\App\Http\Controllers\AbaloController::class, 'getCurrentShoppingCart']);

Route::post('add-to-promotion', [\App\Http\Controllers\AbaloController::class, 'addToPromotion']);
