<?php

namespace App\Http\Controllers;

use App\Exceptions\ClientErrorException;
use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;

class HomeController extends Controller
{
    public function interface()
    {
        return view('interface.index');
    }

    public function writeMessage(User $user)
    {
        return view('interface.messaging', compact('user'));
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

    public function sendMessage(Request $request)
    {
        $user = User::find(1);
        $token = $user->token;
        // return $token;
        $payload = [
            "user_token" => "User's token is " . $token,
            "message" => $request->message,
            "action" => "initialize"
        ];

        return $this->sendNotification();

        return response()->json('sent');
    }

    public function sendFcm($payload, $token)
    {
        // Configure FCM and send message
        $device_token = "fqky-XIA6fxztwVkJmxhMg:APA91bELqcZKI9TXZuqbcYS5wsIEO07kdNZ-pvEvVCJpI1ZZYdPsR5YuBBXE4HzJCsEXtGyGVShNiwrrB404IzCFJiL-0dBRE0gBzHFRBbPPCSn9wB_MMWQhHbQ_ig8hnZFNSVGmBdKm";
        $config = ['ttl' => '360000s', 'priority' => 'high'];
        $message = CloudMessage::withTarget('token', $token)
            ->withData($payload)->withAndroidConfig($config);

        $messaging = app('firebase.messaging');
        try {
            $fcm = $messaging->send($message);
            return true;
        } catch (\Throwable $e) {
            throw new ClientErrorException($e->getMessage(), 400, $e->getTrace());
        }
    }

    public function sendNotification()
    {
        $user = User::find(1);
        $token = $user->token;
        $SERVER_API_KEY = 'AAAAq95Hf6E:APA91bH48qmAVjqKxvDXe9SPFKKP3JGn692Q_mHn6hIk6oh3Q1XPc7MkJ4X0K67k3EZYFu1z9nU3pv8Sv8Iy9jMkW9VvzrZnnS6zHLggSbBBko-8IoTNqrtTnofLww8y2tzDK-wXNFsd';

        $data = [
            "registration_ids" => [$token],
            "notification" => [
                "title" => "test title",
                "body" => "test body",
            ]
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
    }
}
