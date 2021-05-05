<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getPage(Request $request) {
        $page = $request->input('page');
        if (isset($page)) {
            $page = intval($page);
        } else {
            $page = 1;
        }
        return $page;
    }

    protected function saveBase64ImageToFileSystem($base64Image, $type) {
        if (!isset($base64Image)) {
            return null;
        }

        $exploded = explode(',', $base64Image);
        $binaryImage = base64_decode($exploded[1]);

        if (str_contains($exploded[0], 'jpeg')) {
            $extension = 'jpg';
        } else if (str_contains($exploded[0], 'png')) {
            $extension = 'png';
        } else {
            return $this->error('Photo must be a jpg or a png.');
        }

        $imageFileName = uniqid() . '.' . $extension;
        $imageFullPath = public_path() . '/images/' . $type . '/' . $imageFileName;
        file_put_contents($imageFullPath, $binaryImage);

        return $imageFileName;
    }
}
