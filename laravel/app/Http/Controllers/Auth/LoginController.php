<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\Models\User;
use App\Models\SocialUser;
use App\Models\ProfileChecking;
use App\Models\UserGroup;
use DB;

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
    // protected $connection = 'secondary';
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/homes';

    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback($driver)
    {
        // $user = Socialite::driver($driver)->stateless()->user();//->user();
        try {

            $user = Socialite::driver($driver)->stateless()->user();
            // return $user->getEmail();
            $profile = explode('@', $user->getEmail());
            $createUser = User::firstOrCreate([
                'user_email' => $user->getEmail()
            ], [
                'user_login' => $profile[0],
                'user_nicename' => $profile[0],
                'user_registered' => date('Y-m-d H:is'),
                'user_status' => '0',
                'display_name' => $profile[0],
                'is_expert' => '0',
            ]);

            $createSocialLogin = SocialUser::firstOrCreate([
                'ID' => $createUser->ID
            ], [
                'type' => $driver,
                'identifier' => $user->getId(),
            ]);

            $userGroupLoginEO = UserGroup::firstOrCreate(
                ['id_anggota' => $createUser->ID],
                ['group_id' => 4]
            );

            // $checkingUser = ProfileChecking::where('ID', $createUser->ID)->get();
            auth()->login($createUser, true);
            return redirect()->route('registrasiEO.index');
            // redirect($this->redirectPath());
        } catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
            return redirect()->route('/');
        }
    }
}
