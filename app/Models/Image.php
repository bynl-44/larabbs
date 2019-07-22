<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed user_id
 * @property mixed type
 * @property mixed path
 * @property mixed created_at
 * @property mixed updated_at
 */
class Image extends Model
{
    protected $fillable = ['type', 'path',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
