<?php


namespace App\Actions;


class StoreImageToCloud
{
    /**
     * @param $data
     * @return string
     */
    public function __invoke($data):string{
        $path = $data->storeAs('docs', 's3');
        return config('filesystems.disks.s3.url').$path;
    }

}
