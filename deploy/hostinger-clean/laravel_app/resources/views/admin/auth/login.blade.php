<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Acceso Admin | M&Ouml;BELS Alejandro</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800|montserrat:500,600,700,800&display=swap" rel="stylesheet" />
        <style>
            :root{--ink:#18212b;--muted:#60707d;--panel:rgba(255,255,255,.84);--line:rgba(42,59,73,.14);--brand:#4f8191;--brand-strong:#202f5b;--danger:#8f3b31;--ok:#2f7c67}
            *{box-sizing:border-box} body{margin:0;min-height:100vh;display:grid;place-items:center;padding:1rem;color:var(--ink);font-family:"Manrope",sans-serif;background:radial-gradient(circle at top left,rgba(79,129,145,.22),transparent 30%),radial-gradient(circle at 82% 16%,rgba(32,47,91,.18),transparent 24%),linear-gradient(180deg,#edf2f4 0%,#f7f0e7 100%)}
            a{text-decoration:none;color:inherit} .brand-font,h1,h2,strong{font-family:"Montserrat",sans-serif}
            .auth-shell{width:min(1080px,100%);display:grid;grid-template-columns:minmax(0,.95fr) minmax(360px,.75fr);gap:1rem}
            .brand-card,.form-card{border:1px solid var(--line);background:var(--panel);backdrop-filter:blur(18px);box-shadow:0 18px 40px rgba(42,59,73,.08);border-radius:1.7rem}
            .brand-card{padding:1.5rem;background:linear-gradient(160deg,rgba(32,47,91,.96),rgba(79,129,145,.88));color:#f2f8fb;display:grid;align-content:space-between;gap:2rem}
            .brand-lockup{display:flex;gap:.95rem;align-items:center}
            .brand-lockup__mark{width:3.4rem;height:3.4rem;flex:none}
            .brand-lockup__copy{display:grid;gap:.15rem}
            .brand-lockup__copy strong{font-size:1rem;letter-spacing:.08em}
            .brand-lockup__copy span{color:rgba(242,248,251,.78)}
            .brand-lockup__eyebrow{font-size:.69rem;font-weight:800;letter-spacing:.18em;color:#d7e3e7}
            .eyebrow,.pill{display:inline-flex;align-items:center;gap:.5rem;padding:.5rem .82rem;border-radius:999px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.14);font-size:.82rem}
            .eyebrow::before,.pill::before{content:"";width:.58rem;height:.58rem;border-radius:999px;background:linear-gradient(135deg,#d5c4b3,#f7f1ea)}
            .brand-card h1{margin:1rem 0 .7rem;font-size:clamp(2.2rem,5vw,4.1rem);line-height:.94;letter-spacing:-.05em;max-width:11ch}
            .brand-card p{margin:0;line-height:1.8;color:rgba(242,248,251,.82);max-width:56ch}
            .brand-list{display:grid;gap:.8rem;padding:0;margin:0;list-style:none}
            .brand-list li{padding-left:1.2rem;position:relative;line-height:1.7}
            .brand-list li::before{content:"";position:absolute;left:0;top:.72rem;width:.5rem;height:.5rem;border-radius:999px;background:#d5c4b3}
            .form-card{padding:1.5rem;display:grid;gap:1rem}
            .form-card h2{margin:.5rem 0 0;font-size:2rem;letter-spacing:-.04em}
            .form-card p{margin:0;color:var(--muted);line-height:1.75}
            .form{display:grid;gap:1rem}
            .field{display:grid;gap:.45rem}
            .field span{font-size:.9rem;font-weight:700;color:var(--brand-strong)}
            .field input{width:100%;padding:.95rem 1rem;border-radius:1rem;border:1px solid rgba(42,59,73,.12);background:rgba(255,255,255,.86);color:var(--ink);outline:none;transition:border-color .2s ease,box-shadow .2s ease}
            .field input:focus{border-color:rgba(79,129,145,.55);box-shadow:0 0 0 4px rgba(79,129,145,.12)}
            .remember{display:flex;align-items:center;gap:.55rem;color:var(--muted)}
            .button{display:inline-flex;align-items:center;justify-content:center;padding:1rem 1.2rem;border-radius:999px;border:0;background:linear-gradient(135deg,var(--brand),var(--brand-strong));color:#f4f9fc;font-weight:700;box-shadow:0 18px 30px rgba(32,47,91,.2);cursor:pointer}
            .alert{padding:1rem 1.05rem;border-radius:1rem}
            .alert-success{background:rgba(47,124,103,.1);border:1px solid rgba(47,124,103,.18);color:var(--ok)}
            .alert-error{background:rgba(143,59,49,.08);border:1px solid rgba(143,59,49,.12);color:var(--danger)}
            .field-error{font-size:.9rem;color:var(--danger)}
            .form-meta{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap}
            @media (max-width:980px){.auth-shell{grid-template-columns:1fr}}
        </style>
    </head>
    <body>
        <div class="auth-shell">
            <section class="brand-card">
                <div>
                    <span class="eyebrow">Panel admin</span>
                    <div style="margin-top: 1rem;">
                        <x-brand-logo />
                    </div>
                    <h1>Gestion simple para un ecommerce hecho a medida.</h1>
                    <p>Desde este acceso vas a poder cargar categorias, productos y revisar las consultas que lleguen desde la tienda publica.</p>
                </div>

                <div>
                    <span class="pill">Ya disponible</span>
                    <ul class="brand-list">
                        <li>CRUD web para categorias y productos.</li>
                        <li>Entrada centralizada de presupuestos.</li>
                        <li>Vista admin alineada con la identidad de la marca.</li>
                    </ul>
                </div>
            </section>

            <section class="form-card">
                <span class="eyebrow" style="color: var(--brand-strong); background: rgba(79,129,145,.08); border-color: rgba(79,129,145,.12);">Acceso seguro</span>
                <div>
                    <h2>Iniciar sesion</h2>
                    <p>Usá el usuario administrador local para entrar al panel interno.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">Revisá los datos cargados para continuar.</div>
                @endif

                <form class="form" method="POST" action="{{ route('admin.login.store') }}">
                    @csrf

                    <label class="field">
                        <span>Email</span>
                        <input type="email" name="email" value="{{ old('email', 'alejandro@example.com') }}" required>
                        @error('email')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="field">
                        <span>Contrasena</span>
                        <input type="password" name="password" value="password" required>
                        @error('password')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="remember">
                        <input type="checkbox" name="remember" value="1" @checked(old('remember'))>
                        <span>Mantener sesion iniciada</span>
                    </label>

                    <button class="button" type="submit">Entrar al panel</button>
                </form>

                <div class="form-meta">
                    <small style="color: var(--muted);">Demo local: alejandro@example.com / password</small>
                    <a href="{{ route('home') }}" style="color: var(--brand-strong); font-weight: 700;">Volver a la tienda</a>
                </div>
            </section>
        </div>
    </body>
</html>
