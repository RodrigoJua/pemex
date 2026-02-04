<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'SACP') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root{
            --pemex-green:#007a33;
            --pemex-green-dark:#0b4727;
            --pemex-red:#c8102e;
            --bg:#f4f6f8;
            --card:#ffffff;
            --stroke:#e5e7eb;
            --ink:#0f172a;
            --muted:#64748b;
        }
        body{
            background: radial-gradient(900px 480px at 20% 10%, rgba(0,122,51,.16), transparent 60%),
                        radial-gradient(900px 480px at 80% 20%, rgba(200,16,46,.10), transparent 55%),
                        var(--bg) !important;
        }
        .pemex-shell{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:24px 16px;
        }
        .pemex-card{
            width:100%;
            max-width:430px;
            background:var(--card);
            border:1px solid var(--stroke);
            border-radius:18px;
            box-shadow:0 14px 40px rgba(15,23,42,.10);
            overflow:hidden;
        }
        .pemex-head{
            background:linear-gradient(90deg, var(--pemex-green-dark), var(--pemex-green));
            padding:18px 18px 14px;
            color:#fff;
            position:relative;
        }
        .pemex-line{
            position:absolute; left:0; right:0; bottom:0; height:8px;
            background:linear-gradient(90deg, var(--pemex-red), var(--pemex-green));
        }
        .pemex-brand{
            display:flex;
            align-items:center;
            gap:12px;
        }
        .pemex-brand img{
            height:44px;
            width:auto;
            display:block;
        }
        .pemex-title{
            margin:0;
            font-weight:900;
            letter-spacing:.2px;
            font-size:1.15rem;
            line-height:1.1;
        }
        .pemex-sub{
            margin:2px 0 0;
            font-size:.9rem;
            color:#e5e7eb;
            font-weight:600;
        }
        .pemex-body{
            padding:18px;
        }
        .pemex-foot{
            padding:14px 18px 18px;
            color:var(--muted);
            font-size:.85rem;
            text-align:center;
        }
        /* Inputs más “premium” (aplican aunque Breeze use Tailwind) */
        input[type="email"], input[type="password"], input[type="text"]{
            border-radius:12px !important;
        }
        button[type="submit"]{
            border-radius:12px !important;
            font-weight:800 !important;
        }
        a{
            text-decoration:none;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
<div class="pemex-shell">
    <div class="pemex-card">

        <div class="pemex-head">
            <div class="pemex-brand">
                <img src="{{ asset('img/pemex.png') }}" alt="PEMEX" onerror="this.style.display='none'">
                <div>
                    <h1 class="pemex-title">Sistema SACP</h1>
                    <p class="pemex-sub">Acceso de usuarios</p>
                </div>
            </div>
            <div class="pemex-line"></div>
        </div>

        <div class="pemex-body">
            {{ $slot }}
        </div>

        <div class="pemex-foot">
            Superintendencia de Aseguramiento de la Calidad del Producto · {{ now()->format('Y') }}
        </div>

    </div>
</div>
</body>
</html>
