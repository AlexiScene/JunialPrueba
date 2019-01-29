<?php

namespace abmJunial\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [    //los nombres q aparecen no son las categorias de las tablas sino q son los objetos de nuestro formulario html

        'nombre'=>'required|max:50',
        'descripcion'=>'max:256',
            
        ];
    }
}
