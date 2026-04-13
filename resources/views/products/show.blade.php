@extends('layouts.store')

@section('body_class', 'product-detail-page')
@section('description', $product->short_description)
@section('title', $product->name.' | M&Ouml;BELS Alejandro')

@section('page_head')
    <style>
        body.product-detail-page .wrap{width:min(1240px,calc(100% - 1.5rem));padding:1.8rem 0 3rem}
        body.product-detail-page .topbar{margin:0 auto 1rem;padding:1rem 1.15rem;border:1px solid rgba(32,47,91,.08);border-radius:1.45rem;background:rgba(255,255,255,.42);backdrop-filter:blur(20px);box-shadow:0 18px 38px rgba(32,47,91,.08)}
        body.product-detail-page .logo,body.product-detail-page .nav a,body.product-detail-page .footer{color:var(--brand-strong)}
        body.product-detail-page .brand-lockup__copy span{color:rgba(32,47,91,.66)}
        body.product-detail-page .brand-lockup__eyebrow{color:var(--brand)}
        body.product-detail-page .nav a{opacity:.88}
        body.product-detail-page .nav a:hover,body.product-detail-page .nav a.is-active{color:var(--brand-strong);opacity:1}
        body.product-detail-page .nav a.is-active::after{background:linear-gradient(135deg,var(--brand),var(--sand))}
        .product-detail-hero{padding:.6rem 1.25rem;border-radius:1.45rem;border:1px solid rgba(27,39,50,.08);background:rgba(255,255,255,.72);box-shadow:0 24px 54px rgba(14,25,37,.14);backdrop-filter:blur(14px)}
        .product-detail-hero__content{display:grid;gap:.45rem}
        .product-detail-hero__content .page-title{margin:0;max-width:none;font-size:clamp(1.9rem,3.6vw,3.05rem)}
        .product-detail-hero__content .copy{margin:0;max-width:72ch;font-size:clamp(.96rem,1.5vw,1.05rem);line-height:1.6}
        .product-detail-main{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:clamp(.85rem,1.8vw,1.15rem);align-items:stretch}
        .product-detail-purchase{display:flex;align-items:end;justify-content:space-between;gap:1rem;flex-wrap:wrap;padding-top:1rem;border-top:1px solid rgba(42,59,73,.1)}
        .product-detail-page .gallery-stage{position:relative}
        .product-detail-page .gallery-counter{position:absolute;right:1rem;bottom:1rem;z-index:2;padding:.55rem .8rem;border-radius:999px;background:rgba(255,255,255,.82);backdrop-filter:blur(14px);box-shadow:0 12px 24px rgba(42,59,73,.12)}
        .product-detail-page .detail-media{width:100%;min-height:0;height:100%}
        .product-detail-page .gallery-stage{min-height:clamp(20rem,62svh,46rem);height:clamp(20rem,62svh,46rem)}
        .product-detail-page .gallery-meta{display:none}
        .product-detail-page .color-palette{justify-content:center}
        .product-detail-page .color-chip{align-items:start;gap:.65rem;padding:.8rem .75rem;flex-direction:column;background:transparent;border:0;box-shadow:none}
        .product-detail-page .color-chip__copy{gap:.12rem}
        .product-detail-page .color-chip__copy strong{display:block;width:100%;font-size:.62rem;line-height:1.35;letter-spacing:.02em;text-align:center}
        .product-detail-page .color-chip__copy small{display:none}
        .product-detail-page .detail-card{width:100%;height:100%;padding:clamp(1rem,2vw,1.45rem);display:flex;flex-direction:column;justify-content:space-between;gap:1rem}
        .product-detail-page .detail-copy{max-width:none}
        .product-detail-price{font-size:2.4rem;line-height:.95;letter-spacing:-.05em}
        @media (max-width:980px){.product-detail-main{grid-template-columns:1fr}}
        @media (max-width:760px){body.product-detail-page .wrap{width:min(1240px,calc(100% - 1rem));padding-top:1rem}.product-detail-hero{padding:.75rem 1rem}.product-detail-hero__content .page-title{font-size:clamp(1.7rem,8vw,2.5rem)}.product-detail-price{font-size:2rem}.product-detail-purchase{align-items:stretch}.product-detail-purchase > *{width:100%}.product-detail-page .gallery-stage{min-height:clamp(18rem,48svh,26rem);height:clamp(18rem,48svh,26rem)}}
    </style>
