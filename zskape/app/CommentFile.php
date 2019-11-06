<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentFile extends Model
{
    //

    public $timestamps = false;

    protected $fillable = [
        'comment_id',
        'file',
        'file_thumb',
        'file_mime',
        'file_extension'
    ];

    public function comments()
    {
        return $this->belongsTo('App\Comment');
    }
}
