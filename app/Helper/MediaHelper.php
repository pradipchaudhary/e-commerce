<?php

namespace App\Helper;

use Illuminate\Support\Str;
use Image;

class MediaHelper
{
    public function uploadSingleImage($image, $folder = "upload")
    {
        $orginalName = Str::before($image->getClientOriginalName(), '.');

        $imageName =  $orginalName . "-" . Str::random(10) . "." . $image->extension();
        $filePath = storage_path() . '/app/public/upload';

        $img = Image::make($image->path());
        $img->resize(50, 50, function ($const) {
            $const->aspectRatio();
        })->save($filePath . '/' . $imageName);

        $image->storeAs($folder, $imageName, 'public');
        $image->storeAs('thumbnails', $imageName, 'public');
        return $imageName;
    }

    public function uploadMultipleImage($image, $folder = "upload")
    {
        foreach ($image as $key => $value) {

            $orginalName = Str::before($value->getClientOriginalName(), '.');
            $imageName =  $orginalName . "-" . Str::random(10) . "." . $value->extension();
            // dd($imageName);
            $filePath = storage_path() . '/app/public/upload/';
            $img = Image::make($value->path());
            $img->resize(110, 110, function ($const) {
                $const->aspectRatio();
            })->save($filePath . '/' . $imageName);

            $image->storeAs($folder, $imageName, 'public');
            $image->storeAs('thumbnails', $imageName, 'public');
            $photo[] = $imageName;
        }
        return $photo;
    }
}