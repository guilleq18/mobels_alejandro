@extends('layouts.store')

@section('description', 'Amoblamientos de melamina, herreria y muebles a medida para hogar, oficina y espacios comerciales en Catamarca.')
@section('title', 'M&Ouml;BELS Alejandro | Amoblamientos de Melamina a Medida')

@section('page_head')
    <style>
        .landing{display:grid;gap:2rem;padding:1.2rem 0 3.75rem}
        .landing-shell,.landing-hero,.landing-band,.landing-grid,.landing-workflow,.landing-featured,.landing-proof,.landing-cta,.landing-story{display:grid;gap:1.25rem}
        .landing-shell{gap:1.5rem}
        .landing-hero{grid-template-columns:minmax(0,1.08fr) minmax(320px,.92fr);align-items:stretch;padding:1rem 0 0}
        .landing-copy{display:grid;gap:1.25rem;align-content:start}
        .landing-eyebrow,.landing-chip{display:inline-flex;align-items:center;gap:.55rem;width:max-content;padding:.58rem .92rem;border-radius:999px;border:1px solid rgba(79,129,145,.18);background:rgba(255,255,255,.66);backdrop-filter:blur(16px);font-size:.84rem;font-weight:800;letter-spacing:.08em;color:var(--brand-strong);text-transform:uppercase}
        .landing-eyebrow::before,.landing-chip::before{content:"";width:.62rem;height:.62rem;border-radius:999px;background:linear-gradient(135deg,var(--brand),var(--brand-strong));box-shadow:0 0 0 6px rgba(79,129,145,.12)}
        .landing-title{margin:0;max-width:11ch;font-size:clamp(3.4rem,6.2vw,6rem);line-height:.9;letter-spacing:-.06em}
        .landing-lead{margin:0;max-width:60ch;font-size:1.08rem;line-height:1.85;color:var(--muted)}
        .landing-actions{display:flex;gap:.85rem;flex-wrap:wrap}
        .landing-actions .btn,.landing-actions .text-link{min-width:13rem}
        .landing-points{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:.85rem}
        .landing-point,.landing-card,.landing-stat,.landing-room,.landing-feature-card,.landing-proof-card,.landing-story-card,.landing-process-card{border:1px solid var(--line);background:rgba(255,255,255,.72);backdrop-filter:blur(18px);box-shadow:0 18px 40px rgba(42,59,73,.08)}
        .landing-point{padding:1rem 1.05rem;border-radius:1.25rem}
        .landing-point strong{display:block;margin-bottom:.35rem;font-size:1rem}
        .landing-point p,.landing-card p,.landing-room p,.landing-feature-card p,.landing-proof-card p,.landing-story-card p,.landing-process-card p{margin:0;color:var(--muted);line-height:1.7}
        .landing-visual{position:relative;min-height:100%;padding:1rem;border-radius:2rem;background:linear-gradient(180deg,rgba(255,255,255,.78),rgba(255,255,255,.56));border:1px solid var(--line);box-shadow:0 28px 60px rgba(22,34,47,.12);overflow:hidden}
        .landing-visual::before{content:"";position:absolute;inset:.9rem;border-radius:1.45rem;background:linear-gradient(150deg,rgba(79,129,145,.18),transparent 36%),linear-gradient(180deg,rgba(255,255,255,.12),rgba(32,47,91,.12)),radial-gradient(circle at top right,rgba(213,196,179,.26),transparent 32%)}
        .landing-visual-grid{position:relative;z-index:1;height:100%;display:grid;grid-template-columns:1fr 1fr;gap:1rem}
        .landing-card{padding:1.15rem;border-radius:1.35rem}
        .landing-card--media{grid-column:1/-1;padding:0;overflow:hidden;background:linear-gradient(180deg,rgba(215,227,231,.46),rgba(215,227,231,.88))}
        .landing-card--media img{width:100%;aspect-ratio:16/10;object-fit:cover}
        .landing-card__copy{display:grid;gap:.45rem;padding:1.15rem 1.15rem 1.2rem}
        .landing-card__copy strong{font-size:1.18rem}
        .landing-card__meta{display:flex;align-items:center;justify-content:space-between;gap:.75rem;flex-wrap:wrap}
        .landing-note{display:inline-flex;align-items:center;gap:.5rem;color:var(--brand-strong);font-weight:700}
        .landing-note::before{content:"";width:.55rem;height:.55rem;border-radius:999px;background:var(--sand)}
        .landing-band{grid-template-columns:repeat(3,minmax(0,1fr))}
        .landing-stat{padding:1.2rem 1.25rem;border-radius:1.35rem}
        .landing-stat strong{display:block;margin-bottom:.5rem;font-size:1.05rem}
        .landing-stat span{display:block;font-size:1.48rem;line-height:1.1;letter-spacing:-.03em}
        .landing-grid{grid-template-columns:minmax(0,1.02fr) minmax(0,.98fr);align-items:start}
        .landing-section-head{display:grid;gap:.85rem}
        .landing-section-head h2{margin:0;max-width:12ch;font-size:clamp(2.1rem,4vw,3.2rem);line-height:.94}
        .landing-section-head p{margin:0;max-width:58ch;color:var(--muted);line-height:1.8}
        .landing-rooms{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem}
        .landing-room{padding:1.25rem;border-radius:1.45rem;position:relative;overflow:hidden}
        .landing-room::after{content:"";position:absolute;right:-1.8rem;bottom:-2rem;width:7rem;height:7rem;border-radius:2rem;background:linear-gradient(135deg,rgba(79,129,145,.16),rgba(32,47,91,.18));transform:rotate(24deg)}
        .landing-room h3{margin:.9rem 0 .55rem;font-size:1.25rem}
        .landing-room footer{margin-top:1.2rem;display:flex;align-items:center;justify-content:space-between;gap:.8rem;flex-wrap:wrap}
        .landing-bullets{display:grid;gap:.85rem}
        .landing-proof-card,.landing-story-card{padding:1.25rem;border-radius:1.45rem}
        .landing-proof-list,.landing-story-list{display:grid;gap:.85rem;margin:0;padding:0;list-style:none}
        .landing-proof-list li,.landing-story-list li{position:relative;padding-left:1.35rem;color:var(--muted);line-height:1.75}
        .landing-proof-list li::before,.landing-story-list li::before{content:"";position:absolute;left:0;top:.7rem;width:.58rem;height:.58rem;border-radius:999px;background:linear-gradient(135deg,var(--brand),var(--brand-strong))}
        .landing-workflow{grid-template-columns:repeat(4,minmax(0,1fr))}
        .landing-process-card{padding:1.25rem;border-radius:1.45rem}
        .landing-process-card span{display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;border-radius:999px;background:linear-gradient(135deg,var(--brand),var(--brand-strong));color:#f4f9fc;font-weight:800;box-shadow:0 14px 28px rgba(32,47,91,.18)}
        .landing-process-card h3{margin:1rem 0 .6rem;font-size:1.18rem}
        .landing-featured{gap:1.25rem}
        .landing-featured-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem}
        .landing-feature-card{display:grid;grid-template-columns:minmax(220px,.82fr) minmax(0,1.18fr);gap:1rem;padding:1rem;border-radius:1.55rem}
        .landing-feature-card__media{min-height:17rem;border-radius:1.2rem;overflow:hidden;border:1px solid rgba(42,59,73,.08);background:linear-gradient(135deg,rgba(79,129,145,.14),rgba(213,196,179,.18)),linear-gradient(180deg,rgba(255,255,255,.55),rgba(239,231,219,.92))}
        .landing-feature-card__media img{width:100%;height:100%;object-fit:cover}
        .landing-feature-card__copy{display:grid;align-content:space-between;gap:1rem}
        .landing-feature-card__top{display:grid;gap:.6rem}
        .landing-feature-card__top h3{margin:0;font-size:1.35rem}
        .landing-feature-card__meta{display:flex;align-items:end;justify-content:space-between;gap:1rem;flex-wrap:wrap;padding-top:1rem;border-top:1px solid rgba(42,59,73,.1)}
        .landing-feature-card__price span{display:block;color:var(--muted);font-size:.88rem}
        .landing-feature-card__price strong{display:block;font-size:1.52rem}
        .landing-story{grid-template-columns:minmax(0,1.05fr) minmax(0,.95fr);align-items:start}
        .landing-story-card--accent{background:linear-gradient(140deg,rgba(32,47,91,.97),rgba(79,129,145,.88));color:#f1f7fa}
        .landing-story-card--accent p,.landing-story-card--accent li{color:rgba(241,247,250,.82)}
        .landing-story-card--accent .landing-chip{background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.12);color:#f1f7fa}
        .landing-story-card--accent .landing-chip::before{background:#f1f7fa;box-shadow:none}
        .landing-story-card h2{margin:.2rem 0 .55rem}
        .landing-story-card strong{font-size:1.08rem}
        .landing-cta{grid-template-columns:minmax(0,1.1fr) auto;align-items:center;margin-top:.25rem;padding:1.5rem 1.6rem;border-radius:1.7rem;background:linear-gradient(135deg,rgba(32,47,91,.98),rgba(79,129,145,.9));color:#f2f8fb;box-shadow:0 22px 42px rgba(32,47,91,.18)}
        .landing-cta h2,.landing-cta p{margin:0}
        .landing-cta p{max-width:42rem;color:rgba(242,248,251,.82);line-height:1.8}
        .landing-cta .btn-secondary{background:rgba(255,255,255,.16);border-color:rgba(255,255,255,.18);color:#f2f8fb}
        @media (max-width:1080px){.landing-hero,.landing-grid,.landing-story,.landing-featured-grid,.landing-workflow{grid-template-columns:1fr}.landing-points,.landing-band,.landing-rooms{grid-template-columns:repeat(2,minmax(0,1fr))}.landing-feature-card{grid-template-columns:1fr}.landing-title{max-width:none}.landing-visual{min-height:auto}.landing-cta{grid-template-columns:1fr}}
        @media (max-width:760px){.landing{gap:1.5rem;padding-bottom:3rem}.landing-points,.landing-band,.landing-rooms,.landing-workflow{grid-template-columns:1fr}.landing-actions{width:100%}.landing-actions > *{flex:1 1 100%}.landing-actions .btn,.landing-actions .text-link{width:100%}.landing-visual-grid{grid-template-columns:1fr}.landing-title{font-size:clamp(2.75rem,14vw,4.4rem)}.landing-card--media img{aspect-ratio:4/3}.landing-feature-card__media{min-height:14rem}}
        @media (max-width:560px){.landing-shell{gap:1.2rem}.landing-section-head h2{max-width:none;font-size:clamp(1.8rem,9vw,2.4rem)}.landing-lead,.landing-section-head p{font-size:.98rem;line-height:1.7}.landing-point,.landing-stat,.landing-room,.landing-feature-card,.landing-proof-card,.landing-story-card,.landing-process-card{padding:1rem}.landing-cta{padding:1.15rem}.landing-card__copy{padding:1rem}.landing-visual{padding:.75rem;border-radius:1.5rem}.landing-visual::before{inset:.7rem}}
    </style>
@endsection

@section('content')
    <div class="landing">
        <section class="landing-shell">
            <div class="landing-hero">
                <div class="landing-copy">
                    <span class="landing-eyebrow">Catamarca · Amoblamientos a medida</span>
                    <h1 class="landing-title brand-font">Melamina, herreria y muebles que ordenan mejor cada espacio.</h1>
                    <p class="landing-lead">
                        Diseñamos y fabricamos amoblamientos para cocinas, dormitorios, oficinas y espacios comerciales con una mirada
                        técnica, una presencia visual cuidada y soluciones pensadas para durar en el uso diario.
                    </p>

                    <div class="landing-actions">
                        <a class="btn btn-primary" href="{{ route('products.index') }}">Ver catalogo</a>
                        <a class="text-link" href="#proceso">Como trabajamos</a>
                    </div>

                    <div class="landing-points">
                        @foreach ($metrics as $metric)
                            <article class="landing-point">
                                <strong class="brand-font">{{ $metric['value'] }}</strong>
                                <p>{{ $metric['label'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>

                <div class="landing-visual">
                    <div class="landing-visual-grid">
                        <article class="landing-card landing-card--media">
                            <img
                                src="{{ $heroBannerUrl }}"
                                alt="Portada de MÖBELS Alejandro con amoblamientos de melamina y herreria"
                            >
                            <div class="landing-card__copy">
                                <div class="landing-card__meta">
                                    <span class="landing-chip">Inicio de obra a medida</span>
                                    <span class="landing-note">Diseño funcional y terminaciones limpias</span>
                                </div>
                                <strong class="brand-font">Proyectos que combinan estructura, guardado y una presencia profesional en el ambiente.</strong>
                                <p>La identidad sigue usando la misma paleta: petróleo, azul profundo, arena y madera técnica, ahora con una narrativa más comercial para el rubro.</p>
                            </div>
                        </article>

                        <article class="landing-card">
                            <span class="landing-chip">Proyecto integral</span>
                            <strong class="brand-font">Desde la idea hasta la instalación</strong>
                            <p>Tomamos medidas, definimos materiales, fabricamos y dejamos el mueble listo para uso real.</p>
                        </article>

                        <article class="landing-card">
                            <span class="landing-chip">Rubros atendidos</span>
                            <strong class="brand-font">Hogar, oficina y locales</strong>
                            <p>Resoluciones visualmente consistentes para viviendas, espacios de trabajo y puntos de atención al público.</p>
                        </article>
                    </div>
                </div>
            </div>

            <div class="landing-band">
                @foreach ($serviceHighlights as $highlight)
                    <article class="landing-stat">
                        <strong class="brand-font">{{ $highlight['title'] }}</strong>
                        <span>{{ $highlight['copy'] }}</span>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="landing-grid" id="colecciones">
            <div class="landing-section-head">
                <span class="landing-chip">Ambientes y soluciones</span>
                <h2 class="brand-font">Muebles pensados para verse bien y resolver de verdad.</h2>
                <p>
                    En este rubro no alcanza con que el mueble se vea lindo. Tiene que ordenar, aprovechar medidas, soportar uso
                    frecuente y conversar con el resto del ambiente. Por eso la home ahora habla más como una empresa de amoblamientos
                    a medida y menos como una demo genérica.
                </p>
            </div>

            <div class="landing-rooms">
                @foreach ($categories as $category)
                    <article class="landing-room">
                        <span class="landing-chip">{{ $loop->iteration < 10 ? '0'.$loop->iteration : $loop->iteration }}</span>
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

        <section class="landing-workflow" id="proceso">
            @foreach ($workflow as $item)
                <article class="landing-process-card">
                    <span>{{ $item['step'] }}</span>
                    <h3 class="brand-font">{{ $item['title'] }}</h3>
                    <p>{{ $item['copy'] }}</p>
                </article>
            @endforeach
        </section>

        <section class="landing-featured" id="destacados">
            <div class="landing-section-head">
                <span class="landing-chip">Destacados</span>
                <h2 class="brand-font">Modelos que muestran el tipo de trabajo que podemos escalar.</h2>
                <p>
                    Dejamos productos destacados para que la landing también funcione como una vidriera seria:
                    con imagen, precio de referencia, disponibilidad y acceso directo a cada ficha.
                </p>
            </div>

            <div class="landing-featured-grid">
                @foreach ($featuredProducts as $product)
                    <article class="landing-feature-card">
                        <div class="landing-feature-card__media">
                            <img
                                src="{{ $product->primary_image_url }}"
                                alt="Imagen principal de {{ $product->name }}"
                            >
                        </div>

                        <div class="landing-feature-card__copy">
                            <div class="landing-feature-card__top">
                                <span class="landing-chip">{{ $product->category?->name }}</span>
                                <h3 class="brand-font">{{ $product->name }}</h3>
                                <p>{{ $product->short_description }}</p>
                                <p class="muted">{{ $product->description }}</p>
                            </div>

                            <div class="landing-feature-card__meta">
                                <div class="landing-feature-card__price">
                                    <span>Precio referencia</span>
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

        <section class="landing-story">
            <article class="landing-story-card landing-story-card--accent">
                <span class="landing-chip">Por que elegirnos</span>
                <h2 class="brand-font">Una presentacion mas profesional para un oficio que vive del detalle.</h2>
                <p>
                    La nueva home baja la promesa de la marca a algo más creíble para el rubro:
                    soluciones a medida, procesos claros, materiales consistentes y una presencia visual
                    que acompaña el tipo de trabajos que realizan.
                </p>
                <ul class="landing-story-list">
                    @foreach ($advantages as $advantage)
                        <li>{{ $advantage }}</li>
                    @endforeach
                </ul>
            </article>

            <article class="landing-proof-card">
                <span class="landing-chip">Lo que transmite la pagina</span>
                <h2 class="brand-font">Mas confianza, mas contexto y mejores puntos de entrada.</h2>
                <ul class="landing-proof-list">
                    <li>Presenta el negocio como un proveedor serio de amoblamientos, no solo como un catalogo.</li>
                    <li>Ordena mejor los argumentos comerciales antes de llevar a la persona a ver productos.</li>
                    <li>Conserva la misma paleta y el mismo tono visual, pero con jerarquía más profesional.</li>
                    <li>Deja claro el recorrido: ver trabajos, entender el proceso y pedir presupuesto.</li>
                </ul>
            </article>
        </section>

        <section class="landing-cta">
            <div class="landing-section-head" style="gap: .65rem;">
                <span class="landing-chip">Siguiente paso</span>
                <h2 class="brand-font">Explorá el catalogo y elegí una base para tu proyecto.</h2>
                <p>
                    Si ya tienes una idea, puedes entrar al catálogo y ver fichas con precios de referencia, disponibilidad y consulta directa.
                    Si todavía estás definiendo el ambiente, esta landing ya deja más claro qué tipo de trabajo hace la marca.
                </p>
            </div>

            <a class="btn btn-secondary" href="{{ route('products.index') }}">Entrar al catalogo</a>
        </section>
    </div>
@endsection
