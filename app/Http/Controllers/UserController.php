<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showProfile()
    {
        $user = auth()->user();
        $messages_count = $user->messages->count();
        $threads_count = $user->threads->count();
        return view('user.profile-mini', compact('messages_count', 'threads_count'));
    }

    public function showMessages()
    {
        $user = auth()->user()->load('messages');
        $messages_count = $user->messages->count();
        $threads_count = $user->threads->count();
        return view('user.messages', compact('user', 'messages_count', 'threads_count'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            "password" => "required|min:3",
        ]);
        $user = auth()->user();
        return $user;
    }

    public function showThreads()
    {
        $user = auth()->user()->load('messages');
        $messages_count = $user->messages->count();
        $threads_count = $user->threads->count();
        $threads = $user->threads;
        return view('user.threads', compact('threads', 'threads_count', 'messages_count'));
        return $user->threads;
    }
}
