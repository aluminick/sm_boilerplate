<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use App\Repositories\PostLikeRepository;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     protected $posts, $post_like;

     public function __construct(PostRepository $posts, PostLikeRepository $post_like) {

       $this->middleware('auth');
       $this->posts = $posts;
       $this->post_like = $post_like;
     }


    public function index(Request $request)
    {
        $posts = $this->posts->all($request->user());

        foreach ($posts as $key => $post) {
          $post->is_liked = $this->post_like->isLiked($request->user(), $post->id);
        }
        //dd($posts);
        return view('home', [
          //  'posts' => $this->posts->forUser($request->user())
          'posts' => $posts,
          'comments' => []
        ]);
    }
}
