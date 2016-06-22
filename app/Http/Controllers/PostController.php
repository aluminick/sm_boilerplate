<?php

namespace App\Http\Controllers;

use App\Post;

use Validator;

use App\Repositories\PostRepository;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

class PostController extends Controller
{
    //
    protected $posts;

    public function __construct(PostRepository $posts) {

      $this->middleware('auth');
      $this->posts = $posts;
    }

    public function index(Request $request) {
      dd($this->posts->all($request->user()));
    }

    public function store(Request $request) {

      $validator = Validator::make($request->all(), [
        'content' => 'required|max:255',
        'is_private' => 'required'
      ]);

      if ($validator->fails()) {
        return response()
                ->json([
                  'html' => view('common.errors', ['errors' => $validator->errors()])->render()
                ], 422);
      } else {

        $data = $request->user()->posts()->create([
          'content' => $request->content,
          'is_private' => (int)$request->is_private
        ]);

        $post = $this->posts->findOne($data->id);
        $post->is_liked = 0;
        
        return response()
                ->json([
                  'html' => view('posts.components.post', ['post' => $post, 'comments' => []])->render()
                ], 200);
      }


    }

    public function update(Request $request, Post $post) {
      $this->authorize('update', $post);

      $validator = Validator::make($request->all(), [
        'content' => 'required|max:255',
        'is_private' => 'required'
      ]);

      if ($validator->fails()) {
        return response()
                ->json([
                  'html' => view('posts.components.post.error', ['errors' => $validator->errors()])->render()
                ], 422);
      }

      $post->content = $request->content;
      $post->is_private = $request->is_private;

      $post->save();

      return response()
              ->json();
    }

    public function destroy(Request $request, Post $post) {
      $this->authorize('update', $post);

      $post->status = -1;
      $post->save();

      return response()
              ->json();
    }
}
