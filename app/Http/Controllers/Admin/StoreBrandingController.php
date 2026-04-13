<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBrandingRequest;
use App\Models\StoreSetting;
use App\Support\UploadedAsset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StoreBrandingController extends Controller
{
    public function edit(): View
    {
        return view('admin.branding.edit', [
            'brandLogoPath' => StoreSetting::value('brand_logo_path'),
            'brandLogoUrl' => StoreSetting::assetUrl('brand_logo_path'),
            'homeHeroImagePath' => StoreSetting::value('home_hero_image_path'),
            'homeHeroImageUrl' => StoreSetting::assetUrl('home_hero_image_path', 'assets/brand/hero-workshop.svg'),
            'landingBackgroundPath' => StoreSetting::value('landing_background_path'),
            'landingBackgroundUrl' => StoreSetting::assetUrl('landing_background_path', 'assets/brand/landing-background.png'),
            'landingBackgroundBlur' => $this->normalizeBlurValue(StoreSetting::value('landing_background_blur', 5)),
        ]);
    }

    public function update(StoreBrandingRequest $request): RedirectResponse
    {
        $brandLogoPath = $request->validated('brand_logo_path');
        $homeHeroImagePath = $request->validated('home_hero_image_path');
        $landingBackgroundPath = $request->validated('landing_background_path');
        $landingBackgroundBlur = $this->normalizeBlurValue($request->validated('landing_background_blur'));

        if ($request->boolean('clear_brand_logo')) {
            $brandLogoPath = null;
        }

        if ($request->boolean('clear_home_hero_image')) {
            $homeHeroImagePath = null;
        }

        if ($request->boolean('clear_landing_background')) {
            $landingBackgroundPath = null;
        }

        if ($request->hasFile('brand_logo_upload')) {
            $brandLogoPath = $this->storeUploadedImage(
                $request->file('brand_logo_upload'),
                'branding/logo',
            );
        }

        if ($request->hasFile('home_hero_image_upload')) {
            $homeHeroImagePath = $this->storeUploadedImage(
                $request->file('home_hero_image_upload'),
                'branding/home',
            );
        }

        if ($request->hasFile('landing_background_upload')) {
            $landingBackgroundPath = $this->storeUploadedImage(
                $request->file('landing_background_upload'),
                'branding/landing-background',
            );
        }

        StoreSetting::putMany([
            'brand_logo_path' => $brandLogoPath,
            'home_hero_image_path' => $homeHeroImagePath,
            'landing_background_path' => $landingBackgroundPath,
            'landing_background_blur' => (string) $landingBackgroundBlur,
        ]);

        return redirect()
            ->route('admin.branding.edit')
            ->with('status', 'Identidad visual actualizada.');
    }

    private function storeUploadedImage(UploadedFile $file, string $folder): string
    {
        $directory = UploadedAsset::uploadsDirectory($folder);
        File::ensureDirectoryExists($directory);

        $filename = Str::uuid()->toString().'.'.$file->extension();
        $file->move($directory, $filename);

        return 'uploads/'.$folder.'/'.$filename;
    }

    private function normalizeBlurValue(mixed $value): int
    {
        return max(0, min(24, (int) ($value ?? 5)));
    }
}
