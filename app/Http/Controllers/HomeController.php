<?php

namespace App\Http\Controllers;

use App\Exceptions\ClientErrorException;
use App\Models\Feed;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\AndroidConfig;


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
        // return $user;
        $request->validate([
            'message' => 'required_without:image_url',
        ]);

        // return $user->token;

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

        if ($request->repliable && $request->repliable == "true") {
            $request->validate(['replier_token' => 'required|string']);

            $pmessage->replier_id = @$replier->id;
            $pmessage->replyable = 1;
            $pmessage->replier_token = $request->replier_token;
            $pmessage->save();

            $payload = [
                "message_id" => $request->message_id,
                "message" => $pmessage->message,
                "user" => $user,
                "replier_token" => $request->replier_token,
                "action" => "message"
            ];
        }
        $notif = '';
        if ($user->deviceToken) {

            // return $this->sendFcm($payload, $user->token);
            $payload = [
                "title" => "You've got message from an anonymous user",
                "message" => $request->message,
                "url" => route('user.messages.show')
            ];

            $notif = $this->sefcm($user->token, $payload);

            // return $notif;
        };

        return response()->json([
            'success' => true,
            'data' => [
                "token" => $request->replier_token,
                "notification" => $notif,
            ]
        ]);
    }

    // public function sendMessage(Request $request)
    // {
    //     $user = User::find(1);
    //     $token = $user->token;
    //     // return $token;
    //     $payload = [
    //         "user_token" => "User's token is " . $token,
    //         "message" => $request->message,
    //         "action" => "initialize"
    //     ];

    //     return $this->sendNotification();

    //     return response()->json('sent');
    // }
    public function sefcm()
    {
        // dd('ooo');
        $data = [
            "title" => "You've got message from an anonymous user",
            "message" => "Nice message",
            "url" => route('user.messages.show')
        ];

        $token = "eQ1V1QTzQCadDqY8cpjcNV:APA91bEA6zvaQyhrw_JpptnSGBvTTtrLQmjpd7AIVzFdpTlugPDt7W462M4PtLUion3e84Qls7R5oq2DuknYkBFSz9aqMYkGnt8UNzFvob8W0b1abISxRALr33S5e0EbwgHeLfaZ6PjU";

        $config = AndroidConfig::fromArray([
            "ttl" => "500000s",
            "priority" => "high"
        ]);

        $message = CloudMessage::withTarget('token', $token)->withAndroidConfig($config)->withData($data);

        $messaging = app('firebase.messaging');
        $config = config()->get('client_config');
        $fcm = $messaging->send($message);
        // dd($fcm);
        $fcm = $messaging->send($message);
        // dd($fcm);
        //

        return $fcm;
        // }else
        // {
        //     return 'false';
        // }
        return 'false';
    }

    public function sendFcm($token, $payload)
    {
        // Configure FCM and send message
        // dd(99);
        $device_token = "fqky-XIA6fxztwVkJmxhMg:APA91bELqcZKI9TXZuqbcYS5wsIEO07kdNZ-pvEvVCJpI1ZZYdPsR5YuBBXE4HzJCsEXtGyGVShNiwrrB404IzCFJiL-0dBRE0gBzHFRBbPPCSn9wB_MMWQhHbQ_ig8hnZFNSVGmBdKm";
        $token = "eL44mzwaJ0jobPfV5bL2Dx:APA91bGi5tt6ard0zzFFEBatruB_fTmQ2HZhLUm7kAdYwR2EIlG9yp9iQ2W_pbwS_4m3MDLt48zvqXNy_QkJAODWiCkyoSy4PdvHt7tlJLXgCpNMq23nFyhMIBdigO-kvpfEZ5kADVvz";
        $SERVER_API_KEY = 'AAAAq95Hf6E:APA91bH48qmAVjqKxvDXe9SPFKKP3JGn692Q_mHn6hIk6oh3Q1XPc7MkJ4X0K67k3EZYFu1z9nU3pv8Sv8Iy9jMkW9VvzrZnnS6zHLggSbBBko-8IoTNqrtTnofLww8y2tzDK-wXNFsd';

        $data = [
            "registration_ids" => [$token],
            "notification" => $payload,
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        return $response;

        // $config = ['ttl' => '360000s', 'priority' => 'high'];
        // $message = CloudMessage::withTarget('token', $token)
        //     ->withData($payload)->withAndroidConfig($config);

        // $messaging = app('firebase.messaging');
        // try {
        //     $fcm = $messaging->send($message);
        //     return true;
        // } catch (\Throwable $e) {
        //     throw new ClientErrorException($e->getMessage(), 400, $e->getTrace());
        // }
    }

    public function sendNotification()
    {
        // $user = User::find(1);
        // $token = $user->token;
        // // $SERVER_API_KEY = 'AAAAq95Hf6E:APA91bH48qmAVjqKxvDXe9SPFKKP3JGn692Q_mHn6hIk6oh3Q1XPc7MkJ4X0K67k3EZYFu1z9nU3pv8Sv8Iy9jMkW9VvzrZnnS6zHLggSbBBko-8IoTNqrtTnofLww8y2tzDK-wXNFsd';

        // $data = [
        //     "registration_ids" => [$token],
        //     "notification" => [
        //         "title" => "test title",
        //         "body" => "test body",
        //     ]
        // ];
        // $dataString = json_encode($data);

        // $headers = [
        //     'Authorization: key=' . $SERVER_API_KEY,
        //     'Content-Type: application/json',
        // ];

        // $ch = curl_init();

        // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        // $response = curl_exec($ch);

        // return $response;
    }

    public function sendWebPushr()
    {
        // return  
        $token = "c52JHaF7fiXyhpRIz5QP-z:APA91bHXAXDpcBbGDiVm9YAoyLmK_6VGnuI417vg0BTM1N6LGqThfkgLr3SOzspK08DgC_R65nsE4UMjYjBV0XMtUOiJAWuos7z_Z8C6FNaeMrOBJxbvrp6YVhht4ayGgHvGm6PQKhes";
        $payload = [
            "title" => "New message from anonymous user",
            "message" => "We are happy to inform you that bla bla bla",
            "url" => config('app.url')
        ];

        $notif = $this->sendNotification($payload, $token);
        // $notif = sendNotification($token, $payload);

        return $notif;
    }
}
