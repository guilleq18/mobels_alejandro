@csrf

@php
    $variantInputs = old('variants');

    if ($variantInputs === null) {
        $variantInputs = $product->relationLoaded('colorVariants')
            ? $product->colorVariants->map(fn ($variant): array => [
                'name' => $variant->name,
                'swatch_image' => $variant->swatch_image_path,
                'swatch_preview' => $variant->swatch_image_url ?? $variant->galleryImages->first()?->image_url,
                'images' => $variant->galleryImages->pluck('image_path')->all(),
            ])->all()
            : [];
    } else {
        $variantInputs = collect($variantInputs)
            ->map(function ($variantInput): array {
                $variantInput = is_array($variantInput) ? $variantInput : [];

                $images = collect($variantInput['images'] ?? [])
                    ->map(fn ($image) => (string) $image)
                    ->filter()
                    ->values()
                    ->all();

                return [
                    'name' => (string) ($variantInput['name'] ?? ''),
                    'swatch_image' => (string) ($variantInput['swatch_image'] ?? ''),
                    'swatch_preview' => (string) ($variantInput['swatch_image'] ?? ''),
                    'images' => $images,
                ];
            })
            ->all();
    }

    if ($variantInputs === []) {
        $variantInputs = [[
            'name' => '',
            'swatch_image' => '',
            'swatch_preview' => null,
            'images' => [''],
        ]];
    }
@endphp

<div class="form-grid form-grid-3">
    <label class="field">
        <span>Categoria</span>
        <select name="category_id" required>
            <option value="">Seleccionar categoria</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id', $product->category_id) === (string) $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </label>

    <label class="field">
        <span>Nombre</span>
        <input type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="Ej: Escritorio Nativo" required>
        @error('name')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </label>

    <label class="field">
        <span>Slug</span>
        <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" placeholder="Se genera automaticamente">
        @error('slug')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </label>
</div>

<div class="form-grid form-grid-3">
    <label class="field">
        <span>SKU</span>
        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" placeholder="Ej: OFI-NATIVO-001">
        @error('sku')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </label>

    <label class="field">
        <span>Precio</span>
        <input type="text" name="price" value="{{ old('price', $product->price) }}" placeholder="Ej: 480000 o 480.000,50" required>
        @error('price')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </label>

    <label class="field">
        <span>Entrega estimada</span>
        <input type="number" min="1" max="120" name="lead_time_days" value="{{ old('lead_time_days', $product->lead_time_days ?? 7) }}" required>
        <small class="field-help">Este texto se muestra en la tienda como “Disponible en X dias”.</small>
        @error('lead_time_days')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </label>
</div>

<label class="field">
    <span>Descripcion corta</span>
    <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" placeholder="Resumen breve para cards y listados." required>
    @error('short_description')
        <small class="field-error">{{ $message }}</small>
    @enderror
</label>

<label class="field">
    <span>Descripcion completa</span>
    <textarea name="description" placeholder="Detalles de materiales, medidas, uso ideal o terminaciones.">{{ old('description', $product->description) }}</textarea>
    @error('description')
        <small class="field-error">{{ $message }}</small>
    @enderror
</label>

