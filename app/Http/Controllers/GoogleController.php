<?php

namespace App\Http\Controllers;

use Socialite;
use App\User;
use Auth;
use App\Asset;
use Illuminate\Support\Facades\Session;

class GoogleController extends Controller
{
  /**
   * Redirect the user to the GitHub authentication page.
   *
   * @return Response
   */
  public function redirectToProvider()
  {
      return Socialite::driver('google')->redirect();
  }

  /**
   * Obtain the user information from GitHub.
   *
   * @return Response
   */
  public function handleProviderCallback()
  {

      try {
        $social_user = Socialite::driver('google')->user();
      } catch (Exception $e) {
        return redirect('/');
      }

      $user = User::where('google_id', $social_user->getId())->first();
      if ($social_user->getId() != NULL && $social_user->getName() != NULL && $social_user->getEmail() != NULL) {
        // check email exist or not
        $check_user_email = User::where('email', $social_user->getEmail())->count();

        if ($check_user_email == 0) {
          if (!$user) {

            $user = User::create([
              'google_id' => $social_user->getId(),
              'surname' => $social_user->getName(),
              'givenname' => $social_user->getName(),
              'username' => $social_user->getName(),
              'email' => $social_user->getEmail(),
              'is_active' => 1,
              'role_id' => 2,
              'first_login' => 1,
              'gender' => 'M',
              'password' => bcrypt(str_random())
            ]);

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

          }
        }
        elseif ($check_user_email > 0) {
          Session::flash('warning_message', 'Duplicate email exist, please use another social account or register with different email.');
          return redirect('/login');
        }
      }
      else {
        Session::flash('warning_message', 'Google not allow to login, please use another social account or register an account.');
        return redirect('/login');
      }



      Auth::login($user);

      return redirect('/user');

      // $user->token;
  }
}
