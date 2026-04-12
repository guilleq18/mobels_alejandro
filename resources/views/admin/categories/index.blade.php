@extends('layouts.admin')

@section('title', 'Categorias Admin | M&Ouml;BELS Alejandro')
@section('eyebrow', 'Catalogo')
@section('page-title', 'Categorias')
@section('page-copy', 'Organizá el catalogo por lineas comerciales y mantené visible la estructura de la tienda.')

@section('content')
    <section class="table-shell">
        <div class="table-head">
            <div>
                <span class="pill">ABM categorias</span>
                <h2>Listado completo</h2>
                <p class="table-caption">Cada categoria puede destacarse en home y agrupar productos del catalogo publico.</p>
            </div>
            <div class="inline-actions">
                <a class="button button-primary" href="{{ route('admin.categories.create') }}">Nueva categoria</a>
            </div>
        </div>

        @if ($categories->isEmpty())
            <div class="empty-state">
                <span class="pill">Sin categorias</span>
                <h2>No hay categorias cargadas.</h2>
                <p>Creá la primera para empezar a estructurar la tienda.</p>
                <div class="empty-actions" style="margin-top: 1rem;">
                    <a class="button button-primary" href="{{ route('admin.categories.create') }}">Crear categoria</a>
                </div>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Slug</th>
                            <th>Productos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    <div class="table-actions">
                                        <div class="thumb">
                                            @if ($category->image_url)
                                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
                                            @else
                                                <img src="{{ asset('assets/brand/hero-workshop.svg') }}" alt="{{ $category->name }}">
                                            @endif
                                        </div>

                                        <div class="entity">
                                            <strong>{{ $category->name }}</strong>
                                            <p>{{ $category->description ?: 'Sin descripcion.' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ $category->products_count }}</td>
                                <td>
                                    @if ($category->is_featured)
                                        <span class="status-pill status-ok">Destacada</span>
                                    @else
                                        <span class="status-pill">Base</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a class="link-button" href="{{ route('admin.categories.edit', $category) }}">Editar</a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="link-button button-danger" type="submit">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
