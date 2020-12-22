@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-6 d-flex">
        {!! Form::open(['route' => ['guardar_post'], 'files' => true]) !!}
            <div class="card shadow rounded flex-fill">
                <div class="card-body">
                    <h3 class="text-center text-secondary">¿Qué estás pensando, {{ auth()->user()->name }}?</h3>
                    <div class="form-group">
                        <textarea name="contenido_post" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="custom-file mr-2">
                            {!! Form::file('video', ['class' => 'custom-file-input', 'id'=> 'customFile', 'accept' => 'video/*']) !!}
                            <label class="custom-file-label" for="customFile"><i class="fas fa-video"></i> video</label> 
                        </div>
                        <div class="custom-file">
                            {!! Form::file('img', ['class' => 'custom-file-input', 'id'=> 'customFile', 'accept' => 'image/*']) !!}
                            <label class="custom-file-label" for="customFile"><i class="fas fa-camera"></i> Foto</label> 
                        </div>
                    </div>
                    <button class="btn btn_color btn-lg btn-block">Crear Publicación</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    <div class="col-md-4 d-flex">
        <div class="card shadow rounded flex-fill">
            <div class="card-body">
                <h3 class="h3_publicidad">Publicidad</h3>
                <div class="publicidad">
                    <div class="imagen_publicidad">
                        <a href="https://www.mercedes-benz.com/en/" target="_blank"><img src="/img/mercedes.png" class="img_publicidad"></a>
                    </div>
                    <div class="texto_publicidad">
                        <p>Siente el prestigio de nuestros autos, ven a nuestras oficinas. Lo mejor o nada</p>
                    </div>
                </div>
                <div class="publicidad">
                    <div class="imagen_publicidad">
                        <a href="https://www.toyota.com.co/" target="_blank"><img src="/img/toyota.png" class="img_publicidad"></a>
                    </div>
                    <div class="texto_publicidad">
                        <p>! Carros todo terreno para ti ! Pon en marcha tu imposible</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>
@foreach ($posts as $postitem)
<div class="row mt-2">
    <div class="col-md-1"></div>
    <div class="col-md-6 d-flex">
        <div class="card shadow rounded flex-fill">
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
                        <a href="{{ route('compartir_post', $postitem->id) }}" class="btn_reaccion"><i class="fas fa-share"></i> Compartir</a>
                    </div>
                </div>
                <div class="form-group">
                        <textarea id="text_area_comentario" name="comentario" rows="2" placeholder="Escriba su comentario y dar clic en comentar" class="form-control"></textarea>
                    {!! Form::close() !!}
                </div>     
            </div>
        </div>
    </div>
    <div class="col-md-4 d-flex">
        <div class="card shadow rounded flex-fill">
            <div class="card-body">
                @if ($postitem->user->id != auth()->user()->id)
                    <h3 class="text-center text-secondary">Perfil de tu amigo</h3>
                @else
                    <h3 class="text-center text-secondary">Tu Perfil</h3>
                @endif
                @if(is_null($postitem->user->avatar))
                <div align="center">
                <img src="{{ url('/img/default_avatar.png') }}" width="100" height="100">
                </div>
                <p class="text-center"><small>Imagen por defecto</small></p>
                @else
                <div align="center">
                <img src="{{ url('/uploads/'.$postitem->user->file_path.'/t_'.$postitem->user->avatar) }}" width="17%" class="img-circle elevation-2">
                </div>
                @endif
                <p><strong>Nombre: </strong>{{ $postitem->user->name }}</p>
                <p><strong>Apellido: </strong>{{ $postitem->user->lastname }}</p>
                <p><strong>Correo Electrónico: </strong>{{ $postitem->user->email }}</p>
                <p><strong>! Hace cuanto se unio a la comunidad !: </strong>{{ $postitem->user->created_at->diffForHumans() }}</p> 
            </div>
        </div>       
    </div>
    <div class="col-md-1"></div>
</div>
@endforeach 
@endsection

