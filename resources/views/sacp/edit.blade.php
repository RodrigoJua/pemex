<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SACP - Editar</title>

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

        .shell{max-width:920px; margin:28px auto; padding:0 16px}
        .card{
            background:var(--card);
            border:1px solid var(--stroke);
            border-radius:16px;
            box-shadow:0 8px 26px rgba(16,24,40,.06);
            padding:18px
        }

        .brand{
            background:linear-gradient(90deg, var(--pemex-green-dark), var(--pemex-green));
            color:#fff;
            border-radius:16px;
            padding:16px 18px;
            position:relative;
            box-shadow:0 10px 24px rgba(0,0,0,.08);
            margin-bottom:14px;
        }
        .brand-line{
            position:absolute; left:0; right:0; bottom:-8px; height:8px;
            background:linear-gradient(90deg, var(--pemex-red), var(--pemex-green));
            border-bottom-left-radius:12px; border-bottom-right-radius:12px;
        }
        .brand-row{display:flex; align-items:center; gap:14px; flex-wrap:wrap}
        .brand-title{margin:0; font-weight:900; letter-spacing:.2px; font-size:1.25rem}
        .brand-sub{margin:2px 0 0; color:#e5e7eb; font-weight:500; font-size:.95rem}

        .brand-right{
            margin-left:auto;
            display:flex;
            flex-direction:column;
            align-items:flex-end;
            gap:6px;
        }
        .brand-meta{color:#d1fae5; font-size:.9rem}

        .home-btn{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:.35rem .85rem;
            border-radius:999px;
            border:1px solid rgba(255,255,255,.28);
            background:rgba(0,0,0,.12);
            color:#ffffff;
            font-size:.82rem;
            font-weight:800;
            text-decoration:none;
            box-shadow:0 2px 6px rgba(0,0,0,.18);
        }
        .home-btn:hover{
            background:rgba(0,0,0,.22);
            border-color:rgba(255,255,255,.45);
        }

        .tag{
            margin-top:6px;
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:.25rem .6rem;
            background:rgba(255,255,255,.1);
            border-radius:999px;
            font-size:.82rem;
            font-weight:700;
        }

        .grid{
            display:grid;
            grid-template-columns: 1fr 1fr;
            gap:14px;
            margin-top:14px;
        }
        @media (max-width: 720px){
            .grid{grid-template-columns:1fr;}
        }

        .field{
            border:1px solid var(--stroke);
            background:#fff;
            border-radius:14px;
            padding:12px 14px;
        }
        .label{
            display:block;
            font-size:.80rem;
            color:var(--muted);
            font-weight:800;
            text-transform:uppercase;
            letter-spacing:.04em;
            margin-bottom:6px;
        }
        .input{
            width:100%;
            padding:.7rem .8rem;
            border-radius:12px;
            border:1px solid var(--stroke);
            outline:none;
            font-size:.95rem;
        }
        .input:focus{
            border-color:var(--pemex-green);
            box-shadow:0 0 0 4px rgba(0,122,51,.12);
        }

        .readonly{
            padding:.7rem .8rem;
            border-radius:12px;
            border:1px dashed var(--stroke);
            background:#f9fafb;
            font-size:.95rem;
            color:#374151;
        }

        .actions{
            display:flex;
            gap:10px;
            justify-content:flex-end;
            margin-top:16px;
            flex-wrap:wrap;
        }

        .btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            padding:.70rem 1rem;
            border-radius:12px;
            border:1px solid transparent;
            cursor:pointer;
            font-weight:900;
            text-decoration:none;
            font-size:.92rem;
        }
        .btn-primary{
            background:var(--pemex-green);
            color:#fff;
            box-shadow:0 6px 16px rgba(0,122,51,.22);
        }
        .btn-primary:hover{filter:brightness(1.03);}
        .btn-secondary{
            background:#fff;
            color:var(--pemex-green-dark);
            border-color:var(--stroke);
        }
        .btn-secondary:hover{
            background:#e8f7ef;
            border-color:var(--pemex-green);
        }

        .alert{
            border-radius:14px;
            padding:12px 14px;
            margin-top:12px;
            border:1px solid var(--stroke);
            background:#fff;
        }
        .alert.ok{
            border-color: rgba(0,122,51,.25);
            background:#edf9f1;
        }
        .alert.err{
            border-color: rgba(200,16,46,.25);
            background:#fff1f3;
        }
        .alert-title{font-weight:900; margin:0 0 6px;}
        .alert ul{margin:0; padding-left:18px;}
        .muted{color:var(--muted); font-size:.92rem}

        .hijos-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:10px;
        }
        @media (max-width: 720px){
            .hijos-grid{grid-template-columns:1fr;}
        }
        .hijo-item{
            display:flex;
            gap:10px;
            align-items:center;
            padding:10px 12px;
            border:1px solid var(--stroke);
            border-radius:12px;
            background:#fff;
        }
        .hijo-clave{
            font-weight:900;
            color:var(--pemex-green-dark);
            font-size:.95rem;
        }
        .hijo-titulo{
            font-size:.85rem;
            color:var(--muted);
            margin-top:2px;
        }
    </style>
