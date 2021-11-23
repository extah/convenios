<?php

namespace App\Http\Controllers\empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use PDFVillca;
use Barryvdh\DomPDF\Facade as PDF;

use DB;
// use Codedge\Fpdf\Fpdf;
use Fpdf;
// 'Fpdf' => Codedge\Fpdf\Facades\Fpdf::class,
// use setasign\Fpdi\Fpdi;
use setasign\Fpdi\Fpdi;

class EmpleadoController extends Controller
{
    //
    // private $fpdf;

    public function home(Request $request)
    {

        $inicio = "";
        $usuario = $request->email_inicio;
        $contrasena = $request->password_inicio;
        $no_hay_datos = false;
        $status_info = true;

        $login =  DB::select("SELECT * FROM users where email = '" . $usuario . "'" );
        // dd($login);

        if(count($login) == 0)
		{
            
			$message = "usuario/contraseña ";
			$status_error = true;
            $status_ok = false;
            $esEmp = false;
			
			// return view('inicio.inicio', compact('inicio', 'message', 'status_error', 'esEmp'));
            return redirect('inicio')->with(['status_error' => $status_error, 'message' => $message,]);
		}
        else{
            
            $contrasenasql = $login[0]->contrasena;
            if(password_verify($contrasena, $contrasenasql))
            {
                $message = "Bienvenido/a ";
                $status_ok = true;
                $esEmp = true;

                // $request->session()->flush();
                // dd($login[0]->cuit);
                session(['usuario'=>$login[0]->cuit, 'nombre'=>$login[0]->nombreyApellido]);
                $nombre = $login[0]->nombreyApellido;
                $cuit = $login[0]->cuit;
                // $datos =  DB::select("SELECT DISTINCT apellido, tipo, nombre, cuil, mes, mes_nom, anio FROM recibos_originales where cuil = " . $usuario . " OR numero_documento = '" . $usuario . "'" . " ORDER BY anio, mes ASC");
                // $datos =  DB::select("SELECT DISTINCT apellido, tipo, nombre, cuil, mes, mes_nom, anio FROM recibos_originales where cuil = '" . $cuit . "'". " ORDER BY anio, mes ASC");
                
                // if(count( $datos) == 0)
                // {
                //     $no_hay_datos = true;
                // }
                return view('empleado.empleado', compact('inicio', 'esEmp', 'nombre', 'status_ok', 'message', ));
                
            }
            else
            {
                $message = "usuario/contraseña ";
                $status_error = true;
                $status_ok = false;
                $esEmp = false;
                
                // return view('inicio.inicio', compact('inicio', 'message', 'status_error', 'esEmp'));
                return redirect('inicio')->with(['status_error' => $status_error, 'message' => $message,]);
                
            }
        }
    }

    public function indexget(Request $request)
    {
        
        $usuario = $request->session()->get('usuario');
        $nombre = $request->session()->get('nombre');
        $result = $this->isUsuario($usuario);

        if($result == "OK")
        {

            $no_hay_datos = false;
            $inicio = "";
            $esEmp = true;
            $status_ok = false;
            $message = "Bienvenido/a ";
            // $datos =  DB::select("SELECT DISTINCT apellido, tipo, nombre, cuil, mes, mes_nom, anio FROM recibos_originales where cuil = " . $usuario . " OR numero_documento = " . $usuario . " ORDER BY anio, mes ASC");
            
            if(count($datos) == 0)
            {
                $no_hay_datos = true;
            }
            return view('empleado.empleado', compact('inicio', 'esEmp', 'nombre', 'usuario', 'status_ok', 'message', 'no_hay_datos'));
        }
        else
        {
			$message = "Inicie sesion";
			$status_error = false;
            $status_info = true;
            $esEmp = false;

            // return view('inicio.inicio', compact('status_error', 'esEmp', 'message', 'status_info'));
            return redirect('inicio')->with(['status_info' => $status_info, 'message' => $message,]);
        }
    }

