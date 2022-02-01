<?php

namespace App\Http\Controllers;

use App\Conteudo;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function comentar($id, Request $request)
    {
        $conteudo = Conteudo::find($id);
        if($conteudo){
            $user = $request->user();
            $user->comentarios()->create([
                'conteudo_id' => $conteudo->id,
                'texto' => $request->texto,
                'data' => date('Y-m-d H:i:s')
            ]);

            return [
                'status' => true,
                'lista' => $this->lista($request)
            ];
        } else {
            return ['status' => false, 'erro' => "Conteúdo não existe!"];
        }
    }

    public function comentarPagina($id, Request $request)
    {
        $conteudo = Conteudo::find($id);
        if($conteudo){
            $user = $request->user();
            $user->comentarios()->create([
                'conteudo_id' => $conteudo->id,
                'texto' => $request->texto,
                'data' => date('Y-m-d H:i:s')
            ]);

            return [
                'status' => true,
                'lista' => $this->pagina($conteudo->user_id, $request)
            ];
        } else {
            return ['status' => false, 'erro' => "Conteúdo não existe!"];
        }
    }

    public function lista(Request $request)
    {
        $conteudos = Conteudo::with('user')->orderBy('data', 'DESC')->paginate(5);
        $user = $request->user();

        foreach ($conteudos as $conteudo) {
            $conteudo->total_curtidas = $conteudo->curtidas->count();
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
            return ['status' => true, "conteudos" => $conteudos, 'dono' => $donoDaPagina];
        } else {
            return ['status' => false, "erro" => "Usuário não existe!"];
        }
    }
}
