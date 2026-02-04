<?php

namespace App\Http\Controllers;

use App\Models\sacp;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class sacpController extends Controller
{
    /** Tablas permitidas */
    private array $tablas = ['la', 'lc', 'lg', 'le', 'sacp'];

    /** Menú principal */
    public function menu()
    {
        return view('sacp.menu', [
            'tablas' => $this->tablas,
        ]);
    }

    /** Listado + registros + gráficas */
    public function index(Request $request)
    {
        $tabla = $request->get('tabla', 'sacp');
        if (!in_array($tabla, $this->tablas, true)) {
            abort(404);
        }

        $busqueda           = trim((string) $request->get('buscar', ''));
        $estadoSeleccionado = $request->get('estado'); // vigente | proximo | vencido | null
        $UMBRAL_DIAS        = 30;
        $hoy                = Carbon::today();

        // --------- Función para parsear fechas tipo "nov-24" ----------
        $parseFechaMx = function ($s) {
            if ($s === null) return null;
            if ($s instanceof Carbon) return $s;

            $raw = trim((string) $s);
            if ($raw === '') return null;

            $lower = mb_strtolower($raw, 'UTF-8');

            $map = [
                'ene' => '01', 'feb' => '02', 'mar' => '03', 'abr' => '04',
                'may' => '05', 'jun' => '06', 'jul' => '07', 'ago' => '08',
                'sep' => '09', 'oct' => '10', 'nov' => '11', 'dic' => '12',
            ];

            // Formatos "nov-24", "nov 24", "nov/24"
            if (preg_match('/^(ene|feb|mar|abr|may|jun|jul|ago|sep|oct|nov|dic)[\s\-\/]?(\d{2,4})$/u', $lower, $m)) {
                $month = $map[$m[1]];
                $year  = $m[2];

                if (strlen($year) === 2) {
                    $yy   = (int) $year;
                    $year = ($yy <= 30) ? 2000 + $yy : 1900 + $yy;
                }

                try {
                    return Carbon::createFromFormat('Y-m-d', "$year-$month-01");
                } catch (\Exception $e) {
                    return null;
                }
            }

            // Otros formatos habituales
            foreach (['Y-m-d', 'Y/m/d', 'd/m/Y', 'd-m-Y', 'd/m/y', 'd-m-y'] as $fmt) {
                try {
                    return Carbon::createFromFormat($fmt, $raw);
                } catch (\Exception $e) {
                    // seguimos probando
                }
            }

            try {
                return Carbon::parse($raw);
            } catch (\Exception $e) {
                return null;
            }
        };

        // =========================================================
        // 1) PADRES PARA EL LISTADO (registro = 0)
        // =========================================================
        $baseQuery = sacp::from($tabla)->where('registro', 0);

        if ($busqueda !== '') {
            $baseQuery->where(function ($q) use ($busqueda) {
                $q->where('clave_procedimiento', 'like', "%{$busqueda}%")
                  ->orWhere('titulo', 'like', "%{$busqueda}%");
            });
        }

        $padres = $baseQuery->orderBy('clave_procedimiento')->get();

        // Cálculos de fechas/estado para padres
        $padres = $padres->map(function ($fila) use ($parseFechaMx, $UMBRAL_DIAS, $hoy) {
            $emision = $parseFechaMx($fila->fecha_emision);
            $fila->emision_carbon = $emision;

            $nivel = (int) $fila->nivel_riesgo;
            // Padres: nivel 3 -> 4 años, nivel 2 -> 3 años, resto -> 2 años
            $aniosVig = $nivel === 3 ? 4 : ($nivel === 2 ? 3 : 2);

            $caducidad = $emision ? $emision->copy()->addYears($aniosVig) : null;
            $fila->caducidad_carbon = $caducidad;

            $diasRest = $caducidad ? $hoy->diffInDays($caducidad, false) : null;
            $fila->dias_restantes = $diasRest;

            $fila->estado_slug  = null;
            $fila->estado_texto = null;

            if (!is_null($diasRest)) {
                if ($diasRest < 0) {
                    $fila->estado_slug  = 'vencido';
                    $fila->estado_texto = 'Vencido';
                } elseif ($diasRest <= $UMBRAL_DIAS) {
                    $fila->estado_slug  = 'proximo';
                    $fila->estado_texto = 'Próximo a vencer';
                } else {
                    $fila->estado_slug  = 'vigente';
                    $fila->estado_texto = 'Vigente';
                }
            }

            return $fila;
        });

        // =========================================================
        // 2) ESTADÍSTICAS PARA GRÁFICAS (TODOS: PADRES + REGISTROS)
        // =========================================================
        $todos = sacp::from($tabla)->get();

        $totalVencidos = 0;
        $totalProximos = 0;
        $porMes = [];

        $mesesCorto = [1 => 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        foreach ($todos as $fila) {
            $emision = $parseFechaMx($fila->fecha_emision);
            if (!$emision) continue;

            $nivel = (int) $fila->nivel_riesgo;

            // Padres y registros tienen vigencias distintas
            if ((int) $fila->registro === 0) {
                $aniosVig = $nivel === 3 ? 4 : ($nivel === 2 ? 3 : 2);
            } else {
                $aniosVig = $nivel === 3 ? 4 : 2;
            }

            $caducidad = $emision->copy()->addYears($aniosVig);
            $diasRest  = $hoy->diffInDays($caducidad, false);

            $tipo = null;
            if ($diasRest < 0) {
                $tipo = 'vencidos';
                $totalVencidos++;
            } elseif ($diasRest <= $UMBRAL_DIAS) {
                $tipo = 'proximos';
                $totalProximos++;
            } else {
                continue;
            }

            $mesNum   = (int) $caducidad->format('n');
            $anio     = $caducidad->format('y');
            $claveMes = $caducidad->format('Y-m');
            $label    = ($mesesCorto[$mesNum] ?? $caducidad->format('m')) . '-' . $anio;

            if (!isset($porMes[$claveMes])) {
                $porMes[$claveMes] = [
                    'label'    => $label,
                    'vencidos' => 0,
                    'proximos' => 0,
                ];
            }

            $porMes[$claveMes][$tipo]++;
        }

        ksort($porMes);

        $labelsMes    = [];
        $dataVencidos = [];
        $dataProximos = [];

        foreach ($porMes as $m) {
            $labelsMes[]    = $m['label'];
            $dataVencidos[] = $m['vencidos'];
            $dataProximos[] = $m['proximos'];
        }

        $statsGraficas = [
            'totales' => [
                'vencidos' => $totalVencidos,
                'proximos' => $totalProximos,
            ],
            'porMes' => [
                'labels'   => $labelsMes,
                'vencidos' => $dataVencidos,
                'proximos' => $dataProximos,
            ],
        ];

        // ✅ FIX ANTI-PARSEERROR: fallback garantizado (siempre un array válido)
        $statsGraficas = $statsGraficas ?? [
            'totales' => ['vencidos' => 0, 'proximos' => 0],
            'porMes'  => ['labels' => [], 'vencidos' => [], 'proximos' => []],
        ];
// =========================================================
// 2.5) OPCIÓN A: detectar padres que tienen hijos en estado (proximo/vencido)
// =========================================================
$padresConHijosEnEstado = collect();

if (in_array($estadoSeleccionado, ['proximo', 'vencido'], true)) {

    // 1) Sacamos todas las claves de padres (los que están en $padres)
    $clavesPadres = $padres->pluck('clave_procedimiento')->all();

    // 2) Traemos hijos de ESOS padres (registro=1) para analizarlos
    $hijosDeTodosEsosPadres = sacp::from($tabla)
        ->where('registro', 1)
        ->whereIn('clave_padre', $clavesPadres)
        ->get();

    // 3) Marcamos padres que tengan al menos 1 hijo en ese estado
    $padresConHijosEnEstado = $hijosDeTodosEsosPadres
        ->map(function ($h) use ($parseFechaMx, $UMBRAL_DIAS, $hoy) {

            $emision = $parseFechaMx($h->fecha_emision);
            if (!$emision) return null;

            $nivel = (int) $h->nivel_riesgo;
            $aniosVig = ($nivel === 3) ? 4 : 2; // regla para registros

            $caducidad = $emision->copy()->addYears($aniosVig);
            $diasRest  = $hoy->diffInDays($caducidad, false);

            if ($diasRest < 0) {
                $h->estado_slug_calc = 'vencido';
            } elseif ($diasRest <= $UMBRAL_DIAS) {
                $h->estado_slug_calc = 'proximo';
            } else {
                $h->estado_slug_calc = 'vigente';
            }

            return $h;
        })
        ->filter()
        ->filter(fn($h) => $h->estado_slug_calc === $estadoSeleccionado)
        ->pluck('clave_padre')
        ->unique()
        ->values();
}

       // =========================================================
// 3) FILTRO POR ESTADO (PADRES + PADRES CON HIJOS EN ESTADO)
// =========================================================
if (in_array($estadoSeleccionado, ['vigente', 'proximo', 'vencido'], true)) {

    $padres = $padres->filter(function ($p) use ($estadoSeleccionado, $padresConHijosEnEstado) {

        // 1) El padre coincide por sí mismo
        if ($p->estado_slug === $estadoSeleccionado) {
            return true;
        }

        // 2) El padre tiene hijos que coinciden (solo próximo / vencido)
        if (in_array($estadoSeleccionado, ['proximo', 'vencido'], true)) {
            return $padresConHijosEnEstado->contains($p->clave_procedimiento);
        }

        return false;
    })->values();
}

        // =========================================================
        // 4) Paginación manual de padres
        // =========================================================
        $page    = LengthAwarePaginator::resolveCurrentPage() ?: 1;
        $perPage = 10;
        $total   = $padres->count();

        $itemsPagina = $padres->forPage($page, $perPage)->values();

        $datos = new LengthAwarePaginator(
            $itemsPagina,
            $total,
            $perPage,
            $page,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );

        // =========================================================
        // 5) Hijos (registros) solo de los padres de esta página
        // =========================================================
        $clavesPadre = $itemsPagina->pluck('clave_procedimiento')->all();

        $hijos = sacp::from($tabla)
            ->where('registro', 1)
            ->whereIn('clave_padre', $clavesPadre)
            ->orderBy('clave_padre')
            ->orderBy('clave_procedimiento')
            ->get();

        // Cálculos de fechas/estado para hijos
        $hijos = $hijos->map(function ($fila) use ($parseFechaMx, $UMBRAL_DIAS, $hoy) {
            $emision = $parseFechaMx($fila->fecha_emision);
            $fila->emision_carbon = $emision;

            $nivel = (int) $fila->nivel_riesgo;
            // Registros: nivel 3 -> 4 años, si no -> 2 años
            $aniosVig = $nivel === 3 ? 4 : 2;

            $caducidad = $emision ? $emision->copy()->addYears($aniosVig) : null;
            $fila->caducidad_carbon = $caducidad;

            $diasRest = $caducidad ? $hoy->diffInDays($caducidad, false) : null;
            $fila->dias_restantes = $diasRest;

            $fila->estado_slug  = null;
            $fila->estado_texto = null;

            if (!is_null($diasRest)) {
                if ($diasRest < 0) {
                    $fila->estado_slug  = 'vencido';
                    $fila->estado_texto = 'Vencido';
                } elseif ($diasRest <= $UMBRAL_DIAS) {
                    $fila->estado_slug  = 'proximo';
                    $fila->estado_texto = 'Próximo a vencer';
                } else {
                    $fila->estado_slug  = 'vigente';
                    $fila->estado_texto = 'Vigente';
                }
            }

            return $fila;
        });

        $registrosPorPadre = $hijos->groupBy('clave_padre');

        return view('sacp.index', [
            'datos'              => $datos,
            'tabla'              => $tabla,
            'tablas'             => $this->tablas,
            'umbralDias'         => $UMBRAL_DIAS,
            'estadoSeleccionado' => $estadoSeleccionado,
            'busqueda'           => $busqueda,
            'registrosPorPadre'  => $registrosPorPadre,
            'statsGraficas'      => $statsGraficas,
        ]);
    }

    /** EDITAR registro */
    public function edit($tabla, $clave)
    {
        if (!in_array($tabla, $this->tablas, true)) {
            abort(404);
        }

        $registro = sacp::from($tabla)
            ->where('clave_procedimiento', $clave)
            ->firstOrFail();

        // ✅ si es PADRE, cargamos sus registros (hijos)
        $hijos = collect();
        if ((int)$registro->registro === 0) {
            $hijos = sacp::from($tabla)
                ->where('registro', 1)
                ->where('clave_padre', $registro->clave_procedimiento)
                ->orderBy('clave_procedimiento')
                ->get();
        }

        return view('sacp.edit', [
            'registro' => $registro,
            'tabla'    => $tabla,
            'hijos'    => $hijos,
        ]);
    }

    /** ACTUALIZAR */
    public function update(Request $request, $tabla, $clave)
    {
        if (!in_array($tabla, $this->tablas, true)) {
            abort(404);
        }

        $request->validate([
            'fecha_emision' => ['required'],
            'revision'      => ['required', 'integer'],
        ]);

        $fechaFinal = Carbon::parse($request->fecha_emision)->format('Y-m-d');
        $revFinal   = (int)$request->revision;

        // 1) actualiza el procedimiento actual (padre o hijo)
        DB::table($tabla)
            ->where('clave_procedimiento', $clave)
            ->update([
                'fecha_emision' => $fechaFinal,
                'revision'      => $revFinal,
            ]);

        // 2) ✅ si era PADRE, aplicar SOLO a hijos seleccionados
        $esPadre = DB::table($tabla)
            ->where('clave_procedimiento', $clave)
            ->value('registro');

        if ((int)$esPadre === 0) {
            $seleccionados = $request->input('hijos', []); // array de claves

            if (is_array($seleccionados) && count($seleccionados) > 0) {
                DB::table($tabla)
                    ->where('registro', 1)
                    ->where('clave_padre', $clave)
                    ->whereIn('clave_procedimiento', $seleccionados)
                    ->update([
                        'fecha_emision' => $fechaFinal,
                        'revision'      => $revFinal,
                    ]);
            }
        }

        return redirect()
            ->route('sacp.index', ['tabla' => $tabla])
            ->with('status', 'Procedimiento actualizado correctamente.');
    }
}
