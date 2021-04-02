<?php

use App\Models\Main\App;
use App\Models\Main\Tenant;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\WebPushConfig;

function cloudinary_folder_id()
{
    return "chatonym";
}

function cloudinary_upload_url()
{
    return config('cloudinary.upload_url');
}

function cloudinary_upload_preset()
{
    return config('cloudinary.upload_preset');
}

function cloudinary_api_key()
{
    return config('cloudinary.api_key');
}

function sendNotification($to, $data)
{
    return sendWebPushr($to, $data);
}

function sendFcm($token, $payload)
{
    $mock_payload = [
        'notification' => [
            "title" => "You've got message from an anonymous user",
            "body" => "message payload",
            'icon' => 'https://my-server/icon.png',
        ],
        'fcm_options' => [
            'link' => route('user.messages.show'),
        ],
    ];

    $config = AndroidConfig::fromArray([
        "ttl" => "500000s",
        "priority" => "high"
    ]);

    $push_config = WebPushConfig::fromArray(
        $payload
    );
    $message = CloudMessage::withTarget('token', $token)->withAndroidConfig($config)->withData($payload['notification'])
        // ->withWebPushConfig($push_config)
        ;

    $messaging = app('firebase.messaging');
    $config = config()->get('client_config');

    $fcm = $messaging->send($message);
    return $fcm;
}

function olsendFcm($token, $payload)
{
    // dd(env('CHA_SERVER_KEY'));
    // $token = "c52JHaF7fiXyhpRIz5QP-z:APA91bHXAXDpcBbGDiVm9YAoyLmK_6VGnuI417vg0BTM1N6LGqThfkgLr3SOzspK08DgC_R65nsE4UMjYjBV0XMtUOiJAWuos7z_Z8C6FNaeMrOBJxbvrp6YVhht4ayGgHvGm6PQKhes";
    $SERVER_API_KEY = 'AAAAq95Hf6E:APA91bH48qmAVjqKxvDXe9SPFKKP3JGn692Q_mHn6hIk6oh3Q1XPc7MkJ4X0K67k3EZYFu1z9nU3pv8Sv8Iy9jMkW9VvzrZnnS6zHLggSbBBko-8IoTNqrtTnofLww8y2tzDK-wXNFsd';

    $data = [
        "registration_ids" => [$token],

        "data" => $payload['notification'],
        // "data" => [
        //     "title" => "Mario",
        //     "Room" => "PortugalVSDenmark"
        // ]
        "webpush" => [
            "fcm_options" => [
                "link" => "https://dummypage.com"
            ]
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


function sendWebPushr($recipient, $data)
{
    $end_point = config('webpushr.endpoint');
    $token = config('webpushr.token');
    $key = config('webpushr.key');
    $http_header = array(
        "Content-Type: Application/Json",
        "webpushrKey: $key",
        "webpushrAuthToken: $token"
    );
    $req_data = array(
        'title'             => $data['title'], //required
        'message'         => $data['message'], //required
        'target_url'    => $data['url'], //required
        'sid'        => $recipient
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
    curl_setopt($ch, CURLOPT_URL, $end_point);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    return $response;
}

function shareDmLink($link)
{
    // return $link;
    // "Write a *secret anonymous message* for me.. � I *won't know* who wrote it..";
    $template = "Hey, there! Write a *secret anonymous message* 😄♻🗣️ ... *I *won't know* who wrote it..* 😁🤭💃🚀";
    // $thread_template = "Hey, there! Speak your mind on my completely anonymous discussion group 😄♻🗣️ ... *Nobody knows nobody here* 😁🤭💃🚀".$link;
    return urlencode($template).$link;
}

