<?php

namespace abmJunial\Http\Controllers;

use Illuminate\Http\Request;

use abmJunial\Persona;
use Illuminate\Support\Facades\Redirect;
use abmJunial\Http\Requests\PersonaFormRequest;
use DB;

class ProveedorController extends Controller
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
    		->where ('tipo_persona','=','Proveedor')
    		->orwhere('num_documento','LIKE','%'.$query.'%')
    		->where ('tipo_persona','=','Proveedor')
    		->orderBy('idpersona','asc') //ordena de forma descendiente
    		->paginate(7); //muestra la paginacion de 7 resultados

    		return view('compras.proveedor.index',["personas"=>$personas,"searchText"=>$query]);
    	}
    }

    public function create()
    {
    	return view("compras.proveedor.create");
    }

    public function store(PersonaFormRequest $Request)
    {
    	$persona= new Persona;
    	$persona->tipo_persona='Proveedor';
    	$persona->nombre=$Request->get('nombre');
    	$persona->tipo_documento=$Request->get('tipo_documento');
    	$persona->num_documento=$Request->get('num_documento');
    	$persona->direccion=$Request->get('direccion');
    	$persona->telefono=$Request->get('telefono');
    	$persona->email=$Request->get('email');

    	$persona->save();

    	return Redirect::to('compras/proveedor');
    }

    public function show($id)
    {
    	return view("compras.proveedor.show",["persona"=>Persona::findOrFail($id)]);
    }

    public function edit($id)
    {
    	return view("compras.proveedor.edit",["persona"=>Persona::findOrFail($id)]);
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

    	return Redirect::to('compras/proveedor');
    }

    public function destroy($id)
    {
    	$persona=persona::findOrFail($id);
    	$persona->tipo_persona='Inactivo';
    	$persona->update();

    	return Redirect::to('compras/proveedor');
    }
}

