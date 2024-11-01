<?php

namespace App\Http\Controllers\grupos; //checar nombre al final de controlador

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grupos;

class GruposController extends Controller

{

    public function guardarGrupo(Request $request)
    {
        $regexPalabra = '/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/';          //valñiudacion solo abecedario//
        $nombregrupo = $request->input('nombreGrupo');
        $profesor = $request->input('profesor');
        if (!preg_match($regexPalabra, $profesor)) {
            return redirect('/')->with('Error','Solo se aceptan letras') -> withInput();
        }
        Grupos::create([
            'nombre_grupo'=>$nombregrupo,
            'materia'=> $request->input('materia'),
            'fecha_clase'=> $request->input('fechaClase'),
            'profesor'=> $profesor,
            'horario_clase'=> $request->input('horarioClase'),
            'horario_clase_final'=> $request->input('horarioClaseFinal'),
            'horario_registro'=> $request->input('horarioRegistro'),
            'qr_code'=>'PRUEBA',
        ]);

        return redirect('/')->with('Exito','Datos Guardados con Exito') -> withInput();
    }

    //alumnos
    /*public function tablaAlumos(Request $request)
    {
        $id = $request->session()->get('id');
        $rol = $request->session()->get('rol');
        $ruta = $request->session()->get('ruta');

        $admin = Usuarios::find($id);
        //$alumnos = Alumnos::get();
        $alumnos = Alumnos::where('id', 'like', '%'.$request->input('search').'%')->paginate(4);
        return view('administradores.alumnos.alumnos', compact('admin','alumnos'));
    }
    //buscar alumno
    public function buscarAlumos(Request $request)
    {
        $id = $request->session()->get('id');
        $rol = $request->session()->get('rol');
        $ruta = $request->session()->get('ruta');
    
        $admin = Usuarios::find($id);
    
        // Obtén la consulta de búsqueda
        $search = $request->input('search');
    
        // Si hay un término de búsqueda, filtrar por él
        if ($search) 
        {
            $alumnos = Alumnos::where('no_cuenta', 'like', '%' . $search . '%')
                ->orWhere('nombre', 'like', '%' . $search . '%')
                ->orWhere('apellido_paterno', 'like', '%' . $search . '%')
                ->paginate(4); // Paginación con 10 alumnos por página
        } 
        else 
        {
            $alumnos = Alumnos::paginate(4); // Paginación con 10 alumnos por página si no hay búsqueda
        }
        if ($request->ajax()) 
        {
            return response()->json($alumnos);
        }
    
        return view('administradores.alumnos.alumnos', compact('admin', 'alumnos'));
    }
    //eliminar alumno
    public function eliminarAlumno(Request $request,$cuenta)
    {
        
        // Buscar el alumno por su ID
        $alumno = Usuarios::where('no_cuenta', $cuenta)->first();

        // Verificar si el alumno existe
        if (!$alumno) {
            return redirect()->back()->with('status', 'El alumno no fue encontrado.')->with('error',false);
        }
        else
        {
            $alumno->delete();

            return redirect()->back()->with('status', 'Alumno eliminado con exito.')->with('error',true);
        }
    }
    //editar alumno
    public function datosAlumno(Request $request, $cuenta)
    {
        $id = $request->session()->get('id');

        $admin = Usuarios::find($id);
        $alumno = Alumnos::where('no_cuenta', $cuenta)->first();
        return view('administradores.alumnos.editarAlumno', compact('admin', 'alumno'));
    }




    
    //administrador
    public function consultaAdmin(Request $request)
    {
        $id = $request->session()->get('id');
        $rol = $request->session()->get('rol');
        $ruta = $request->session()->get('ruta');

        if($rol == 'administrador')
        {
            //$alumnos = Alumno::with('credenciales')->get(); 
            $admin = Usuarios::find($id);
            return view('administradores.indexAdministrador', compact('admin'));
        }
        else if($rol !== 'administrador')
        {
            return redirect($ruta);
        }
        else
        {
            return redirect('index');
        }
    }

    public function editarAdmin(Request $request, $id)
    {
        //campos de entrada
        $nombre = $request->input('nombres');
        $paterno = $request->input('apellidoPaterno');
        $materno = $request->input('apellidoMaterno');
        $telefono = $request->input('telefono'); 
        //mensaje para los errores de los campos de texto 
        $alumnosController = new AlumnosController();
        $mensajeNombre = $alumnosController->validacionesTextos($nombre, "Nombre");
        $mensajePaterno = $alumnosController->validacionesTextos($paterno, "Apellido Paterno");
        $mensajeMaterno = $alumnosController->validacionesTextos($materno, "Apellido Materno");
        $mensajeTelefono = $alumnosController->validarNumero($telefono);

        if(!$mensajeNombre == "")
        {
            return back()->with('status', $mensajeNombre);
        }

        if(!$mensajePaterno == "")
        {
            return back()->with('status', $mensajePaterno);
        }

        if(!$mensajeMaterno == "")
        {
            return back()->with('status', $mensajeMaterno);
        }

        if(!$mensajeTelefono == "")
        {
            return back()->with('status', $mensajeTelefono);
        }

        //Verificamos si el teléfono ya existen para otro usuario
        $usuarioDuplicado = Usuarios::where('telefono', $telefono)
        ->where('id', '!=', $id)
        ->first();

        if ($usuarioDuplicado) 
        {
            $mensaje = '';
            
            if ($usuarioDuplicado->telefono == $telefono) 
            {
                $mensaje .= 'El número de teléfono ' . $telefono . ' ya está registrado.';
            }

            return back()->with('status', $mensaje)
            ->with('error',false)->withInput();
        }
        else
        {
            Usuarios::where('id', $id)->update([
                'nombre' => $nombre,
                'apellido_paterno' => $paterno,
                'apellido_materno' => $materno,
                'telefono' => $telefono,
            ]);

            return redirect('/index-admin')->with('status', 'Datos actualizado exitosamente.')
            ->with('error',true)->withInput();
        }
    }/*/
}
