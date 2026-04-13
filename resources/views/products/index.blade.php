@extends('layouts.store')

@section('body_class', 'catalog-page')
@section('description', 'Catalogo de productos de M&Ouml;BELS Alejandro con muebles de melamina para cocina, dormitorio, living y oficina.')
@section('title', 'Catalogo | M&Ouml;BELS Alejandro')

@section('page_head')
    <style>
        body.catalog-page .wrap{width:min(1240px,calc(100% - 1.5rem));padding:1.8rem 0 3rem}
        body.catalog-page .topbar{margin:0 auto 1rem;padding:1rem 1.15rem;border:1px solid rgba(32,47,91,.08);border-radius:1.45rem;background:rgba(255,255,255,.42);backdrop-filter:blur(20px);box-shadow:0 18px 38px rgba(32,47,91,.08)}
        body.catalog-page .logo,body.catalog-page .nav a,body.catalog-page .footer{color:var(--brand-strong)}
        body.catalog-page .brand-lockup__copy span{color:rgba(32,47,91,.66)}
        body.catalog-page .brand-lockup__eyebrow{color:var(--brand)}
        body.catalog-page .nav a{opacity:.88}
        body.catalog-page .nav a:hover,body.catalog-page .nav a.is-active{color:var(--brand-strong);opacity:1}
        body.catalog-page .nav a.is-active::after{background:linear-gradient(135deg,var(--brand),var(--sand))}
        .catalog-shell{display:grid;gap:1.4rem}
        .catalog-hero-card{padding:1.2rem 1.25rem;border-radius:1.7rem;border:1px solid rgba(27,39,50,.08);background:rgba(255,255,255,.72);box-shadow:0 24px 54px rgba(14,25,37,.14);backdrop-filter:blur(14px)}
        .catalog-hero-card__content{display:grid;gap:1rem}
        .catalog-hero-card__header{display:flex;align-items:end;justify-content:space-between;gap:1rem;flex-wrap:wrap}
        .catalog-hero-card .page-title{max-width:13ch;margin-top:.75rem}
        .catalog-hero-card .copy{margin:0;max-width:52ch}
        .catalog-hero-card__actions{display:flex;gap:.8rem;flex-wrap:wrap}
        body.catalog-page .page-intro{padding:0}
        @media (max-width:760px){body.catalog-page .wrap{width:min(1240px,calc(100% - 1rem));padding-top:1rem}.catalog-hero-card__actions{width:100%}.catalog-hero-card__actions > *{flex:1 1 100%}}
    </style>
@endsection

@section('content')
    <div class="catalog-shell">
        <section class="catalog-hero-card">
            <div class="catalog-hero-card__content">
                <div class="catalog-hero-card__header">
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
                            ?? 'Explora la coleccion de M&Ouml;BELS Alejandro con una presentacion mas clara, filtros directos y acceso rapido a cada ficha para avanzar a presupuesto.' }}
                    </p>
                </div>

                <div class="catalog-hero-card__actions">
                    <a class="btn btn-primary" href="{{ route('home') }}">Volver al inicio</a>
                    <a class="text-link" href="#productos">Ver productos</a>
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
            <section class="listing-grid" id="productos">
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
    </div>
@endsection
