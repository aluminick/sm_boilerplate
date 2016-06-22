<?php

namespace App\Repositories;

use App\User;

use DB;

class PostLikeRepository {

  public function isLiked(User $user, $post_id) {

    return $user->postLikes()
            ->where('user_id', $user->id)
            ->where('post_id', $post_id)
            ->where('status', 1)
            ->first();
  }

  public function exists(User $user, $post_id) {

    return $user->postLikes()
            ->where('user_id', $user->id)
            ->where('post_id', $post_id)
            ->first()['exists'];
  }
}
