<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'user_id',
        'post_id',
        'text',
        'parent_id',
        'active'

    ];
    //
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function replies()
    {
        return $this->hasMany('App\Comment', 'parent_id', 'id');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commentsReports()
    {
        return $this->hasMany('App\CommentReport');
    }

    public function commentsFiles()
    {
        return $this->hasOne('App\CommentFile');
    }
}

