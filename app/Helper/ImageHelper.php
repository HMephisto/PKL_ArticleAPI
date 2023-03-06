<?php

namespace App\Helper;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public function upload($file, $filename)
    {
        return Storage::disk('public')->putFileAs("images", $file, $filename);
    }

    public function deleteImage($filename)
    {
        return Storage::disk('public')->delete("images/".$filename);
    }
}