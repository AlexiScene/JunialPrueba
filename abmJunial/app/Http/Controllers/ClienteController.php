<?php

namespace abmJunial\Http\Controllers;

use Illuminate\Http\Request;

use abmJunial\Http\Requests;
use abmJunial\Persona;
use Illuminate\Support\Facades\Redirect;
use abmJunial\Http\Requests\PersonaFormRequest;
use DB;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if ($request){
    		$query=trim($request->get('searchText')); //filtro de busqueda
    		$personas=DB::table('persona')
    		->where('nombre','LIKE','%'.$query.'%') //query=cadena de texto
    		->where ('tipo_persona','=','Cliente')
    		->orwhere('num_documento','LIKE','%'.$query.'%')
    		->where ('tipo_persona','=','Cliente')
    		->orderBy('idpersona','asc') //ordena de forma descendiente
    		->paginate(7); //muestra la paginacion de 7 resultados

    		return view('ventas.cliente.index',["personas"=>$personas,"searchText"=>$query]);
    	}
    }

    public function create()
    {
    	return view("ventas.cliente.create");
    }

    public function store(PersonaFormRequest $Request)
    {
    	$persona= new Persona;
    	$persona->tipo_persona='Cliente';
    	$persona->nombre=$Request->get('nombre');
    	$persona->tipo_documento=$Request->get('tipo_documento');
    	$persona->num_documento=$Request->get('num_documento');
    	$persona->direccion=$Request->get('direccion');
    	$persona->telefono=$Request->get('telefono');
    	$persona->email=$Request->get('email');

    	$persona->save();

    	return Redirect::to('ventas/cliente');
    }

    public function show($id)
    {
    	return view("ventas.cliente.show",["persona"=>Persona::findOrFail($id)]);
    }

    public function edit($id)
    {
    	return view("ventas.cliente.edit",["persona"=>Persona::findOrFail($id)]);
    }

    public function update(PersonaFormRequest $Request, $id)
    {
    	$persona=Persona::findOrFail($id);
    	$persona->nombre=$Request->get('nombre');
    	$persona->tipo_documento=$Request->get('tipo_documento');
    	$persona->num_documento=$Request->get('num_documento');
    	$persona->direccion=$Request->get('direccion');
    	$persona->telefono=$Request->get('telefono');
    	$persona->email=$Request->get('email');

    	$persona->update();

    	return Redirect::to('ventas/cliente');
    }

    public function destroy($id)
    {
    	$persona=persona::findOrFail($id);
    	$persona->tipo_persona='Inactivo';
    	$persona->update();

    	return Redirect::to('ventas/cliente');
    }
}
