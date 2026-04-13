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
        .catalog-product-link{display:grid;text-decoration:none;color:inherit;transition:transform .2s ease,box-shadow .2s ease,border-color .2s ease}
        .catalog-product-link:hover{transform:translateY(-3px);box-shadow:0 24px 44px rgba(32,47,91,.14);border-color:rgba(79,129,145,.24)}
        .catalog-product-link .product-copy{gap:1.15rem}
        .catalog-product-meta{display:flex;align-items:center;justify-content:space-between;gap:.85rem;flex-wrap:wrap}
        .catalog-product-availability{display:inline-flex;align-items:center;gap:.45rem;padding:.45rem .75rem;border-radius:999px;background:rgba(79,129,145,.12);color:var(--brand-strong);font-size:.86rem;font-weight:700}
        .catalog-product-availability::before{content:"";width:.5rem;height:.5rem;border-radius:999px;background:linear-gradient(135deg,var(--brand),var(--brand-strong))}
        .catalog-product-summary{display:grid;gap:.55rem}
        .catalog-product-summary p,.catalog-product-summary .muted{margin:0;text-align:justify;text-justify:inter-word}
        .catalog-product-price{display:grid;gap:.3rem;width:100%;padding-top:1rem;border-top:1px solid rgba(42,59,73,.1)}
        .catalog-product-price span{font-size:.88rem;color:var(--muted)}
        .catalog-product-price strong{display:block;width:100%;font-size:1.68rem;line-height:1.05}
        .catalog-product-link .visual{aspect-ratio:1.1 / 1;min-height:0}
        body.catalog-page .page-intro{padding:0}
        @media (max-width:760px){body.catalog-page .wrap{width:min(1240px,calc(100% - 1rem));padding-top:1rem}.catalog-product-meta{align-items:flex-start;flex-direction:column}}
    </style>
@endsection

@section('content')
    <div class="catalog-shell">
        <section class="catalog-hero-card">
            <div class="catalog-hero-card__content">
                <div class="catalog-hero-card__header">
                    <div>
                        <h1 class="page-title">
                            {{ $selectedCategory ? 'Productos de '.$selectedCategory->name : 'Muebles para cada espacio del proyecto.' }}
                        </h1>
                    </div>

                    <p class="copy">
                        {{ $selectedCategory?->description
                            ?? 'Explora la coleccion de M&Ouml;BELS Alejandro con una presentacion mas clara, filtros directos y acceso rapido a cada ficha para avanzar a presupuesto.' }}
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
                    <a class="product catalog-product-link" href="{{ route('products.show', $product) }}">
                        <div class="visual">
                            <img
                                class="product-banner"
                                src="{{ $product->primary_image_url }}"
                                alt="Banner ilustrado de {{ $product->name }}"
                            >
                        </div>

                        <div class="product-copy">
                            <div class="catalog-product-summary">
                                <div class="catalog-product-meta">
                                    <span class="pill">{{ $product->category?->name }}</span>
                                    <span class="catalog-product-availability">{{ $product->availability_label }}</span>
                                </div>
                                <h3>{{ $product->name }}</h3>
                                <p>{{ $product->short_description }}</p>
                                <p class="muted">{{ $product->description }}</p>
                            </div>

                            <div class="catalog-product-price">
                                <span>Precio referencia</span>
                                <strong class="brand-font">AR$ {{ number_format((float) $product->price, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </a>
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
