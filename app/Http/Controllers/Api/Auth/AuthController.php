<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only(
            'email',
            'password',
            'device_name'
        );

        $user = User::where('email', $credentials['email'])->first();

        if(! $user || !  Hash::check($credentials['password'], $user->password) ){
            
            throw ValidationException::withMessages([
                'email' => ['Credenciais incorretas']
            ]);
        }
      
        // if($request->has('logout_others_devices')) deslogar todos os dispositivos ao fazer um login
        $user->tokens()->delete();

        $token = $user->createToken($credentials['device_name'])->plainTextToken;
        
        return response()->json([
            'token' => $token
        ]);
    }

    public function register(Request $request, User $user){

        $userData = $request->only(
            'name',
            'email',
            'password'
        );

        $userData['password'] = bcrypt($userData['password']);

        if (User::where('email', $userData['email'])->exists()) {
            throw ValidationException::withMessages([
                'message' => ['Este e-mail já está sendo usado']
            ]);
        }
        
        $user = $user->create($userData);
     
        if(!$user){
            throw ValidationException::withMessages([
                'mensage' => ['Erro ao criar novo usuario']
            ]);
        }
       
                
        return response()->json([
            'user' => $user
        ]);
    }
    public function logout(Request $request){

        //remove o token somente do local que esta conectado
        // auth()->user()->tokens()->delete();

       // phpcs:ignore Undefined method 'currentAccessToken'

       //remove o token somente do local que esta conectado
        $request->user()->currentAccessToken()->delete(); 

        throw ValidationException::withMessages([
            'message' => ['User deslogado']
        ]);
    }
}
