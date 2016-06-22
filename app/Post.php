<?php

namespace App;

use App\PostLike;

use App\Comment;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = ['content', 'is_private'];
    protected $hidden = ['password', 'email', 'updated_at'];

    public function user() {

      return $this->belongsTo(User::class);
    }

    public function comments() {

      return $this->hasMany(Comment::class);
    }

    public function likes() {

      return $this->hasMany(PostLike::class);
    }
}
