<?php

namespace App\Http\Controllers;

use App\Models\Asistenciaest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\EstudianteGrupo;
use App\Models\Grupo;
use App\Models\Estudiante;


class AsistenciaestController extends Controller
{
    public function index(Request $request)
    {
        $query = Asistenciaest::query();
        
        if($request->has('estudiante_id') && is_numeric($request->estudiante_id))
        {
            $query->where('estudiante_id', '=', $request->estudiante_id);
        }
        $asistencias_est = $query->with('estudiante', 'grupo')
        ->orderBy('id', 'desc')
        ->simplePaginate(10);
        $asistencias_est = $query->orderBy('id', 'desc')->simplePaginate(10);

        $estudiantes = Estudiante::all();

         return view('asistencias_est.index', compact('asistencias_est','estudiantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estudiantes = Estudiante::all();
        $grupos = Grupo::all();
        return view('asistencias_est.create', compact('estudiantes','grupos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $estudiante = Estudiante::where([
            ['email', '=', $request->email],
            ['pin', '=', $request->pin],
        ])->firstOrFail();
    
        if (!$estudiante) {
            // no se encontro al estudiante
            return abort(404);
        }
    
        $estudianteGrupo = EstudianteGrupo::where('estudiante_id', '=', $estudiante->id)->firstOrFail();
        if (!$estudianteGrupo) {
            // el estudiante no esta registrado en ningun grupo
            return abort(404);
        }
    
        $date = Carbon::now('America/El_Salvador');
    
        $asistencia_est = [
            'estudiante_id' => $estudianteGrupo->estudiante_id,
            'grupo_id' => $estudianteGrupo->grupo_id,
            'fecha' => $date->format('Y-m-d'),
            'hora_entrada' => date('H:i:s', $date->timestamp),
        ];
    
        // Guardar datos de asistencia
        $marcacion = Asistenciaest::create($asistencia_est);
    
        return redirect()->route('asistencias_est.create')->with('success', 'Asistencia registrada correctamente');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Asistencia_est $asistencia_est)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asistencia_est $asistencia_est)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asistencia_est $asistencia_est)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asistencia_est $asistencia_est)
    {
        //
    }
}
