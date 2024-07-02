<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EstudianteController extends Controller
{

    public function index(Request $request)
    {
        $query = Estudiante::query();

        if ($request->has('nombre')) {
            $query->where('nombre','like','%'. $request->nombre . '%');
        }
        if ($request->has('apellido')) {
            $query->where('apellido','like','%'. $request->apellido . '%');
        }
        $estudiantes = $query->orderBy('id','desc')->simplePaginate(10);

        return view('estudiantes.index',compact('estudiantes'));
    }

    public function create()
    {
        return view('estudiantes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:estudiante',
        ]);

        $pin = Str::random(6);
        $estudiante = new Estudiante([
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'email' => $request->get('email'),
            'pin' => $pin
        ]);
        $estudiante->save();

        // Aquí puedes enviar el PIN al email del estudiante

        return redirect()->route('estudiantes.index')->with('pin', $pin);
    }

    public function show($id)
    {
        $estudiante = Estudiante::find($id);

        if(!$estudiante){
            return abort(404);

        }

        return view('estudiantes.show', compact('estudiante'));
    }

    public function edit($id)
    {
        $estudiante = Estudiante::find($id);

        if(!$estudiante){
            return abort(404);

        }

        return view('estudiantes.edit', compact('estudiante'));
    }

    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::find($id);

        
        if(!$estudiante){
            return abort(404);

        }

        $estudiante->nombre = $request->nombre;
        $estudiante->apellido = $request->apellido;
        $estudiante->email = $request->email;

        $estudiante->save();

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado correctamente');
    }

    public function delete($id)
    {
        $estudiante = Estudiante::find($id);

        
        if(!$estudiante){
            return abort(404);

        }
        return view('estudiantes.delete', compact('estudiante'));

    }

 
    public function destroy($id)
    {
        $estudiante = Estudiante::find($id);

        
        if(!$estudiante){
            return abort(404);

        }
        $estudiante->delete();
        return redirect()->route('estudiantes.index')->with('success', 'Estudiante eliminado correctamente');
    }

    public function showLoginForm()
    {
        return view('estudiantes.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'pin' => 'required'
        ]);

        $estudiante = Estudiante::where('email', $request->get('email'))->where('pin', $request->get('pin'))->first();

        if ($estudiante) {
            // Autenticar al estudiante (por ejemplo, usando sesiones)
            session(['estudiante_id' => $estudiante->id]);

            // Generar un nuevo PIN para la próxima vez que el estudiante quiera iniciar sesión
            $estudiante->pin = Str::random(6);
            $estudiante->save();

            return redirect()->route('estudiantes.index')->with('success', 'Login exitoso.');
        } else {
            return redirect('/login')->withErrors('PIN incorrecto o email no registrado.');
        }
    }

    public function logout()
    {
        Auth::guard('estudiante')->logout();
            return redirect()->route('estudiantes.showLoginForm');
    }
}
