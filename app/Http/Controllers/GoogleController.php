<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;

class GoogleController extends Controller
{
    //
    function redirectToGoogle(Request $req)
    {
        return Socialite::driver('google')->with(['prompt' => 'consent'])->redirect();
    }

    function googleCallback(Request $req)
    {

        try {
            if (Session::has('google_user')) {
                $user = Session::get('google_user');
            } else {
                $user = Socialite::driver('google')->user();
                Session::put('google_user', $user);
            }
        } catch (\Exception $e) {
            return redirect('/login');
        }

        // return response()->json($user);

        $userCheck = User::where('email', $user->email)->first();

        if ($userCheck) {
            Auth::login($userCheck, true);
            return view('home', ['user' => $userCheck]);
        } else {
            Session::forget('google_user');
            Session::flush();
            Auth::logout();
            return redirect('https://accounts.google.com/o/oauth2/auth?client_id=invalid&response_type=code&scope=email');
        }
    }
}
