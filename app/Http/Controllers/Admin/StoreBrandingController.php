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
        ]);
    }

    public function update(StoreBrandingRequest $request): RedirectResponse
    {
        $brandLogoPath = $request->validated('brand_logo_path');
        $homeHeroImagePath = $request->validated('home_hero_image_path');

        if ($request->boolean('clear_brand_logo')) {
            $brandLogoPath = null;
        }

        if ($request->boolean('clear_home_hero_image')) {
            $homeHeroImagePath = null;
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

        StoreSetting::putMany([
            'brand_logo_path' => $brandLogoPath,
            'home_hero_image_path' => $homeHeroImagePath,
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
}
