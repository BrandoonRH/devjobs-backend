<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        //Revisar Password
        if(!Auth::attempt($data)){
            return response([
                'errors' => ['El Email o el Password son Incorrectos']
            ], 422);
        }
        //Autenticar al Usuario
        $user = Auth::user();
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        //crear Usuario
        /*$user = User::create([
            'name' =>  $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'rol' => $data['rol']
        ]);*/

        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->rol = $data['rol'];
        $user->save();
        //Retornar Respuesta
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }

    public function logout(Request $request)
    {
        //Revocar Token
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return [
            'user' => null
        ];
    }
}
