<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Social;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {

        $user = Socialite::driver($provider)->user();
        dd($user);
        $authUser = $this->findOrCreateUser($user, $provider);

        Auth::login($authUser, true);
    }




    public function findOrCreateUser($providerUser, $provider)

    {

        $account = Social::whereProviderName($provider)

            ->whereProviderId($providerUser->getId())

            ->first();




        if ($account) {

            return $account->user;
        } else {

            $user = User::whereEmail($providerUser->getEmail())->first();




            if (!$user) {

                $user = User::create([

                    'email' => $providerUser->getEmail(),

                    'name'  => $providerUser->getName(),

                ]);
            }




            $user->social()->create([

                'provider_id'   => $providerUser->getId(),

                'provider_name' => $provider,

            ]);




            return $user;
        }
    }
}
