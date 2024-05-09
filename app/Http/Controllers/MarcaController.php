<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function __construct(Marca $marca){
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $marcas = Marca::all();
        $marcas = $this->marca->all();
        return response()->json($marcas,200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate($this->marca->regras(), $this->marca->feedback());

       $image = $request->file('imagem');
       $imagem_urn = $image->store('image_path','public');

        $marca = $this->marca->create(
            [
                'nome'=>$request->nome,
                'imagem'=>$imagem_urn,
            ]
        );

        return response()->json($marca,201);
    }

    /**
     * Display the specified resource.
     * @param Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['erro' => 'Recurso pesquisado não existe'],404);
        }
        return response()->json($marca,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe.'],404);
        }

        if($request->method() === 'PATCH'){
            $regrasDinamicas = array();
            foreach($marca->regras() as $input => $regra){
                if(array_key_exists($input,$request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $marca->feedback());
        }else{

            $request->validate($marca->regras(), $marca->feedback());
        }
        $marca->update($request->all());
        return response()->json($marca,200);
    }

    /**
     * Remove the specified resource from storage.
     * @param Integer
     * @param \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe.'],404);
        }
        $marca->delete();
        // print_r($marca->getAttributes()); //dados atuais
        return response()->json(['msg'=>'Marca removida com sucesso!'],200);
    }
}
