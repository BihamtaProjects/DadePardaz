<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationFilesController extends Controller
{
    public function upload($files)
    {
        $fileNames = [];

        foreach ($files as $file) {
            $fileName = generateFileName($file->getClientOriginalName());
            $file->move(public_path(env('APPLICATION_FILES_UPLOAD_PATH')),$fileName);
            array_push($fileNames, $fileName);
        }

        return $fileNames;

    }
}
