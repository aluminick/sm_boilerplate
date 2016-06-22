<?php

namespace App\Repositories;

use DB;

class CommentRepository {

  public function findOne ($id) {

    return DB::table('comments')
                ->join('users', 'users.id', '=', 'comments.user_id')
                ->select('comments.id', 'comments.user_id as owner_id', 'users.name as owner_name', 'comments.content')
                ->where('comments.id', $id)
                ->first();

  }

  public function findFive ($post_id) {

    return DB::table('comments')
                ->join('users', 'users.id', '=', 'comments.user_id')
                ->select('comments.id', 'comments.user_id as owner_id', 'users.name as owner_name', 'comments.content')
                ->where('comments.post_id', $post_id)
                ->where('comments.status', 0)
                ->orderBy('comments.created_at', 'desc')
                ->take(5)
                ->get();
  }

  public function nextFive ($post_id, $offset) {
    return DB::table('comments')
                ->join('users', 'users.id', '=', 'comments.user_id')
                ->select('comments.id', 'comments.user_id as owner_id', 'users.name as owner_name', 'comments.content')
                ->where('comments.post_id', $post_id)
                ->where('comments.status', 0)
                ->orderBy('comments.created_at', 'desc')
                ->skip($offset)
                ->take(5)
                ->get();
  }

  public function totalPostComments ($post_id) {

    return DB::table('comments')
              ->where('post_id', $post_id)
              ->where('status', 0)
              ->count();
  }

  public function postComments ($post_id) {

    return DB::table('comments')
              ->where('post_id', $post_id)
              ->orderBy('created_at', 'desc')
              ->get();
  }
}
