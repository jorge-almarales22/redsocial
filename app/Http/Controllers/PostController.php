<?php

namespace App\Http\Controllers;

use App\Img;
use App\Like;
use App\Post;
use App\Video;
use App\Comment;
use App\Compartir;
use App\Events\LikeEvent;
use Illuminate\Support\Str;
use App\Events\CommentEvent;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{
    public function guardar_post(Request $request)
    {
        $user = auth()->user();

        $post = new Post();
        $post->contenido = e($request->contenido_post);
        $user->posts()->save($post);

        if($request->hasFile('img')){

            $path = '/'.date('Y-m-d');
            $fileExt = trim($request->file('img')->getClientOriginalExtension());
            $upload_path = Config::get('filesystems.disks.uploads.root');
            $name = Str::slug(str_replace($fileExt, '', $request->file('img')->getClientOriginalName()));
            $filename = rand(1,999).'-'. $name.'.' .$fileExt;
            $file_file = $upload_path.'/'.$path.'/'.$filename;

            $image = new Img();
            $image->img = $filename;
            $image->file_path = date('Y-m-d');
            $post->images()->save($image);

            $request->img->storeAs($path, $filename, 'uploads');
            $img = Image::make($file_file);
            $img->fit(256,256, function($constraint){
                $constraint->upsize();
            });
            $img->save($upload_path.'/'.$path.'/t_'.$filename);

        }
        
        if($request->hasFile('video')){

            $path = '/'.date('Y-m-d');
            $fileExt = trim($request->file('video')->getClientOriginalExtension());
            $upload_path = Config::get('filesystems.disks.uploads.root');
            $name = Str::slug(str_replace($fileExt, '', $request->file('video')->getClientOriginalName()));
            $filename = rand(1,999).'-'. $name.'.' .$fileExt;

            $video = new Video();
            $video->video = $filename;
            $video->file_path = date('Y-m-d');
            $post->videos()->save($video);

            $request->video->storeAs($path, $filename, 'uploads');

        }
        if($user->save())
        { 
            return back()->with('status', '¡ Su post fue subido con exito !');
        }
    }

    public function getLikePost(Post $post)
    {
        $like = new Like();
        $like->user_id = auth()->user()->id;
        $post->likes()->save($like);
        event(new LikeEvent($like));
        return back()->with('status', 'Diste un like con exito');
    }
    public function getDislikePost(Post $post)
    {
        $like = Like::where('likeable_id', $post->id)->where('user_id', auth()->user()->id);
        $like->delete();
        return back()->with('status', 'se quito el like con exito');
    }
    
    public function postComentarPost(Request $request, Post $post)
    {
        $comentario = new Comment();
        $comentario->contenido = e($request->comentario);
        $comentario->user_id = auth()->user()->id;
        $post->comentarios()->save($comentario);
        event(new CommentEvent($comentario));
        return back()->with('status', 'se subio su comentario con exito');
    }

    public function getVerComentarios(Post $post)
    {
        $posts = Post::where('id', $post->id)
        ->with(['comentarios', 'comentarios.likes', 'comentarios.user','images', 'videos', 'user', 'likes'])
        ->withCount(['likes', 'comentarios','compartirs'])->get();
        $likesUser = Like::where('user_id', auth()->user()->id)->get();
        return view('post.comentarios', compact('posts','likesUser'));
    }

    public function getCompartirPost(Post $post)
    {

        $image = Img::where('imageable_id', $post->id)->first();
        $video = Video::where('videoable_id',$post->id)->first();

        if($image)
        {
            $compartir = new Compartir();
            $compartir->user_id = auth()->user()->id;
            $post->compartirs()->save($compartir);

            $nuevoPost = new Post();
            $nuevoPost->contenido = $post->contenido;
            auth()->user()->posts()->save($nuevoPost);

            $imageCompartida = new Img();
            $imageCompartida->img = $image->img;
            $imageCompartida->file_path = $image->file_path;
            $nuevoPost->images()->save($imageCompartida);
            
        }
        if($video)
        {
            $compartir = new Compartir();
            $compartir->user_id = auth()->user()->id;
            $post->compartirs()->save($compartir);

            $nuevoPost = new Post();
            $nuevoPost->contenido = $post->contenido;
            auth()->user()->posts()->save($nuevoPost);

            $videoCompartido = new Video();
            $videoCompartido->video = $video->video;
            $videoCompartido->file_path = $video->file_path;
            $nuevoPost->videos()->save($videoCompartido);
            
        }
        if(!$video && !$image)
        {
            $compartir = new Compartir();
            $compartir->user_id = auth()->user()->id;
            $post->compartirs()->save($compartir);

            $nuevoPost = new Post();
            $nuevoPost->contenido = $post->contenido;
            auth()->user()->posts()->save($nuevoPost);
        }
        return redirect()->route('home')->with('status', 'se compartio con exito el post');
    }
}
