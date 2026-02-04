<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SACP - Iniciar sesión</title>

    <style>
        :root{
            --pemex-green:#007a33;
            --pemex-green-dark:#0b4727;
            --pemex-red:#c8102e;
            --ink:#0f172a;
            --muted:#64748b;
            --bg:#f4f6f8;
            --card:#ffffff;
            --stroke:#e5e7eb;
        }
        *{box-sizing:border-box}
        body{
            margin:0;
            font-family:system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
            color:var(--ink);
            background:
              radial-gradient(900px 420px at 15% 10%, rgba(0,122,51,.15), transparent 60%),
              radial-gradient(800px 360px at 85% 15%, rgba(200,16,46,.12), transparent 55%),
              var(--bg);
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:24px 16px;
        }
        .card{
            width:min(420px, 100%);
            background:var(--card);
            border:1px solid var(--stroke);
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 18px 50px rgba(16,24,40,.12);
        }
        .brand{
            background:linear-gradient(90deg, var(--pemex-green-dark), var(--pemex-green));
            color:#fff;
            padding:16px 18px;
            position:relative;
        }
        .brand::after{
            content:"";
            position:absolute; left:0; right:0; bottom:-7px; height:7px;
            background:linear-gradient(90deg, var(--pemex-red), var(--pemex-green));
        }
        .brand-row{display:flex; gap:12px; align-items:center;}
        .logo{
            width:44px; height:44px;
            border-radius:12px;
            background:rgba(255,255,255,.1);
            display:flex; align-items:center; justify-content:center;
            overflow:hidden;
        }
        .logo img{max-height:28px; display:block;}
        .brand h1{margin:0; font-size:1.05rem; font-weight:900; letter-spacing:.2px;}
        .brand p{margin:2px 0 0; color:#e5e7eb; font-size:.88rem; font-weight:600;}

        .content{padding:18px;}
        .title{margin:0; font-size:1.05rem; font-weight:900;}
        .subtitle{margin:6px 0 0; color:var(--muted); font-size:.92rem; line-height:1.35;}

        .alert{
            margin:14px 0 0;
            padding:12px 14px;
            border-radius:14px;
            border:1px solid var(--stroke);
            background:#fff;
        }
        .alert.ok{border-color: rgba(0,122,51,.25); background:#edf9f1;}
        .alert.err{border-color: rgba(200,16,46,.25); background:#fff1f3;}
        .alert .t{font-weight:900; margin:0 0 6px;}
        .alert ul{margin:0; padding-left:18px;}

        .field{margin-top:14px;}
        label{
            display:block;
            font-size:.80rem;
            color:var(--muted);
            font-weight:900;
            text-transform:uppercase;
            letter-spacing:.04em;
            margin-bottom:6px;
        }
        input[type="email"], input[type="password"]{
            width:100%;
            padding:.78rem .9rem;
            border-radius:12px;
            border:1px solid var(--stroke);
            outline:none;
            font-size:.95rem;
            background:#fff;
        }
        input:focus{
            border-color:var(--pemex-green);
            box-shadow:0 0 0 4px rgba(0,122,51,.12);
        }
        .row{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            margin-top:12px;
            flex-wrap:wrap;
        }
        .remember{
            display:flex; align-items:center; gap:10px;
            color:#334155; font-size:.92rem;
        }
        .remember input{width:16px; height:16px;}
        .link{
            color:#0b4727;
            font-weight:800;
            font-size:.9rem;
            text-decoration:none;
        }
        .link:hover{text-decoration:underline;}

        .btn{
            width:100%;
            margin-top:14px;
            border:none;
            cursor:pointer;
            padding:.85rem 1rem;
            border-radius:14px;
            background:var(--pemex-green);
            color:#fff;
            font-weight:900;
            font-size:.95rem;
            box-shadow:0 10px 22px rgba(0,122,51,.22);
        }
        .btn:hover{filter:brightness(1.03);}
        .tiny{
            margin-top:10px;
            color:#64748b;
            font-size:.85rem;
            text-align:center;
        }
        .footer{
            margin-top:14px;
            text-align:center;
            color:#94a3b8;
            font-size:.82rem;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="brand">
        <div class="brand-row">
            <div class="logo">
                <img src="{{ asset('img/pemex.png') }}" alt="PEMEX" onerror="this.style.display='none'">
            </div>
            <div>
                <h1>Sistema SACP</h1>
                <p>Acceso de usuarios</p>
            </div>
        </div>
    </div>

    <div class="content">
        <p class="title">Iniciar sesión</p>
        <p class="subtitle">Ingresa con tu correo y contraseña para acceder a la aplicación.</p>

        @if (session('status'))
            <div class="alert ok">
                <p class="t">Listo</p>
                <div>{{ session('status') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert err">
                <p class="t">Revisa tus datos</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field">
                <label for="email">Correo</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus autocomplete="username"
                       placeholder="usuario@pemex.com (ejemplo)">
            </div>

            <div class="field">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password"
                       required autocomplete="current-password"
                       placeholder="••••••••">
            </div>

            <div class="row">
                <label class="remember" for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember">
                    Mantener sesión
                </label>

                @if (Route::has('password.request'))
                    <a class="link" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <button class="btn" type="submit">🔐 Entrar al sistema</button>

            <div class="tiny">Si no tienes usuario, pídeselo al administrador del sistema.</div>
            <div class="footer">Superintendencia de Aseguramiento de la Calidad del Producto · {{ now()->format('Y') }}</div>
        </form>
    </div>
</div>

</body>
</html>
