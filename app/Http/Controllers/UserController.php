<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    function index()
    {
        $user = User::all();
        return view('edituser', ['users' => $user]);
    }

    function deleteUser(Request $req)
    {
        $user = User::find($req->id);
        $user->delete();
        return redirect()->route('edit.users');
    }
    function editUser(Request $req)
    {
        $user = User::find($req->id);
        $user->email = $req->email;
        $user->r_name = $req->role;
        $user->save();
        return view('edituser');
    }
    function addNewUser(Request $req)
    {
        $users = new User();
        $users->email = $req->email;
        $users->role = $req->role;
        $users->save();
        return redirect('/user-edit');
    }
}
