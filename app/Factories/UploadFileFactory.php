<?php

namespace App\Factories;

use App\Services\AwsS3Service;
use App\Services\CloudinaryService;
use App\Services\LocalStorageService;

class UploadFileFactory
{
    public static function getStore(string $store)
    {
        switch ($store) {
            case self::findStoreMatch($store, 'aws-s3'):
                return new AwsS3Service;
            case self::findStoreMatch($store, 'cloudinary'):
                return new CloudinaryService;
            default:
                return new LocalStorageService;
        }
    }

    private static function findStoreMatch(string $store, string $option): bool
    {
        return (strtolower($store) == $option) ? true : false;
    }
}
