<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThreadController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return $user->threads;
    }


    public function create(Request $request)
    {
        $user = auth()->user();
        $secret = null;
        // $token = null;
        // return $thread;
        // return $request;
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required|max:100',
            'visibility' => 'required|in:private,public',

        ]);

        if ($user->threads->count() > 9) {
            return response()->json(
                [
                    'success' => false,
                    'data' => [
                        'message' => 'You cannot create more than 10 threads.'
                    ]
                ],
                403
            );
        }

        if ($request->visibility == 'private') {
            $secret = Str::random(6);
            $token = 'tk-' . Str::random(10) . '-' . Str::random(10) . '_' . Str::random(10);
        }

        $thread = $user->threads()->create([
            'name' => $request->name,
            'description' => $request->description,
            'secret' => $secret,
            'token' => $token,
            'visibility' => $request->visibility,
        ]);
        $thread = $thread->load('user');
        $thread->threads_count = $user->threads->count();

        return response()->json(
            [
                'success' => true,
                'data' => $thread
            ],
        );
    }
}
