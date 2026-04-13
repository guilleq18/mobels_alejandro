<?php

namespace App\Http\Controllers;

use App\Support\UploadedAsset;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UploadedAssetController extends Controller
{
    public function show(string $path): BinaryFileResponse
    {
        $absolutePath = UploadedAsset::findAbsolutePath('uploads/'.$path);

        abort_unless($absolutePath, 404);

        return response()->file($absolutePath, [
            'Cache-Control' => 'public, max-age=604800',
        ]);
    }
}
