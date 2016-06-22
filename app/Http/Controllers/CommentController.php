<?php

namespace App\Http\Controllers;

use Validator;

use App\Comment;

use App\Repositories\CommentRepository;
use App\Repositories\CommentLikeRepository;

use Illuminate\Http\Request;

use App\Http\Requests;

class CommentController extends Controller
{
    protected $comments, $comment_like;

    public function __construct(CommentRepository $comments, CommentLikeRepository $comment_like) {

      $this->comments = $comments;
      $this->comment_like = $comment_like;
      $this->middleware('auth');

    }

    public function store(Request $request) {

      $validator = Validator::make($request->all(), [
        'comment' => 'required|max:255',
        'post_id' => 'required'
      ]);

      if ($validator->fails()) {
        return response()
                ->json([
                  'html' => view('common.errors', ['errors' => $validator->errors()])->render()
                ], 422);
      } else {

        $data = $request->user()->comments()->create([
          'post_id' => $request->post_id,
          'content' => $request->comment
        ]);

        return response()
                ->json([
                  'html' => view('posts.components.comments.components.comment', ['comment' => $this->comments->findOne($data->id)])->render()
                ], 200);
      }

    }

    public function update(Request $request, Comment $comment) {
      $this->authorize('update', $comment);

      $validator = Validator::make($request->all(), [
        'post_id' => 'required',
        'comment' => 'required|max:255'
      ]);

      if ($validator->fails()) {
        return response()
                ->json([
                  'html' => view('common.errors', ['errors' => $validator->errors()])->render()
                ], 422);
      } else {

        $comment->content = $request->comment;

        $comment->save();

        return response()
                ->json();
      }

    }

    public function destroy (Request $request, Comment $comment) {
      $this->authorize('update', $comment);

      $comment->status = -1;
      $comment->save();

      return response()
                ->json();
    }

    public function findOne(Request $request) {
      //return View::make('posts.components.comments.components.comment', ['comment' => $this->comments->findOne($request->comment)]);
      dd($this->comments->findOne($request->comment));
    }

    public function findFive(Request $request) {
      //dd($this->comments->findFive($request->post));
      $totalComments = $this->comments->totalPostComments($request->post);
      $offset = ($totalComments > 5)? 5:0;
      $comments = $this->comments->findFive($request->post);

      foreach ($comments as $comment) {
        $comment->is_liked = $this->comment_like->isLiked($request->user(), $comment->id);
        $comment->is_unliked = $this->comment_like->isUnLiked($request->user(), $comment->id);
      }
      //dd($comments);
      return response()
              ->json([
                'html' => view('posts.components.comments.components.comment.list', [
                  'comments' => $comments,
                  'offset' => $offset
                  ])->render()
              ], 200);
    }

    public function nextFive(Request $request) {
      $totalComments = $this->comments->totalPostComments($request->post);
      $offset = ($totalComments > $request->offset+5)? $request->offset+5: 0;
      $comments = $this->comments->nextFive($request->post, $request->offset);

      foreach ($comments as $comment) {
        $comment->is_liked = $this->comment_like->isLiked($request->user(), $comment->id);
        $comment->is_unliked = $this->comment_like->isUnLiked($request->user(), $comment->id);
      }
      return response()
              ->json([
                'html' => view('posts.components.comments.components.comment.list', [
                  'comments' => $comments,
                  'offset' => $offset
                ])->render(),
                'post' => $request->post,
                'offset'=> $offset
              ], 200);
    }

    public function postComments(Request $request) {
      dd($this->comments->postComments($request->post));
      return $this->comments->postComments($request->post);
    }
}
