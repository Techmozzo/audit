<?php

namespace App\Services;

use App\Interfaces\UploadFile;

class LocalStorageService implements UploadFile
{
    public function upload(object $file, string $folder = null): string
    {
        $file_name = str_ireplace(' ', '', $file->getClientOriginalName());
        $ext = $file->getClientOriginalExtension();
        $pic_file_name = str_ireplace('.' . $ext, '', $file_name) . '_' . time() . '.' . $ext;
        if (empty($folder) || is_null($folder)) {
            $file->move(env('UPLOAD_FILE_PATH') . '/', $pic_file_name);
            return env('APP_URL').'/'.env('UPLOAD_FILE_PATH') . '/'. $pic_file_name;
        } else {
            $file->move(env('UPLOAD_FILE_PATH') . $folder . '/', $pic_file_name);
            return env('APP_URL').'/'.env('UPLOAD_FILE_PATH') .'/'. $folder . '/'. $pic_file_name;
        }
    }
}
