@extends('layouts.store')

@section('description', 'Catalogo de productos de M&Ouml;BELS Alejandro con muebles de melamina para cocina, dormitorio, living y oficina.')
@section('title', 'Catalogo | M&Ouml;BELS Alejandro')

@section('content')
    <section class="page-intro">
        <div class="page-intro__header">
            <div>
                <p class="breadcrumbs">
                    <a href="{{ route('home') }}">Inicio</a>
                    <span class="muted"> / Catalogo</span>
                    @if ($selectedCategory)
                        <span class="muted"> / {{ $selectedCategory->name }}</span>
                    @endif
                </p>
                <span class="chip">Catalogo publico</span>
                <h1 class="page-title">
                    {{ $selectedCategory ? 'Productos de '.$selectedCategory->name : 'Muebles para cada espacio del proyecto.' }}
                </h1>
            </div>

            <p class="copy">
                {{ $selectedCategory?->description
                    ?? 'Explora la primera version del catalogo de M&Ouml;BELS Alejandro. Ya queda preparada para crecer con mas categorias, filtros, imagenes y fichas tecnicas.' }}
            </p>
        </div>

        <div class="filters">
            <a
                href="{{ route('products.index') }}"
                @class(['filter-chip', 'is-active' => ! $selectedCategory])
            >
                Todos
            </a>

            @foreach ($categories as $category)
                <a
                    href="{{ route('products.index', ['categoria' => $category->slug]) }}"
                    @class(['filter-chip', 'is-active' => $selectedCategory?->is($category)])
                >
                    {{ $category->name }}
                    <span class="muted">({{ $category->active_products_count }})</span>
                </a>
            @endforeach
        </div>
    </section>

    @if ($products->isEmpty())
        <section class="empty-state">
            <span class="pill">Sin resultados</span>
            <h2>No encontramos productos para este filtro.</h2>
            <p>Podemos volver al catalogo completo o cargar nuevos items para esta categoria en la siguiente iteracion.</p>
            <div class="card-actions">
                <a class="btn btn-primary" href="{{ route('products.index') }}">Ver todos los productos</a>
                <a class="btn btn-secondary" href="{{ route('home') }}">Volver al inicio</a>
            </div>
        </section>
    @else
        <section class="listing-grid">
            @foreach ($products as $product)
                <article class="product">
                    <div class="visual">
                        <img
                            class="product-banner"
                            src="{{ $product->primary_image_url }}"
                            alt="Banner ilustrado de {{ $product->name }}"
                        >
                    </div>

                    <div class="product-copy">
                        <div>
                            <span class="pill">{{ $product->category?->name }}</span>
                            <h3>{{ $product->name }}</h3>
                            <p>{{ $product->short_description }}</p>
                            <p class="muted">{{ $product->description }}</p>
                        </div>

                            <div class="price">
                                <div>
                                    <span class="muted">Precio referencia</span>
                                    <strong class="brand-font">AR$ {{ number_format((float) $product->price, 0, ',', '.') }}</strong>
                                </div>

                                <div class="card-actions">
                                    <span class="availability-tag">{{ $product->availability_label }}</span>
                                    <a class="btn btn-secondary btn-small" href="{{ route('products.show', $product) }}#presupuesto">
                                        Pedir presupuesto
                                    </a>
                                    <a class="text-link" href="{{ route('products.show', $product) }}">Ver ficha</a>
                                </div>
                            </div>
                        </div>
                    </article>
            @endforeach
        </section>
    @endif

    <section class="cta">
        <div>
            <h2>El catalogo ya tambien capta consultas.</h2>
            <p>
                Cada ficha ya puede recibir una solicitud de presupuesto y quedar lista
                para continuar por WhatsApp o por el canal de contacto que el cliente prefiera.
            </p>
        </div>
        <a class="btn btn-secondary" href="{{ route('home') }}">Volver al inicio</a>
    </section>
@endsection
