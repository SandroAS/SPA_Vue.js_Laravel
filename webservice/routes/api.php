<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/cadastro', function (Request $request) {
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
});

Route::post('/login', 'UsuarioController@login');

Route::middleware('auth:api')->get('/usuario', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->put('/perfil', function (Request $request) {
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
});
