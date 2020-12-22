@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-md-4">
        {!! Form::model($user, ['route' => ['editar_perfil'], 'method' => 'POST', 'files' => true]) !!}
        <div class="card shadow rounded">
            <div class="card-body">
                <h4 class="text-center mb-1">Información Almacenada</h4>
                <hr>
                @if(is_null($user->avatar))
                <div align="center">
                <img src="{{ url('/img/default_avatar.png') }}" width="100" height="100">
                </div>
                <p class="text-center"><small>Imagen por defecto</small></p>
                @else
                <img src="{{ url('/uploads/'.$user->file_path.'/t_'.$user->avatar) }}" class="img_perfil">
                @endif
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}">
                    @error('name')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
                </div>
                <div class="form-group">
                    <label for="lastname">Apellido</label>
                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ $user->lastname }}">
                     @error('lastname')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
                </div>
                 <div class="form-group">
                    <label for="email">Corre Electrónico</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                    </div>
                    <div class="custom-file">
                      <input name="avatar" type="file" class="custom-file-input @error('avatar') is-invalid @enderror" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                      <label class="custom-file-label" for="inputGroupFile01"><i class="fas fa-camera"></i> Buscar Imagen</label>
                    </div>
                    @error('avatar')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button class="btn btn-dark btn-lg btn-block font-weight-bold">
                        <i class="far fa-save"></i> Editar Informacion</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-md-8">
        <div class="card shadow rounded">
            <div class="card-body">
                <h4 class=" display-4 text-center">Terminos y condiciones</h4>
                <p class="card-text text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo maiores nihil eveniet. Totam autem aliquid blanditiis voluptate ipsum, excepturi possimus. Saepe maiores obcaecati eaque voluptatem vitae ipsam fugiat facilis ad!
                Doloremque unde quidem repellendus placeat animi voluptatum suscipit, expedita eos mollitia est rem error dolor. Ab nihil a corrupti qui id incidunt quisquam reiciendis! Itaque rem commodi necessitatibus est asperiores?
                Optio aliquam nihil aspernatur? Totam hic aliquid magnam est assumenda quo architecto quam veniam voluptatem necessitatibus, expedita iure voluptates cum! Atque deleniti rem ex assumenda, expedita harum magnam ducimus itaque!
                Voluptate ex non minima saepe dolores consequuntur consequatur illum dicta voluptatum nemo facere vero molestias voluptates veniam qui adipisci sequi, porro vitae eius ab tempore dolorum ea ipsam. Iusto, ipsum?</p>
                <br>
                <h2 class="">Politicas</h2>
                <p class="card-text text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo maiores nihil eveniet. Totam autem aliquid blanditiis voluptate ipsum, excepturi possimus. Saepe maiores obcaecati eaque voluptatem vitae ipsam fugiat facilis ad!
                    Doloremque unde quidem repellendus placeat animi voluptatum suscipit, expedita eos mollitia est rem error dolor. Ab nihil a corrupti qui id incidunt quisquam reiciendis! Itaque rem commodi necessitatibus est asperiores?
                    Optio aliquam nihil aspernatur? Totam hic aliquid magnam est assumenda quo architecto quam veniam voluptatem necessitatibus,
                </p>
            </div>
        </div>
    </div>
</div>
@endsection