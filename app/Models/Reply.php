<?php

namespace App\Models;

/**
 * @property false|resource|string|null content
 * @property int|null user_id
 * @property mixed topic_id
 * @property mixed topic
 * @property mixed id
 * @property mixed user
 * @property mixed created_at
 * @property mixed updated_at
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
