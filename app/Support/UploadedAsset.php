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
            self::legacySharedHostingPath($relativePath),
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
        if (self::isSingleRootPublicHtmlDeploy()) {
            return public_path('uploads');
        }

        $sharedHostingPublic = self::sharedHostingPublicPath();

        if ($sharedHostingPublic && is_dir($sharedHostingPublic)) {
            return $sharedHostingPublic.DIRECTORY_SEPARATOR.'uploads';
        }

        return public_path('uploads');
    }

    private static function legacySharedHostingPath(string $relativePath): ?string
    {
        $sharedHostingPublic = self::sharedHostingPublicPath();

        if (! $sharedHostingPublic || self::isSingleRootPublicHtmlDeploy()) {
            return null;
        }

        return $sharedHostingPublic.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
    }

    private static function sharedHostingPublicPath(): ?string
    {
        $path = base_path('../public_html');

        return is_dir($path) ? $path : null;
    }

    private static function isSingleRootPublicHtmlDeploy(): bool
    {
        $sharedHostingPublic = self::sharedHostingPublicPath();

        if (! $sharedHostingPublic) {
            return false;
        }

        $basePath = realpath(base_path());
        $publicHtmlPath = realpath($sharedHostingPublic);

        return $basePath !== false
            && $publicHtmlPath !== false
            && $basePath === $publicHtmlPath;
    }
}