<section class="variant-builder" data-variant-builder>
    <div class="panel-header">
        <div>
            <span class="pill">Melaminas y carrusel</span>
            <h3>Melaminas disponibles por producto</h3>
            <p class="help-copy">Cada melamina puede tener una imagen de muestra y su propio carrusel de fotos, igual que una publicación con varias vistas.</p>
        </div>

        <button class="button button-secondary" type="button" data-add-variant>
            Agregar melamina
        </button>
    </div>

    @if (
        $errors->has('variants')
        || $errors->has('variants.*.name')
        || $errors->has('variants.*.swatch_image')
        || $errors->has('variant_swatch_uploads.*')
        || $errors->has('variants.*.images')
        || $errors->has('variants.*.images.*')
        || $errors->has('variant_gallery_uploads.*.*')
    )
        <div class="alert alert-error">
            Revisá la configuración de melaminas. Cada una necesita nombre, una imagen de muestra y al menos una imagen para el carrusel.
        </div>
    @endif

    <div class="variant-list" data-variant-list>
        @foreach ($variantInputs as $variantIndex => $variantInput)
            @php
                $variantImages = collect($variantInput['images'] ?? [])->map(fn ($image) => (string) $image)->all();
                $variantSwatchPreview = $variantInput['swatch_preview'] ?? ($variantInput['swatch_image'] ?? null);

                if ($variantImages === []) {
                    $variantImages = [''];
                }

                $variantImagesError = $errors->first("variants.$variantIndex.images")
                    ?: $errors->first("variants.$variantIndex.images.*")
                    ?: $errors->first("variant_gallery_uploads.$variantIndex.*");

                $hasVariantErrors = $errors->has("variants.$variantIndex.name")
                    || $errors->has("variants.$variantIndex.swatch_image")
                    || $errors->has("variant_swatch_uploads.$variantIndex")
                    || $variantImagesError;
            @endphp

            <div @class(['variant-card', 'is-collapsed' => ! $loop->first && ! $hasVariantErrors]) data-variant-item>
                <div class="variant-card__head">
                    <div class="variant-card__title">
                        <span class="pill">Melamina {{ $loop->iteration }}</span>
                        <strong class="brand-font" data-variant-title>{{ $variantInput['name'] ?: 'Nueva melamina' }}</strong>
                    </div>

                    <div class="inline-actions">
                        <button
                            class="link-button variant-toggle"
                            type="button"
                            data-toggle-variant
                            aria-expanded="{{ ! $loop->first && ! $hasVariantErrors ? 'false' : 'true' }}"
                        >
                            <span data-toggle-label>{{ ! $loop->first && ! $hasVariantErrors ? 'Expandir' : 'Contraer' }}</span>
                            <span class="variant-toggle__icon" data-toggle-icon>{{ ! $loop->first && ! $hasVariantErrors ? '+' : '-' }}</span>
                        </button>
                        <button class="link-button button-danger" type="button" data-remove-variant>Quitar melamina</button>
                    </div>
                </div>

                <div class="variant-card__body" data-variant-body>
                    <div class="form-grid">
                        <label class="field">
                            <span>Nombre de la melamina</span>
                            <input
                                type="text"
                                name="variants[{{ $variantIndex }}][name]"
                                value="{{ $variantInput['name'] ?? '' }}"
                                placeholder="Ej: Roble natural"
                                data-variant-name
                            >
                            @error("variants.$variantIndex.name")
                                <small class="field-error">{{ $message }}</small>
                            @enderror
                        </label>

                        <div class="variant-swatch-panel">
                            @if ($variantSwatchPreview)
                                <div class="variant-swatch-preview">
                                    <img src="{{ $variantSwatchPreview }}" alt="Muestra de {{ $variantInput['name'] ?: 'melamina' }}">
                                </div>
                            @endif

                            <div class="form-grid">
                                <label class="field">
                                    <span>Ruta o URL de la muestra</span>
                                    <input
                                        type="text"
                                        name="variants[{{ $variantIndex }}][swatch_image]"
                                        value="{{ $variantInput['swatch_image'] ?? '' }}"
                                        placeholder="Ej: uploads/melaminas/roble-natural.jpg"
                                    >
                                    <small class="field-help">Podés usar una ruta pública, una URL externa o dejarla vacía y subir el archivo abajo.</small>
                                    @error("variants.$variantIndex.swatch_image")
                                        <small class="field-error">{{ $message }}</small>
                                    @enderror
                                </label>

                                <label class="field">
                                    <span>Subir muestra de melamina</span>
                                    <input type="file" name="variant_swatch_uploads[{{ $variantIndex }}]" accept="image/*" data-variant-swatch-upload>
                                    <small class="field-help">Si subís una imagen, tendrá prioridad sobre la ruta manual en esta edición.</small>
                                    @error("variant_swatch_uploads.$variantIndex")
                                        <small class="field-error">{{ $message }}</small>
                                    @enderror
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="variant-images" data-image-list>
                        @foreach ($variantImages as $imageIndex => $image)
                            <div class="variant-image-row" data-image-item>
                                <label class="field">
                                    <span>Imagen {{ $loop->iteration }}</span>
                                    <input
                                        type="text"
                                        name="variants[{{ $variantIndex }}][images][{{ $imageIndex }}]"
                                        value="{{ $image }}"
                                        placeholder="URL, ruta pública o data URL"
                                    >
                                </label>

                                <button class="link-button button-danger" type="button" data-remove-image>Quitar</button>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-grid">
                        <label class="field">
                            <span>Subir imagenes del carrusel</span>
                            <input type="file" name="variant_gallery_uploads[{{ $variantIndex }}][]" accept="image/*" multiple data-variant-gallery-upload>
                            <small class="field-help">Podés subir hasta 5 imágenes por vez. El orden manual se respeta primero y los archivos subidos se agregan al final.</small>
                            @if ($variantImagesError)
                                <small class="field-error">{{ $variantImagesError }}</small>
                            @endif
                        </label>
                    </div>

                    <div class="inline-actions">
                        <button class="button button-secondary" type="button" data-add-image>Agregar imagen manual</button>
                        <small class="muted">Usá la muestra para la paleta y las fotos para el carrusel público.</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <template data-variant-template>
        <div class="variant-card" data-variant-item>
            <div class="variant-card__head">
                <div class="variant-card__title">
                    <span class="pill">Nueva melamina</span>
                    <strong class="brand-font" data-variant-title>Nueva melamina</strong>
                </div>

                <div class="inline-actions">
                    <button class="link-button variant-toggle" type="button" data-toggle-variant aria-expanded="true">
                        <span data-toggle-label>Contraer</span>
                        <span class="variant-toggle__icon" data-toggle-icon>-</span>
                    </button>
                    <button class="link-button button-danger" type="button" data-remove-variant>Quitar melamina</button>
                </div>
            </div>

            <div class="variant-card__body" data-variant-body>
                <div class="form-grid">
                    <label class="field">
                        <span>Nombre de la melamina</span>
                        <input type="text" name="variants[__INDEX__][name]" value="" placeholder="Ej: Roble natural" data-variant-name>
                    </label>

                    <div class="variant-swatch-panel">
                        <div class="form-grid">
                            <label class="field">
                                <span>Ruta o URL de la muestra</span>
                                <input
                                    type="text"
                                    name="variants[__INDEX__][swatch_image]"
                                    value=""
                                    placeholder="Ej: uploads/melaminas/roble-natural.jpg"
                                >
                                <small class="field-help">Podés usar una ruta pública, una URL externa o dejarla vacía y subir el archivo abajo.</small>
                            </label>

                            <label class="field">
                                <span>Subir muestra de melamina</span>
                                <input type="file" name="variant_swatch_uploads[__INDEX__]" accept="image/*" data-variant-swatch-upload>
                                <small class="field-help">La subida directa tendrá prioridad sobre la ruta manual.</small>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="variant-images" data-image-list></div>

                <div class="form-grid">
                    <label class="field">
                        <span>Subir imagenes del carrusel</span>
                        <input type="file" name="variant_gallery_uploads[__INDEX__][]" accept="image/*" multiple data-variant-gallery-upload>
                        <small class="field-help">Podés subir hasta 5 imágenes por vez.</small>
                    </label>
                </div>

                <div class="inline-actions">
                    <button class="button button-secondary" type="button" data-add-image>Agregar imagen manual</button>
                    <small class="muted">Ordená las fotos como querés verlas en el carrusel.</small>
                </div>
            </div>
        </div>
    </template>

    <template data-image-template>
        <div class="variant-image-row" data-image-item>
            <label class="field">
                <span>Nueva imagen</span>
                <input type="text" name="variants[__INDEX__][images][__IMAGE_INDEX__]" value="" placeholder="URL, ruta pública o data URL">
            </label>

            <button class="link-button button-danger" type="button" data-remove-image>Quitar</button>
        </div>
    </template>
</section>

<div class="checkboxes">
    <label class="check">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))>
        <span>Mostrar en tienda publica</span>
    </label>

    <label class="check">
        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))>
        <span>Marcar como destacado</span>
    </label>
</div>

<div class="form-actions">
    <button class="button button-primary" type="submit">{{ $submitLabel }}</button>
    <a class="ghost-link" href="{{ route('admin.products.index') }}">Volver al listado</a>
</div>
