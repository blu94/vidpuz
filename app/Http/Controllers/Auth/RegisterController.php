<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Socialite;
use Auth;
use App\Asset;
use App\SocialProvider;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
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

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {

        try {
          $social_user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
          return redirect('/');
        }

        $social_providers = SocialProvider::where('provider_id', $social_user->getId())->first();
        if (!$social_providers) {

          $check_user_email_and_role = User::where('email', $social_user->getEmail())
          ->where('role_id', 1)
          ->count();
          if ($check_user_email_and_role > 0) {
            Session::flash('warning_message', 'Duplicate email exist, please use another social account or register with different email.');
            return redirect('/login');
          }
          else if ($check_user_email_and_role == 0) {
            $user = User::firstOrCreate(
              ['email' => $social_user->getEmail()],
              [
                'surname' => $social_user->getName(),
                'givenname' => $social_user->getName(),
                'username' => $social_user->getName(),
                'is_active' => 1,
                'role_id' => 2,
                'first_login' => 1,
                'gender' => 'M',
                'password' => bcrypt(str_random())
              ]
            );

            if ($social_user->getAvatar() != "") {
              $asset = Asset::create([
                'title' => $social_user->getName(),
                'path' => $social_user->getAvatar(),
                'format' => 'jpg',
                'usage' => 'PROFILE',
                'user_id' => $user->id,
                'assetable_id' => $user->id,
                'assetable_type' => 'App\User'
              ]);
            }

            SocialProvider::create([
              'user_id' => $user->id,
              'provider_id' => $social_user->getId(),
              'provider' => $provider
            ]);
          }

        }
        else {
          $user = User::findOrFail($social_providers->user_id);
        }


        Auth::login($user);

        return redirect('/user');

        // $user->token;
    }
}
