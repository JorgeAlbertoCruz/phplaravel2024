<?php

namespace App\Http\Controllers;

use App\Models\DocenteGrupo;
use Illuminate\Http\Request;

use App\Models\Docente;
use App\Models\Grupo;

class DocenteGrupoController extends Controller
{
    
    public function index(Request $request)
    {
        $query = DocenteGrupo::query();
        
        if($request->has('docente_id') && is_numeric($request->docente_id))
        {
            $query->where('docente_id', '=', $request->docente_id);
        }
        $docentesGrupos = $query->with('docente', 'grupo')
        ->orderBy('id', 'desc')
        ->simplePaginate(10);
        $docentesGrupos = $query->orderBy('id', 'desc')->simplePaginate(10);

        $docentes = Docente::all();

         return view('docentes_grupos.index', compact('docentesGrupos','docentes'));
    }

    public function create()
    {
        $docentes = Docente::all();
        $grupos = Grupo::all();
        return view('docentes_grupos.create', compact('docentes','grupos'));
    }

    public function store(Request $request)
    {
        $docenteGrupo = DocenteGrupo::create($request->all());

        return redirect()->route('docentes_grupos.index')->with('success','Docente grupo creado correctamente.');
    }

    public function show($id)
    {
        $docenteGrupo = DocenteGrupo::find($id);

        if(!$docenteGrupo)
        {
            return abort(404);
        }

        return view('docentes_grupos.show', compact('docenteGrupo'));
    }

    public function edit($id)
    {
        $docenteGrupo = DocenteGrupo::find($id);

        if(!$docenteGrupo)
        {
            return abort(404);
        }
        $docentes = Docente::all();
        $grupos = Grupo::all();

        return view('docentes_grupos.edit', compact('docenteGrupo', 'docentes','grupos'));
    }

    public function update(Request $request, $id)
    {
        $docenteGrupo = DocenteGrupo::find($id);

        if(!$docenteGrupo)
        {
            return abort(404);
        }

        $docenteGrupo->docente_id = $request->docente_id;
        $docenteGrupo->grupo_id = $request->grupo_id;

        $docenteGrupo->save();

        return redirect()->route('docentes_grupos.index')->with('success','Docente grupoo actualizado correctamente.');

    }

    public function delete($id)
    {
        $docenteGrupo = DocenteGrupo::find($id);

        if(!$docenteGrupo)
        {
            return abort(404);
        }

        return view('docentes_grupos.delete', compact('docenteGrupo'));
    }

    public function destroy($id)
    {
        $docenteGrupo = DocenteGrupo::find($id);

        if(!$docenteGrupo)
        {
            return abort(404);
        }

        $docenteGrupo->delete();

        return redirect()->route('docentes_grupos.index')->with('success', 'Docente grupo eliminado correctamente.');
    }
}