@endsection

@section('content')
    @php
        $initialVariant = $galleryVariants[0];
        $initialImages = $initialVariant['images'];
        $initialImage = $initialImages[0];
    @endphp

    <section class="product-detail-hero">
        <div class="product-detail-hero__content">
            <h1 class="page-title">{{ $product->name }}</h1>
            <p class="copy">{{ $product->short_description }}</p>
        </div>
    </section>

    <section class="product-detail-main">
        <article class="detail-media" data-product-gallery>
            <script type="application/json" data-gallery-payload>@json($galleryVariants)</script>

            <div class="gallery-stage">
                <button class="gallery-nav is-prev" type="button" data-gallery-prev aria-label="Imagen anterior">
                    &#8249;
                </button>

                <img
                    src="{{ $initialImage['url'] }}"
                    alt="{{ $initialImage['alt'] }}"
                    data-gallery-image
                >

                <span class="gallery-counter" data-gallery-counter>1 / {{ count($initialImages) }}</span>

                <button class="gallery-nav is-next" type="button" data-gallery-next aria-label="Imagen siguiente">
                    &#8250;
                </button>
            </div>

            <div class="gallery-meta">
                <div>
                    <span class="pill">Melamina activa</span>
                    <strong class="brand-font" data-gallery-variant-name>{{ $initialVariant['name'] }}</strong>
                </div>
            </div>

            <div class="color-palette" data-gallery-variants>
                @foreach ($galleryVariants as $variantIndex => $variant)
                    <button
                        type="button"
                        class="color-chip {{ $loop->first ? 'is-active' : '' }}"
                        data-variant-index="{{ $variantIndex }}"
                    >
                        <span class="color-swatch">
                            <img src="{{ $variant['swatch_url'] }}" alt="Muestra de melamina {{ $variant['name'] }}">
                        </span>
                        <span class="color-chip__copy">
                            <strong>{{ $variant['name'] }}</strong>
                        </span>
                    </button>
                @endforeach
            </div>

            <div class="gallery-thumbs" data-gallery-thumbs>
                @foreach ($initialImages as $imageIndex => $image)
                    <button
                        type="button"
                        class="gallery-thumb {{ $loop->first ? 'is-active' : '' }}"
                        data-image-index="{{ $imageIndex }}"
                    >
                        <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}">
                    </button>
                @endforeach
            </div>
        </article>

        <article class="note-card detail-card">
            <span class="pill">Descripcion</span>
            <p class="detail-copy">{{ $product->description }}</p>
            <div class="product-detail-purchase">
                <strong class="detail-price product-detail-price brand-font">AR$ {{ number_format((float) $product->price, 0, ',', '.') }}</strong>
                <a class="btn btn-primary" href="#presupuesto">Pedir presupuesto</a>
            </div>
        </article>
    </section>

    <section class="quote-section" id="presupuesto">
        <div class="section-head">
            <div>
                <span class="chip">Paso 2 listo</span>
                <h2>Pedí tu presupuesto para {{ $product->name }}</h2>
            </div>
            <p class="related-copy">
                Dejamos dos caminos claros: enviar la consulta desde la tienda o continuar por los canales directos de la marca con el producto ya definido.
            </p>
        </div>

        <div class="quote-grid">
            <article class="note-card quote-panel">
                <span class="pill">Respuesta comercial</span>
                <h3>Preparado para muebles a medida</h3>
                <p>
                    Contanos medidas, ambiente, terminacion o idea general y dejamos registrada la consulta para avanzar
                    con una propuesta mas precisa.
                </p>

                <ul class="list">
                    <li>Ideal para presupuestos iniciales, asesoramiento o distintas melaminas.</li>
                    <li>La ficha del producto queda asociada a la consulta para no perder contexto.</li>
                    <li>Si preferis un canal rapido, tambien dejamos acceso directo a la marca.</li>
                </ul>

                <div class="detail-actions">
                    @if ($whatsAppUrl)
                        <a class="btn btn-primary" href="{{ $whatsAppUrl }}" target="_blank" rel="noreferrer">
                            Pedir por WhatsApp
                        </a>
                    @endif

                    @if ($instagramUrl)
                        <a class="btn btn-secondary" href="{{ $instagramUrl }}" target="_blank" rel="noreferrer">
                            Escribir por Instagram
                        </a>
                    @endif
                </div>

                @unless ($whatsAppUrl)
                    <div class="inline-note">
                        <strong class="brand-font">WhatsApp listo para activar</strong>
                        <p>
                            El formulario ya funciona. En cuanto carguemos el numero comercial en la configuracion del proyecto,
                            este bloque tambien abre el mensaje prearmado por WhatsApp.
                        </p>
                    </div>
                @endunless
            </article>

            <article class="note-card quote-form-card">
                <span class="pill">Formulario de consulta</span>
                <h3>Recibir un presupuesto</h3>
                <p>Este formulario queda guardado en la base y ya sirve como punto de partida para un futuro panel interno.</p>

                @if (session('quote_request_created'))
                    <div class="alert alert-success">
                        {{ session('quote_request_created') }}
                    </div>
                @endif

                <form class="quote-form" method="POST" action="{{ route('products.quote-requests.store', $product) }}">
                    @csrf

                    <label class="form-field">
                        <span>Nombre y apellido</span>
                        <input
                            type="text"
                            name="customer_name"
                            value="{{ old('customer_name') }}"
                            placeholder="Ej: Maria Gomez"
                            required
                        >
                        @error('customer_name')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>

                    <div class="form-grid">
                        <label class="form-field">
                            <span>Telefono o WhatsApp</span>
                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="Ej: 3834 123456"
                                required
                            >
                            @error('phone')
                                <small class="field-error">{{ $message }}</small>
                            @enderror
                        </label>

                        <label class="form-field">
                            <span>Email</span>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nombre@correo.com"
                            >
                            @error('email')
                                <small class="field-error">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>

                    <label class="form-field">
                        <span>Localidad o zona</span>
                        <input
                            type="text"
                            name="city"
                            value="{{ old('city') }}"
                            placeholder="Ej: Valle Viejo, Catamarca"
                        >
                        @error('city')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="form-field">
                        <span>Contanos tu idea</span>
                        <textarea
                            name="project_details"
                            rows="6"
                            placeholder="Medidas aproximadas, melamina deseada, ambiente, si necesitás instalación o cualquier detalle útil."
                            required
                        >{{ old('project_details') }}</textarea>
                        @error('project_details')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>

                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit">Enviar consulta</button>
                        <span class="muted">Producto asociado: {{ $product->name }}</span>
                    </div>
                </form>
            </article>
        </div>
    </section>

    @if ($relatedProducts->isNotEmpty())
        <section class="related-section">
            <div class="section-head">
                <div>
                    <span class="chip">Relacionados</span>
                    <h2>Mas productos de {{ $product->category?->name }}</h2>
                </div>
                <p class="related-copy">
                    Aprovechamos la misma categoria para que el usuario siga navegando dentro de una misma linea de producto.
                </p>
            </div>

            <div class="related-grid">
                @foreach ($relatedProducts as $relatedProduct)
                    <article class="product">
                        <div class="visual">
                            <img
                                class="product-banner"
                                src="{{ $relatedProduct->primary_image_url }}"
                                alt="Banner ilustrado de {{ $relatedProduct->name }}"
                            >
                        </div>

                        <div class="product-copy">
                            <div>
                                <span class="pill">{{ $relatedProduct->category?->name }}</span>
                                <h3>{{ $relatedProduct->name }}</h3>
                                <p>{{ $relatedProduct->short_description }}</p>
                            </div>

                            <div class="price">
                                <div>
                                    <span class="muted">Precio referencia</span>
                                    <strong class="brand-font">AR$ {{ number_format((float) $relatedProduct->price, 0, ',', '.') }}</strong>
                                    <span class="availability-tag">{{ $relatedProduct->availability_label }}</span>
                                </div>
                                <div class="card-actions">
                                    <a class="btn btn-secondary btn-small" href="{{ route('products.show', $relatedProduct) }}#presupuesto">
                                        Presupuesto
                                    </a>
                                    <a class="text-link" href="{{ route('products.show', $relatedProduct) }}">Ver ficha</a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
