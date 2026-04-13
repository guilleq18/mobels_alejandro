<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta
            name="description"
            content="@yield('description', 'Base ecommerce en Laravel para M&Ouml;BELS Alejandro, con identidad visual inspirada en la marca.')"
        >
        <title>@yield('title', 'M&Ouml;BELS Alejandro | Ecommerce de Melamina')</title>
        @yield('page_head')
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800|montserrat:500,600,700,800&display=swap" rel="stylesheet" />
        <style>
            :root{--ink:#18212b;--muted:#60707d;--paper:#f4f2ee;--panel:rgba(255,255,255,.74);--line:rgba(42,59,73,.14);--brand:#4f8191;--brand-strong:#202f5b;--brand-soft:#d7e3e7;--sand:#d5c4b3;--wood:#9a6a46;--charcoal:#2f3137}
            *{box-sizing:border-box} html{scroll-behavior:smooth} body{margin:0;color:var(--ink);font-family:"Manrope",sans-serif;background:radial-gradient(circle at top left,rgba(79,129,145,.22),transparent 30%),radial-gradient(circle at 86% 18%,rgba(32,47,91,.18),transparent 24%),radial-gradient(circle at 50% 100%,rgba(213,196,179,.32),transparent 30%),linear-gradient(180deg,#eef3f5 0%,var(--paper) 46%,#efe5db 100%)}
            a{text-decoration:none;color:inherit} img{max-width:100%;display:block} .wrap{width:min(1120px,calc(100% - 2rem));margin:0 auto}
            .brand-font,h1,h2,h3,.page-title,.logo-badge{font-family:"Montserrat",sans-serif}
            .topbar,.hero,.section-head,.cta,.page-intro__header,.detail-shell{display:flex;gap:1rem}
            .topbar{align-items:center;justify-content:space-between;padding:1.5rem 0;flex-wrap:wrap}
            .logo{display:block} .nav a,.muted,.footer{color:var(--muted)} .nav{display:flex;gap:1rem;flex-wrap:wrap}
            .nav a{position:relative;transition:color .2s ease}.nav a:hover,.nav a.is-active{color:var(--brand-strong)}
            .nav a.is-active::after{content:"";position:absolute;left:0;right:0;bottom:-.35rem;height:2px;border-radius:999px;background:linear-gradient(135deg,var(--brand),var(--brand-strong))}
            .brand-lockup{display:flex;gap:.95rem;align-items:center}
            .brand-lockup__mark{width:3.4rem;height:3.4rem;flex:none;filter:drop-shadow(0 16px 22px rgba(32,47,91,.2));object-fit:cover;border-radius:1rem;background:rgba(255,255,255,.76)}
            .brand-lockup__copy{display:grid;gap:.15rem}
            .brand-lockup__copy strong{font-size:.98rem;letter-spacing:.1em}
            .brand-lockup__copy span{color:var(--muted)}
            .brand-lockup__eyebrow{font-size:.69rem;font-weight:800;letter-spacing:.18em;color:var(--brand)}
            .chip,.pill,.filter-chip{display:inline-flex;align-items:center;gap:.55rem;padding:.55rem .9rem;border-radius:999px;border:1px solid rgba(79,129,145,.18);background:rgba(255,255,255,.58);backdrop-filter:blur(14px);font-size:.88rem;color:var(--brand-strong)}
            .chip::before,.filter-chip::before{content:"";width:.6rem;height:.6rem;border-radius:999px;background:linear-gradient(135deg,var(--brand),var(--brand-strong));box-shadow:0 0 0 6px rgba(79,129,145,.12)}
            .filter-chip{padding:.7rem 1rem;font-weight:700}
            .filter-chip.is-active{background:linear-gradient(135deg,var(--brand),var(--brand-strong));color:#f4f9fc;border-color:transparent;box-shadow:0 14px 24px rgba(32,47,91,.18)}
            .filter-chip.is-active::before{background:#f4f9fc;box-shadow:none}
            .hero{align-items:center;padding:2rem 0 3.5rem;display:grid;grid-template-columns:minmax(0,1.08fr) minmax(290px,.92fr)}
            h1{margin:1.15rem 0 1rem;max-width:12ch;font-size:clamp(3rem,6vw,5.5rem);line-height:.94;letter-spacing:-.05em}
            h2{margin:.55rem 0 0;font-size:clamp(1.7rem,3vw,2.4rem);line-height:1;letter-spacing:-.04em}
            .page-title{margin:.7rem 0 0;max-width:14ch;font-size:clamp(2.5rem,5vw,4.2rem);line-height:.95;letter-spacing:-.05em}
            .lead,.copy,.breadcrumbs,.empty-state p,.detail-copy,.note-card p,.related-copy{max-width:64ch;font-size:1.05rem;line-height:1.75;color:var(--muted)}
            .actions,.stats,.catalog,.roadmap,.filters{display:flex;gap:1rem;flex-wrap:wrap} .actions{margin-top:1.8rem}
            .btn,.text-link{display:inline-flex;align-items:center;justify-content:center;gap:.55rem;padding:.95rem 1.35rem;border-radius:999px;font-weight:600;border:1px solid transparent;transition:transform .2s ease,box-shadow .2s ease}.btn:hover,.text-link:hover{transform:translateY(-2px)}
            .btn-primary{background:linear-gradient(135deg,var(--brand),var(--brand-strong));color:#f4f9fc;box-shadow:0 18px 30px rgba(32,47,91,.24)} .btn-secondary,.text-link{background:rgba(255,255,255,.58);border-color:rgba(42,59,73,.12)}
            .btn-small{padding:.75rem 1rem;font-size:.92rem}
            .text-link{padding:.8rem 1.15rem}
            .stats{margin-top:1.7rem} .stat,.card,.product,.step,.cta,.spec,.detail-media,.note-card,.empty-state{border:1px solid var(--line);background:var(--panel);backdrop-filter:blur(16px);box-shadow:0 16px 34px rgba(51,37,32,.07)}
            .stat{flex:1 1 180px;padding:1rem 1.1rem;border-radius:1.2rem} .stat strong{display:block;font-size:1.55rem;margin-bottom:.2rem}
            .scene{padding:1rem;border-radius:2rem;background:linear-gradient(180deg,rgba(255,255,255,.74),rgba(255,255,255,.54));position:relative;min-height:33rem;border:1px solid var(--line);box-shadow:0 28px 60px rgba(22,34,47,.11)}
            .scene::before{content:"";position:absolute;inset:1rem;border-radius:1.4rem;background:linear-gradient(145deg,rgba(79,129,145,.18),transparent 35%),linear-gradient(160deg,rgba(32,47,91,.22),rgba(255,255,255,.04)),linear-gradient(180deg,rgba(213,196,179,.2),transparent 72%),repeating-linear-gradient(90deg,rgba(32,47,91,.05) 0,rgba(32,47,91,.05) 1px,transparent 1px,transparent 44px)}
            .scene-grid{position:relative;z-index:1;height:100%;display:grid;grid-template-columns:1fr 1fr;gap:1rem} .panel{padding:1.1rem;border-radius:1.35rem;background:rgba(248,251,252,.76);border:1px solid rgba(42,59,73,.12)}
            .panel-large{grid-column:1/-1;display:grid;overflow:hidden;padding:0;background:linear-gradient(180deg,rgba(215,227,231,.46),rgba(215,227,231,.9)),linear-gradient(135deg,rgba(79,129,145,.16),rgba(32,47,91,.22))}
            .panel-large-copy{padding:1.15rem 1.15rem 1.2rem;display:grid;gap:.35rem}
            .hero-banner{display:block;width:100%;aspect-ratio:16 / 9;object-fit:cover;border-radius:1.1rem 1.1rem 0 0}
            .panel strong{display:block;margin:.8rem 0 .45rem;font-size:1.15rem} .panel p{margin:0;line-height:1.65;color:var(--muted)}
            section{padding-top:1.2rem} .section-head{justify-content:space-between;align-items:end;margin-bottom:1.5rem;flex-wrap:wrap}
            .catalog{display:grid;grid-template-columns:repeat(4,minmax(0,1fr))}
            .card{padding:1.35rem;border-radius:1.4rem;min-height:15rem;display:grid;align-content:space-between;position:relative;overflow:hidden}
            .card::after{content:"";position:absolute;right:-1.8rem;bottom:-1.8rem;width:7rem;height:7rem;border-radius:2rem;background:linear-gradient(135deg,rgba(79,129,145,.16),rgba(32,47,91,.2));transform:rotate(18deg)}
            .card h3,.product h3,.step h3,.detail-price,.spec strong{margin:.9rem 0 .55rem;font-size:1.28rem}
            .card p,.product p,.step p,.cta p,.list li{line-height:1.7;color:var(--muted)}
            .products,.listing-grid,.related-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem}
            .related-grid{grid-template-columns:repeat(3,minmax(0,1fr))}
            .related-grid .product{grid-template-columns:1fr}
            .related-grid .visual{min-height:12rem}
            .product{display:grid;grid-template-columns:.85fr 1.15fr;gap:1rem;padding:1rem;border-radius:1.45rem}
            .visual,.detail-media{min-height:15rem;border-radius:1.2rem;position:relative;overflow:hidden;background:linear-gradient(135deg,rgba(79,129,145,.14),rgba(213,196,179,.18)),linear-gradient(180deg,rgba(255,255,255,.55),rgba(239,231,219,.92));border:1px solid rgba(42,59,73,.08)}
            .detail-media{min-height:28rem;padding:.8rem}
            .detail-media img{width:100%;height:100%;object-fit:cover;border-radius:1rem}
            .product-banner{display:block;width:100%;height:100%;object-fit:cover}
            .product-copy{display:flex;flex-direction:column;justify-content:space-between;gap:1rem} .price{display:flex;align-items:end;justify-content:space-between;gap:1rem;border-top:1px solid rgba(42,59,73,.1);padding-top:1rem}
            .price strong,.detail-price{display:block;font-size:1.5rem}
            .card-actions,.detail-actions{display:flex;gap:.75rem;flex-wrap:wrap}
            .list{margin:0;padding:0;list-style:none;display:grid;gap:.8rem} .list li{position:relative;padding-left:1.3rem}
            .list li::before{content:"";position:absolute;left:0;top:.72rem;width:.55rem;height:.55rem;border-radius:999px;background:linear-gradient(135deg,var(--brand),var(--brand-strong))}
            .roadmap{display:grid;grid-template-columns:repeat(3,minmax(0,1fr))} .step{padding:1.3rem;border-radius:1.35rem}
            .cta{margin:2.25rem 0 4rem;padding:1.5rem 1.6rem;align-items:center;justify-content:space-between;border-radius:1.6rem;background:linear-gradient(135deg,rgba(32,47,91,.98),rgba(79,129,145,.9));color:#f2f8fb;flex-wrap:wrap}
            .cta p{color:rgba(242,248,251,.82);max-width:38rem} .footer{padding:0 0 2rem;text-align:center;font-size:.92rem}
            .page-intro{padding:1.5rem 0 1.4rem;display:grid;gap:1.15rem}
            .page-intro__header{justify-content:space-between;align-items:end;flex-wrap:wrap}
            .breadcrumbs{font-size:.94rem}
            .breadcrumbs a:hover{color:var(--brand-strong)}
            .empty-state{padding:1.5rem;border-radius:1.5rem}
            .detail-shell{padding-top:1rem;display:grid;grid-template-columns:minmax(0,1fr) minmax(320px,.9fr);align-items:start}
            .detail-stack{display:grid;gap:1rem}
            .detail-card{padding:1.35rem;border-radius:1.5rem}
            .detail-copy{margin-top:.35rem}
            .detail-media{display:grid;gap:1rem;align-content:start}
            .gallery-stage{position:relative;min-height:28rem}
            .gallery-stage img{width:100%;height:100%;object-fit:cover;border-radius:1rem}
            .gallery-meta{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap}
            .gallery-counter{font-weight:700;color:var(--brand-strong)}
            .gallery-nav{position:absolute;top:50%;transform:translateY(-50%);width:2.85rem;height:2.85rem;border:1px solid rgba(42,59,73,.12);border-radius:999px;background:rgba(255,255,255,.82);backdrop-filter:blur(16px);display:grid;place-items:center;font-size:1.3rem;cursor:pointer;box-shadow:0 16px 28px rgba(42,59,73,.12)}
            .gallery-nav.is-prev{left:1rem}
            .gallery-nav.is-next{right:1rem}
            .gallery-nav[disabled]{opacity:.45;cursor:not-allowed;transform:translateY(-50%)}
            .color-palette,.gallery-thumbs{display:flex;gap:.75rem;flex-wrap:wrap}
            .color-chip{display:flex;align-items:center;gap:.85rem;padding:.7rem .9rem;border-radius:1.2rem;border:1px solid rgba(42,59,73,.12);background:rgba(255,255,255,.78);cursor:pointer;transition:transform .2s ease,border-color .2s ease,box-shadow .2s ease;text-align:left}
            .color-chip:hover,.color-chip.is-active{transform:translateY(-2px);border-color:rgba(79,129,145,.38);box-shadow:0 14px 24px rgba(32,47,91,.12)}
            .color-swatch{width:3.4rem;height:3.4rem;border-radius:.9rem;overflow:hidden;border:1px solid rgba(42,59,73,.1);background:linear-gradient(135deg,rgba(79,129,145,.12),rgba(213,196,179,.18));flex:none}
            .color-swatch img{width:100%;height:100%;object-fit:cover}
            .color-chip__copy{display:grid;gap:.18rem}
            .color-chip__copy strong{font-size:.96rem}
            .color-chip__copy small{color:var(--muted);font-size:.8rem}
            .gallery-thumb{width:5rem;height:5rem;padding:0;border:1px solid rgba(42,59,73,.12);border-radius:1rem;background:rgba(255,255,255,.78);overflow:hidden;cursor:pointer;transition:transform .2s ease,border-color .2s ease,box-shadow .2s ease}
            .gallery-thumb img{width:100%;height:100%;object-fit:cover}
            .gallery-thumb:hover,.gallery-thumb.is-active{transform:translateY(-2px);border-color:rgba(79,129,145,.4);box-shadow:0 14px 24px rgba(32,47,91,.12)}
            .availability-tag{display:inline-flex;align-items:center;gap:.45rem;padding:.45rem .75rem;border-radius:999px;background:rgba(79,129,145,.12);color:var(--brand-strong);font-size:.86rem;font-weight:700}
            .spec-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.85rem}
            .spec{padding:1rem 1.05rem;border-radius:1.2rem}
            .spec span{display:block;font-size:.82rem;letter-spacing:.08em;color:var(--muted);text-transform:uppercase}
            .spec strong{display:block;margin-top:.4rem}
            .note-card{padding:1.2rem;border-radius:1.4rem}
            .quote-section{padding:2rem 0 1rem}
            .quote-grid,.form-grid{display:grid;gap:1rem}
            .quote-grid{grid-template-columns:minmax(0,.88fr) minmax(0,1.12fr)}
            .quote-panel,.quote-form-card{display:grid;align-content:start;gap:1rem}
            .quote-form{display:grid;gap:1rem}
            .form-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
            .form-field{display:grid;gap:.5rem}
            .form-field span{font-size:.9rem;font-weight:700;color:var(--brand-strong)}
            .form-field input,.form-field textarea{width:100%;padding:.95rem 1rem;border-radius:1rem;border:1px solid rgba(42,59,73,.12);background:rgba(255,255,255,.82);font:inherit;color:var(--ink);outline:none;transition:border-color .2s ease,box-shadow .2s ease}
            .form-field input:focus,.form-field textarea:focus{border-color:rgba(79,129,145,.55);box-shadow:0 0 0 4px rgba(79,129,145,.12)}
            .form-field textarea{resize:vertical;min-height:9rem}
            .field-error{color:#8f3b31;line-height:1.5}
            .form-actions{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap}
            .alert,.inline-note{padding:1rem 1.05rem;border-radius:1rem}
            .alert-success{background:rgba(79,129,145,.12);border:1px solid rgba(79,129,145,.2);color:var(--brand-strong)}
            .inline-note{background:rgba(32,47,91,.06);border:1px solid rgba(32,47,91,.09)}
            .inline-note p{margin:.4rem 0 0}
            .related-section{padding:2rem 0 3rem}
            @media (max-width:980px){.hero,.catalog,.products,.roadmap,.product,.listing-grid,.related-grid,.detail-shell,.spec-grid,.quote-grid,.form-grid{grid-template-columns:1fr}.scene-grid{grid-template-columns:1fr}.panel-large{grid-column:auto}h1,.page-title{max-width:none}.scene{min-height:auto}.detail-shell{gap:1rem}.detail-media{order:0}}
            @media (max-width:760px){.wrap{width:min(1120px,calc(100% - 1.2rem))}.topbar{padding:1rem 0;gap:.85rem}.topbar,.page-intro__header,.section-head,.cta{align-items:stretch}.logo,.nav{width:100%}.nav{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem}.nav a{padding:.9rem 1rem;border-radius:1rem;border:1px solid rgba(42,59,73,.1);background:rgba(255,255,255,.58);text-align:center}.nav a.is-active::after{display:none}.hero{padding:1rem 0 2.25rem}.actions,.card-actions,.detail-actions,.form-actions{width:100%}.actions > *, .card-actions > *, .detail-actions > *, .form-actions > *{flex:1 1 100%}.btn,.text-link{width:100%}.catalog{gap:.85rem}.product{padding:.85rem}.price{align-items:stretch;flex-direction:column}.detail-media{padding:.65rem}.gallery-stage{min-height:20rem}.gallery-nav{width:2.5rem;height:2.5rem}.gallery-nav.is-prev{left:.6rem}.gallery-nav.is-next{right:.6rem}.color-palette{display:grid;grid-template-columns:1fr}.color-chip{width:100%}.gallery-thumbs{display:grid;grid-template-columns:repeat(4,minmax(0,1fr))}.gallery-thumb{width:100%;height:auto;aspect-ratio:1}.quote-section{padding-top:1.4rem}.quote-panel,.quote-form-card,.detail-card,.note-card,.spec,.empty-state,.card,.product,.step,.stat{padding:1rem}.footer{padding-bottom:1.5rem}}
            @media (max-width:560px){body{background:radial-gradient(circle at top left,rgba(79,129,145,.2),transparent 36%),linear-gradient(180deg,#eef3f5 0%,var(--paper) 42%,#efe5db 100%)}h1{font-size:clamp(2.45rem,12vw,3.5rem)}h2{font-size:clamp(1.55rem,8vw,2rem)}.page-title{font-size:clamp(2rem,10vw,2.8rem)}.lead,.copy,.breadcrumbs,.empty-state p,.detail-copy,.note-card p,.related-copy{font-size:.98rem;line-height:1.65}.chip,.pill,.filter-chip{font-size:.82rem;padding:.5rem .8rem}.stats{gap:.75rem}.stat{flex-basis:100%}.scene{padding:.75rem;border-radius:1.5rem}.scene::before{inset:.75rem}.panel{padding:1rem}.hero-banner{aspect-ratio:4 / 3}.page-intro{padding:1rem 0 1.1rem}.filters{display:grid;grid-template-columns:1fr 1fr}.filter-chip{justify-content:center;text-align:center}.visual{min-height:12.5rem}.detail-media{min-height:auto}.gallery-stage{min-height:16rem}.gallery-meta{align-items:flex-start}.gallery-thumbs{grid-template-columns:repeat(3,minmax(0,1fr))}.color-swatch{width:3rem;height:3rem}.color-chip__copy strong{font-size:.92rem}.spec-grid{gap:.75rem}.quote-grid,.form-grid{gap:.85rem}.form-field input,.form-field textarea{padding:.9rem}.cta{margin:1.8rem 0 3rem;padding:1.15rem}.footer{font-size:.86rem}}
            @media (max-width:420px){.wrap{width:min(1120px,calc(100% - 1rem))}.nav{grid-template-columns:1fr}.filters{grid-template-columns:1fr}.gallery-thumbs{grid-template-columns:repeat(2,minmax(0,1fr))}.gallery-counter{font-size:.92rem}.brand-lockup{gap:.75rem}.brand-lockup__mark{width:2.9rem;height:2.9rem}.brand-lockup__copy strong{font-size:.88rem;letter-spacing:.08em}}
        </style>
    </head>
    <body>
        <div class="wrap">
            <header class="topbar">
                <a href="{{ route('home') }}" class="logo">
                    <x-brand-logo />
                </a>

                <nav class="nav">
                    <a href="{{ route('home') }}" @class(['is-active' => request()->routeIs('home')])>Inicio</a>
                    <a href="{{ route('products.index') }}" @class(['is-active' => request()->routeIs('products.*')])>Catalogo</a>
                    <a href="{{ route('home') }}#colecciones">Colecciones</a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}">Panel</a>
                    @else
                        <a href="{{ route('login') }}">Acceso admin</a>
                    @endauth
                </nav>
            </header>

            <main>
                @yield('content')
            </main>

            <footer class="footer">
                M&Ouml;BELS Alejandro · Laravel v{{ Illuminate\Foundation\Application::VERSION }} · PHP v{{ PHP_VERSION }}
            </footer>
        </div>

        @yield('page_scripts')
    </body>
</html>
