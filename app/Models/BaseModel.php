<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BaseModel
 *
 * @mixin \Eloquent
 */
abstract class BaseModel extends Model
{
    use UuidTrait;

    protected $fillable = [
    ];

    protected $hidden = [
        'id',
    ];
}
