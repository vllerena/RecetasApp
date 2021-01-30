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

        // DB::table('recetas')->insert([
        //     'titulo' => $data['titulo'],
        //     'preparacion' => $data['preparacion'],
        //     'ingredientes' => $data['ingredientes'],
        //     'imagen' => $imagen_path,
        //     'user_id' => Auth::user()->id,
        //     'categoria_id' => $data['categoria'],
        // ]);

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
}
