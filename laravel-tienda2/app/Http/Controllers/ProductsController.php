<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    //Api para obtener productos
    public function index()
    {
        $products = Products::all();
        return response()->json($products);
    }

    //Api para guardar productos
    public function store(Request $request)
    {
        $respuesta = [];
        $validar = $this->validar($request->all());
        if(!is_array($validar)){
            Products::create($request->all());
            array_push($respuesta,['status'=>'success']);
            return response()->json($respuesta);
        }
        else{
            return response()->json($validar);
        }
    }

    //Api para buscar productos dado un Id
    public function show($id)
    {
        $product = Products::find($id);
        return response()->json($product);
    }

    //Api para modificar un producto
    public function update(Request $request, $id)
    {
        $respuesta = [];
        $validar = $this->validar($request->all());
        if(!is_array($validar)){
            $product = Products::find($id);
            if($product){
                $product->fill($request->all())->save();
                array_push($respuesta,['status'=>'success']);
            }
            else{
                array_push($respuesta,['status'=>'error']);
                array_push($respuesta,['message'=>['id' => ['No existe el ID']]]);
            }
            return response()->json($respuesta);
        }
        else{
            return response()->json($validar);
        }
    }

    //Api para eliminar un producto
    public function destroy($id)
    {
        $respuesta = [];
        $product = Products::find($id);
        if($product){
            $product->delete();
            array_push($respuesta,['status'=>'success']);
        }
        else{
            array_push($respuesta,['status'=>'error']);
            array_push($respuesta,['message'=>['id' => ['No existe el ID']]]);
        }
        return response()->json($respuesta);
    }

    //Funcion de validaciones
    public function validar($parametros)
    {
        $respuesta = [];
        $messages = [
            'max' => 'El campo :attribute no debe tener mas de :max caracteres',
            'required' => 'El campo :attribute no debe estar vacio',
            'price.numeric' => 'El precio debe ser numerico',
        ];
        $attributes = [
            'name' => 'nombre',
            'description' => 'descripcion',
            'price' => 'precio',
        ];
        $validation = Validator::make($parametros,
        [
            'name'=>'required|max:80',
            'description'=>'required|max:150',
            'price'=>'required|numeric|max:999999',
        ],$messages,$attributes);
        if($validation->fails()){
            array_push($respuesta,['status'=>'error']);
            array_push($respuesta,['status'=>$validation->errors()]);
            return $respuesta;
        } else{
            return true;
        }
    }
}