@endsection

@section('page_scripts')
    <script>
        (() => {
            const gallery = document.querySelector('[data-product-gallery]');

            if (!gallery) {
                return;
            }

            const payloadNode = gallery.querySelector('[data-gallery-payload]');
            const payload = JSON.parse(payloadNode.textContent);

            if (!Array.isArray(payload) || payload.length === 0) {
                return;
            }

            const imageNode = gallery.querySelector('[data-gallery-image]');
            const counterNode = gallery.querySelector('[data-gallery-counter]');
            const variantNameNode = gallery.querySelector('[data-gallery-variant-name]');
            const thumbsNode = gallery.querySelector('[data-gallery-thumbs]');
            const prevButton = gallery.querySelector('[data-gallery-prev]');
            const nextButton = gallery.querySelector('[data-gallery-next]');
            const variantButtons = Array.from(gallery.querySelectorAll('[data-variant-index]'));

            let activeVariantIndex = 0;
            let activeImageIndex = 0;

            const renderThumbs = () => {
                const variant = payload[activeVariantIndex];

                thumbsNode.innerHTML = variant.images.map((image, imageIndex) => `
                    <button
                        type="button"
                        class="gallery-thumb ${imageIndex === activeImageIndex ? 'is-active' : ''}"
                        data-image-index="${imageIndex}"
                    >
                        <img src="${image.url}" alt="${image.alt}">
                    </button>
                `).join('');
            };

            const render = () => {
                const variant = payload[activeVariantIndex];
                const image = variant.images[activeImageIndex];

                imageNode.src = image.url;
                imageNode.alt = image.alt;
                variantNameNode.textContent = variant.name;
                counterNode.textContent = `${activeImageIndex + 1} / ${variant.images.length}`;

                prevButton.disabled = variant.images.length <= 1;
                nextButton.disabled = variant.images.length <= 1;

                variantButtons.forEach((button, index) => {
                    button.classList.toggle('is-active', index === activeVariantIndex);
                });

                renderThumbs();
            };

            gallery.addEventListener('click', (event) => {
                const variantButton = event.target.closest('[data-variant-index]');

                if (variantButton) {
                    activeVariantIndex = Number(variantButton.dataset.variantIndex);
                    activeImageIndex = 0;
                    render();
                    return;
                }

                const imageButton = event.target.closest('[data-image-index]');

                if (imageButton) {
                    activeImageIndex = Number(imageButton.dataset.imageIndex);
                    render();
                    return;
                }

                if (event.target.closest('[data-gallery-prev]')) {
                    const variant = payload[activeVariantIndex];
                    activeImageIndex = (activeImageIndex - 1 + variant.images.length) % variant.images.length;
                    render();
                    return;
                }

                if (event.target.closest('[data-gallery-next]')) {
                    const variant = payload[activeVariantIndex];
                    activeImageIndex = (activeImageIndex + 1) % variant.images.length;
                    render();
                }
            });

            render();
        })();
    </script>
@endsection
