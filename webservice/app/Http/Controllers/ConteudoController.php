<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConteudoController extends Controller
{
    public function adicionar(Request $request)
    {
        $data = $request->all();
        $user = $request->user();

        $conteudo = new Conteudo;

        $conteudo->titulo = $data['titulo'];
        $conteudo->texto = $data['texto'];
        $conteudo->link = $data['link'] ;
        $conteudo->imagem = $data['imagem'];
        $conteudo->data = date('Y-m-d H:i:s');

        $user->conteudos()->save($conteudo);

        return ['status' => true, "conteudos" => $user->conteudos()];
    }
}
