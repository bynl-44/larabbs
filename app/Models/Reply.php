<?php

namespace App\Models;

/**
 * @property false|resource|string|null content
 * @property int|null user_id
 * @property mixed topic_id
 * @property mixed topic
 */
class Reply extends Model
{
    protected $fillable = ['content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
