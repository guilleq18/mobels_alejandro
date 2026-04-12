<?php

namespace App\Support;

class UploadedAsset
{
    public static function uploadsDirectory(string $folder = ''): string
    {
        $root = self::resolveUploadsRoot();
        $folder = trim($folder, '/\\');

        return $folder === ''
            ? $root
            : $root.DIRECTORY_SEPARATOR.str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $folder);
    }

    public static function findAbsolutePath(string $relativePath): ?string
    {
        $relativePath = trim(str_replace('\\', '/', $relativePath), '/');

        if ($relativePath === '') {
            return null;
        }

        $candidates = array_filter([
            public_path($relativePath),
            base_path($relativePath),
            is_dir(base_path('../public_html')) ? base_path('../public_html/'.$relativePath) : null,
        ]);

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    private static function resolveUploadsRoot(): string
    {
        $sharedHostingPublic = base_path('../public_html');

        if (is_dir($sharedHostingPublic)) {
            return $sharedHostingPublic.DIRECTORY_SEPARATOR.'uploads';
        }

        return public_path('uploads');
    }
}
