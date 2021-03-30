<?php

namespace App\Http\Controllers;

use App\Exceptions\ClientErrorException;
use App\Models\Feed;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\WebPushConfig;

class HomeController extends Controller
{
    public function interface()
    {
        return view('interface.feed');
    }
    public function vuefeeds()
    {
        return view('vue.landing');
    }

    public function peepMessage(User $user)
    {
        $user->load('messages');
        return view('interface.peep', compact('user'));
    }

    // public function showFeed(Feed $feed)
    // {
    //     $feed->load('replies')
    //     return $feed;
    // }

    public function writeMessage(User $user)
    {
        // return $user;
        return view('interface.landing', compact('user'));
        return $user;
    }

    public function setToken(Request $request)
    {
        $user = auth()->user();
    }

    public function saveToken(Request $request)
    {
        $user = auth()->user();
        $user->deviceToken()->updateOrCreate(['user_id' => $user->id], [
            "token" => $request->token,
        ]);

        return response()->json([
            "success" => true,
            "message" => "Token saved successfully",
            "data" => $user->load('deviceToken')
        ]);
    }



    public function sendPm(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required_without:image_url',
        ]);

        $replier = null;
        $user = User::whereUsername($request->username)->firstOrFail();
        if (auth()->check()) {
            $replier = auth()->user();
        }

        $status = 'submitted';
        $media_type = 'text';

        if ($request->has('audio_url')) {

            $status = 'submitted-with-audio';
        }


        if ($request->has('image_url')) {

            $request->validate([
                'image_url' => 'array',
            ]);

            $status = 'submitted-with-image';
            $media_type = 'text-and-image';

            json_encode($request->image_url);
        }


        $message = nl2br(strip_tags($request->message));

        $pmessage = Message::create(
            [
                'message' => $message,
                'user_id' => $user->id,
                'user_ip' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'media_type' => $media_type,
                'image_url' => $request->image_url,
                'audio_url' => $request->audio_url,
                'warped_audio_url' => $request->warped_audio_url,
                'warp_effect' => $request->warp_effect,
                'status' => $status
            ]
        );
        $notif = null;
        // $pmessage = Message::find(16140);
        // return $request;
        $payload = [
            'notification' => [
                "title" => "You've got message from an anonymous user",
                "body" => $request->message,
                'icon' => 'https://my-server/icon.png',
                'click_action' => route('user.messages.show'),
            ],
            'fcm_options' => [
                'link' => route('user.messages.show'),
            ],
        ];
        if ($request->repliable && $request->repliable == "true" && $request->replier_token && $user->token) {
            $pmessage->replier_id = @$replier->id;
            $pmessage->replyable = 1;
            $pmessage->replier_token = $request->replier_token;
            $pmessage->save();
            $pmessage->chats()->create([
                "message" => "Hi, Leave a message for me. It's completely anonymous.",
                "image_url" => $pmessage->image_url,
                "user_token" => $user->token,
                "replier_token" => $request->replier_token,
                "sent_by_anon" => false
            ]);
            $pmessage->chats()->create([
                "message" => $request->message,
                "image_url" => $pmessage->image_url,
                "user_token" => $user->token,
                "replier_token" => $request->replier_token,
                "sent_by_anon" => auth()->user()->id != $pmessage->user_id
            ]);
        }
        if ($user->token) {
            $notif = sendFcm($user->token, $payload);
        };

        return response()->json([
            'success' => true,
            'data' => [
                "token" => $request->replier_token,
                "notification" => $notif,
                "chat" => $pmessage->load('chats')
            ]
        ]);
    }


    public function sendWebPushr()
    {
        $token = "c52JHaF7fiXyhpRIz5QP-z:APA91bHXAXDpcBbGDiVm9YAoyLmK_6VGnuI417vg0BTM1N6LGqThfkgLr3SOzspK08DgC_R65nsE4UMjYjBV0XMtUOiJAWuos7z_Z8C6FNaeMrOBJxbvrp6YVhht4ayGgHvGm6PQKhes";
        $payload = [
            "title" => "New message from anonymous user",
            "message" => "We are happy to inform you that bla bla bla",
            "url" => config('app.url')
        ];
        $notif = $this->sendNotification($payload, $token);
        return $notif;
    }
}
