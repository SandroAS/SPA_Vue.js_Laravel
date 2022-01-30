<?php

namespace App\Http\Controllers;

use App\Conteudo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            return ['status' => false, "validacao" => true, "erros" => $validacao->errors()];
        }

        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            $user = auth()->user();
            $user->token = $user->createToken($user->email)->accessToken;
            return ['status' => true, "usuario" => $user];
        } else {
            return ['status' => false];
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
            return ['status' => false, "validacao" => true, "erros" => $validacao->errors()];
        }

        $imagem = DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "perfil_padrao.jpg";

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'imagem' => $imagem
        ]);

        $user->token = $user->createToken($user->email)->accessToken;
        $user->imagem = asset($user->imagem);

        return ['status' => true, "usuario" => $user];
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
                return ['status' => false, "validacao" => true, "erros" => $validacao->errors()];
            }
            $user->password = Hash::make($data['password']);
        } else {
            $validacao = Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => ['required','string','email','max:255',Rule::unique('users')->ignore($user->id)],
            ]);
            if($validacao->fails()){
                return ['status' => false, "validacao" => true, "erros" => $validacao->errors()];
            }
            $user->name = $data['name'];
            $user->email = $data['email'];
        }
        if(isset($data['imagem'])){


            $valiacaoImagem = $this->validaImagem($data['imagem']);

            if(!$valiacaoImagem){
                return ['status' => false, "validacao" => true, "erros" => ['base64image'=>'Imagem inválida']];
            }
            $time = time();
            $diretorioPai = 'public' . DIRECTORY_SEPARATOR . 'perfis';
            $diretorioFilho = DIRECTORY_SEPARATOR . 'perfil_id-' . $user->id;
            $ext = substr($data['imagem'], 11, strpos($data['imagem'], ';') - 11);
            $nomeImagem = DIRECTORY_SEPARATOR . $time . '.' . $ext;
            $urlImagem = $diretorioPai . $diretorioFilho . $nomeImagem;
            
            $file = str_replace('data:image/' . $ext . ';base64,', '', $data['imagem']);
            $file = base64_decode($file);

            $imgUser = str_replace(asset('/'), DIRECTORY_SEPARATOR, $user->imagem);

            if($imgUser && $imgUser !== DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "perfil_padrao.jpg"){
                $rotaPublic = public_path() . $imgUser;
                if(file_exists($rotaPublic)) {
                    $rotaStorage = str_replace(DIRECTORY_SEPARATOR . 'storage', DIRECTORY_SEPARATOR . 'public', $imgUser);
                    Storage::delete($rotaStorage);
                }
            }

            Storage::put($urlImagem, $file);
            // $url = $diretorioStorage . $diretorioFilho . $nomeImagem;
            $user->imagem = $diretorioFilho . $nomeImagem;
        }

        $user->save();

        // $user->imagem = asset($url);
        $user->token = $user->createToken($user->email)->accessToken;
        return ['status' => true, "usuario" => $user];
    }

    public function validaImagem($imagem)
    {
        $explode = explode(',', $imagem);
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
    }

    public function amigo(Request $request)
    {
        $user = $request->user();
        $amigo = User::find($request->id);
        if($amigo && $user->id != $amigo->id){
            $user->amigos()->toggle($amigo->id);
            return ['status' => true, "usuario" => $user->amigos];
        } else {
            return ['status' => false, "erro" => "Esse usuário não existe!"];
        }
    }

    public function listaAmigos(Request $request)
    {
        $user = $request->user();
        if($user){
            return ['status' => true, "usuario" => $user->amigos];
        } else {
            return ['status' => false, "erro" => "Esse usuário não existe!"];
        }
    }

    public function listaAmigosPagina($id, Request $request)
    {
        $user = User::find($id);
        $userLogado = $request->user();
        if($user){
            return ['status' => true, "usuario" => $user->amigos, "amigos_logado" => $userLogado->amigos];
        } else {
            return ['status' => false, "erro" => "Esse usuário não existe!"];
        }
    }
}
