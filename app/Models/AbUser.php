<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** @property integer $id */
/** @property string $ab_name */
/** @property string $ab_password */
/** @property string $ab_email */
class AbUser extends BaseModel
{
    use HasFactory;
    protected $table = 'ab_user';
    protected $fillable = [
        'id',
        'ab_name',
        'ab_password',
        'ab_email'
    ];
}
