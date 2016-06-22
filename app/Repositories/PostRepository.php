<?php

namespace App\Repositories;

use App\User;

use DB;

class PostRepository {

  public function forUser(User $user) {

    return $user->posts()
                ->join('users', function ($join) {
                  $join->on('posts.user_id', '=', 'users.id');
                })
                ->select('posts.id', 'posts.user_id as owner_id', 'posts.content', 'posts.is_private', 'posts.status', 'users.name as owner_name')
                ->orderBy('posts.created_at', 'desc')
                ->get();
  }

  public function all(User $user) {
    return DB::table('posts')
                ->join('users', function ($join) {
                  $join->on('posts.user_id', '=', 'users.id');
                })
                ->select('posts.id', 'posts.user_id as owner_id', 'posts.content', 'posts.is_private', 'posts.status', 'users.name as owner_name')
                ->where(function ($query) {
                  $query->where('posts.status', '>=', 0);
                })
                ->where(function($query) use ($user) {
                  $query->where('posts.user_id', $user->id)
                        ->orWhere('posts.is_private', 0);
                })
                ->orderBy('posts.created_at', 'desc')
                ->get();
  }

  public function findOne($id) {
    return DB::table('posts')
                ->join('users', function ($join) {
                  $join->on('posts.user_id', '=', 'users.id');
                })
                ->select('posts.id', 'posts.user_id as owner_id', 'posts.content', 'posts.is_private', 'posts.status', 'users.name as owner_name')
                ->where('posts.id', $id)
                ->first();
  }

}
