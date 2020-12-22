@extends('layouts.master')

@section('content')
<div class="row mt-2">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @foreach ($posts as $postitem)
        <div class="card shadow rounded">
            <div class="card-body">
                <a href="#" class="text-secondary text-center">{{ $postitem->user->name }} {{ $postitem->user->lastname }}</a>         
                @foreach ($postitem->images as $image)
                    <div class="mt-2 text-center">
                        <img src="{{ asset('/uploads/'.$image->file_path.'/'.$image->img) }}" width="250px">                    
                    </div>
                @endforeach 
                @foreach ($postitem->videos as $video)
                    <div class="mt-2 text-center">
                        <video width="320" height="240" controls loop>
                            <source src="{{ asset('/uploads/'.$video->file_path.'/'.$video->video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                @endforeach
                <div class="mt-2">
                    <p class="p_parrafo">{{ $postitem->contenido }}</p>
                </div>
                <div class="numero_de_reacciones">
                    <div class="numero_de_likes">
                        <i class="fas fa-thumbs-up"></i> {{ $postitem->likes_count }}
                    </div>
                    <div class="numero_de_comen_comp">
                        <a href="{{ route('ver_comentarios', $postitem->id) }}" class="numero_de_comen_comp">{{ $postitem->comentarios_count }} {{ Str::plural('comentario', $postitem->comentarios_count) }}</a> <span>{{ $postitem->compartirs_count }} veces compartido</span> 
                    </div>
                </div>
                <div class="reacciones">
                    <div class="like">
                        @php
                            $contador = 0;
                        @endphp
                        @foreach ($likesUser as $like)
                            @if($like->likeable_id == $postitem->id)
                                @php
                                $contador+=1;
                                @endphp
                            @endif
                        @endforeach
                        @if ($contador != 0)
                        <a href="{{ route('dislike_post',$postitem->id) }}" class="btn_reaccion_active"><i class="fas fa-thumbs-up"></i> Like</a>
                        @else
                        <a href="{{ route('like_post',$postitem->id) }}" class="btn_reaccion"><i class="far fa-thumbs-up"></i> Like</a>
                        @endif
                    </div>
                    <div class="comment">
                        {!! Form::open(['route' => ['comentar_post', $postitem->id]]) !!}
                        <button type="submit"><i class="far fa-comments"></i> Comentar</a></button>
                    </div>
                    <div class="share">
                        <a href="#" class="btn_reaccion"><i class="fas fa-share"></i> Compartir</a>
                    </div>
                </div>
                <div class="form-group">
                        <textarea id="text_area_comentario" name="comentario" rows="2" placeholder="Escriba su comentario y dar clic en comentar" class="form-control"></textarea>
                    {!! Form::close() !!}
                </div>
                @if(is_null($postitem->user->avatar))                 
                    @foreach ($postitem->comentarios as $comentario)      
                    <div class="comentarios">            
                        <img src="{{ url('/img/default_avatar.png') }}" class="img_comentarios">
                        <p class="text-secondary d-inline-block">{{ $comentario->user->name }} {{ $comentario->user->lastname }}</p>
                        <p class="contenido_comentario">{{ $comentario->contenido }}</p>
                    </div>
                    @endforeach
                @else 
                    @foreach ($postitem->comentarios as $comentario)
                    <div class="comentarios">                  
                        <img src="{{ url('/uploads/'.$comentario->user->file_path.'/t_'.$comentario->user->avatar) }}" class="img_comentarios">  
                        <p class="text-secondary d-inline-block">{{ $comentario->user->name }} {{ $comentario->user->lastname }}</p>
                        <p class="contenido_comentario">{{ $comentario->contenido }}</p>
                    </div> 
                    @endforeach            
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div class="col-md-2"></div>
</div>
@endsection