<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menú SACP</title>

    <style>
        :root{
            --pemex-green:#007a33;
            --pemex-green-dark:#0b4727;
            --pemex-red:#c8102e;
            --ink:#1f2937;
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
            background:var(--bg)
        }
        img{display:block; max-width:100%; height:auto}

        .shell{max-width:1100px; margin:28px auto; padding:0 16px}

        .brand{
            background:linear-gradient(90deg, var(--pemex-green-dark), var(--pemex-green));
            color:#fff;
            border-radius:16px;
            padding:16px 18px;
            position:relative;
            box-shadow:0 10px 24px rgba(0,0,0,.08);
            margin-bottom:20px;
        }
        .brand-row{display:flex; align-items:center; gap:14px; flex-wrap:wrap}
        .brand-title{margin:0; font-weight:800; letter-spacing:.2px; font-size:1.35rem}
        .brand-sub{margin:2px 0 0; color:#e5e7eb; font-weight:500}
        .brand-meta{margin-left:auto; color:#d1fae5; font-size:.9rem}
        .brand-line{
            position:absolute; left:0; right:0; bottom:-8px; height:8px;
            background:linear-gradient(90deg, var(--pemex-red), var(--pemex-green));
            border-bottom-left-radius:12px; border-bottom-right-radius:12px;
        }

        .menu-card{
            background:var(--card);
            border-radius:18px;
            border:1px solid var(--stroke);
            padding:22px 22px 26px;
            box-shadow:0 10px 30px rgba(15,23,42,.08);
        }

        .menu-title{
            margin:0 0 12px;
            font-weight:700;
            font-size:1.05rem;
            color:var(--pemex-green-dark);
        }
        .menu-sub{
            margin:0 0 20px;
            font-size:.9rem;
            color:var(--muted);
        }

        .menu-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(140px, 1fr));
            gap:18px;
        }

        .menu-item{
            text-decoration:none;
            color:inherit;
            background:#f9fafb;
            border-radius:18px;
            padding:16px 12px;
            border:1px solid transparent;
            display:flex;
            flex-direction:column;
            align-items:center;
            gap:10px;
            transition:all .18s ease-out;
            position:relative;
            overflow:hidden;
        }
        .menu-item::before{
            content:"";
            position:absolute;
            inset:0;
            opacity:0;
            background:radial-gradient(circle at top, rgba(0,122,51,.18), transparent 65%);
            transition:opacity .2s ease-out;
        }
        .menu-item:hover{
            transform:translateY(-3px);
            box-shadow:0 12px 32px rgba(15,23,42,.16);
            border-color:rgba(0,122,51,.3);
        }
        .menu-item:hover::before{
            opacity:1;
        }

        .menu-icon{
            width:60px; height:60px;
            border-radius:18px;
            background:#000;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:800;
            font-size:1.15rem;
            color:#fff;
            position:relative;
        }
        .menu-icon::after{
            content:"";
            position:absolute;
            inset:-3px;
            border-radius:20px;
            background:linear-gradient(135deg, var(--pemex-green), var(--pemex-red));
            z-index:-1;
        }

        .menu-label{
            font-weight:700;
            font-size:.9rem;
            text-align:center;
        }
        .menu-desc{
            font-size:.8rem;
            text-align:center;
            color:var(--muted);
        }

        .chip{
            position:absolute;
            top:10px;
            right:12px;
            font-size:.65rem;
            background:#ecfdf3;
            color:var(--pemex-green-dark);
            border-radius:999px;
            padding:.12rem .6rem;
            border:1px solid rgba(22,163,74,.4);
            text-transform:uppercase;
            letter-spacing:.06em;
        }
    </style>
</head>
<body>

<div class="shell">
    <div class="brand">
        <div class="brand-row">
            <img src="{{ asset('img/pemex.png') }}" alt="PEMEX" style="height:42px"
                 onerror="this.style.display='none'">
            <div>
                <h1 class="brand-title">Sistema SACP</h1>
                <p class="brand-sub">Menú de laboratorios</p>
            </div>
            <div class="brand-meta">{{ now()->format('d/m/Y') }}</div>
        </div>
        <div class="brand-line"></div>
    </div>

    <div class="menu-card">
        <h2 class="menu-title">Seleccione la tabla</h2>
        <p class="menu-sub">Elija el módulo que desea consultar. Cada opción lo llevará al listado con filtros por estado de vigencia.</p>

        <div class="menu-grid">
            {{-- LA --}}
            <a href="{{ route('sacp.index', ['tabla' => 'la', 'estado' => 'vigente']) }}" class="menu-item">
                <div class="menu-icon">LA</div>
                <div class="menu-label">LA</div>
                <div class="menu-desc">Laboratorio analitico.</div>
            </a>

            {{-- LC --}}
            <a href="{{ route('sacp.index', ['tabla' => 'lc', 'estado' => 'vigente']) }}" class="menu-item">
                <div class="menu-icon">LC</div>
                <div class="menu-label">LC</div>
                <div class="menu-desc">Laboratorio de control.</div>
            </a>

            {{-- LG --}}
            <a href="{{ route('sacp.index', ['tabla' => 'lg', 'estado' => 'vigente']) }}" class="menu-item">
                <div class="menu-icon">LG</div>
                <div class="menu-label">LG</div>
                <div class="menu-desc">Laboratorio de gases.</div>
            </a>

            {{-- LE --}}
            <a href="{{ route('sacp.index', ['tabla' => 'le', 'estado' => 'vigente']) }}" class="menu-item">
                <div class="menu-icon">LE</div>
                <div class="menu-label">LE</div>
                <div class="menu-desc">Laboratorio experimental.</div>
            </a>

            {{-- SACP --}}
            <a href="{{ route('sacp.index', ['tabla' => 'sacp', 'estado' => 'vigente']) }}" class="menu-item">
                <div class="menu-icon">SP</div>
                <div class="menu-label">SACP</div>
                <div class="menu-desc">Superintendencia de Aseguramiento de la Calidad del Producto.</div>
            </a>
        </div>
    </div>
</div>

</body>
</html>
