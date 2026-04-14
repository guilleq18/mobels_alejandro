@extends('layouts.admin')

@section('title', 'Nueva Categoria | MOBELS Alejandro')
@section('eyebrow', 'Catalogo')
@section('page-title', 'Crear categoria')
@section('page-copy', 'Sumá una nueva linea comercial para ordenar el catalogo y usarla luego en productos.')

@section('content')
    <section class="form-shell">
        <article class="form-panel">
            <form class="form" method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                @include('admin.categories.partials.form', ['submitLabel' => 'Crear categoria'])
            </form>
        </article>

        <aside class="aside-panel">
            <span class="pill">Consejo</span>
            <h3>Una categoria clara ayuda a vender mejor.</h3>
            <p>Usá nombres simples como Cocinas, Placares, Living u Oficinas para que el catalogo sea mas facil de navegar.</p>
            <p class="help-copy">Si dejás el slug vacío, lo generamos automáticamente desde el nombre.</p>
        </aside>
    </section>
@endsection
