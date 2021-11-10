<?php

namespace App\Http\Controllers;

use App\Actions\StoreImageToCloud;
use App\Http\Requests\FileUploadRequest;
use Symfony\Component\HttpFoundation\Response;

class FileUploadController extends Controller
{
    public function __invoke(FileUploadRequest $request, StoreImageToCloud $storeImageToCloud)
    {
        return response()->success(Response::HTTP_OK, 'Upload Successful', ['url' => $storeImageToCloud($request->file('document')), 'name' => $request->name]);
    }
}
