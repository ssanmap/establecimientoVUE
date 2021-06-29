<?php

namespace App\Http\Controllers;

use App\Imagen;
use App\Categoria;
use App\Establecimiento;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class EstablecimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categorias = Categoria::all();
        return view('establecimientos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
         // // Validación

         $data = $request->validate([
            'nombre' => 'required',
            // 'categoria_id' => 'required|exists:App\Categoria,id',
            'imagen_principal' => 'required|image|max:1000',
            'direccion' => 'required',
            'comuna' => 'required',
            'telefono' => 'required|numeric',
            'descripcion' => 'required|min:50',
            'apertura' => 'date_format:H:i',
            'cierre' => 'date_format:H:i|after:apertura',
            'uuid' => 'required|uuid'
        ]);

        // Guardar la imagen
        $ruta_imagen = $request['imagen_principal']->store('principales', 'public');

        // Resize a la imagen
        $img = Image::make( public_path("storage/{$ruta_imagen}") )->fit(800, 600);
        $img->save();
        $cat = $request['categoria_id'];

        $lat = $request['lat'];
        $lng = $request['lng'];
        $establecimiento = new Establecimiento($data);
        // dd($establecimiento);
        $establecimiento->imagen_principal = $ruta_imagen;
        $establecimiento->categoria_id = $cat;

        $establecimiento->lat = $lat;
        $establecimiento->lng = $lng;
        $establecimiento->user_id = auth()->user()->id;
        $establecimiento->save();



        return back()->with('estado', 'Tu información se almacenó correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Establecimiento $establecimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Establecimiento $establecimiento)
    {
        //consultar las categorias
        $categorias = Categoria::all();
        // obtener el establecimiento
        $establecimiento = auth()->user()->establecimiento;
        $establecimiento->apertura = date('H:i', strtotime($establecimiento->apertura) );
        $establecimiento->cierre = date('H:i', strtotime($establecimiento->cierre) );

        // Obtiene las imagenes del establecimiento
        $imagenes = Imagen::where('id_establecimiento', $establecimiento->uuid)->get();

        return view('establecimientos.edit', compact('categorias', 'establecimiento', 'imagenes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Establecimiento $establecimiento)
    {
        //

        // Ejecutar el policy
        // $this->authorize('update', $establecimiento );


        //
        $data = $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required|exists:App\Categoria,id',
            'imagen_principal' => 'image|max:1000',
            'direccion' => 'required',
            'comuna' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'telefono' => 'required|numeric',
            'descripcion' => 'required|min:50',
            'apertura' => 'date_format:H:i',
            'cierre' => 'date_format:H:i|after:apertura',
            'uuid' => 'required|uuid'
        ]);


        $establecimiento->nombre = $data['nombre'];
        $establecimiento->categoria_id = $data['categoria_id'];
        $establecimiento->direccion = $data['direccion'];
        $establecimiento->comuna = $data['comuna'];
        $establecimiento->lat = $data['lat'];
        $establecimiento->lng = $data['lng'];
        $establecimiento->telefono = $data['telefono'];
        $establecimiento->descripcion = $data['descripcion'];
        $establecimiento->apertura = $data['apertura'];
        $establecimiento->cierre = $data['cierre'];
        $establecimiento->uuid = $data['uuid'];

        // Si el usuario sube una imagen
        if(request('imagen_principal')) {
            // Guardar la imagen
            $ruta_imagen = $request['imagen_principal']->store('principales', 'public');

            // Resize a la imagen
            $img = Image::make( public_path("storage/{$ruta_imagen}") )->fit(800, 600);
            $img->save();

            $establecimiento->imagen_principal = $ruta_imagen;
        }


        $establecimiento->save();

        // Mensaje al usuario
        return back()->with('estado', 'Tu información se almacenó correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Establecimiento $establecimiento)
    {
        //
    }
}
