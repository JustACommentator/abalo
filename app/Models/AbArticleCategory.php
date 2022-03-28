<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/** @property int $id */
/** @property string $ab_name */
/** @property string|null $ab_description */
/** @property int|null $ab_parent */
class AbArticleCategory extends BaseModel
{
    use HasFactory;
    protected $table = 'ab_articlecategory';
    protected $fillable = [
        'id',
        'ab_name',
        'ab_description',
        'ab_parent'
    ];
}
