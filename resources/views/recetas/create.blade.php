@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css" integrity="sha512-CWdvnJD7uGtuypLLe5rLU3eUAkbzBR3Bm1SFPEaRfvXXI2v2H5Y0057EMTzNuGGRIznt8+128QIDQ8RqmHbAdg==" crossorigin="anonymous" />
@endsection

@section('botones')
    <a href="{{route('recetas')}}" class="btn btn-primary mr-2 text-white"> Regresar</a>
@endsection

@section('content')
    <h2 class="text-center mb-5"> Crear nueva recetas</h2>
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <form action="{{route('recetas.store')}}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="form-group">
                    <label for="titulo"> Título Receta</label>
                    <input type="text"
                    name="titulo"
                    class="form-control @error('titulo') is-invalid @enderror"
                    id="titulo"
                    placeholder="Título de la Receta"
                    value="{{old('titulo')}}">
                    @error('titulo')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="categoria"> Categoría</label>
                    <select name="categoria" id="categoria" class="form-control @error('categoria') is-invalid @enderror">
                    <option value="">-- Selecciona una categoría --</option>
                    @foreach ($categorias as $c)
                        <option value="{{$c->id}}" {{old('categoria') == $c->id ? 'selected' : ''}}>{{$c->nombre}}</option>
                    @endforeach
                    </select>
                    @error('categoria')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="preparacion"> Preparación</label>
                    <input type="hidden" id="preparacion" name="preparacion" value="{{old('preparacion')}}">
                    <trix-editor input="preparacion" class="form-control @error('preparacion') is-invalid @enderror"></trix-editor>
                    @error('preparacion')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ingredientes"> Ingredientes</label>
                    <input type="hidden" id="ingredientes" name="ingredientes" value="{{old('ingredientes')}}">
                    <trix-editor input="ingredientes" class="form-control @error('ingredientes') is-invalid @enderror"></trix-editor>
                    @error('ingredientes')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="imagen">Selecciona la Imagen</label>
                    <input type="file" id="imagen" name="imagen" class="form-control @error('imagen') is-invalid @enderror">
                    @error('imagen')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js" integrity="sha512-/1nVu72YEESEbcmhE/EvjH/RxTg62EKvYWLG3NdeZibTCuEtW5M4z3aypcvsoZw03FAopi94y04GhuqRU9p+CQ==" crossorigin="anonymous" defer></script>
@endsection
