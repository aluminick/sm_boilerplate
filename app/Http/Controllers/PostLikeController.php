<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PostLike;
use App\Repositories\PostLikeRepository;
use DB;

use App\Http\Requests;

class PostLikeController extends Controller
{

    protected $post_like;

    public function __construct(PostLikeRepository $post_like) {
      $this->post_like = $post_like;
    }
    public function store(Request $request) {

      //TODO: check if post_id & user_id exists in
      if ($this->post_like->exists($request->user(), $request->post)) {
        return $this->update($request);
      } else {
        $data = $request->user()->postLikes()->create([
          'post_id' => $request->post,
          'status' => 1
        ]);
      }

      return response()
              ->json([],
              200);
    }

    public function update(Request $request) {

      $request->user()->postLikes()
              ->where('post_id', $request->post)
              ->update(['status' => DB::raw('!status')]);
      return response()
              ->json([], 200);
    }
}
