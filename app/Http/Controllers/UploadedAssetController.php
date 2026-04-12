<?php

namespace App\Http\Controllers;

use App\Support\UploadedAsset;
use Illuminate\Http\Response;

class UploadedAssetController extends Controller
{
    public function show(string $path): Response
    {
        $absolutePath = UploadedAsset::findAbsolutePath('uploads/'.$path);

        abort_unless($absolutePath, 404);

        return response()->file($absolutePath, [
            'Cache-Control' => 'public, max-age=604800',
        ]);
    }
}
