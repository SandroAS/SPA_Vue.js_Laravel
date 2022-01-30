<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function adicionar(Request $request)
    {
        $user = $request->user();
        $comentario = $user->comentarios()->create([
            'conteudo_id' => $request->conteudo_id,
            'texto' => $request->texto,
            'data' => date('Y-m-d')
        ]);

        return $comentario;
    }
}
