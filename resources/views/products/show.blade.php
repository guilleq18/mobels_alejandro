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
        .product-detail-hero__content .page-title{margin:0;max-width:none;font-size:clamp(1.22rem,2.3vw,1.95rem)}
        .product-detail-hero__content .copy{margin:0;max-width:72ch;font-size:clamp(.96rem,1.5vw,1.05rem);line-height:1.6}
        .product-detail-main{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:clamp(.85rem,1.8vw,1.15rem);align-items:stretch}
        .product-detail-sidebar{display:grid;grid-template-rows:minmax(0,7fr) minmax(0,3fr);gap:clamp(.85rem,1.8vw,1.15rem);min-height:0}
        .product-detail-purchase{display:flex;align-items:end;justify-content:space-between;gap:1rem;flex-wrap:wrap;padding-top:1rem;border-top:1px solid rgba(42,59,73,.1)}
        .product-detail-cta-group{display:flex;gap:.75rem;flex-wrap:wrap;justify-content:flex-end}
        .product-detail-page .gallery-stage{position:relative}
        .product-detail-page .gallery-counter{position:absolute;right:1rem;bottom:1rem;z-index:2;padding:.55rem .8rem;border-radius:999px;background:rgba(255,255,255,.82);backdrop-filter:blur(14px);box-shadow:0 12px 24px rgba(42,59,73,.12)}
        .product-detail-page .detail-media{width:100%;min-height:0;height:100%}
        .product-detail-page .gallery-stage{min-height:clamp(20rem,62svh,46rem);height:clamp(20rem,62svh,46rem)}
        .product-detail-page .gallery-stage > img[data-gallery-image]{cursor:zoom-in}
        .product-detail-page .gallery-expand{position:absolute;top:1rem;right:1rem;z-index:2;display:inline-flex;align-items:center;justify-content:center;width:2.9rem;height:2.9rem;border:1px solid rgba(42,59,73,.12);border-radius:999px;background:rgba(255,255,255,.82);backdrop-filter:blur(14px);box-shadow:0 12px 24px rgba(42,59,73,.12);cursor:pointer}
        .product-detail-page .gallery-expand svg{width:1.1rem;height:1.1rem;stroke:var(--brand-strong)}
        .product-detail-page .gallery-meta{display:none}
        .product-detail-page .melamine-card{width:100%;height:100%;padding:clamp(1rem,2vw,1.3rem);display:grid;align-content:start;gap:.8rem}
        .product-detail-page .melamine-card h3{margin:0;font-size:1.08rem;letter-spacing:-.03em}
        .product-detail-page .color-palette{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.5rem;justify-content:stretch;width:min(100%,13rem);margin:0}
        .product-detail-page .color-chip{position:relative;display:grid;place-items:center;padding:.32rem;background:rgba(255,255,255,.34);border:1px solid rgba(42,59,73,.08);box-shadow:none;width:100%;aspect-ratio:1 / 1;border-radius:1.15rem;overflow:hidden}
        .product-detail-page .color-chip__copy{position:absolute;inset:0;z-index:2;display:grid;place-items:center;padding:.75rem;text-align:center}
        .product-detail-page .color-chip__copy strong{display:block;width:100%;font-size:.72rem;line-height:1.3;letter-spacing:.03em;text-align:center;color:#f7fbfc;text-shadow:0 2px 10px rgba(24,33,43,.45)}
        .product-detail-page .color-chip__copy small{display:none}
        .product-detail-page .color-swatch{width:100%;height:100%;margin:0;border-radius:.92rem;overflow:hidden;position:relative}
        .product-detail-page .color-swatch::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(24,33,43,.08),rgba(24,33,43,.22))}
        .product-detail-page .detail-card{width:100%;height:100%;padding:clamp(1rem,2vw,1.45rem);display:flex;flex-direction:column;justify-content:space-between;gap:1rem;min-height:0}
        .product-detail-page .detail-card__header{display:flex;align-items:center;justify-content:space-between;gap:.75rem;flex-wrap:wrap}
        .product-detail-page .detail-card__label{font-size:1.06rem;padding:.65rem 1rem}
        .product-detail-page .detail-card__category{display:inline-flex;align-items:center;padding:.65rem 1rem;border-radius:999px;background:rgba(79,129,145,.12);border:1px solid rgba(79,129,145,.14);font-size:1rem;font-weight:700;color:var(--brand-strong)}
        .product-detail-page .detail-copy{max-width:none}
        .product-detail-price{font-size:3.46rem;line-height:.95;letter-spacing:-.05em}
        .product-detail-channel-note{margin:0;font-size:.86rem;line-height:1.55;color:var(--muted)}
        .product-detail-feedback{position:fixed;left:50%;bottom:1.25rem;z-index:90;transform:translate(-50%,1rem);padding:.85rem 1rem;border-radius:999px;background:rgba(18,26,36,.92);color:#f3f8fb;box-shadow:0 18px 40px rgba(0,0,0,.22);opacity:0;pointer-events:none;transition:opacity .2s ease,transform .2s ease}
        .product-detail-feedback.is-visible{opacity:1;transform:translate(-50%,0)}
        .gallery-lightbox{position:fixed;inset:0;z-index:80;display:grid;place-items:center;padding:1.25rem;background:rgba(13,18,25,.78);backdrop-filter:blur(12px);opacity:0;visibility:hidden;pointer-events:none;transition:opacity .2s ease,visibility .2s ease}
        .gallery-lightbox.is-open{opacity:1;visibility:visible;pointer-events:auto}
        .gallery-lightbox__dialog{width:min(1120px,100%);max-height:calc(100svh - 2.5rem);display:grid;grid-template-rows:auto minmax(0,1fr) auto;gap:1rem;padding:1rem;border-radius:1.6rem;border:1px solid rgba(255,255,255,.1);background:rgba(18,26,36,.92);box-shadow:0 30px 70px rgba(0,0,0,.35)}
        .gallery-lightbox__header{display:flex;align-items:center;justify-content:space-between;gap:1rem;color:#f3f8fb}
        .gallery-lightbox__header strong{font-size:1.05rem;letter-spacing:.02em}
        .gallery-lightbox__header span{color:rgba(243,248,251,.72);font-size:.95rem}
        .gallery-lightbox__close{display:inline-flex;align-items:center;justify-content:center;width:2.85rem;height:2.85rem;border-radius:999px;border:1px solid rgba(255,255,255,.14);background:rgba(255,255,255,.08);color:#f3f8fb;cursor:pointer}
        .gallery-lightbox__stage{position:relative;min-height:0;border-radius:1.2rem;overflow:hidden;background:rgba(255,255,255,.04)}
        .gallery-lightbox__stage img{width:100%;height:100%;max-height:calc(100svh - 13rem);object-fit:contain;background:#111923}
        .gallery-lightbox__nav{position:absolute;top:50%;transform:translateY(-50%);width:3rem;height:3rem;border-radius:999px;border:1px solid rgba(255,255,255,.14);background:rgba(255,255,255,.1);color:#f3f8fb;display:grid;place-items:center;font-size:1.4rem;cursor:pointer}
        .gallery-lightbox__nav.is-prev{left:1rem}
        .gallery-lightbox__nav.is-next{right:1rem}
        .gallery-lightbox__nav[disabled]{opacity:.35;cursor:not-allowed}
        .gallery-lightbox__counter{position:absolute;right:1rem;bottom:1rem;padding:.6rem .85rem;border-radius:999px;background:rgba(17,25,35,.72);color:#f3f8fb;font-weight:700}
        .gallery-lightbox__thumbs{display:flex;gap:.7rem;overflow:auto;padding-bottom:.1rem}
        .gallery-lightbox__thumb{flex:none;width:5.25rem;height:5.25rem;padding:.2rem;border-radius:1rem;border:1px solid rgba(255,255,255,.14);background:rgba(255,255,255,.06);overflow:hidden;cursor:pointer}
        .gallery-lightbox__thumb img{width:100%;height:100%;object-fit:cover;border-radius:.82rem}
        .gallery-lightbox__thumb.is-active{border-color:rgba(215,227,231,.82);box-shadow:0 0 0 1px rgba(215,227,231,.58)}
        @media (max-width:980px){.product-detail-main{grid-template-columns:1fr}.product-detail-sidebar{grid-template-rows:auto auto}}
        @media (max-width:760px){body.product-detail-page .wrap{width:min(1240px,calc(100% - 1rem));padding-top:1rem}.product-detail-hero{padding:.75rem 1rem}.product-detail-hero__content .page-title{font-size:clamp(.98rem,5.1vw,1.56rem)}.product-detail-price{font-size:2.88rem}.product-detail-purchase{align-items:stretch}.product-detail-purchase > *{width:100%}.product-detail-cta-group{justify-content:stretch}.product-detail-cta-group > *{flex:1 1 100%}.product-detail-page .gallery-stage{min-height:clamp(18rem,48svh,26rem);height:clamp(18rem,48svh,26rem)}.product-detail-page .color-palette{grid-template-columns:1fr 1fr}.product-detail-page .detail-card__header{align-items:stretch}.product-detail-page .detail-card__label,.product-detail-page .detail-card__category{justify-content:center}.gallery-lightbox{padding:.75rem}.gallery-lightbox__dialog{max-height:calc(100svh - 1.5rem);padding:.75rem}.gallery-lightbox__thumb{width:4.2rem;height:4.2rem}.gallery-lightbox__nav{width:2.7rem;height:2.7rem}}
        @media (max-width:560px){.product-detail-page .color-palette{grid-template-columns:1fr}.gallery-lightbox__header{align-items:start;flex-direction:column}.gallery-lightbox__stage img{max-height:calc(100svh - 15rem)}}
    </style>
@endsection

@section('content')
    @php
        $initialVariant = $galleryVariants[0];
        $initialImages = $initialVariant['images'];
        $initialImage = $initialImages[0];
        $whatsAppNumber = $whatsAppNumber ?: null;
    @endphp

    <section class="product-detail-hero">
        <div class="product-detail-hero__content">
            <h1 class="page-title">{{ $product->name }}</h1>
            <p class="copy">{{ $product->short_description }}</p>
        </div>
    </section>

    <section class="product-detail-main" data-product-gallery>
        <article class="detail-media">
            <script type="application/json" data-gallery-payload>@json($galleryVariants)</script>

            <div class="gallery-stage">
                <button class="gallery-expand" type="button" data-gallery-open-modal aria-label="Abrir imagen en pantalla completa">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M8 3H5a2 2 0 0 0-2 2v3M16 3h3a2 2 0 0 1 2 2v3M8 21H5a2 2 0 0 1-2-2v-3M16 21h3a2 2 0 0 0 2-2v-3" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

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

        <div class="product-detail-sidebar">
            <article class="note-card detail-card">
                <div class="detail-card__header">
                    <span class="pill detail-card__label">Descripcion</span>
                    @if ($product->category)
                        <span class="detail-card__category">{{ $product->category->name }}</span>
                    @endif
                </div>
                <p class="detail-copy">{{ $product->description }}</p>
                <div class="product-detail-purchase">
                    <strong class="detail-price product-detail-price brand-font">AR$ {{ number_format((float) $product->price, 0, ',', '.') }}</strong>
                    <div class="product-detail-cta-group">
                        @if ($whatsAppNumber)
                            <button
                                class="btn btn-primary"
                                type="button"
                                data-quote-channel="whatsapp"
                            >
                                Pedir por WhatsApp
                            </button>
                        @endif

                        @unless ($whatsAppNumber)
                            <button class="btn btn-primary" type="button" disabled>Canal no configurado</button>
                        @endunless
                    </div>
                    @if ($whatsAppNumber)
                        <p class="product-detail-channel-note">
                            El mensaje se arma con el producto, la categoria, la melamina activa y la imagen que el cliente esta viendo.
                        </p>
                    @endif
                </div>
            </article>

            <article class="note-card melamine-card">
                <h3>Opciones de Melamina</h3>
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
            </article>
        </div>
    </section>

    <div class="gallery-lightbox" data-gallery-modal aria-hidden="true">
        <div class="gallery-lightbox__dialog" role="dialog" aria-modal="true" aria-label="Vista ampliada de imagen de producto">
            <div class="gallery-lightbox__header">
                <div>
                    <strong data-gallery-modal-variant>{{ $initialVariant['name'] }}</strong>
                    <span>Vista ampliada del producto</span>
                </div>

                <button class="gallery-lightbox__close" type="button" data-gallery-close-modal aria-label="Cerrar visor">
                    &#10005;
                </button>
            </div>

            <div class="gallery-lightbox__stage">
                <button class="gallery-lightbox__nav is-prev" type="button" data-gallery-modal-prev aria-label="Imagen anterior">
                    &#8249;
                </button>

                <img
                    src="{{ $initialImage['url'] }}"
                    alt="{{ $initialImage['alt'] }}"
                    data-gallery-modal-image
                >

                <span class="gallery-lightbox__counter" data-gallery-modal-counter>1 / {{ count($initialImages) }}</span>

                <button class="gallery-lightbox__nav is-next" type="button" data-gallery-modal-next aria-label="Imagen siguiente">
                    &#8250;
                </button>
            </div>

            <div class="gallery-lightbox__thumbs" data-gallery-modal-thumbs></div>
        </div>
    </div>

    <div class="product-detail-feedback" data-quote-feedback aria-live="polite"></div>

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
            const openModalButton = gallery.querySelector('[data-gallery-open-modal]');
            const variantButtons = Array.from(gallery.querySelectorAll('[data-variant-index]'));
            const modalNode = document.querySelector('[data-gallery-modal]');
            const modalImageNode = modalNode?.querySelector('[data-gallery-modal-image]');
            const modalCounterNode = modalNode?.querySelector('[data-gallery-modal-counter]');
            const modalVariantNode = modalNode?.querySelector('[data-gallery-modal-variant]');
            const modalThumbsNode = modalNode?.querySelector('[data-gallery-modal-thumbs]');
            const modalPrevButton = modalNode?.querySelector('[data-gallery-modal-prev]');
            const modalNextButton = modalNode?.querySelector('[data-gallery-modal-next]');
            const feedbackNode = document.querySelector('[data-quote-feedback]');
            const quoteButtons = Array.from(document.querySelectorAll('[data-quote-channel]'));

            let activeVariantIndex = 0;
            let activeImageIndex = 0;
            let modalOpen = false;
            let feedbackTimeout = null;

            const storeConfig = {
                productCategory: @json($product->category?->name ?? 'General'),
                productName: @json($product->name),
                productPrice: @json('AR$ '.number_format((float) $product->price, 0, ',', '.')),
                whatsAppDefaultMessage: @json($whatsAppDefaultMessage),
                whatsAppNumber: @json($whatsAppNumber),
            };

            const showFeedback = (message) => {
                if (!feedbackNode) {
                    return;
                }

                feedbackNode.textContent = message;
                feedbackNode.classList.add('is-visible');

                if (feedbackTimeout) {
                    clearTimeout(feedbackTimeout);
                }

                feedbackTimeout = window.setTimeout(() => {
                    feedbackNode.classList.remove('is-visible');
                }, 2600);
            };

            const buildQuoteMessage = () => {
                const variant = payload[activeVariantIndex];
                const image = variant.images[activeImageIndex];

                return [
                    storeConfig.whatsAppDefaultMessage || 'Hola MÖBELS Alejandro, quiero pedir un presupuesto.',
                    `Producto: ${storeConfig.productName}`,
                    `Categoria: ${storeConfig.productCategory}`,
                    `Melamina seleccionada: ${variant.name}`,
                    `Precio referencia: ${storeConfig.productPrice}`,
                    `Imagen de referencia: ${image.url}`,
                    `Ficha del producto: ${window.location.href}`,
                    'Quiero revisar medidas, terminaciones y tiempos de entrega.',
                ].join('\n');
            };

            const openWhatsAppQuote = () => {
                if (!storeConfig.whatsAppNumber) {
                    showFeedback('WhatsApp todavia no esta configurado.');
                    return;
                }

                const message = buildQuoteMessage();
                const url = `https://wa.me/${storeConfig.whatsAppNumber}?text=${encodeURIComponent(message)}`;

                window.open(url, '_blank', 'noopener');
            };

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

            const renderModalThumbs = () => {
                if (!modalThumbsNode) {
                    return;
                }

                const variant = payload[activeVariantIndex];

                modalThumbsNode.innerHTML = variant.images.map((image, imageIndex) => `
                    <button
                        type="button"
                        class="gallery-lightbox__thumb ${imageIndex === activeImageIndex ? 'is-active' : ''}"
                        data-modal-image-index="${imageIndex}"
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
                if (modalImageNode) {
                    modalImageNode.src = image.url;
                    modalImageNode.alt = image.alt;
                }
                if (modalCounterNode) {
                    modalCounterNode.textContent = `${activeImageIndex + 1} / ${variant.images.length}`;
                }
                if (modalVariantNode) {
                    modalVariantNode.textContent = variant.name;
                }

                prevButton.disabled = variant.images.length <= 1;
                nextButton.disabled = variant.images.length <= 1;
                if (modalPrevButton) {
                    modalPrevButton.disabled = variant.images.length <= 1;
                }
                if (modalNextButton) {
                    modalNextButton.disabled = variant.images.length <= 1;
                }

                variantButtons.forEach((button, index) => {
                    button.classList.toggle('is-active', index === activeVariantIndex);
                });

                renderThumbs();
                renderModalThumbs();
            };

            const openModal = () => {
                if (!modalNode) {
                    return;
                }

                modalOpen = true;
                modalNode.classList.add('is-open');
                modalNode.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            };

            const closeModal = () => {
                if (!modalNode) {
                    return;
                }

                modalOpen = false;
                modalNode.classList.remove('is-open');
                modalNode.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
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

                if (event.target.closest('[data-gallery-open-modal]') || event.target.closest('[data-gallery-image]')) {
                    openModal();
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

            modalNode?.addEventListener('click', (event) => {
                if (event.target === modalNode || event.target.closest('[data-gallery-close-modal]')) {
                    closeModal();
                    return;
                }

                const modalThumbButton = event.target.closest('[data-modal-image-index]');

                if (modalThumbButton) {
                    activeImageIndex = Number(modalThumbButton.dataset.modalImageIndex);
                    render();
                    return;
                }

                if (event.target.closest('[data-gallery-modal-prev]')) {
                    const variant = payload[activeVariantIndex];
                    activeImageIndex = (activeImageIndex - 1 + variant.images.length) % variant.images.length;
                    render();
                    return;
                }

                if (event.target.closest('[data-gallery-modal-next]')) {
                    const variant = payload[activeVariantIndex];
                    activeImageIndex = (activeImageIndex + 1) % variant.images.length;
                    render();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (!modalOpen) {
                    return;
                }

                if (event.key === 'Escape') {
                    closeModal();
                    return;
                }

                if (event.key === 'ArrowLeft') {
                    const variant = payload[activeVariantIndex];
                    activeImageIndex = (activeImageIndex - 1 + variant.images.length) % variant.images.length;
                    render();
                }

                if (event.key === 'ArrowRight') {
                    const variant = payload[activeVariantIndex];
                    activeImageIndex = (activeImageIndex + 1) % variant.images.length;
                    render();
                }
            });

            quoteButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    if (button.dataset.quoteChannel === 'whatsapp') {
                        openWhatsAppQuote();
                    }
                });
            });

            render();
        })();
    </script>
@endsection
