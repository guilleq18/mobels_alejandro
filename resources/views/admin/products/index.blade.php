@extends('layouts.admin')

@section('title', 'Productos Admin | MOBELS Alejandro')
@section('eyebrow', 'Catalogo')
@section('page-title', 'Productos')
@section('page-copy', 'Cargá fichas, melaminas, carruseles, precio y visibilidad para controlar lo que el cliente ve en la tienda.')

@section('content')
    <section class="table-shell">
        <div class="table-head">
            <div>
                <span class="pill">ABM productos</span>
                <h2>Listado completo</h2>
                <p class="table-caption">Cada producto cargado desde este panel ya impacta en el catalogo y en la ficha publica.</p>
            </div>
            <div class="inline-actions">
                <a class="button button-primary" href="{{ route('admin.products.create') }}">Nuevo producto</a>
            </div>
        </div>

        @if ($products->isEmpty())
            <div class="empty-state">
                <span class="pill">Sin productos</span>
                <h2>No hay productos cargados.</h2>
                <p>Creá el primero y quedará disponible para la tienda pública si lo marcás como activo.</p>
                <div class="empty-actions" style="margin-top: 1rem;">
                    <a class="button button-primary" href="{{ route('admin.products.create') }}">Crear producto</a>
                </div>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Categoria</th>
                            <th>Precio</th>
                            <th>Entrega</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <div class="table-actions">
                                        <div class="thumb thumb--wide">
                                            <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}">
                                        </div>

                                        <div class="entity">
                                            <strong>{{ $product->name }}</strong>
                                            <p>{{ $product->short_description }}</p>
                                            <small>Slug: {{ $product->slug }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $product->category?->name ?? 'Sin categoria' }}</td>
                                <td>AR$ {{ number_format((float) $product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->availability_label }}</td>
                                <td>
                                    <div class="entity">
                                        @if ($product->is_active)
                                            <span class="status-pill status-ok">Publicado</span>
                                        @else
                                            <span class="status-pill status-danger">Oculto</span>
                                        @endif

                                        @if ($product->is_featured)
                                            <small>Destacado en home</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a class="link-button" href="{{ route('admin.products.edit', $product) }}">Editar</a>
                                        <a class="link-button" href="{{ route('products.show', $product) }}" target="_blank" rel="noreferrer">Ver ficha</a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
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
