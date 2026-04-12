@extends('layouts.store')

@section('description', $product->short_description)
@section('title', $product->name.' | M&Ouml;BELS Alejandro')

@section('content')
    @php
        $initialVariant = $galleryVariants[0];
        $initialImages = $initialVariant['images'];
        $initialImage = $initialImages[0];
    @endphp

    <section class="page-intro">
        <div class="page-intro__header">
            <div>
                <p class="breadcrumbs">
                    <a href="{{ route('home') }}">Inicio</a>
                    <span class="muted"> / </span>
                    <a href="{{ route('products.index') }}">Catalogo</a>
                    <span class="muted"> / {{ $product->name }}</span>
                </p>
                <span class="chip">{{ $product->category?->name }}</span>
                <h1 class="page-title">{{ $product->name }}</h1>
            </div>

            <p class="copy">{{ $product->short_description }}</p>
        </div>
    </section>

    <section class="detail-shell">
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

                <button class="gallery-nav is-next" type="button" data-gallery-next aria-label="Imagen siguiente">
                    &#8250;
                </button>
            </div>

            <div class="gallery-meta">
                <div>
                    <span class="pill">Melamina activa</span>
                    <strong class="brand-font" data-gallery-variant-name>{{ $initialVariant['name'] }}</strong>
                </div>
                <span class="gallery-counter" data-gallery-counter>1 / {{ count($initialImages) }}</span>
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
                            <small>Muestra de melamina</small>
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

        <div class="detail-stack">
            <article class="note-card detail-card">
                <span class="pill">Descripcion</span>
                <strong class="detail-price brand-font">AR$ {{ number_format((float) $product->price, 0, ',', '.') }}</strong>
                <div class="card-actions">
                    <span class="availability-tag">{{ $product->availability_label }}</span>
                    <span class="muted">
                        {{ count($galleryVariants) }} {{ Illuminate\Support\Str::plural('melamina', count($galleryVariants)) }} disponibles
                    </span>
                </div>
                <p class="detail-copy">{{ $product->description }}</p>
                <div class="detail-actions">
                    <a class="btn btn-primary" href="#presupuesto">Pedir presupuesto</a>
                    <a class="btn btn-secondary" href="{{ route('products.index', ['categoria' => $product->category?->slug]) }}">
                        Ver mas de {{ $product->category?->name }}
                    </a>
                    <a class="btn btn-secondary" href="{{ route('products.index') }}">Volver al catalogo</a>
                </div>
            </article>

            <div class="spec-grid">
                @foreach ($specs as $spec)
                    <article class="spec">
                        <span>{{ $spec['label'] }}</span>
                        <strong class="brand-font">{{ $spec['value'] }}</strong>
                    </article>
                @endforeach
            </div>

            <article class="note-card">
                <span class="pill">Por que encaja bien en la tienda</span>
                <ul class="list">
                    @foreach ($highlights as $highlight)
                        <li>{{ $highlight }}</li>
                    @endforeach
                </ul>
            </article>
        </div>
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
