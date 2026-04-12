<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->withCount('products')
            ->orderByDesc('is_featured')
            ->orderBy('name')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create', [
            'category' => new Category(),
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        Category::query()->create($this->payload($request));

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Categoria creada y lista para usar en el catalogo.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($this->payload($request));

        return redirect()
            ->route('admin.categories.edit', $category)
            ->with('status', 'Categoria actualizada.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'No se puede eliminar una categoria que todavia tiene productos asociados.');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Categoria eliminada.');
    }

    private function payload(CategoryRequest $request): array
    {
        $payload = collect($request->validated())
            ->except('image_upload')
            ->all();

        if ($request->hasFile('image_upload')) {
            $payload['image'] = $this->storeUploadedImage($request->file('image_upload'), 'categories');
        }

        return $payload;
    }

    private function storeUploadedImage(UploadedFile $file, string $folder): string
    {
        $directory = public_path('uploads/'.$folder);
        File::ensureDirectoryExists($directory);

        $filename = Str::uuid()->toString().'.'.$file->extension();
        $file->move($directory, $filename);

        return 'uploads/'.$folder.'/'.$filename;
    }
}
