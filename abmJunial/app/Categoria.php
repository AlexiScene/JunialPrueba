<?php

namespace abmJunial;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table='categoria';

    protected $primaryKey='idcategoria';

    public $timestamps=false; //para q no se creen dos columnas creacion y actualizacion de registros

    protected $fillable =[
    	'nombre',
    	'descripcion',
    	'condicion'
    ];

    protected $guarded =[
    	
    ];
}
