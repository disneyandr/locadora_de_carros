<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function regras(){
        return [
            'nome'=>'required|unique:marcas,nome,'.$this->id.'|min:3',
            'imagem'=>'required|file|mimes:png,jpeg,jpg,docx,ppt,mp3'
        ];
    }

    public function feedback() {
        return [
            'required'=>'O campo :attribute é obrigatório',
            'nome.unique'=>'O nome da marca já existe',
            'nome.mimes'=>'O nome deve ter no mínimo 3 caracteres',
            'imagem.mines'=>'Imagens devem ser do tipo: png, jpg'
        ];
    }
}
