<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentReport extends Model
{
    //
    protected $fillable = [
        'id',
        'comment_id',
        'user_id',

    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->belongsTo('App\Comment');
    }
}
