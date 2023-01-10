<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageController
{

    public function upload(Request $request)
    {
        $file = $request->file('image');
        $name = Str::random(10);
        $url = \Storage::putFileAs('images', $file, $name .'.'.$file->extension());

        return [
            'url' => env('APP_URL') . 'ImageController.php/' . $url
        ];
    }
}
