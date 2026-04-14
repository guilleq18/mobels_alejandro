<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Panel Admin | MOBELS Alejandro')</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800|montserrat:500,600,700,800&display=swap" rel="stylesheet" />
        <style>
            :root{--ink:#18212b;--muted:#63717d;--paper:#eef1f2;--panel:rgba(255,255,255,.84);--line:rgba(42,59,73,.14);--brand:#4f8191;--brand-strong:#202f5b;--brand-soft:#d7e3e7;--sand:#d5c4b3;--wood:#9a6a46;--ok:#2f7c67;--danger:#8f3b31}
            *{box-sizing:border-box} html{scroll-behavior:smooth} body{margin:0;color:var(--ink);font-family:"Manrope",sans-serif;background:radial-gradient(circle at top left,rgba(79,129,145,.18),transparent 28%),radial-gradient(circle at 88% 12%,rgba(32,47,91,.18),transparent 24%),linear-gradient(180deg,#edf2f4 0%,#f7f3ed 100%)}
            a{text-decoration:none;color:inherit} img{display:block;max-width:100%} button,input,select,textarea{font:inherit}
            .brand-font,h1,h2,h3,h4,.brand-lockup__copy strong,.metric strong{font-family:"Montserrat",sans-serif}
            .admin-shell{min-height:100vh;display:grid;grid-template-columns:300px minmax(0,1fr)}
            .sidebar{padding:1.6rem 1.3rem;border-right:1px solid rgba(42,59,73,.08);background:linear-gradient(180deg,rgba(255,255,255,.82),rgba(255,255,255,.62));backdrop-filter:blur(18px);display:grid;align-content:start;gap:1.35rem;position:sticky;top:0;height:100vh}
            .brand-lockup{display:flex;gap:.95rem;align-items:center}
            .brand-lockup__mark{width:3.35rem;height:3.35rem;flex:none;filter:drop-shadow(0 16px 24px rgba(32,47,91,.2));object-fit:cover;border-radius:1rem;background:rgba(255,255,255,.76)}
            .brand-lockup__copy{display:grid;gap:.15rem}
            .brand-lockup__copy strong{font-size:1rem;letter-spacing:.08em}
            .brand-lockup__copy span{color:var(--muted)}
            .brand-lockup__eyebrow{font-size:.69rem;font-weight:800;letter-spacing:.18em;color:var(--brand)}
            .eyebrow,.pill,.status-pill{display:inline-flex;align-items:center;gap:.5rem;padding:.5rem .82rem;border-radius:999px;border:1px solid rgba(79,129,145,.18);background:rgba(255,255,255,.68);font-size:.82rem;color:var(--brand-strong)}
            .eyebrow::before,.pill::before,.status-pill::before{content:"";width:.58rem;height:.58rem;border-radius:999px;background:linear-gradient(135deg,var(--brand),var(--brand-strong))}
            .status-pill.status-ok{color:var(--ok)}
            .status-pill.status-ok::before{background:var(--ok)}
            .status-pill.status-danger{color:var(--danger)}
            .status-pill.status-danger::before{background:var(--danger)}
            .side-copy{display:grid;gap:.7rem;padding:1rem;border-radius:1.3rem;background:linear-gradient(160deg,rgba(32,47,91,.96),rgba(79,129,145,.86));color:#f3f8fb;box-shadow:0 18px 36px rgba(22,34,47,.18)}
            .side-copy p{margin:0;color:rgba(243,248,251,.78);line-height:1.7}
            .side-nav{display:grid;gap:.45rem}
            .side-nav a{display:flex;align-items:center;justify-content:space-between;padding:.95rem 1rem;border-radius:1rem;color:var(--muted);transition:background .2s ease,color .2s ease,transform .2s ease}
            .side-nav a:hover,.side-nav a.is-active{background:linear-gradient(135deg,rgba(79,129,145,.12),rgba(32,47,91,.1));color:var(--brand-strong);transform:translateX(2px)}
            .side-nav span{font-size:.82rem;color:inherit}
            .side-note{padding:1rem;border:1px solid var(--line);border-radius:1.2rem;background:rgba(255,255,255,.7)}
            .side-note p{margin:.45rem 0 0;color:var(--muted);line-height:1.65}
            .content{padding:1.5rem 1.6rem 2rem}
            .topbar{display:flex;align-items:start;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:1.35rem}
            .topbar h1{margin:.6rem 0 .45rem;font-size:clamp(2rem,4vw,3.2rem);line-height:.95;letter-spacing:-.05em}
            .topbar p{margin:0;max-width:62ch;color:var(--muted);line-height:1.75}
            .topbar-actions,.inline-actions,.form-actions,.table-actions,.empty-actions{display:flex;align-items:center;gap:.75rem;flex-wrap:wrap}
            .button,.link-button,.ghost-link{display:inline-flex;align-items:center;justify-content:center;gap:.55rem;padding:.92rem 1.2rem;border-radius:999px;border:1px solid transparent;font-weight:700;transition:transform .2s ease,box-shadow .2s ease,background .2s ease;cursor:pointer}
            .button:hover,.link-button:hover,.ghost-link:hover{transform:translateY(-2px)}
            .button-primary{background:linear-gradient(135deg,var(--brand),var(--brand-strong));color:#f4f9fc;box-shadow:0 18px 32px rgba(32,47,91,.22)}
            .button-secondary,.ghost-link,.link-button{background:rgba(255,255,255,.7);border-color:rgba(42,59,73,.12);color:var(--ink)}
            .button-danger{background:rgba(143,59,49,.08);border-color:rgba(143,59,49,.12);color:var(--danger)}
            .stack{display:grid;gap:1rem}
            .panel,.metric,.table-shell,.empty-state,.form-panel,.aside-panel{border:1px solid var(--line);background:var(--panel);backdrop-filter:blur(16px);box-shadow:0 18px 40px rgba(42,59,73,.08)}
            .metric-grid,.cards-grid,.split-grid,.form-grid,.form-shell{display:grid;gap:1rem}
            .metric-grid{grid-template-columns:repeat(4,minmax(0,1fr))}
            .cards-grid{grid-template-columns:repeat(3,minmax(0,1fr))}
            .split-grid{grid-template-columns:1.2fr .8fr}
            .metric{padding:1.2rem;border-radius:1.35rem}
            .metric strong{display:block;margin-top:.65rem;font-size:2rem}
            .metric p,.panel p,.table-caption,.help-copy,.field-help,.empty-state p{margin:.45rem 0 0;color:var(--muted);line-height:1.7}
            .panel,.table-shell,.form-panel,.aside-panel{padding:1.25rem;border-radius:1.45rem}
            .panel h2,.panel h3,.table-shell h2{margin:.75rem 0 .45rem;font-size:1.35rem;letter-spacing:-.03em}
            .panel-header,.table-head{display:flex;align-items:start;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:1rem}
            .panel-list{display:grid;gap:.85rem;padding:0;margin:0;list-style:none}
            .panel-list li{display:flex;align-items:start;justify-content:space-between;gap:1rem;padding:.9rem 0;border-top:1px solid rgba(42,59,73,.08)}
            .panel-list li:first-child{padding-top:0;border-top:0}
            .panel-list small,.muted{color:var(--muted)}
            .table-wrap{overflow:auto}
            table{width:100%;border-collapse:collapse;min-width:760px}
            th,td{padding:1rem .85rem;text-align:left;vertical-align:top;border-top:1px solid rgba(42,59,73,.08)}
            thead th{padding-top:0;border-top:0;font-size:.82rem;letter-spacing:.08em;text-transform:uppercase;color:var(--muted)}
            tbody tr:hover{background:rgba(79,129,145,.04)}
            .thumb{width:4rem;height:4rem;border-radius:1rem;overflow:hidden;border:1px solid rgba(42,59,73,.08);background:linear-gradient(135deg,rgba(79,129,145,.12),rgba(213,196,179,.18))}
            .thumb img{width:100%;height:100%;object-fit:cover}
            .thumb--wide{width:5.5rem}
            .entity{display:grid;gap:.3rem}
            .entity strong{font-size:1rem}
            .entity p{margin:0;color:var(--muted);line-height:1.6}
            .form-shell{grid-template-columns:minmax(0,1fr) 300px}
            .aside-panel{display:grid;align-content:start;gap:1rem}
            .form{display:grid;gap:1rem}
            .form-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
            .form-grid-3{grid-template-columns:repeat(3,minmax(0,1fr))}
            .field{display:grid;gap:.45rem}
            .field span{font-size:.9rem;font-weight:700;color:var(--brand-strong)}
            .field input,.field select,.field textarea{width:100%;padding:.92rem 1rem;border-radius:1rem;border:1px solid rgba(42,59,73,.12);background:rgba(255,255,255,.84);color:var(--ink);outline:none;transition:border-color .2s ease,box-shadow .2s ease}
            .field input:focus,.field select:focus,.field textarea:focus{border-color:rgba(79,129,145,.55);box-shadow:0 0 0 4px rgba(79,129,145,.12)}
            .field textarea{min-height:10rem;resize:vertical}
            .checkboxes{display:flex;gap:1rem;flex-wrap:wrap}
            .check{display:inline-flex;align-items:center;gap:.55rem;padding:.85rem 1rem;border-radius:1rem;border:1px solid rgba(42,59,73,.1);background:rgba(255,255,255,.72)}
            .variant-builder,.variant-list{display:grid;gap:1rem}
            .variant-card{padding:1rem;border:1px solid rgba(42,59,73,.1);border-radius:1.25rem;background:rgba(255,255,255,.68)}
            .variant-card__head{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:1rem}
            .variant-card__title{display:grid;gap:.4rem}
            .variant-card__title strong{font-size:1rem}
            .variant-card__body{display:grid;gap:1rem}
            .variant-card.is-collapsed .variant-card__body{display:none}
            .variant-card.is-collapsed .variant-card__head{margin-bottom:0}
            .variant-toggle{min-width:8.25rem}
            .variant-toggle__icon{width:1.7rem;height:1.7rem;border-radius:999px;background:rgba(79,129,145,.12);display:grid;place-items:center;font-weight:800;line-height:1}
            .variant-swatch-panel{display:grid;gap:.85rem}
            .variant-swatch-preview{width:7rem;height:7rem;border-radius:1rem;overflow:hidden;border:1px solid rgba(42,59,73,.08);background:linear-gradient(135deg,rgba(79,129,145,.12),rgba(213,196,179,.18))}
            .variant-swatch-preview img{width:100%;height:100%;object-fit:cover}
            .variant-images{display:grid;gap:.75rem}
            .variant-image-row{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:.75rem;align-items:end}
            .field-error{font-size:.9rem;color:var(--danger)}
            .alert{padding:1rem 1.05rem;border-radius:1rem}
            .alert-success{background:rgba(47,124,103,.1);border:1px solid rgba(47,124,103,.18);color:var(--ok)}
            .alert-error{background:rgba(143,59,49,.08);border:1px solid rgba(143,59,49,.12);color:var(--danger)}
            .empty-state h2{margin:.65rem 0 0;font-size:1.55rem}
            @media (max-width:1180px){.metric-grid,.cards-grid,.split-grid,.form-shell,.form-grid,.form-grid-3{grid-template-columns:1fr}.admin-shell{grid-template-columns:1fr}.sidebar{position:static;height:auto;border-right:0;border-bottom:1px solid rgba(42,59,73,.08)}}
            @media (max-width:820px){.topbar,.panel-header,.table-head,.panel-list li,.table-actions,.form-actions,.inline-actions{align-items:stretch}.topbar-actions,.inline-actions,.form-actions,.table-actions,.empty-actions{width:100%}.topbar-actions > *, .inline-actions > *, .form-actions > *, .table-actions > *, .empty-actions > *{flex:1 1 100%}.button,.link-button,.ghost-link{width:100%}.variant-card__head{align-items:stretch}.variant-card__head .inline-actions{width:100%}.variant-card__head .inline-actions > *{flex:1 1 calc(50% - .375rem)}}
            @media (max-width:720px){.content{padding:1.15rem 1rem 1.5rem}.topbar h1{font-size:2rem}table{min-width:620px}.sidebar{padding:1.2rem 1rem}.panel,.table-shell,.form-panel,.aside-panel,.metric{padding:1rem}.thumb--wide{width:100%;max-width:6rem}.variant-image-row{grid-template-columns:1fr}.variant-swatch-preview{width:100%;max-width:8rem;height:auto;aspect-ratio:1}}
            @media (max-width:560px){.content{padding:1rem .85rem 1.25rem}.topbar p,.metric p,.panel p,.table-caption,.help-copy,.field-help,.empty-state p{font-size:.95rem;line-height:1.6}.side-nav a{padding:.82rem .9rem}.check{width:100%}.variant-card__head .inline-actions > *{flex:1 1 100%}.variant-toggle{min-width:0}}
        </style>
    </head>
    <body>
        <div class="admin-shell">
            <aside class="sidebar">
                <a href="{{ route('admin.dashboard') }}">
                    <x-brand-logo />
                </a>

                <section class="side-copy">
                    <span class="pill">Panel interno</span>
                    <strong class="brand-font">Catalogo, contenido y consultas en un mismo lugar.</strong>
                    <p>Dejamos una base simple para operar la tienda sin salir de Laravel ni depender de herramientas externas.</p>
                </section>

                <nav class="side-nav">
                    <a href="{{ route('admin.dashboard') }}" @class(['is-active' => request()->routeIs('admin.dashboard')])>Dashboard <span>Resumen</span></a>
                    <a href="{{ route('admin.categories.index') }}" @class(['is-active' => request()->routeIs('admin.categories.*')])>Categorias <span>ABM</span></a>
                    <a href="{{ route('admin.products.index') }}" @class(['is-active' => request()->routeIs('admin.products.*')])>Productos <span>ABM</span></a>
                    <a href="{{ route('admin.branding.edit') }}" @class(['is-active' => request()->routeIs('admin.branding.*')])>Identidad <span>Marca</span></a>
                    <a href="{{ route('admin.quote-requests.index') }}" @class(['is-active' => request()->routeIs('admin.quote-requests.*')])>Presupuestos <span>Inbox</span></a>
                </nav>

                <section class="side-note">
                    <span class="pill">Accesos rapidos</span>
                    <p><a href="{{ route('home') }}">Ver tienda publica</a><br><a href="{{ route('products.index') }}">Abrir catalogo</a></p>
                </section>
            </aside>

            <div class="content">
                <header class="topbar">
                    <div>
                        <span class="eyebrow">@yield('eyebrow', 'Administracion')</span>
                        <h1>@yield('page-title', 'Panel admin')</h1>
                        <p>@yield('page-copy', 'Administra productos, categorias y consultas desde una sola pantalla.')</p>
                    </div>

                    <div class="topbar-actions">
                        <a class="ghost-link" href="{{ route('home') }}">Ir a la tienda</a>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button class="button button-secondary" type="submit">Cerrar sesion</button>
                        </form>
                    </div>
                </header>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                <main class="stack">
                    @yield('content')
                </main>
            </div>
        </div>

        @yield('page_scripts')
    </body>
</html>
