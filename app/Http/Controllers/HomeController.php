<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::with(['images', 'videos', 'user', 'comentarios', 'likes'])->withCount(['likes', 'comentarios','compartirs'])->orderBy('id', 'DESC')->get();
        $likesUser = Like::where('user_id', auth()->user()->id)->get();
        return view('home', compact('posts','likesUser'));
    }
}
