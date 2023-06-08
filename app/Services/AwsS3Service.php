<?php

namespace App\Services;

use App\Interfaces\UploadFile;
use Illuminate\Support\Facades\Storage;

class AwsS3Service implements UploadFile
{
    public function upload(object $file,  string $folder = null): string
    {
        $file_name = str_ireplace(' ', '', $file->getClientOriginalName());
        $ext = $file->getClientOriginalExtension();
        $pic_fileName = str_ireplace('.' . $ext, '', $file_name) . '_' . time() . '.' . $ext;

        if (empty($folder) || is_null($folder)) {
            Storage::disk('s3')->put(env('AWS_UPLOAD') . '/' . $pic_fileName, file_get_contents($file_name));
            return $pic_fileName;
        } else {
            Storage::disk('s3')->put(env('AWS_UPLOAD') . $folder . '/' . $pic_fileName, file_get_contents($file_name));
            return $pic_fileName;
        }
    }
}
