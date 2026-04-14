@extends('layouts.admin')

@section('title', 'Dashboard Admin | MOBELS Alejandro')
@section('eyebrow', 'Panel de control')
@section('page-title', 'Dashboard comercial')
@section('page-copy', 'Resumen rapido del catalogo, el contenido publicado y las solicitudes de presupuesto que ya entran desde la tienda.')

@section('content')
    <section class="metric-grid">
        @foreach ($stats as $stat)
            <article class="metric">
                <span class="pill">{{ $stat['label'] }}</span>
                <strong>{{ $stat['value'] }}</strong>
                <p>{{ $stat['hint'] }}</p>
            </article>
        @endforeach
    </section>

    <section class="cards-grid">
        <article class="panel">
            <span class="pill">Accion</span>
            <h2>Cargar una categoria nueva</h2>
            <p>Agregá una linea de producto y dejala lista para usarse en el catalogo.</p>
            <div class="inline-actions" style="margin-top: 1rem;">
                <a class="button button-primary" href="{{ route('admin.categories.create') }}">Nueva categoria</a>
            </div>
        </article>

        <article class="panel">
            <span class="pill">Accion</span>
            <h2>Publicar un producto</h2>
            <p>Cargá precio, entrega estimada, colores e imagenes para que se refleje en la tienda publica.</p>
            <div class="inline-actions" style="margin-top: 1rem;">
                <a class="button button-primary" href="{{ route('admin.products.create') }}">Nuevo producto</a>
            </div>
        </article>

        <article class="panel">
            <span class="pill">Inbox</span>
            <h2>Seguir presupuestos</h2>
            <p>Entrá al listado completo de consultas enviadas desde las fichas de producto.</p>
            <div class="inline-actions" style="margin-top: 1rem;">
                <a class="button button-secondary" href="{{ route('admin.quote-requests.index') }}">Ver presupuestos</a>
            </div>
        </article>

        <article class="panel">
            <span class="pill">Marca</span>
            <h2>Actualizar identidad visual</h2>
            <p>Cambiá el logo del sitio y la imagen principal del inicio desde el panel.</p>
            <div class="inline-actions" style="margin-top: 1rem;">
                <a class="button button-secondary" href="{{ route('admin.branding.edit') }}">Editar identidad</a>
            </div>
        </article>
    </section>

    <section class="split-grid">
        <article class="table-shell">
            <div class="table-head">
                <div>
                    <span class="pill">Productos recientes</span>
                    <h2>Ultimas altas del catalogo</h2>
                </div>
                <a class="ghost-link" href="{{ route('admin.products.index') }}">Administrar productos</a>
            </div>

            @if ($recentProducts->isEmpty())
                <div class="empty-state">
                    <span class="pill">Sin datos</span>
                    <h2>Todavia no hay productos cargados.</h2>
                    <p>Podés crear el primero desde el panel y se reflejará en el catalogo publico.</p>
                </div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Categoria</th>
                                <th>Precio</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentProducts as $product)
                                <tr>
                                    <td>
                                        <div class="entity">
                                            <strong>{{ $product->name }}</strong>
                                            <p>{{ $product->short_description }}</p>
                                        </div>
                                    </td>
                                    <td>{{ $product->category?->name ?? 'Sin categoria' }}</td>
                                    <td>AR$ {{ number_format((float) $product->price, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($product->is_active)
                                            <span class="status-pill status-ok">Activo</span>
                                        @else
                                            <span class="status-pill status-danger">Oculto</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </article>

        <article class="panel">
            <div class="panel-header">
                <div>
                    <span class="pill">Categorias</span>
                    <h2>Base del catalogo</h2>
                </div>
                <a class="ghost-link" href="{{ route('admin.categories.index') }}">Ver todas</a>
            </div>

            <ul class="panel-list">
                @forelse ($recentCategories as $category)
                    <li>
                        <div class="entity">
                            <strong>{{ $category->name }}</strong>
                            <p>{{ $category->description ?: 'Sin descripcion todavia.' }}</p>
                        </div>
                        <small>{{ $category->products_count }} productos</small>
                    </li>
                @empty
                    <li>
                        <div class="entity">
                            <strong>Sin categorias</strong>
                            <p>Creá la primera para empezar a ordenar el catalogo.</p>
                        </div>
                    </li>
                @endforelse
            </ul>
        </article>
    </section>

    <section class="table-shell">
        <div class="table-head">
            <div>
                <span class="pill">Presupuestos recientes</span>
                <h2>Consultas que entraron desde la tienda</h2>
            </div>
            <a class="ghost-link" href="{{ route('admin.quote-requests.index') }}">Abrir inbox completo</a>
        </div>

        @if ($recentQuotes->isEmpty())
            <div class="empty-state">
                <span class="pill">Sin consultas</span>
                <h2>Todavia no llegaron presupuestos.</h2>
                <p>Cuando un cliente complete el formulario desde una ficha, aparecerá aca.</p>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Contacto</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentQuotes as $quoteRequest)
                            <tr>
                                <td>
                                    <div class="entity">
                                        <strong>{{ $quoteRequest->customer_name }}</strong>
                                        <p>{{ $quoteRequest->city ?: 'Sin localidad' }}</p>
                                    </div>
                                </td>
                                <td>{{ $quoteRequest->product?->name ?? 'Producto eliminado' }}</td>
                                <td>
                                    <div class="entity">
                                        <strong>{{ $quoteRequest->phone }}</strong>
                                        <p>{{ $quoteRequest->email ?: 'Sin email' }}</p>
                                    </div>
                                </td>
                                <td>{{ $quoteRequest->created_at?->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
