<?php

namespace App;

use App\Post;

use App\CommentLike;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['content'];

    public function user() {

      return $this->belongsTo(User::class);
    }

    public function post() {

      return $this->belongsTo(Post::class);
    }

    public function likes() {

      return $this->hasMany(CommentLike::class);
    }
}
