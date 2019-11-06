<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'file',
        'file_thumb',
        'file_extension',
        'file_mime',
        'up',
        'down',
        'rating'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User'); // user_id
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postsRatings()
    {
        return $this->hasMany('App\PostRating');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postsReports()
    {
        return $this->hasMany('App\PostReport');
    }



}
