<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        // $users = DB::table('users')
        //     ->join('roles', 'users.role_id', '=', 'roles.id')
        //     ->select('users.*', 'roles.name as role_name')
        //     ->get();
            
        dd($users);
        return view('user.indexuser');
    }

}
