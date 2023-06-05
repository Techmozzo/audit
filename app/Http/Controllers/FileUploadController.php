<?php

namespace App\Http\Controllers;

use App\Actions\StoreImageToCloud;
use App\Factories\UploadFileFactory;
use App\Http\Requests\FileUploadRequest;
use Symfony\Component\HttpFoundation\Response;

class FileUploadController extends Controller
{
    public function __invoke(FileUploadRequest $request)
    {
        $file_name = UploadFileFactory::getStore(env('FILE_STORE', 'local'))->upload($request->file('document'));
        if(!$file_name){
            return response()->error(Response::HTTP_BAD_REQUEST, 'Upload Failed');
        }
        return response()->success(Response::HTTP_OK, 'Upload Successful',  ['url' => $file_name, 'name' => $request->file('document')->getClientOriginalName()]);
    }
}
