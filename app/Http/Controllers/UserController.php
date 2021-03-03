<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showProfile()
    {
        return view('user.profile');
    }

    public function showMessages()
    {
        
        $user = auth()->user()->load('messages');
        // return $user;
        return view('user.messages', compact('user'));
    }
}
