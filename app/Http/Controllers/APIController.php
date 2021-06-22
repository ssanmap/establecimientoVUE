<?php

namespace App\Http\Controllers;

use App\Imagen;
use App\Categoria;
use App\Establecimiento;
use Illuminate\Http\Request;

class APIController extends Controller
{
    //

      // Método para obtener todos los establecimientos
      public function index()
      {
          $establecimientos = Establecimiento::with('categoria')->get();

          return response()->json($establecimientos);
      }


    public function categorias(){

        $categorias =  Categoria::all();

        return response()->json($categorias);

    }
    public function categoria(Categoria $categoria){

        $establecimientos = Establecimiento::where('categoria_id', $categoria->id)->with('categoria')->take(3)->get();
        return response()->json($establecimientos);
    }

    public function establecimientoscategoria( Categoria $categoria )
    {
        $establecimientos = Establecimiento::where('categoria_id', $categoria->id)->with('categoria')->get();
        return response()->json($establecimientos);
    }


    // Muestra un establecimiento en especifico
    public function show( Establecimiento $establecimiento ) {

        // return 'desde el est';
        $imagenes = Imagen::where('id_establecimiento', $establecimiento->uuid)->get();
        $establecimiento->imagenes = $imagenes;

        return response()->json($establecimiento);
    }

}
