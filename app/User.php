<?php

namespace App;

use App\Post;
use App\PostLike;
use App\CommentLike;
use App\Comment;
use App\Friend;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts() {

      return $this->hasMany(Post::class);
    }

    public function postLikes() {

      return $this->hasMany(postLike::class);
    }

    public function comments() {

      return $this->hasMany(Comment::class);
    }

    public function commentLikes() {

      return $this->hasMany(CommentLike::class);
    }
    
    public function friends() {

      return $this->hasMany(Friend::class);
    }
}
