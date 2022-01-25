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

    public function cadastro(Request $request)
    {
        $data = $request->all();

        $validacao = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if($validacao->fails()){
            return $validacao->errors();
        }

        $imagem = "/img/perfil_padrao.jpg";

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'imagem' => $imagem ,
        ]);

        $user->token = $user->createToken($user->email)->accessToken;
        $user->imagem = asset($user->imagem);

        return $user;
    }

    public function usuario(Request $request)
    {
        return $request->user();
    }

    public function perfil(Request $request)
    {
        $user = $request->user();
        $data = $request->all();

        if(isset($data['password'])){
            $validacao = Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => ['required','string','email','max:255',Rule::unique('users')->ignore($user->id)],
                'password' => 'required|string|min:6|confirmed',
            ]);
            if($validacao->fails()){
                return $validacao->errors();
            }
            $user->password = Hash::make($data['password']);
        } else {
            $validacao = Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => ['required','string','email','max:255',Rule::unique('users')->ignore($user->id)],
            ]);
            if($validacao->fails()){
                return $validacao->errors();
            }
            $user->name = $data['name'];
            $user->email = $data['email'];
        }

        if(isset($data['imagem'])){

            Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
                $explode = explode(',', $value);
                $allow = ['png', 'jpg', 'svg','jpeg'];
                $format = str_replace(
                    [
                        'data:image/',
                        ';',
                        'base64',
                    ],
                    [
                        '', '', '',
                    ],
                    $explode[0]
                );
                // check file format
                if (!in_array($format, $allow)) {
                    return false;
                }
                // check base64 format
                if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                    return false;
                }
                return true;
            });

            $valiacao = Validator::make($data, [
                'imagem' => 'base64image',

            ],['base64image'=>'Imagem inválida']);

            if($valiacao->fails()){
            return $valiacao->errors();
            }

            $time = time();
            $diretorioPai = 'public' . DIRECTORY_SEPARATOR . 'perfis';
            $diretorioFilho = DIRECTORY_SEPARATOR . 'perfil_id-' . $user->id;
            $ext = substr($data['imagem'], 11, strpos($data['imagem'], ';') - 11);
            $nomeImagem = DIRECTORY_SEPARATOR . $time . '.' . $ext;
            $urlImagem = $diretorioPai . $diretorioFilho . $nomeImagem;
            $diretorioStorage = 'storage' .  DIRECTORY_SEPARATOR . 'perfis';

            $file = str_replace('data:image/' . $ext . ';base64,', '', $data['imagem']);
            $file = base64_decode($file);

            if($user->imagem){
                $rotaPublic = public_path() . DIRECTORY_SEPARATOR . $diretorioStorage . $user->imagem;
                if(file_exists($rotaPublic)) {
                    $rotaStorage = $diretorioPai . $user->imagem;
                    Storage::delete($rotaStorage);
                }
            }

            Storage::put($urlImagem, $file);

            $url = $diretorioStorage . $diretorioFilho . $nomeImagem;
            $user->imagem = $diretorioFilho . $nomeImagem;
        }

        $user->save();

        $user->imagem = asset($url);
        $user->token = $user->createToken($user->email)->accessToken;
        return $user;
    }
}
