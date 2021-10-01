<?php


namespace App\Actions;


class StoreImageToCloud
{
    /**
     * @param $data
     * @return string
     */
    public function __invoke($data):string{
        $path = $data->store('docs', 's3');
        return config('filesystems.s3url').$path;
    }

}
