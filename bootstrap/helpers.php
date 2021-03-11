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