<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Laravel\Passport\Token;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        //アクセストークン取得してログイン
        $email    = $request->email;
        $password = $request->password;
        $user = User::where('email',$email)->first();; //該当アドレスでの登録があるかどうか

        if($user){ 
            if(Hash::check($password, $user->password)){
                $access_token = $user->createToken($user->email)->accessToken;
                return ['access_token' => $access_token, 'user_id' => $user->id, 'user_name' => $user->name];
            }else{
                return response()->json([
                    'errors' => [
                        'code'   => 401,
                        'title'  => 'Unauthorixed',
                    ]
                ], 401);
            }
        }else{
            return response()->json([
                'errors' => [
                    'code'   => 404,
                    'title'  => 'Vital Not Found',
                ]
            ], 404);
        }
    }
}
