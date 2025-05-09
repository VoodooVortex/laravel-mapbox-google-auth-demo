<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    function index()
    {

        $user = Auth::user();
        $userData = User::find($user->id);
        return view('home', ['user' => $userData]);
    }
}
