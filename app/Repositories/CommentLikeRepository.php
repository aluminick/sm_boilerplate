<?php

namespace App\Repositories;

use App\User;

use DB;

class CommentLikeRepository {

  public function isLiked(User $user, $comment_id) {

    return $user->commentLikes()
            ->where('user_id', $user->id)
            ->where('comment_id', $comment_id)
            ->where('status', 1)
            ->first();
  }

  public function isUnLiked(User $user, $comment_id) {

    return $user->commentLikes()
            ->where('user_id', $user->id)
            ->where('comment_id', $comment_id)
            ->where('status', -1)
            ->first();
  }

  public function exists(User $user, $comment_id) {

    return $user->commentLikes()
            ->where('user_id', $user->id)
            ->where('comment_id', $comment_id)
            ->first()['exists'];
  }
}
