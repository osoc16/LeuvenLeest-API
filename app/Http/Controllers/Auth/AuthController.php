<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use \Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use \JWTAuth;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $loginPath = '/auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function postLogin(Request $request){
        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
            return new Response(['oAuth_token' => JWTAuth::fromUser(Auth::user())],200);
        }
        return new Response('wrong logindata',404);
    }

    public function logout(){
        if(Auth::check()){
            JWTAuth::invalidate(JWTAuth::getToken());
            Auth::logout();
            return new Response('Successfully logged out.',200);
        }
    }

    public function login($client){
        if($client == 'fb'){
            return Socialite::driver('facebook')->redirect();
        } else if($client == 'google'){
            return Socialite::driver('google')->redirect();
        }
    }

    public function loginCallback($client){
        if($client == 'fb'){
            $user = Socialite::driver('facebook')->user();
        } else if($client == 'google'){
            $user = Socialite::driver('google')->user();
        }

        $pass = substr($user->name,1,3);
        $pass .= strtoupper(substr($user->email,strpos($user->email,'@'),4));
        $pass .= substr($user->id,4,4);

        $userExists = User::where('email', $user->email)->first();
        if(!$userExists){
            $this->create([ 'name' => $user->name,
                    'email' => $user->email,
                    'password' => $pass, ]);
        }

        $user = Auth::attempt(['email' => $user->email, 'password' => $pass], true);

        return new Response(['oAuth_token' => JWTAuth::fromUser($user)],200);
    }

    public function postRegister(Request $request){
        $validator = $this->validator($request->all());

        if($validator->fails()){
            return $validator->errors();
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $user = $this->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            ]);

        if($user){
            return new Response(['oAuth_token' => JWTAuth::fromUser($user)],200);
        }
    }
}
