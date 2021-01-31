<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\TipoCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
    }

    public function index()
    {
        $recetas = Auth::user()->recetas;
        return view('recetas.index', compact('recetas'));
    }

    public function create()
    {
        $categorias = TipoCategoria::all();
        return view('recetas.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'titulo' => 'required | min:6',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'imagen' => 'required|image',
            'categoria' => 'required',
        ]);

        $imagen_path = $request['imagen']->store('upload-recetas', 'public');
        $imagen = Image::make(public_path("storage/{$imagen_path}"))->fit(1200, 550);
        $imagen->save();

        Auth::user()->recetas()->create([
            'titulo' => $data['titulo'],
            'preparacion' => $data['preparacion'],
            'ingredientes' => $data['ingredientes'],
            'imagen' => $imagen_path,
            'categoria_id' => $data['categoria'],
        ]);

        return redirect()->route('recetas');
    }

    public function show(Receta $receta)
    {
        return view('recetas.show', compact('receta'));
    }

    public function edit(Receta $receta)
    {
        $categorias = TipoCategoria::all();
        return view('recetas.edit', compact('receta', 'categorias'));
    }

    public function update(Receta $receta, Request $request)
    {

        $this->authorize('update', $receta);

        $data = request()->validate([
            'titulo' => 'required | min:6',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'categoria' => 'required',
        ]);

        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];

        if (request('imagen')) {
            $imagen_path = $request['imagen']->store('upload-recetas', 'public');
            $imagen = Image::make(public_path("storage/{$imagen_path}"))->fit(1200, 550);
            $imagen->save();
            $receta->imagen = $imagen_path;
        }

        $receta->save();

        return redirect()->route('recetas');
    }

    public function destroy(Receta $receta)
    {
        $this->authorize('delete', $receta);

        $receta->delete();

        return redirect()->route('recetas');
    }
}
