@extends('layouts.store')

@section('body_class', 'landing-home')
@section('description', 'Amoblamientos de melamina, herreria y muebles a medida para hogar, oficina y espacios comerciales en Catamarca.')
@section('title', 'M&Ouml;BELS Alejandro | Amoblamientos de Melamina a Medida')

@section('page_head')
    <style>
        body.landing-home{position:relative;background:#9ebbc2;isolation:isolate}
        body.landing-home::before{content:"";position:fixed;inset:0;z-index:-2;pointer-events:none;background:url('{{ $landingBackgroundUrl }}') center center / cover no-repeat;filter:blur({{ $landingBackgroundBlur }}px) saturate(.92) brightness(.9);transform:scale(1.04)}
        body.landing-home::after{content:"";position:fixed;inset:0;z-index:-1;pointer-events:none;background:radial-gradient(circle at top,rgba(255,255,255,.18),transparent 24%),linear-gradient(180deg,rgba(215,232,235,.56) 0%,rgba(170,197,203,.5) 38%,rgba(122,161,169,.46) 100%)}
        body.landing-home .wrap{position:relative;z-index:1;width:min(1240px,calc(100% - 1.5rem));padding:1.8rem 0 3rem}
        body.landing-home .topbar{margin:0 auto 1rem;padding:1rem 1.15rem;border:1px solid rgba(32,47,91,.08);border-radius:1.45rem;background:rgba(255,255,255,.42);backdrop-filter:blur(20px);box-shadow:0 18px 38px rgba(32,47,91,.08)}
        body.landing-home .logo,body.landing-home .nav a,body.landing-home .footer{color:var(--brand-strong)}
        body.landing-home .brand-lockup__copy span{color:rgba(32,47,91,.66)}
        body.landing-home .brand-lockup__eyebrow{color:var(--brand)}
        body.landing-home .nav a{opacity:.88}
        body.landing-home .nav a:hover,body.landing-home .nav a.is-active{color:var(--brand-strong);opacity:1}
        body.landing-home .nav a.is-active::after{background:linear-gradient(135deg,var(--brand),var(--sand))}
        .showcase{display:grid;gap:1.45rem}
        .showcase-frame,.showcase-card,.showcase-highlight,.showcase-room,.showcase-product,.showcase-process,.showcase-cta,.showcase-proof,.showcase-story{border:1px solid rgba(27,39,50,.08);background:rgba(255,255,255,.65);box-shadow:0 24px 54px rgba(14,25,37,.18);backdrop-filter:blur(12px)}
        .showcase-frame{padding:1.1rem;border-radius:2rem}
        .showcase-hero{display:grid;grid-template-columns:minmax(0,.9fr) minmax(320px,1.1fr);gap:1rem}
        .showcase-panel{padding:1.1rem;border-radius:1.5rem;background:linear-gradient(180deg,rgba(244,242,238,.58),rgba(255,255,255,.65));backdrop-filter:blur(12px)}
        .showcase-copy{display:grid;align-content:start;gap:1rem;padding:1rem .8rem 1rem .35rem}
        .showcase-kicker,.showcase-chip,.showcase-tab{display:inline-flex;align-items:center;gap:.5rem;width:max-content;padding:.5rem .8rem;border-radius:999px;border:1px solid rgba(79,129,145,.14);background:rgba(79,129,145,.08);font-size:.82rem;font-weight:800;letter-spacing:.08em;color:var(--brand-strong);text-transform:uppercase}
        .showcase-kicker::before,.showcase-chip::before,.showcase-tab::before{content:"";width:.55rem;height:.55rem;border-radius:999px;background:linear-gradient(135deg,var(--brand),var(--brand-strong))}
        .showcase-rating{display:inline-flex;align-items:center;gap:.55rem;width:max-content;padding:.7rem .95rem;border-radius:1rem;border:1px solid rgba(42,59,73,.08);background:#fff;color:var(--brand-strong);font-weight:700;box-shadow:0 12px 28px rgba(32,47,91,.08)}
        .showcase-rating span{font-size:.84rem;color:var(--muted);font-weight:600}
        .showcase-title{margin:0;max-width:10ch;font-size:clamp(3.5rem,6vw,6.1rem);line-height:.9;letter-spacing:-.07em}
        .showcase-lead{margin:0;max-width:58ch;font-size:1.02rem;line-height:1.85;color:var(--muted)}
        .showcase-actions{display:flex;gap:.8rem;flex-wrap:wrap;padding-top:.35rem}
        .showcase-actions .btn,.showcase-actions .text-link{min-width:12.5rem}
        .showcase-trust{display:grid;gap:.75rem;padding-top:.7rem}
        .showcase-trust strong{font-size:.84rem;letter-spacing:.12em;text-transform:uppercase;color:var(--muted)}
        .showcase-trust-list{display:flex;gap:1rem;flex-wrap:wrap}
        .showcase-trust-list span{display:inline-flex;align-items:center;gap:.45rem;padding:.5rem .8rem;border-radius:999px;background:rgba(244,242,238,.9);color:var(--ink);font-weight:700}
        .showcase-trust-list span::before{content:"";width:.45rem;height:.45rem;border-radius:999px;background:var(--sand)}
        .showcase-media{position:relative;padding:1rem;border-radius:1.6rem;background:linear-gradient(145deg,rgba(244,242,238,.56),rgba(255,255,255,.62));overflow:hidden;backdrop-filter:blur(12px)}
        .showcase-media::before{content:"";position:absolute;inset:.85rem;border-radius:1.2rem;background:linear-gradient(160deg,rgba(79,129,145,.18),transparent 34%),radial-gradient(circle at bottom right,rgba(213,196,179,.26),transparent 26%)}
        .showcase-media img{position:relative;z-index:1;width:100%;height:100%;min-height:29rem;object-fit:cover;border-radius:1.2rem}
        .showcase-floating{position:absolute;z-index:2;right:2rem;bottom:2rem;display:grid;gap:.8rem;width:min(17rem,calc(100% - 4rem))}
        .showcase-floating-card{padding:.95rem 1rem;border-radius:1.2rem;background:rgba(255,255,255,.9);backdrop-filter:blur(18px);box-shadow:0 18px 36px rgba(32,47,91,.12)}
        .showcase-floating-card strong{display:block;font-size:1rem}
        .showcase-floating-card p{margin:.25rem 0 0;color:var(--muted);line-height:1.6}
        .showcase-mosaic{display:grid;grid-template-columns:1fr 1fr 1.15fr;gap:1rem}
        .showcase-card{padding:1rem;border-radius:1.5rem}
        .showcase-card--image{overflow:hidden;padding:.75rem}
        .showcase-card--image img{width:100%;height:13rem;object-fit:cover;border-radius:1.1rem}
        .showcase-card h3,.showcase-product__copy h3,.showcase-room h3,.showcase-process h3,.showcase-story h2,.showcase-proof h2,.showcase-cta h2{margin:.85rem 0 .45rem}
        .showcase-card p,.showcase-product__copy p,.showcase-room p,.showcase-process p,.showcase-story p,.showcase-proof p{margin:0;color:var(--muted);line-height:1.75}
        .showcase-card__footer{display:flex;align-items:center;justify-content:space-between;gap:.8rem;flex-wrap:wrap;margin-top:1.1rem}
        .showcase-categories{display:grid;gap:1rem}
        .showcase-categories-head{display:flex;align-items:end;justify-content:space-between;gap:1rem;flex-wrap:wrap}
        .showcase-categories-head p{margin:0;max-width:42rem;color:var(--muted);line-height:1.8}
        .showcase-tabs{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:.75rem}
        .showcase-tab{width:100%;justify-content:center;padding:.85rem 1rem;background:rgba(244,242,238,.84);border-color:rgba(42,59,73,.08);font-weight:700;letter-spacing:0;text-transform:none}
        .showcase-rooms{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem}
        .showcase-room{padding:1.15rem;border-radius:1.5rem;position:relative;overflow:hidden}
        .showcase-room::after{content:"";position:absolute;right:-2rem;bottom:-2rem;width:7.5rem;height:7.5rem;border-radius:2rem;background:linear-gradient(135deg,rgba(79,129,145,.16),rgba(32,47,91,.14));transform:rotate(22deg)}
        .showcase-room footer{margin-top:1rem;display:flex;align-items:center;justify-content:space-between;gap:.75rem;flex-wrap:wrap}
        .showcase-products{display:grid;gap:1rem}
        .showcase-product{display:grid;grid-template-columns:minmax(220px,.78fr) minmax(0,1.22fr);gap:1rem;padding:1rem;border-radius:1.7rem}
        .showcase-product__media{overflow:hidden;border-radius:1.2rem;background:linear-gradient(135deg,rgba(79,129,145,.14),rgba(213,196,179,.18))}
        .showcase-product__media img{width:100%;height:100%;min-height:15rem;object-fit:cover}
        .showcase-product__copy{display:grid;gap:1rem;align-content:space-between}
        .showcase-product__meta{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:1rem;align-items:end;padding-top:1rem;border-top:1px solid rgba(42,59,73,.08)}
        .showcase-price span{display:block;font-size:.88rem;color:var(--muted)}
        .showcase-price strong{display:block;font-size:1.6rem}
        .showcase-product__actions{display:flex;gap:.75rem;flex-wrap:wrap;justify-content:flex-end}
        .showcase-bottom{display:grid;grid-template-columns:minmax(0,1.02fr) minmax(0,.98fr);gap:1rem}
        .showcase-story,.showcase-proof{padding:1.25rem;border-radius:1.7rem}
        .showcase-story{background:linear-gradient(140deg,rgba(32,47,91,.98),rgba(79,129,145,.88));color:#f4f8fb}
        .showcase-story p,.showcase-story li{color:rgba(244,248,251,.82)}
        .showcase-list{display:grid;gap:.85rem;margin:1rem 0 0;padding:0;list-style:none}
        .showcase-list li{position:relative;padding-left:1.3rem;line-height:1.75}
        .showcase-list li::before{content:"";position:absolute;left:0;top:.7rem;width:.55rem;height:.55rem;border-radius:999px;background:linear-gradient(135deg,var(--sand),#fff)}
        .showcase-proof-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.85rem;margin-top:1rem}
        .showcase-highlight{padding:1rem;border-radius:1.25rem;background:rgba(244,242,238,.72)}
        .showcase-highlight strong{display:block;font-size:1.05rem}
        .showcase-highlight span{display:block;margin-top:.35rem;color:var(--muted);line-height:1.6}
        .showcase-workflow{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:.85rem}
        .showcase-process{padding:1.1rem;border-radius:1.5rem}
        .showcase-process__step{display:inline-flex;align-items:center;justify-content:center;width:2.9rem;height:2.9rem;border-radius:999px;background:linear-gradient(135deg,var(--brand),var(--brand-strong));color:#f4f9fc;font-weight:800;box-shadow:0 14px 28px rgba(32,47,91,.16)}
        .showcase-cta{display:grid;grid-template-columns:minmax(0,1.1fr) auto;align-items:center;gap:1rem;padding:1.3rem 1.4rem;border-radius:1.7rem;background:linear-gradient(135deg,rgba(244,242,238,.78),rgba(215,227,231,.76))}
        .showcase-cta p{margin:0;max-width:42rem;color:var(--muted);line-height:1.8}
        .showcase-cta h2{margin:.2rem 0 .5rem}
        @media (max-width:1080px){.showcase-hero,.showcase-mosaic,.showcase-bottom,.showcase-workflow{grid-template-columns:1fr}.showcase-tabs,.showcase-rooms,.showcase-proof-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.showcase-product{grid-template-columns:1fr}.showcase-product__actions{justify-content:flex-start}.showcase-cta{grid-template-columns:1fr}.showcase-title{max-width:none}.showcase-media img{min-height:22rem}}
        @media (max-width:760px){body.landing-home .wrap{width:min(1240px,calc(100% - 1rem));padding-top:1rem}
            body.landing-home .topbar{padding:.85rem;border-radius:1.2rem}
            .showcase-frame{padding:.85rem;border-radius:1.5rem}
            .showcase-tabs,.showcase-rooms,.showcase-proof-grid,.showcase-workflow{grid-template-columns:1fr}
            .showcase-title{font-size:clamp(2.7rem,14vw,4.2rem)}
            .showcase-actions{width:100%}
            .showcase-actions > *{flex:1 1 100%}
            .showcase-actions .btn,.showcase-actions .text-link{width:100%}
            .showcase-media img{min-height:18rem}
            .showcase-floating{position:static;width:100%;margin-top:.85rem}
            .showcase-product__meta{grid-template-columns:1fr}
        }
        @media (max-width:560px){.showcase-copy,.showcase-panel,.showcase-card,.showcase-room,.showcase-product,.showcase-process,.showcase-story,.showcase-proof,.showcase-cta{padding:1rem}.showcase-panel{padding:.9rem}.showcase-title{font-size:clamp(2.35rem,13vw,3.5rem)}.showcase-lead,.showcase-categories-head p,.showcase-cta p{font-size:.97rem;line-height:1.7}.showcase-card--image img{height:11rem}}
    </style>
@endsection

@section('content')
    <div class="showcase">
        <section class="showcase-frame">
            <div class="showcase-hero">
                <div class="showcase-panel">
                    <div class="showcase-copy">
                        <div class="showcase-rating">
                            <span>4.9</span>
                            <strong>Atencion personalizada y trabajo a medida</strong>
                        </div>

                        <div>
                            <span class="showcase-kicker">Melamina · Herreria · Instalacion</span>
                            <h1 class="showcase-title brand-font">Diseñamos muebles que hacen rendir mejor cada ambiente.</h1>
                        </div>

                        <p class="showcase-lead">
                            Creamos amoblamientos para hogares, oficinas y espacios comerciales con una presentación más profesional,
                            materiales consistentes y una lógica de proyecto que acompaña desde la idea hasta la colocación final.
                        </p>

                        <div class="showcase-actions">
                            <a class="btn btn-primary" href="{{ route('products.index') }}">Ver catalogo</a>
                            <a class="text-link" href="#proceso">Conocer el proceso</a>
                        </div>

                        <div class="showcase-trust">
                            <strong>Ideal para</strong>
                            <div class="showcase-trust-list">
                                <span>Cocinas integrales</span>
                                <span>Placares a medida</span>
                                <span>Oficinas y locales</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="showcase-panel showcase-media">
                    <img
                        src="{{ $heroBannerUrl }}"
                        alt="Portada de MÖBELS Alejandro con amoblamientos a medida"
                    >

                    <div class="showcase-floating">
                        <div class="showcase-floating-card">
                            <strong class="brand-font">Proyecto integral</strong>
                            <p>Relevamiento, propuesta, fabricación y colocación bajo una misma coordinación.</p>
                        </div>

                        <div class="showcase-floating-card">
                            <strong class="brand-font">{{ $categories->count() }} lineas activas</strong>
                            <p>Soluciones para hogar, oficina y espacios comerciales con la misma identidad visual.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="showcase-mosaic">
                <article class="showcase-card showcase-card--image">
                    @if ($featuredProducts->isNotEmpty())
                        <img src="{{ $featuredProducts->first()->primary_image_url }}" alt="{{ $featuredProducts->first()->name }}">
                    @endif
                    <h3 class="brand-font">Diseño con lectura arquitectónica</h3>
                    <p>Propuestas limpias, proporciones equilibradas y muebles pensados para integrarse con el ambiente.</p>
                </article>

                <article class="showcase-card showcase-card--image">
                    @if ($featuredProducts->count() > 1)
                        <img src="{{ $featuredProducts->skip(1)->first()->primary_image_url }}" alt="{{ $featuredProducts->skip(1)->first()->name }}">
                    @elseif ($featuredProducts->isNotEmpty())
                        <img src="{{ $featuredProducts->first()->primary_image_url }}" alt="{{ $featuredProducts->first()->name }}">
                    @endif
                    <h3 class="brand-font">Materiales y terminaciones</h3>
                    <p>Melaminas, herrajes y detalles resueltos para que el resultado se vea sólido, prolijo y durable.</p>
                </article>

                <article class="showcase-card">
                    <span class="showcase-chip">Servicio integral</span>
                    <h3 class="brand-font">Cada proyecto busca resolver uso, guardado y presencia visual.</h3>
                    <p>
                        Desde cocinas y placares hasta puestos de trabajo y recepciones, planteamos soluciones a medida
                        para que el mueble acompañe el ritmo real del espacio.
                    </p>
                    <div class="showcase-card__footer">
                        <span class="availability-tag">Amoblamientos a medida</span>
                        <a class="text-link" href="#colecciones">Explorar ambientes</a>
                    </div>
                </article>
            </div>
        </section>

        <section class="showcase-frame showcase-categories" id="colecciones">
            <div class="showcase-categories-head">
                <div>
                    <span class="showcase-kicker">Soluciones por ambiente</span>
                    <h2 class="brand-font">Soluciones pensadas para cada ambiente y cada necesidad de uso.</h2>
                </div>
                <p>
                    Trabajamos muebles que combinan estética, resistencia y organización, con una propuesta visual coherente
                    para viviendas, oficinas y espacios comerciales.
                </p>
            </div>

            <div class="showcase-tabs">
                @foreach ($categories as $category)
                    <a class="showcase-tab" href="{{ route('products.index', ['categoria' => $category->slug]) }}">{{ $category->name }}</a>
                @endforeach
            </div>

            <div class="showcase-rooms">
                @foreach ($categories as $category)
                    <article class="showcase-room">
                        <span class="showcase-chip">{{ $loop->iteration < 10 ? '0'.$loop->iteration : $loop->iteration }}</span>
                        <h3 class="brand-font">{{ $category->name }}</h3>
                        <p>{{ $category->description }}</p>
                        <footer>
                            <span class="muted">Linea comercial</span>
                            <a class="text-link" href="{{ route('products.index', ['categoria' => $category->slug]) }}">Ver productos</a>
                        </footer>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="showcase-frame showcase-products">
            @foreach ($featuredProducts as $product)
                <article class="showcase-product">
                    <div class="showcase-product__media">
                        <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}">
                    </div>

                    <div class="showcase-product__copy">
                        <div>
                            <span class="showcase-chip">{{ $product->category?->name }}</span>
                            <h3 class="brand-font">{{ $product->name }}</h3>
                            <p>{{ $product->short_description }}</p>
                            <p class="muted" style="margin-top:.45rem;">{{ $product->description }}</p>
                        </div>

                        <div class="showcase-product__meta">
                            <div class="showcase-price">
                                <span>Precio referencia</span>
                                <strong class="brand-font">AR$ {{ number_format((float) $product->price, 0, ',', '.') }}</strong>
                            </div>

                            <div class="showcase-product__actions">
                                <span class="availability-tag">{{ $product->availability_label }}</span>
                                <a class="btn btn-secondary btn-small" href="{{ route('products.show', $product) }}">Ver ficha</a>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="showcase-bottom">
            <article class="showcase-story">
                <span class="showcase-kicker" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.14);color:#f4f8fb;">Nuestra mirada</span>
                <h2 class="brand-font">Diseñamos muebles para que el espacio se vea mejor y funcione mejor.</h2>
                <p>
                    En M&Ouml;BELS Alejandro buscamos que cada proyecto combine orden, presencia y practicidad.
                    Por eso trabajamos cada ambiente con una lógica clara: entender el uso, definir materiales y ejecutar
                    una solución que se sienta natural una vez instalada.
                </p>

                <ul class="showcase-list">
                    @foreach ($advantages as $advantage)
                        <li>{{ $advantage }}</li>
                    @endforeach
                </ul>
            </article>

            <article class="showcase-proof">
                <span class="showcase-kicker">Fortalezas del negocio</span>
                <h2 class="brand-font">Una propuesta clara para quienes buscan calidad, criterio y atención personalizada.</h2>
                <p>Melamina, herreria y una ejecución cuidada para lograr muebles durables, visualmente limpios y listos para el uso cotidiano.</p>

                <div class="showcase-proof-grid">
                    @foreach ($metrics as $metric)
                        <article class="showcase-highlight">
                            <strong class="brand-font">{{ $metric['value'] }}</strong>
                            <span>{{ $metric['label'] }}</span>
                        </article>
                    @endforeach
                </div>
            </article>
        </section>

        <section class="showcase-workflow" id="proceso">
            @foreach ($workflow as $item)
                <article class="showcase-process">
                    <span class="showcase-process__step">{{ $item['step'] }}</span>
                    <h3 class="brand-font">{{ $item['title'] }}</h3>
                    <p>{{ $item['copy'] }}</p>
                </article>
            @endforeach
        </section>

        <section class="showcase-cta">
            <div>
                <span class="showcase-kicker">Siguiente paso</span>
                <h2 class="brand-font">Entrá al catálogo y elegí una base para tu próximo proyecto.</h2>
                <p>
                    Si ya tienes medidas o una idea avanzada, puedes pasar directamente al catálogo. Si estás en etapa de exploración,
                    esta home ya te deja claro cómo trabaja la marca y qué tipo de soluciones ofrece.
                </p>
            </div>

            <a class="btn btn-primary" href="{{ route('products.index') }}">Ir al catalogo</a>
        </section>
    </div>
@endsection
