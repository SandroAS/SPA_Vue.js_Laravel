<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->all();

        $validacao = Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if($validacao->fails()){
            return $validacao->errors();
        }

        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            $user = auth()->user();
            $user->token = $user->createToken($user->email)->accessToken;
            $user->imagem == "/img/perfil_padrao.jpg" ? $url = $user->imagem : $url = 'storage' .  DIRECTORY_SEPARATOR . 'perfis' . $user->imagem;
            $user->imagem = asset($url);
            return $user;
        } else {
            return ['status' => 'false'];
        }
    }
}
