<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** @property int $id */
/** @property string $ab_name */
/** @property int $ab_price */
/** @property string $ab_description */
/** @property int $ab_creator_id */
/** @property Carbon $ab_createdate */
class AbArticle extends BaseModel
{
    use HasFactory;
    protected $table = 'ab_article';
    protected $fillable = [
        'id',
        'ab_name',
        'ab_price',
        'ab_description',
        'ab_creator_id',
        'ab_createdate'
    ];

}
