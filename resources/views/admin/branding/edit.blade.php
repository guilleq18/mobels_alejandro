@extends('layouts.admin')

@section('title', 'Identidad Visual | Panel Admin')
@section('eyebrow', 'Marca')
@section('page-title', 'Identidad visual')
@section('page-copy', 'Actualizá el logo del sitio y la imagen principal del inicio sin tocar código ni mover archivos manualmente.')

@section('content')
    <section class="form-shell">
        <article class="form-panel">
            <form class="form" method="POST" action="{{ route('admin.branding.update') }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="panel-header">
                    <div>
                        <span class="pill">Assets globales</span>
                        <h2>Logo y portada del inicio</h2>
                    </div>
                </div>

                <div class="form-grid">
                    <label class="field">
                        <span>Ruta o URL del logo</span>
                        <input
                            type="text"
                            name="brand_logo_path"
                            value="{{ old('brand_logo_path', $brandLogoPath) }}"
                            placeholder="Ej: uploads/branding/logo/logo.png"
                        >
                        <small class="field-help">Opcional. Puede ser una ruta pública dentro de `public` o una URL externa.</small>
                        @error('brand_logo_path')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="field">
                        <span>Subir nuevo logo</span>
                        <input type="file" name="brand_logo_upload" accept="image/*">
                        <small class="field-help">Si subís un archivo, tiene prioridad sobre la ruta manual.</small>
                        @error('brand_logo_upload')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>
                </div>

                <div class="checkboxes">
                    <label class="check">
                        <input type="checkbox" name="clear_brand_logo" value="1" @checked(old('clear_brand_logo'))>
                        <span>Volver al logo predeterminado</span>
                    </label>
                </div>

                <div class="form-grid">
                    <label class="field">
                        <span>Ruta o URL de la imagen del inicio</span>
                        <input
                            type="text"
                            name="home_hero_image_path"
                            value="{{ old('home_hero_image_path', $homeHeroImagePath) }}"
                            placeholder="Ej: uploads/branding/home/inicio.jpg"
                        >
                        <small class="field-help">Esta imagen reemplaza la portada principal de la home.</small>
                        @error('home_hero_image_path')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="field">
                        <span>Subir nueva imagen de inicio</span>
                        <input type="file" name="home_hero_image_upload" accept="image/*">
                        <small class="field-help">Recomendado: imagen horizontal en buena resolución.</small>
                        @error('home_hero_image_upload')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>
                </div>

                <div class="checkboxes">
                    <label class="check">
                        <input type="checkbox" name="clear_home_hero_image" value="1" @checked(old('clear_home_hero_image'))>
                        <span>Volver a la imagen predeterminada del inicio</span>
                    </label>
                </div>

                <div class="form-actions">
                    <button class="button button-primary" type="submit">Guardar identidad visual</button>
                    <a class="ghost-link" href="{{ route('admin.dashboard') }}">Volver al dashboard</a>
                </div>
            </form>
        </article>

        <aside class="aside-panel">
            <div>
                <span class="pill">Vista previa</span>
                <h2 style="margin: .75rem 0 .45rem;">Logo actual</h2>
                <p class="help-copy">Se refleja en la tienda pública, el login y el panel de administración.</p>
            </div>

            <div class="panel" style="padding: 1rem;">
                <x-brand-logo />
            </div>

            <div>
                <h2 style="margin: .75rem 0 .45rem;">Portada actual del inicio</h2>
                <p class="help-copy">Esta es la imagen que aparece en el bloque principal de la home.</p>
            </div>

            <div class="thumb thumb--wide" style="width: 100%; height: 15rem;">
                <img src="{{ $homeHeroImageUrl }}" alt="Vista previa de la imagen principal del inicio">
            </div>

            @if ($brandLogoUrl)
                <div>
                    <h2 style="margin: .75rem 0 .45rem;">Archivo de logo cargado</h2>
                    <div class="thumb thumb--wide" style="width: 8rem; height: 8rem;">
                        <img src="{{ $brandLogoUrl }}" alt="Logo cargado">
                    </div>
                </div>
            @endif
        </aside>
    </section>
@endsection
