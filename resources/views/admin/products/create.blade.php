@extends('layouts.admin')

@section('title', 'Nuevo Producto | MOBELS Alejandro')
@section('eyebrow', 'Catalogo')
@section('page-title', 'Crear producto')
@section('page-copy', 'Cargá una ficha completa con precio, entrega estimada, melaminas y visuales para sumarla a la tienda.')

@section('content')
    <section class="form-shell">
        <article class="form-panel">
            <form class="form" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @include('admin.products.partials.form', ['submitLabel' => 'Crear producto'])
            </form>
        </article>

        <aside class="aside-panel">
            <span class="pill">Consejo</span>
            <h3>Empezá con una ficha simple y clara.</h3>
            <p>Un nombre específico, una descripción corta y una categoría correcta ya alcanzan para publicar un buen primer catálogo.</p>
            <p class="help-copy">Si dejás el slug vacío, lo generamos automáticamente.</p>
        </aside>
    </section>
@endsection

@include('admin.products.partials.variant-builder-script')
