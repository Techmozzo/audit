<?php

namespace App\Services;

use App\Interfaces\UploadFile;
use Cloudinary\Cloudinary;

class CloudinaryService implements UploadFile
{
    protected $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary(
            [
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key'    => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
            ]
        );
    }

    public function upload(object $file, string $folder = null): string
    {
        $file_name = str_ireplace(' ', '', $file->getClientOriginalName());
        $ext = $file->getClientOriginalExtension();
        $pic_file_name = str_ireplace('.' . $ext, '', $file_name) . '_' . time() . '.' . $ext;
        $response = $this->cloudinary->uploadApi()->upload($file->getRealPath(), ['public_id' => $pic_file_name]);
        return $response['secure_url'] ?? null;
    }
}
