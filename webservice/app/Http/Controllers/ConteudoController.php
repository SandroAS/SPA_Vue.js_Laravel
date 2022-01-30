<?php

namespace App\Http\Controllers;

use App\Conteudo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use stdClass;

class ConteudoController extends Controller
{
    public function lista(Request $request)
    {
        $conteudos = Conteudo::with('user')->orderBy('data', 'DESC')->paginate(5);
        $user = $request->user();

        foreach ($conteudos as $conteudo) {
            $conteudo->total_curtidas = $conteudo->curtidas()->count();
            $conteudo->comentarios = $conteudo->comentarios()->with('user')->get();
            $curtiu = $user->curtidas()->find($conteudo->id);
            if($curtiu){
                $conteudo->curtiu_conteudo = true;
            } else {
                $conteudo->curtiu_conteudo = false;
            }
        }

        return ['status' => true, "conteudos" => $conteudos];
    }

    public function adicionar(Request $request)
    {
        $data = $request->all();
        $user = $request->user();

        $validacao = Validator::make($data, [
            'titulo' => 'required',
            'texto' => 'required',
        ]);

        if($validacao->fails()){
            return ['status' => false, "validacao" => true, "erros" => $validacao->errors()];
        }

        $conteudo = new Conteudo();

        $conteudo->titulo = $data['titulo'];
        $conteudo->texto = $data['texto'];
        $conteudo->link = $data['link'] ;
        $conteudo->imagem = $data['imagem'];
        $conteudo->data = date('Y-m-d H:i:s');

        $user->conteudos()->save($conteudo);

        $conteudos = Conteudo::with('user')->orderBy('data', 'DESC')->paginate(5);

        return ['status' => true, "conteudos" => $conteudos];
    }

    public function curtir($id, Request $request)
    {
        $conteudo = Conteudo::find($id);
        if($conteudo) {
            $user = $request->user();
            $user->curtidas()->toggle($conteudo->id);
            return [
                'status' => true,
                "curtidas" => $conteudo->curtidas->count(),
                'lista' => $this->lista($request)
            ];
        } else {
            return ['status' => false, "erro" => "Conteúdo não existe!"];
        }
    }

    public function pagina($id, Request $request)
    {
        $donoDaPagina = User::find($id);
        if($donoDaPagina){
            $conteudos = $donoDaPagina->conteudos()->with('user')->orderBy('data', 'DESC')->paginate(5);
            $user = $request->user();

            foreach ($conteudos as $conteudo) {
                $conteudo->total_curtidas = $conteudo->curtidas()->count();
                $conteudo->comentarios = $conteudo->comentarios()->with('user')->get();
                $curtiu = $user->curtidas()->find($conteudo->id);
                if($curtiu){
                    $conteudo->curtiu_conteudo = true;
                } else {
                    $conteudo->curtiu_conteudo = false;
                }
            }
            return ['status' => true, "conteudos" => $conteudos];
        } else {
            return ['status' => false, "erro" => "Usuário não existe!"];
        }
    }
}
