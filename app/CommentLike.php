<?php

namespace App;

use App\Comment;

use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
  protected $fillable = ['comment_id', 'status'];

  public function user() {

    return $this->belongsTo(User::class);
  }

  public function comment() {

    return $this->belongsTo(Comment::class);
  }
}
