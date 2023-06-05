<?php

namespace App\Interfaces;

interface UploadFile {
    public function upload(object $file, string $folder = null):string;
}
