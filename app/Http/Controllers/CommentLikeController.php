<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\CommentLikeRepository;

use App\Http\Requests;

class CommentLikeController extends Controller
{

    protected $comment_like;

    public function __construct(CommentLikeRepository $comment_like) {

      $this->comment_like = $comment_like;
    }

    public function store(Request $request) {

      //TODO: check if comment_id & user_id exists

      if ($this->comment_like->exists($request->user(), $request->comment)) {
        return $this->update($request);
      } else {
        $request->user()->commentLikes()->create([
          'comment_id' => $request->comment,
          'status' => ($request->action == 'like')? 1: -1
        ]);
      }
      return response()
              ->json([], 200);
    }

    public function update(Request $request) {

      $status = 0;
      if ($request->action == 'like') {
        $status = 1;
      } else if ($request->action == 'unlike') {
        $status = -1;
      }

      $request->user()->commentLikes()
              ->where('comment_id', $request->comment)
              ->update(['status' => $status]);

      return response()
              ->json([], 200);
    }
}
