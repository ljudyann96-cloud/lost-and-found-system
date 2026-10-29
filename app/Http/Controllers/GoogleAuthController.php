<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->with(['prompt' => 'select_account'])->redirect();
    }

    /**
     * Obtain the user information from Google and authenticate them.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $email = strtolower($googleUser->getEmail());
            
            // Gamiton ang updateOrCreate aron kung wala na o na-delete man sa database, 
            // awtomatiko siyang mahimo/mabalik ug makaka-login gihapon.
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    // I-add ang uban pang fields dinhi kung kinahanglan sa imong database table (e.g., role, password, etc.)
                ]
            );

            // I-log in ang user sa sistema
            Auth::login($user);

            // Malampusong pag-redirect sa dashboard
            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            // Pagdumala sa mga error sama sa nakansela nga login o network failure
            return redirect('/login')->with('error', 'Wala nagmalampuson ang pag-login gamit ang Google. Palihug sulayi pag-usab.');
        }
    }
}