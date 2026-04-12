@extends('layouts.store')

@section('description', 'Base ecommerce en Laravel para M&Ouml;BELS Alejandro, con una identidad visual inspirada en el Instagram oficial de la marca.')
@section('title', 'M&Ouml;BELS Alejandro | Ecommerce de Melamina')

@section('content')
    <section class="hero">
        <div>
            <span class="chip">Identidad inspirada en el Instagram oficial de la marca</span>
            <h1>Muebles de melamina con presencia, orden y precision.</h1>
            <p class="lead">
                La home ahora toma la direccion visual que aparece en el perfil de M&Ouml;BELS Alejandro:
                azules petroleo, azules profundos, tonos arena y una tipografia sans mas geometrica e industrial.
                El resultado se siente mucho mas cercano al taller, al trabajo metalico y a la carpinteria del feed.
            </p>

            <div class="actions">
                <a class="btn btn-primary" href="{{ route('products.index') }}">Ver catalogo completo</a>
                <a class="btn btn-secondary" href="#colecciones">Explorar colecciones</a>
            </div>

            <div class="stats">
                @foreach ($metrics as $metric)
                    <article class="stat">
                        <strong class="brand-font">{{ $metric['value'] }}</strong>
                        <span class="muted">{{ $metric['label'] }}</span>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="scene">
            <div class="scene-grid">
                <article class="panel panel-large">
                    <img
                        class="hero-banner"
                        src="{{ asset($heroBanner) }}"
                        alt="Banner ilustrado de MÖBELS Alejandro con muebles de melamina y estructura metalica"
                    >
                    <div class="panel-large-copy">
                        <span class="pill">Catamarca · Valle Viejo</span>
                        <strong class="brand-font">Acabado mas tecnico, contrastes frios y calidez madera en una misma pantalla.</strong>
                        <p>Tomamos la mezcla visual del perfil: taller, estructura, melamina y una estetica de servicio serio.</p>
                    </div>
                </article>

                <article class="panel">
                    <span class="pill">Catalogo</span>
                    <strong class="brand-font">{{ $categories->count() }} categorias semilla</strong>
                    <p>Living, dormitorios, cocinas y oficinas con una base lista para crecer.</p>
                </article>

                <article class="panel">
                    <span class="pill">Pedidos</span>
                    <strong class="brand-font">Modelo preparado</strong>
                    <p>Ordenes e items ya estan pensados para conectar carrito, checkout y estados.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="colecciones">
        <div class="section-head">
            <div>
                <span class="chip">Colecciones iniciales</span>
                <h2>Lineas listas para vender y evolucionar.</h2>
            </div>
            <p class="copy">
                Cada categoria ya puede crecer con filtros, imagenes, variantes y fichas tecnicas.
                Por ahora dejamos una base ordenada y reutilizable.
            </p>
        </div>

        <div class="catalog">
            @foreach ($categories as $category)
                <article class="card">
                    <div>
                        <span class="pill">{{ $loop->iteration < 10 ? '0'.$loop->iteration : $loop->iteration }}</span>
                        <h3>{{ $category->name }}</h3>
                        <p>{{ $category->description }}</p>
                    </div>
                    <div class="card-actions">
                        <small class="muted">Slug: {{ $category->slug }}</small>
                        <a class="text-link" href="{{ route('products.index', ['categoria' => $category->slug]) }}">Ver productos</a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section id="destacados">
        <div class="section-head">
            <div>
                <span class="chip">Productos destacados</span>
                <h2>Fichas demo con datos mas realistas.</h2>
            </div>
            <p class="copy">
                Cargamos productos semilla para que la tienda no arranque vacia y podamos iterar sobre
                galerias por color, pricing y UX desde algo concreto.
            </p>
        </div>

        <div class="products">
            @foreach ($featuredProducts as $product)
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
                                <a class="text-link" href="{{ route('products.show', $product) }}">Ver ficha</a>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section id="proceso">
        <div class="section-head">
            <div>
                <span class="chip">Siguiente evolucion</span>
                <h2>La base ya esta lista para avanzar por capas.</h2>
            </div>
            <ul class="list">
                @foreach ($advantages as $advantage)
                    <li>{{ $advantage }}</li>
                @endforeach
            </ul>
        </div>

        <div class="roadmap">
            <article class="step">
                <span class="pill">01</span>
                <h3>Catalogo administrable</h3>
                <p>ABM de categorias, productos, imagenes, medidas y terminaciones.</p>
            </article>
            <article class="step">
                <span class="pill">02</span>
                <h3>Carrito y checkout</h3>
                <p>Conexion de ordenes con carrito, envio, pagos y estados de compra.</p>
            </article>
            <article class="step">
                <span class="pill">03</span>
                <h3>Backoffice comercial</h3>
                <p>Panel interno para variantes, pedidos, clientes y presupuestos a medida.</p>
            </article>
        </div>
    </section>

    <section class="cta">
        <div>
            <h2>Proyecto listo para la siguiente iteracion.</h2>
            <p>
                Ya no estamos sobre la pantalla por defecto de Laravel. Ahora hay una base ecommerce con dominio,
                datos demo y una home mucho mas cercana a una marca de muebles de melamina.
            </p>
        </div>
        <a class="btn btn-secondary" href="{{ route('products.index') }}">Entrar al catalogo</a>
    </section>
@endsection
