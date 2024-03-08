<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TwitterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function handle()
    {
        try {
            return Socialite::driver('twitter')->redirect();
        } catch (Exception $e) {
            return redirect()->route('wlc')->with('error', "Woops!..Failed to login via Twitter.\n Setup Twitter Developers https://developer.twitter.com/en \n If you continuously face problems, please click the login button for normal login.");

        }
    }

    public function callbackHandle(Request $request)
    {
        try {
            $user = Socialite::driver('twitter')->user();
            $data = User::where('email', $user->nickname)->first();

            if (is_null($data)) {
                $userinfo['name'] = $user->name;
                $userinfo['email'] = $user->nickname;
                $data = User::create($userinfo);
            }

            Auth::login($data);
            return redirect()->route('home');
        } catch (Exception $e) {
            return redirect()->route('wlc')->with('error', 'Failed to login via Twitter Click Login Button.');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

}
