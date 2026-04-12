@extends('layouts.admin')

@section('title', 'Editar Producto | M&Ouml;BELS Alejandro')
@section('eyebrow', 'Catalogo')
@section('page-title', 'Editar producto')
@section('page-copy', 'Actualizá la ficha y controlá cómo se muestran sus melaminas, carruseles y datos comerciales en la tienda pública.')

@section('content')
    <section class="form-shell">
        <article class="form-panel">
            <form class="form" method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.products.partials.form', ['submitLabel' => 'Guardar cambios'])
            </form>
        </article>

        <aside class="aside-panel">
            <span class="pill">Publico</span>
            <h3>{{ $product->name }}</h3>
            <p>{{ $product->short_description }}</p>
            <div class="thumb thumb--wide" style="width: 100%; height: 14rem;">
                <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}">
            </div>
            <div class="inline-actions">
                <a class="ghost-link" href="{{ route('products.show', $product) }}" target="_blank" rel="noreferrer">Abrir ficha publica</a>
            </div>
        </aside>
    </section>
@endsection

@include('admin.products.partials.variant-builder-script')
