@csrf

<div class="form-grid">
    <label class="field">
        <span>Nombre</span>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" placeholder="Ej: Cocinas" required>
        @error('name')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </label>

    <label class="field">
        <span>Slug</span>
        <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="Se genera automaticamente si lo dejás vacío">
        @error('slug')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </label>
</div>

<label class="field">
    <span>Descripcion</span>
    <textarea name="description" placeholder="Contá qué tipo de muebles agrupa esta categoria.">{{ old('description', $category->description) }}</textarea>
    @error('description')
        <small class="field-error">{{ $message }}</small>
    @enderror
</label>

<div class="form-grid">
    <label class="field">
        <span>Ruta publica o URL de imagen</span>
        <input type="text" name="image" value="{{ old('image', $category->image) }}" placeholder="Ej: uploads/categories/cocinas.jpg">
        <small class="field-help">Opcional. Puede ser una ruta local dentro de public o una URL externa.</small>
        @error('image')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </label>

    <label class="field">
        <span>Subir imagen</span>
        <input type="file" name="image_upload" accept="image/*">
        <small class="field-help">Si subís un archivo, va a tener prioridad sobre la ruta manual.</small>
        @error('image_upload')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </label>
</div>

<div class="checkboxes">
    <label class="check">
        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $category->is_featured))>
        <span>Mostrar como categoria destacada</span>
    </label>
</div>

@if ($category->image_url)
    <div class="aside-panel" style="padding: 1rem;">
        <span class="pill">Vista previa</span>
        <div class="thumb thumb--wide" style="width: 100%; height: 14rem;">
            <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
        </div>
    </div>
@endif

<div class="form-actions">
    <button class="button button-primary" type="submit">{{ $submitLabel }}</button>
    <a class="ghost-link" href="{{ route('admin.categories.index') }}">Volver al listado</a>
</div>
