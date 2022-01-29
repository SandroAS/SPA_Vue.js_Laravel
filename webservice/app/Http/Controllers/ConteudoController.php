<?php

namespace App\Http\Controllers;

use App\Conteudo;
use Illuminate\Http\Request;
use stdClass;

class ConteudoController extends Controller
{
    public function lista(Request $request)
    {
        $conteudos = Conteudo::with('user')->orderBy('data', 'DESC')->paginate(5);
        // dd($conteudos);
        return ['status' => true, "conteudos" => $conteudos];
    }

    public function adicionar(Request $request)
    {
        $data = $request->all();
        $user = $request->user();

        $conteudo = new Conteudo();

        $conteudo->titulo = $data['titulo'];
        $conteudo->texto = $data['texto'];
        $conteudo->link = $data['link'] ;
        $conteudo->imagem = $data['imagem'];
        $conteudo->data = date('Y-m-d H:i:s');

        $conteudoSalvo = $user->conteudos()->save($conteudo);

        return ['status' => true, "conteudos" => $conteudoSalvo];
    }
}
