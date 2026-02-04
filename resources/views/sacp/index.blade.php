<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SACP - Listado</title>

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
            --amber:#f59e0b;
        }
        *{box-sizing:border-box}
        body{
            margin:0;
            font-family:system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
            color:var(--ink);
            background:var(--bg)
        }
        img{display:block; max-width:100%; height:auto}

        .shell{max-width:1200px; margin:28px auto; padding:0 16px}
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
        .brand-title{margin:0; font-weight:800; letter-spacing:.2px; font-size:1.35rem}
        .brand-sub{margin:2px 0 0; color:#e5e7eb; font-weight:500}

        .brand-right{
            margin-left:auto;
            display:flex;
            flex-direction:column;
            align-items:flex-end;
            gap:6px;
        }
        .brand-meta{
            color:#d1fae5;
            font-size:.9rem
        }
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
            font-weight:700;
            text-decoration:none;
            box-shadow:0 2px 6px rgba(0,0,0,.18);
            cursor:pointer;
        }
        .home-btn:hover{
            background:rgba(0,0,0,.22);
            border-color:rgba(255,255,255,.45);
        }

        .brand-tag{
            margin-top:6px;
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:.2rem .55rem;
            background:rgba(255,255,255,.1);
            border-radius:999px;
            font-size:.8rem;
        }

        .search{margin:10px 0 12px}
        .search input{
            width:100%; padding:.9rem 1rem; border-radius:12px; border:1px solid var(--stroke);
            outline:none; transition:border-color .2s, box-shadow .2s; background:#fff
        }
        .search input:focus{
            border-color:var(--pemex-green);
            box-shadow:0 0 0 4px rgba(0,122,51,.12)
        }

        .legend{display:flex; gap:8px; flex-wrap:wrap; margin-bottom:10px}
        .pill{
            border-radius:999px; padding:.42rem .9rem;
            font-weight:600; font-size:.85rem; border:1px solid transparent;
            cursor:pointer; user-select:none;
            background:#fff;
        }
        .pill.ok   {background:#e8f7ef;  color:var(--pemex-green); border-color:var(--pemex-green)}
        .pill.warn {background:#fff7e6;  color:#8a5a07;         border-color:var(--amber)}
        .pill.dang {background:#fde8ea;  color:var(--pemex-red); border-color:var(--pemex-red)}
        .pill.active{ box-shadow:0 0 0 3px rgba(0,0,0,.08); }

        .btn-graficas{
            margin-left:auto;
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:.55rem 1.1rem;
            border-radius:999px;
            border:none;
            cursor:pointer;
            font-size:.85rem;
            font-weight:700;
            background:var(--pemex-green);
            color:#fff;
            box-shadow:0 4px 10px rgba(0,122,51,.25);
        }
        .btn-graficas:hover{ filter:brightness(1.03); }

        .table-wrap{overflow:auto; border:1px solid var(--stroke); border-radius:12px}
        table{
            width:100%;
            border-collapse:separate;
            border-spacing:0;
            min-width:1100px;
        }

        thead th{
            background:var(--pemex-green-dark);
            color:#fff;
            padding:.9rem .9rem;
            text-transform:uppercase;
            font-size:.80rem;
            font-weight:800;
            letter-spacing:.04em;
            text-align:center;
            white-space:nowrap;
        }
        thead th:first-child{ border-top-left-radius:12px; }
        thead th:last-child{ border-top-right-radius:12px; }

        tbody td{
            padding:.8rem .9rem;
            border-top:1px solid var(--stroke);
            vertical-align:middle;
            text-align:center;
            white-space:nowrap;
        }
        tbody td:nth-child(3){
            text-align:left;
            white-space:normal;
        }
        tbody tr:nth-child(even){background:#fbfcfd}
        tbody tr:hover{background:#f7faf9}

        .status{
            background:#fafafa;
            border-left:6px solid #cbd5e1;
            border-radius:10px;
            padding:.55rem .7rem;
            line-height:1.2
        }
        .status.ok{ background:#edf9f1; border-left-color:var(--pemex-green) }
        .status.warn{ background:#fff8eb; border-left-color:var(--amber) }
        .status.dang{ background:#fff1f3; border-left-color:var(--pemex-red) }
        .status .t{font-weight:800; margin-bottom:3px}
        .status .m{font-size:.86rem; color:#556274}
        .days{
            display:inline-block;
            background:#0f172a;
            color:#fff;
            border-radius:6px;
            padding:.2rem .45rem;
            font-weight:800;
            font-size:.78rem;
            margin-top:4px
        }

        a.pdf{color:var(--pemex-green); font-weight:700; text-decoration:none}
        a.pdf:hover{text-decoration:underline}

        .edit-btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            width:34px;
            height:34px;
            border-radius:10px;
            border:1px solid var(--stroke);
            background:#fff;
            text-decoration:none;
            box-shadow:0 2px 6px rgba(16,24,40,.06);
            font-size:1rem;
        }
        .edit-btn:hover{
            background:#e8f7ef;
            border-color:var(--pemex-green);
        }

        .pagination-wrapper{
            display:flex;
            justify-content:center;
            margin-top:18px;
        }
        .pagination-wrapper nav{
            display:flex;
            justify-content:center;
            width:100%;
        }
        .pagination-wrapper nav > div{
            display:flex;
            justify-content:center;
            width:100%;
        }
        .pagination-wrapper ul{
            display:flex;
            gap:6px;
            list-style:none;
            padding:0;
            margin:0;
        }
        .pagination-wrapper a,
        .pagination-wrapper span{
            display:inline-block;
            min-width:34px;
            text-align:center;
            padding:.45rem .75rem;
            border:1px solid var(--stroke);
            border-radius:8px;
            text-decoration:none;
            color:var(--pemex-green-dark);
            background:#fff;
            font-weight:700;
            font-size:.85rem;
        }
        .pagination-wrapper a:hover{
            background:#e8f7ef;
            border-color:var(--pemex-green);
        }
        .pagination-wrapper span[aria-current="page"],
        .pagination-wrapper .active > span{
            background:var(--pemex-green);
            color:#fff;
            border-color:var(--pemex-green);
        }

        .toggle-row{
            border:none;
            background:transparent;
            cursor:pointer;
            margin-right:6px;
            font-size:0.95rem;
            line-height:1;
        }
        .toggle-row[disabled]{ opacity:0; cursor:default; }

        .is-hidden{ display:none !important; }
        .toggle-row.is-open{ transform: rotate(180deg); }

        .row-registro td:nth-child(2){
            padding-left:2.5rem;
        }
        .badge-registro{
            display:inline-block;
            font-size:.72rem;
            background:#e5e7eb;
            color:#374151;
            border-radius:999px;
            padding:.15rem .5rem;
            margin-right:.25rem;
        }

        #panelGraficas{
            margin:10px 0 16px;
            padding:16px 18px;
            background:#f9fafb;
            border-radius:16px;
            border:1px dashed var(--stroke);
        }
        .kpi-row{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
            margin-bottom:12px;
        }
        .kpi-card{
            flex:1 1 220px;
            background:#fff;
            border-radius:14px;
            border:1px solid var(--stroke);
            padding:10px 14px;
        }
        .kpi-title{
            font-size:.80rem;
            color:var(--muted);
            text-transform:uppercase;
            letter-spacing:.04em;
            margin-bottom:4px;
            font-weight:700;
        }
        .kpi-value{
            font-size:1.5rem;
            font-weight:900;
        }
        .chart-block{
            background:#fff;
            border-radius:14px;
            border:1px solid var(--stroke);
            padding:14px 16px;
            margin-top:10px;
        }
        .chart-title{
            font-size:.9rem;
            font-weight:800;
            margin:0 0 6px;
        }
    </style>
</head>
<body>

@php
    $isEditor = auth()->check() && (auth()->user()->role ?? null) === 'editor';
@endphp

<div class="shell">
    <div class="brand">
        <div class="brand-row">
            <img src="{{ asset('img/pemex.png') }}" alt="PEMEX" style="height:42px"
                 onerror="this.style.display='none'">

            <div>
                <h1 class="brand-title">Sistema SACP</h1>
                <p class="brand-sub">Superintendencia de Aseguramiento de la Calidad del Producto</p>
                <div class="brand-tag">
                    <span>Tabla actual:</span>
                    <strong>{{ strtoupper($tabla) }}</strong>
                </div>
            </div>

            {{-- ✅ AQUÍ va el logout (y ya está correcto) --}}
            <div class="brand-right">
                <div style="display:flex; gap:8px; align-items:center;">

                    <a href="{{ route('sacp.menu') }}" class="home-btn" title="Volver al menú principal">
                        🏠 Inicio
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="home-btn" title="Cerrar sesión">
                            🚪 Salir
                        </button>
                    </form>
                </div>

                <div class="brand-meta">
                    {{ auth()->check() ? auth()->user()->name : 'Invitado' }} · {{ now()->format('d/m/Y') }}
                </div>
            </div>
        </div>

        <div class="brand-line"></div>
    </div>

    <div class="card">

        <form method="GET" action="{{ route('sacp.index') }}">
            <input type="hidden" name="tabla" value="{{ $tabla }}">

            <div class="search">
                <input
                    id="buscador"
                    type="text"
                    name="buscar"
                    value="{{ $busqueda ?? '' }}"
                    placeholder="Buscar por cualquier campo…">
            </div>

            <div class="legend">
                <button type="submit" name="estado" value="vigente"
                        class="pill ok {{ $estadoSeleccionado === 'vigente' ? 'active' : '' }}">
                    Vigente
                </button>

                <button type="submit" name="estado" value="proximo"
                        class="pill warn {{ $estadoSeleccionado === 'proximo' ? 'active' : '' }}">
                    Próximo a vencer (≤ {{ $umbralDias }} días)
                </button>

                <button type="submit" name="estado" value="vencido"
                        class="pill dang {{ $estadoSeleccionado === 'vencido' ? 'active' : '' }}">
                    Vencido
                </button>

                <button type="button" id="btnVerGraficas" class="btn-graficas">
                    📊 Ver gráficas
                </button>
            </div>
        </form>

        <div id="panelGraficas" style="display:none;">
            <div class="kpi-row">
                <div class="kpi-card">
                    <div class="kpi-title">Faltantes (vencidos)</div>
                    <div class="kpi-value" id="lblTotalVencidos">0</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-title">Próximos a vencer (≤ {{ $umbralDias }} días)</div>
                    <div class="kpi-value" id="lblTotalProximos">0</div>
                </div>
            </div>

            <div class="chart-block">
                <p class="chart-title">Vencidos por mes de caducidad</p>
                <canvas id="chartVencidos" height="110"></canvas>
            </div>

            <div class="chart-block">
                <p class="chart-title">Próximos a vencer por mes de caducidad</p>
                <canvas id="chartProximos" height="110"></canvas>
            </div>
        </div>

        <div id="seccionTabla">
            <div class="table-wrap">
                <table id="tablaRegistros">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>CLAVE</th>
                        <th>TÍTULO</th>
                        <th>EMISIÓN</th>
                        <th>ESTADO</th>
                        <th>REVISIÓN</th>
                        <th>NIVEL</th>
                        @if($isEditor)
                            <th>EDITAR</th>
                        @endif
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($datos as $i => $fila)
                        @php
                            $num = ($datos->currentPage() - 1) * $datos->perPage() + ($i + 1);

                            $key         = md5($fila->clave_procedimiento);
                            $children    = $registrosPorPadre[$fila->clave_procedimiento] ?? collect();
                            $hasChildren = $children->isNotEmpty();

                            $estadoSlug  = $fila->estado_slug;
                            $estadoTexto = $fila->estado_texto;
                            $emision     = $fila->emision_carbon;
                            $caducidad   = $fila->caducidad_carbon;
                            $diasRest    = $fila->dias_restantes;

                            $cls = 'status';
                            if     ($estadoSlug === 'vigente') $cls .= ' ok';
                            elseif ($estadoSlug === 'proximo') $cls .= ' warn';
                            elseif ($estadoSlug === 'vencido') $cls .= ' dang';
                        @endphp

                        <tr class="row-padre">
                            <td style="font-weight:900;">{{ $num }}</td>

                            <td>
                                @if($hasChildren)
                                    <button type="button" class="toggle-row" data-key="{{ $key }}">▾</button>
                                @else
                                    <button type="button" class="toggle-row" disabled>▾</button>
                                @endif

                                <a class="pdf"
                                   href="{{ asset('pemex/' . $fila->clave_procedimiento . '.pdf') }}"
                                   target="_blank">
                                    {{ $fila->clave_procedimiento }}
                                </a>
                            </td>

                            <td>{{ $fila->titulo }}</td>

                            <td>
                                @if($emision)
                                    {{ $emision->format('Y-m-d') }}
                                @else
                                    —
                                @endif
                            </td>

                            <td>
                                @if($estadoTexto)
                                    <div class="{{ $cls }}">
                                        <div class="t">{{ $estadoTexto }}</div>
                                        <div class="m">
                                            @if($emision)
                                                Emisión: {{ $emision->format('Y-m-d') }}
                                            @endif
                                            @if($caducidad)
                                                &nbsp;•&nbsp; Caduca: {{ $caducidad->format('Y-m-d') }}
                                            @endif
                                        </div>
                                        @if(!is_null($diasRest))
                                            <span class="days">
                                                {{ $diasRest < 0 ? '-' : '' }}{{ abs($diasRest) }} d
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    —
                                @endif
                            </td>

                            <td>{{ $fila->revision }}</td>
                            <td>{{ $fila->nivel_riesgo }}</td>

                            @if($isEditor)
                                <td>
                                    <a class="edit-btn"
                                       href="{{ route('sacp.edit', ['tabla' => $tabla, 'clave' => $fila->clave_procedimiento]) }}"
                                       title="Editar emisión y revisión">✏️</a>
                                </td>
                            @endif
                        </tr>

                        @foreach($children as $reg)
                            @php
                                $estadoSlugH  = $reg->estado_slug;
                                $estadoTextoH = $reg->estado_texto;
                                $emisionH     = $reg->emision_carbon;
                                $caducidadH   = $reg->caducidad_carbon;
                                $diasRestH    = $reg->dias_restantes;

                                $clsH = 'status';
                                if     ($estadoSlugH === 'vigente') $clsH .= ' ok';
                                elseif ($estadoSlugH === 'proximo') $clsH .= ' warn';
                                elseif ($estadoSlugH === 'vencido') $clsH .= ' dang';
                            @endphp

                            <tr class="row-registro registro-{{ $key }} is-hidden">
                                <td></td>

                                <td>
                                    <span class="badge-registro">Registro</span>
                                    <a class="pdf"
                                       href="{{ asset('pemex/' . $reg->clave_procedimiento . '.pdf') }}"
                                       target="_blank">
                                        {{ $reg->clave_procedimiento }}
                                    </a>
                                </td>

                                <td>{{ $reg->titulo }}</td>

                                <td>
                                    @if($emisionH)
                                        {{ $emisionH->format('Y-m-d') }}
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>
                                    @if($estadoTextoH)
                                        <div class="{{ $clsH }}">
                                            <div class="t">{{ $estadoTextoH }}</div>
                                            <div class="m">
                                                @if($emisionH)
                                                    Emisión: {{ $emisionH->format('Y-m-d') }}
                                                @endif
                                                @if($caducidadH)
                                                    &nbsp;•&nbsp; Caduca: {{ $caducidadH->format('Y-m-d') }}
                                                @endif
                                            </div>
                                            @if(!is_null($diasRestH))
                                                <span class="days">
                                                    {{ $diasRestH < 0 ? '-' : '' }}{{ abs($diasRestH) }} d
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>{{ $reg->revision }}</td>
                                <td>{{ $reg->nivel_riesgo }}</td>

                                @if($isEditor)
                                    <td>
                                        <a class="edit-btn"
                                           href="{{ route('sacp.edit', ['tabla' => $tabla, 'clave' => $reg->clave_procedimiento]) }}"
                                           title="Editar emisión y revisión">✏️</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                    @empty
                        <tr>
                            <td colspan="{{ $isEditor ? 8 : 7 }}" style="text-align:center; padding:18px; color:#6b7280">
                                No hay datos que mostrar
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $datos->appends([
                    'tabla'  => $tabla,
                    'buscar' => $busqueda,
                    'estado' => $estadoSeleccionado,
                ])->links() }}
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    // ================== PLEGAR / DESPLEGAR REGISTROS ==================
    document.querySelectorAll('.toggle-row').forEach(btn => {
        const key = btn.dataset.key;
        if (!key) return;

        btn.addEventListener('click', () => {
            const rows = document.querySelectorAll('.registro-' + key);
            if (!rows.length) return;

            const isOpen = btn.classList.contains('is-open');

            rows.forEach(tr => {
                tr.classList.toggle('is-hidden', isOpen);
            });

            btn.classList.toggle('is-open', !isOpen);
            btn.textContent = isOpen ? '▾' : '▴';
        });
    });

    // ================== GRÁFICAS ==================
    const btnGraficas   = document.getElementById('btnVerGraficas');
    const panelGraficas = document.getElementById('panelGraficas');
    const seccionTabla  = document.getElementById('seccionTabla');
    const lblVencidos   = document.getElementById('lblTotalVencidos');
    const lblProximos   = document.getElementById('lblTotalProximos');

    if (!btnGraficas || !panelGraficas) return;

    // ✅ Blindado: si viene null/undefined, usa defaults
    const statsRaw = @json($statsGraficas ?? null);
    const stats = (statsRaw && typeof statsRaw === 'object')
        ? statsRaw
        : {
            totales: { vencidos: 0, proximos: 0 },
            porMes: { labels: [], vencidos: [], proximos: [] }
        };

    let graficasCargadas = false;

    btnGraficas.addEventListener('click', () => {
        const oculto = (panelGraficas.style.display === 'none' || panelGraficas.style.display === '');

        if (oculto) {
            panelGraficas.style.display = 'block';
            if (seccionTabla) seccionTabla.style.display = 'none';
            btnGraficas.textContent = 'Ver tabla';
        } else {
            panelGraficas.style.display = 'none';
            if (seccionTabla) seccionTabla.style.display = '';
            btnGraficas.textContent = '📊 Ver gráficas';
            return;
        }

        if (lblVencidos) lblVencidos.textContent = (stats.totales?.vencidos ?? 0);
        if (lblProximos) lblProximos.textContent = (stats.totales?.proximos ?? 0);

        if (!graficasCargadas && window.Chart) {
            const ctxV = document.getElementById('chartVencidos')?.getContext('2d');
            const ctxP = document.getElementById('chartProximos')?.getContext('2d');
            if (!ctxV || !ctxP) return;

            new Chart(ctxV, {
                type: 'bar',
                data: {
                    labels: stats.porMes.labels,
                    datasets: [{
                        label: 'Vencidos',
                        data: stats.porMes.vencidos,
                        backgroundColor: '#dc2626',
                    }]
                },
                options: {
                    responsive: true,
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }
            });

            new Chart(ctxP, {
                type: 'bar',
                data: {
                    labels: stats.porMes.labels,
                    datasets: [{
                        label: 'Próximos a vencer',
                        data: stats.porMes.proximos,
                        backgroundColor: '#f59e0b',
                    }]
                },
                options: {
                    responsive: true,
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }
            });

            graficasCargadas = true;
        }
    });

});
</script>

</body>
</html>
