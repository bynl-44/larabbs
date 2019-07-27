<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed description
 */
class Category extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

}
