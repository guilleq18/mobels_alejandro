@extends('layouts.admin')

@section('title', 'Editar Categoria | MOBELS Alejandro')
@section('eyebrow', 'Catalogo')
@section('page-title', 'Editar categoria')
@section('page-copy', 'Actualizá la informacion de la linea y mantené consistente la estructura del catalogo.')

@section('content')
    <section class="form-shell">
        <article class="form-panel">
            <form class="form" method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.categories.partials.form', ['submitLabel' => 'Guardar cambios'])
            </form>
        </article>

        <aside class="aside-panel">
            <span class="pill">Resumen</span>
            <h3>{{ $category->name }}</h3>
            <p>{{ $category->description ?: 'Esta categoria todavia no tiene descripcion.' }}</p>
            <p class="help-copy">Productos asociados: {{ $category->products()->count() }}</p>
        </aside>
    </section>
@endsection
