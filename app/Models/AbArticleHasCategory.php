<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** @property int $id */
/** @property int $ab_articlecategory_id */
/** @property int $ab_article_id */

class AbArticleHasCategory extends BaseModel
{
    use HasFactory;
    protected $table = 'ab_article_has_articlecategory';
    protected $fillable = [
        'id',
        'ab_articlecategory_id',
        'ab_article_id'
    ];
}
