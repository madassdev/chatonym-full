<?php

use App\Models\Main\App;
use App\Models\Main\Tenant;

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
