<?php

namespace abmJunial\Http\Controllers;

use Illuminate\Http\Request;

use abmJunial\Http\Requests;
use abmJunial\Categoria;
use Illuminate\Support\Facades\Redirect;
use abmJunial\Http\Requests\CategoriaFormRequest;
use DB;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if ($request){
    		$query=trim($request->get('searchText')); //filtro de busqueda
    		$categorias=DB::table('Categoria')->where('nombre','LIKE','%'.$query.'%')
    		->where ('condicion','=','1')	//con "1" muestra las categorias activas
    		->orderBy('idcategoria','asc') //ordena de forma descendiente
    		->paginate(7); //muestra la paginacion de 7 resultados

    		return view('almacen.categoria.index',["categorias"=>$categorias,"searchText"=>$query]);
    	}
    }

    public function create()
    {
    	return view("almacen.categoria.create");
    }

    public function store(CategoriaFormRequest $Request)
    {
    	$categoria= new Categoria;
    	$categoria->nombre=$Request->get('nombre');
    	$categoria->descripcion=$Request->get('descripcion');
    	$categoria->condicion='1';
    	$categoria->save();

    	return Redirect::to('almacen/categoria');
    }

    public function show($id)
    {
    	return view("almacen.categoria.show",["categoria"=>categoria::findOrFail($id)]);
    }

    public function edit($id)
    {
    	return view("almacen.categoria.edit",["categoria"=>Categoria::findOrFail($id)]);
    }

    public function update(CategoriaFormRequest $request, $id)
    {
    	$categoria=Categoria::findOrFail($id);
    	$categoria->nombre=$request->get('nombre');
    	$categoria->descripcion=$request->get('descripcion');
    	$categoria->update();

    	return Redirect::to('almacen/categoria');
    }

    public function destroy($id)
    {
    	$categoria=categoria::findOrFail($id);
    	$categoria->condicion='0';
    	$categoria->update();

    	return Redirect::to('almacen/categoria');
    }
}