<?php

namespace App\Http\Controllers;

use App\Models\Message;
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

    public function showChat(Message $message)
    {
        abort_unless($message->user_id == auth()->user()->id || $message->replier_token == auth()->user()->token, 404, "We couldn't can");
        $message->load('chats');
        // return $message->chats;
        $chat_page = true;
        return view('user.chat', compact('message', 'chat_page'));
    }

    public function sendChat(Request $request, Message $message)
    {
        $user = auth()->user();
        // return $request;
        $chat_message = $message->chats()->create([
            "message" => $request->message,
            "image_url" => $message->image_url,
            "user_token" => $user->token,
            "replier_token" => $message->replier_token,
            "sent_by_anon" => auth()->user()->id != $message->user_id
        ]);

        $payload = [
            'notification' => [
                "title" => $request->message,
                "body" => $request->message,
                'icon' => 'https://chatonym.dv/house.png',
                'click_action' => route('user.chat.show', ['message' => $message->id]),
            ],
            'fcm_options' => [
                'link' => route('user.chat.show', ['message' => $message->id]),
            ],
        ];
        $recipient = $message->user->id == auth()->id() ? $chat_message->replier_token : $message->user->token;

        $notif = sendFcm($recipient, $payload);
        return response()->json([
            "success" => true,
            "data" => [
                "message" => $message,
                "notification" => $notif,
            ]
        ]);
        return view('user.chat', compact('message'));
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
        $user->threads->map(function ($t) {
            if (!$t->messages->count()) {
                $t->messages()->firstOrCreate([
                    "message" => "<b>" . $t->name . "</b><br>" . $t->description
                ]);
            }
        });
        $threads = $user->threads->loadCount('messages');
        return view('user.threads', compact('threads', 'threads_count', 'messages_count'));
        return $user->threads;
    }
}