    public function agregar(Request $request)
    {
        $usuario = $request->session()->get('usuario');
        $nombre = $request->session()->get('nombre');
        $result = $this->isUsuario($usuario);

        if($result == "OK")
        {

            $no_hay_datos = false;
            $inicio = "";
            $esEmp = true;
            $status_ok = false;
            // $message = "Bienvenido/a ";
            // $datos =  DB::select("SELECT DISTINCT apellido, tipo, nombre, cuil, mes, mes_nom, anio FROM recibos_originales where cuil = " . $usuario . " OR numero_documento = " . $usuario . " ORDER BY anio, mes ASC");
            
            return view('empleado.agregarnuevoconvenio', compact('inicio', 'esEmp', 'nombre', 'usuario',));
        }
        else
        {
			$message = "Inicie sesion";
			$status_error = false;
            $status_info = true;
            $esEmp = false;

            // return view('inicio.inicio', compact('status_error', 'esEmp', 'message', 'status_info'));
            return redirect('inicio')->with(['status_info' => $status_info, 'message' => $message,]);
        }
        
    }




    public function cerrarsesion(Request $request)
    {

        $id = session()->getId();

        $directory = 'C:\xampp\htdocs\recibodesueldo\storage\framework\sessions';
        $ignoreFiles = ['.gitignore', '.', '..'];
        $files = scandir($directory);
        
        foreach ($files as $file) {
            $var = $file;
            if($var == $id)
            {
                if(!in_array($file,$ignoreFiles)) unlink($directory . '/' . $file);
            }
            else {

            }
            // if(!in_array($file,$ignoreFiles)) unlink($directory . '/' . $file);
        }

        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);

        if($result == "OK")
        {
            $request->session()->flush();
        }
        $inicio = "";    
        $esEmp = false;
        $status_error = false;
        $status_info = false;
        // return view('inicio.inicio', compact('inicio','status_error', 'esEmp', 'status_info'));
        return redirect('inicio');

    }

    public function registrarse(Request $request)
    {
        
        $nombre = $request->nombre;
        $apellido = $request->apellido;
        $email = $request->email;
        $cuit = $request->cuit;
        $dni = $request->dni;
        $contrasena = $request->password;
        $confirmpassword = $request->confirmpassword;

        if($nombre == null || $apellido == null || $email == null || $cuit == null || $dni == null || $contrasena == null || $confirmpassword  == null)
        {
			$message = "Para Registrarse, complete todos los datos del formulario";
			$status_error = true;
            $status_ok = false;
            $esEmp = false;
			
			// return view('inicio.inicio', compact('inicio', 'message', 'status_error', 'esEmp'));
            return redirect('inicio')->with(['status_info' => $status_error, 'message' => $message,]);
        }

        //validar con la tabla que exista el empleado en la tabla de usuarios con mail del municipio
        $existe =  DB::select("SELECT * FROM users where cuit = '" . $cuit . "' OR dni = '" . $dni . "' OR email = '" . $email . "';");
        
        if(count($existe) >= 1)
		{
			$message = "Usted ya posee una cuenta";
			$status_error = true;
            $status_ok = false;
            $esEmp = false;
			
            return redirect('inicio')->with(['status_info' => $status_error, 'message' => $message,]);
		}
        else {
            if ($contrasena == $confirmpassword) {
                $passhash = password_hash($contrasena, PASSWORD_DEFAULT);
                DB::insert("insert into users 
							(nombreyApellido, cuit, dni, contrasena)
							values('". $fullname . "', '". $cuit ."', '" . $numero_documento."', '" . $passhash ."')");

                            $message = "Cuentra creada con exito";
                            $status_error = true;
                            $status_ok = false;
                            $esEmp = false;

                            return redirect('inicio')->with(['status_info' => $status_error, 'message' => $message,]);
            }
            else {
                $message = "No coinciden las contraseñas";
                $status_error = true;
                $status_ok = false;
                $esEmp = false;
                
                return redirect('inicio')->with(['status_info' => $status_error, 'message' => $message,]);
            }
        }
    }

    
    function isUsuario($usuario)
    {
        # code...
        // return "OK";
        if($usuario == null)
        {
            return "FALSE";
            // $inicio = ""; 
            // $status_error = false;
            // $esEmp = false;

            // return view('inicio.inicio', compact('inicio','status_error', 'esEmp'));
        }
 
        return "OK";

    }
}
