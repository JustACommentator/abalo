<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $ab_creator_id
 * @property $ab_createdate
 */
class ShoppingCart extends Model
{
    use HasFactory;

    protected $table = 'ab_shoppingcart';
    public $timestamps = false;
}