</head>
<body>

<div class="shell">
    <div class="brand">
        <div class="brand-row">
            <img src="{{ asset('img/pemex.png') }}" alt="PEMEX" style="height:42px" onerror="this.style.display='none'">

            <div>
                <h1 class="brand-title">Sistema SACP</h1>
                <p class="brand-sub">Editar emisión y revisión</p>
                <div class="tag">
                    <span>Tabla:</span>
                    <strong>{{ strtoupper($tabla) }}</strong>
                </div>
            </div>

            <div class="brand-right">
                <a class="home-btn" href="{{ route('sacp.index', ['tabla' => $tabla]) }}" title="Volver al listado">
                    <span>⬅️</span><span>Volver</span>
                </a>
                <div class="brand-meta">{{ now()->format('d/m/Y') }}</div>
            </div>
        </div>
        <div class="brand-line"></div>
    </div>

    <div class="card">

        @if (session('status'))
            <div class="alert ok">
                <p class="alert-title">Listo</p>
                <div>{{ session('status') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert err">
                <p class="alert-title">Revisa estos campos</p>
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ FORM COMPLETO ENVOLVIENDO TODO --}}
        <form id="frmUpdate" method="POST"
              action="{{ route('sacp.update', ['tabla' => $tabla, 'clave' => $registro->clave_procedimiento]) }}">
            @csrf
            @method('PUT')

            <div class="grid">
                <div class="field">
                    <span class="label">Clave</span>
                    <div class="readonly">{{ $registro->clave_procedimiento }}</div>
                    <div class="muted" style="margin-top:6px;">Este identificador no se modifica.</div>
                </div>

                <div class="field">
                    <span class="label">Título</span>
                    <div class="readonly">{{ $registro->titulo }}</div>
                </div>

                <div class="field">
                    <label class="label" for="fecha_emision">Fecha de emisión</label>
                    <input
                        class="input"
                        type="date"
                        id="fecha_emision"
                        name="fecha_emision"
                        value="{{ old('fecha_emision', $registro->fecha_emision ? \Carbon\Carbon::parse($registro->fecha_emision)->format('Y-m-d') : '') }}"
                        required
                    >
                </div>

                <div class="field">
                    <label class="label" for="revision">Revisión</label>
                    <input
                        class="input"
                        type="number"
                        id="revision"
                        name="revision"
                        min="0"
                        step="1"
                        value="{{ old('revision', $registro->revision) }}"
                        required
                    >
                    <div class="muted" style="margin-top:6px;">Usa número entero (ej. 0, 1, 2...).</div>
                </div>

                {{-- ✅ NUEVO: SOLO SI ES PADRE, MOSTRAR CHECKBOXES --}}
                @if(isset($hijos) && $hijos->count() > 0)
                    <div class="field" style="grid-column:1/-1;">
                        <span class="label">Aplicar cambios a registros (opcional)</span>

                        <div class="muted" style="margin-bottom:10px;">
                            Selecciona a cuáles registros se les copiará la misma <b>fecha de emisión</b> y <b>revisión</b>.
                        </div>

                        <label style="display:flex; gap:10px; align-items:center; margin-bottom:10px; font-weight:800;">
                            <input type="checkbox" id="chkTodos">
                            Aplicar a todos los registros
                        </label>

                        <div class="hijos-grid">
                            @foreach($hijos as $h)
                                <label class="hijo-item">
                                    <input type="checkbox" class="chkHijo" name="hijos[]" value="{{ $h->clave_procedimiento }}">
                                    <div>
                                        <div class="hijo-clave">{{ $h->clave_procedimiento }}</div>
                                        <div class="hijo-titulo">{{ $h->titulo }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const chkTodos = document.getElementById('chkTodos');
                            const hijos = document.querySelectorAll('.chkHijo');
                            if (!chkTodos) return;

                            chkTodos.addEventListener('change', () => {
                                hijos.forEach(c => c.checked = chkTodos.checked);
                            });
                        });
                    </script>
                @endif
            </div>

            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('sacp.index', ['tabla' => $tabla]) }}">
                    Cancelar
                </a>
                <button class="btn btn-primary" type="submit">
                    💾 Guardar cambios
                </button>
            </div>
        </form>

    </div>
</div>

</body>
</html>
