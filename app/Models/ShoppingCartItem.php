<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $ab_shoppingcart_id
 * @property $ab_article_id
 * @property $ab_createdate
 */
class ShoppingCartItem extends Model
{
    use HasFactory;

    protected $table = 'ab_shoppingcart_item';
    public $timestamps = false;
}
