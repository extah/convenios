<?php

namespace App\Http\Controllers\empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use PDFVillca;
use App\PasosEtapas;
use App\Paso1;
use App\Paso2;
use App\Paso3;
use App\Paso4;
use App\Compra;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

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
                $status_convenio = false;
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
                return view('empleado.empleado', compact('inicio', 'esEmp', 'nombre', 'status_ok', 'status_convenio', 'message', ));
                
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
            $status_convenio=false;
            $message = "Bienvenido/a ";
            // $datos =  DB::select("SELECT DISTINCT apellido, tipo, nombre, cuil, mes, mes_nom, anio FROM recibos_originales where cuil = " . $usuario . " OR numero_documento = " . $usuario . " ORDER BY anio, mes ASC");
            
            // if(count($datos) == 0)
            // {
            //     $no_hay_datos = true;
            // }
            return view('empleado.empleado', compact('inicio', 'esEmp', 'nombre', 'usuario', 'status_ok', 'status_convenio', 'message', 'no_hay_datos'));
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

    public function agregarconvenio(Request $request)
    {
        $usuario = $request->session()->get('usuario');
        $nombre = $request->session()->get('nombre');
        $result = $this->isUsuario($usuario);

        if($result == "OK")
        {
            $nombre_proyecto = $request->nombre_proyecto;

            // DB::insert("insert into pasos_etapas 
            // (nombre_proyecto, paso1, paso2, paso3, paso4, finalizo)
            // values('" . $nombre_proyecto . "', 1, 0, 0, 0, 0)");

            $pasosEtapas = new PasosEtapas;
            $pasosEtapas->nombre_proyecto = $nombre_proyecto;
            $pasosEtapas->creado = $nombre;
            $pasosEtapas->paso1 = "NO";
            $pasosEtapas->paso2 = "NO";
            $pasosEtapas->paso3 = "NO";
            $pasosEtapas->paso4 = "NO";
            $pasosEtapas->finalizo = "NO";
            $pasosEtapas->tipo_rendicion = $request->select_ejecucion;
            $pasosEtapas->save();

            $data = PasosEtapas::latest('id')->first();

            $pasos1 = new Paso1;
            $pasos1->id_etapas = $data->id;
            $pasos1->organismo_financiador = $request->organismo_financiador;
            $pasos1->nombre_proyecto = $request->nombre_proyecto;
            $pasos1->monto = $request->monto;
            $pasos1->cuenta_bancaria = $request->select_cuenta;
            $pasos1->fecha_inicio = $request->fecha_inicio;
            $pasos1->fecha_rendicion = $request->fecha_rendicion;
            $pasos1->fecha_finalizacion =  $request->fecha_finalizacin;
            $pasos1->tipo_rendicion = $request->select_ejecucion;
            $pasos1->save();

            $no_hay_datos = false;
            $inicio = "";
            $esEmp = true;
            $status_ok = false;
            $status_convenio = true;
            $nombreconvenio = "ÉXITO";
            $message = "Convenio creado";
            $status_agregado = true;

            return view('empleado.empleado', compact('status_agregado', 'status_ok', 'status_convenio', 'esEmp', 'nombreconvenio', 'nombre', 'message'));
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

    public function editarconvenio(Request $request)
    {
        $usuario = $request->session()->get('usuario');
        $nombre = $request->session()->get('nombre');
        $result = $this->isUsuario($usuario);
        // return $request;
        if($result == "OK")
        {
            $pasos1  = Paso1::get_registro($request->id_etapas);

            if($request->monto_recibido != '0')
            {
                $pasos1_monto_recibido = new Paso1;
                $pasos1_monto_recibido->id_etapas = $request->id_etapas;
                $pasos1_monto_recibido->monto_recibido = $request->monto_recibido;

                $pasos1_monto_recibido->save();
            }
            
            $pasos1->organismo_financiador = $request->organismo_financiador;
            $pasos1->nombre_proyecto = $request->nombre_proyecto;
            $pasos1->monto = $request->monto;
            $pasos1->cuenta_bancaria = $request->select_cuenta;
            $pasos1->fecha_inicio = $request->fecha_inicio;
            $pasos1->fecha_rendicion = $request->fecha_rendicion;
            $pasos1->fecha_finalizacion =  $request->fecha_finalizacion;
            $pasos1->tipo_rendicion = $request->condicion_rendicion;
            


            $nombre_carpeta = 'pdf/'. $request->nombre_proyecto . '/firma';
            $path = storage_path($nombre_carpeta);

            if (!file_exists($path)) {
                mkdir($path, 0775, true);
            }

            if($request->hasFile("pdf")){
                $file=$request->file("pdf");
                
                // $nombre = "pdf_".time().".".$file->guessExtension();
                $nombre_pdf = "convenio_firmado.".$file->guessExtension();
                $ruta = $path . "/" . $nombre_pdf;
                

                if($file->guessExtension()=="pdf"){
                    if (file_exists($pasos1->nombre_archivo)) {
                        //File::delete($image_path);
                        unlink($nombre_pdf);
                    }
                    copy($file, $ruta);
                    $pasos1->nombre_archivo = $nombre_pdf;
                    // return $ruta;
                }else{
                    dd("NO ES UN PDF");
                }
    
    
    
            }
    
            $pasos1->save();
            
            $pasosEtapas = PasosEtapas::get_registro($request->id_etapas);
            // return $request->nombre_proyecto;
            $pasosEtapas->nombre_proyecto = $request->nombre_proyecto;
            $pasosEtapas->paso1 = "SI";
            $pasosEtapas->save();

            $no_hay_datos = false;
            $inicio = "";
            $esEmp = true;
            $status_ok = false;
            $status_convenio = true;
            $nombreconvenio = "ÉXITO";
            $message = "Convenio creado";
            $status_agregado = true;

            $esEmp = true;
            $paso1 = DB::select("SELECT id_etapas, organismo_financiador, nombre_proyecto, monto, cuenta_bancaria, fecha_inicio, fecha_rendicion, fecha_finalizacion, tipo_rendicion, nombre_archivo FROM paso1s where id_etapas = " . $request->id_etapas);
            // return ($paso1);
            // 'empleado/verconvenio',['id' => $paso1[0]->id_etapas, 'paso' => 'paso1']
            return redirect()->route('empleado.verconveniopaso', ['id' => $request->id_etapas, 'paso' => 'paso1']);
            // return view('empleado.verconvenio', compact('esEmp', 'paso1','nombre',));
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



    public function buscarconvenios(Request $request)
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

            return view('empleado.buscarconvenios', compact('inicio', 'esEmp', 'nombre', 'usuario',));
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

    public function tablaconvenios(Request $request)
    {
        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);       
            
        if($result == "OK"){
            
            if (is_null($request->opcion)) {

                if(is_null($request->opcion_buscar)){
                    
                    if (is_null($request->opcion_proyecto)) {

                        $opcion = $request->opcion_finalizado;
                    }else
                    {
                        
                        $opcion = $request->opcion_proyecto;
                    }   
                   
                } 
                else
                {
                    
                    $opcion = $request->opcion_buscar;
                }   
                
            } else {
                
                $opcion = $request->opcion;

            }
            
            switch($opcion){

                case 1:
                
                    //Agregar  

                    break;    
                case 2: 
                    //Actualizar

                    break;
                case 3: 
                    //borrar

                    break;

                case 4: 
                    // $limit = " LIMIT 2000";
                    $orderby = " ORDER BY pasos_etapas.id DESC ";
                    $limit = " LIMIT 500"; 
            
                    $data = DB::select(DB::raw("SELECT pasos_etapas.id,  pasos_etapas.nombre_proyecto as proyecto, pasos_etapas.creado,pasos_etapas.paso1, pasos_etapas.paso2, pasos_etapas.paso3, pasos_etapas.paso4, pasos_etapas.finalizo 
                    FROM pasos_etapas
                    WHERE pasos_etapas.finalizo = 0 
                    ".$orderby." ".$limit));
                    
                    break;
                case 5:
                    $nro_convenio = $request->nro_convenio;
                    // $limit = " LIMIT 2000";        
                    $orderby = " ORDER BY pasos_etapas.id ASC ";
                    $limit = " LIMIT 500"; 
            
                    $data = DB::select(DB::raw("SELECT pasos_etapas.id,  pasos_etapas.nombre_proyecto as proyecto, pasos_etapas.paso1, pasos_etapas.paso2, pasos_etapas.paso3, pasos_etapas.paso4, pasos_etapas.finalizo 
                    FROM pasos_etapas
                    WHERE id = " . $nro_convenio . " " . $orderby." ".$limit));

                    break;
                case 6:
                    $nombre = $request->nombre_proyecto;
                    $orderby = " ORDER BY pasos_etapas.id ASC ";
                    $limit = " LIMIT 500"; 
            
                    $data = DB::select(DB::raw("SELECT pasos_etapas.id,  pasos_etapas.nombre_proyecto as proyecto, pasos_etapas.paso1, pasos_etapas.paso2, pasos_etapas.paso3, pasos_etapas.paso4, pasos_etapas.finalizo 
                    FROM pasos_etapas
                    WHERE nombre_proyecto LIKE '%" . $nombre ."%'" 
                            . $orderby." ".$limit));

                    break;    
                case 7:
                    $estado = $request->estado;
                    $orderby = " ORDER BY pasos_etapas.id ASC ";
                    $limit = " LIMIT 500"; 
            
                    $data = DB::select(DB::raw("SELECT pasos_etapas.id,  pasos_etapas.nombre_proyecto as proyecto, pasos_etapas.paso1, pasos_etapas.paso2, pasos_etapas.paso3, pasos_etapas.paso4, pasos_etapas.finalizo 
                    FROM pasos_etapas
                    WHERE pasos_etapas.finalizo = '" . $estado . "' "
                            . $orderby." ".$limit));

                    break;      
            }

            return json_encode($data, JSON_UNESCAPED_UNICODE);

        }
    }

    public function verconvenio($id, Request $request)
    {
        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);       
            
        if($result == "OK"){
            $esEmp = true;
            $nombre = $request->session()->get('nombre');
            $paso1 = DB::select("SELECT id_etapas, organismo_financiador, nombre_proyecto, monto, cuenta_bancaria, fecha_inicio, fecha_rendicion, fecha_finalizacion, tipo_rendicion, nombre_archivo, created_at FROM paso1s where id_etapas = " . $id);
            // return ($paso1);
            return view('empleado.verconvenio', compact('esEmp', 'paso1','nombre',));
        }
        else{

        }

    }

    public function verconveniopaso($id_etapa, $paso,  Request $request)
    {

        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);
        $id_etapas = $id_etapa;
            
        if($result == "OK"){
            $esEmp = true;
            $nombre = $request->session()->get('nombre');
            

            if ($paso == 'paso1') {

                $registro  = Paso1::get_registro($id_etapa);

                return view('empleado.paso1', compact('esEmp', 'registro','nombre',));
            } else {
                if ($paso == 'paso2') {
                    // $registro  = Paso1::get_registro($id_etapa);
                    $registro  = Paso2::get_registro($id_etapa);
                    $pasos_etapas  = PasosEtapas::get_registro($id_etapa);
                    $compra  = Compra::get_registro($id_etapa);
                    // return $compra;
                    return view('empleado.paso2', compact('esEmp', 'registro','nombre', 'id_etapas', 'pasos_etapas', 'compra'));
                } else {
                    if ($paso == 'paso3') {
                        // $registro  = Paso3::get_registro($id_etapa);
                        // return $registro;
                         return view('empleado.paso3', compact('esEmp', 'registro','nombre',));
                    } else {
                        if ($paso == 'paso4') {
                            $registro  = Paso4::get_registro($id_etapa);
                            // return $registro;
                             return view('empleado.paso4', compact('esEmp', 'registro','nombre',));
                        } else {
                            # code...
                        }
                    }
                }
            }
        }
        else{

        }
    }

    public function verpdfconvenio($id_etapa, $paso, $pdf, Request $request)
    {
        // return $pdf;

        // $filename = 'test.pdf';
        // $path = storage_path($filename);
        $pasos_etapas  = PasosEtapas::get_registro($id_etapa);
        if($paso == "paso1")
        {
            // $pasos  = Paso1::get_registro($id_etapa);
            $filename = 'pdf/'. $pasos_etapas->nombre_proyecto . '/firma'. '/' . $pdf;
        }
        elseif($paso == "paso2")
        {
            // $pasos  = Paso2::get_registro($id_etapa);
            $filename = 'pdf/'. $pasos_etapas->nombre_proyecto . '/ejecucion'. '/' . $pdf;
        }
       
        // return $pasos1;
        // $filename = 'pdf/'. $pasos_etapas->nombre_proyecto . '/ejecucion'. '/' . $pdf;
        $path = storage_path($filename);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }

    // COMPRAS
    public function ejecucionconveniocompra(Request $request)
    {
        $usuario = $request->session()->get('usuario');
        $nombre = $request->session()->get('nombre');
        $result = $this->isUsuario($usuario);
        
        // return $request;
        if($result == "OK")
        {
            $pasosEtapas  = PasosEtapas::get_registro($request->id_etapas);

            $compras = new Compra;
            $compras->id_etapas = $request->id_etapas;
            $compras->orden_compra = $request->orden_compra;
            

            $nombre_carpeta = 'pdf/'. $pasosEtapas->nombre_proyecto . '/compras';
            $path = storage_path($nombre_carpeta);

            if (!file_exists($path)) {
                mkdir($path, 0775, true);
            }

            if($request->hasFile("pdf_orden_compra")){
                $file=$request->file("pdf_orden_compra");
                
                // $nombre = "pdf_".time().".".$file->guessExtension();
                $nombre_pdf = $file->getClientOriginalName() ;
                $ruta = $path . "/" . $nombre_pdf;
                

                if($file->guessExtension()=="pdf"){
                    if (file_exists($pasosEtapas->nombre_archivo)) {
                        //File::delete($image_path);
                        unlink($nombre_pdf);
                    }
                    copy($file, $ruta);
                    $compras->nombre_archivo = $nombre_pdf;
                    // return $ruta;
                }else{
                    dd("NO ES UN PDF");
                }
    
    
    
            }

            $compras->save();

            $no_hay_datos = false;
            $inicio = "";
            $esEmp = true;
            $status_ok = false;
            $status_convenio = true;
            $nombreconvenio = "ÉXITO";
            $message = "Convenio creado";
            $status_agregado = true;

            // return view('empleado.paso1', compact('status_agregado', 'status_ok', 'status_convenio', 'esEmp', 'nombreconvenio', 'nombre', 'message'));
            $id_etapas = $request->id_etapas;

            $registro  = Paso2::get_registro($id_etapas);
            $pasos_etapas  = PasosEtapas::get_registro($id_etapas);
            $compra  = Compra::get_registro($id_etapas);
            

            return view('empleado.paso2', compact('esEmp', 'registro','nombre', 'id_etapas', 'pasos_etapas', 'compra'));
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

    public function ejecucionconveniofisicaobra(Request $request)
    {
        $usuario = $request->session()->get('usuario');
        $nombre = $request->session()->get('nombre');
        $result = $this->isUsuario($usuario);
        
        return $request;

// borrar

// "orden_compra": "1",
// "nro_certificado": "23232323",
// "avance_obra": "50",
// "monto": "25.0",
// "pdf_certificado_obra":


        if($result == "OK")
        {
            $pasosEtapas  = PasosEtapas::get_registro($request->id_etapas);

            $compras = new Compra;
            $compras->id_etapas = $request->id_etapas;
            $compras->orden_compra = $request->orden_compra;

            $nombre_carpeta = 'pdf/'. $pasosEtapas->nombre_proyecto . '/compras';
            $path = storage_path($nombre_carpeta);

            if (!file_exists($path)) {
                mkdir($path, 0775, true);
            }

            if($request->hasFile("pdf_orden_compra")){
                $file=$request->file("pdf_orden_compra");
                
                // $nombre = "pdf_".time().".".$file->guessExtension();
                $nombre_pdf = $file->getClientOriginalName() ;
                $ruta = $path . "/" . $nombre_pdf;
                

                if($file->guessExtension()=="pdf"){
                    if (file_exists($pasosEtapas->nombre_archivo)) {
                        //File::delete($image_path);
                        unlink($nombre_pdf);
                    }
                    copy($file, $ruta);
                    $compras->nombre_archivo = $nombre_pdf;
                    // return $ruta;
                }else{
                    dd("NO ES UN PDF");
                }
    
    
    
            }

            $compras->save();

            $no_hay_datos = false;
            $inicio = "";
            $esEmp = true;
            $status_ok = false;
            $status_convenio = true;
            $nombreconvenio = "ÉXITO";
            $message = "Convenio creado";
            $status_agregado = true;

            // return view('empleado.paso1', compact('status_agregado', 'status_ok', 'status_convenio', 'esEmp', 'nombreconvenio', 'nombre', 'message'));
            $id_etapas = $request->id_etapas;

            $registro  = Paso2::get_registro($id_etapas);
            $pasos_etapas  = PasosEtapas::get_registro($id_etapas);
            $compra  = Compra::get_registro($id_etapas);
            

            return view('empleado.paso2', compact('esEmp', 'registro','nombre', 'id_etapas', 'pasos_etapas', 'compra'));
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

    public function ejecucionconvenio(Request $request)
    {     
        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);  
        // return $request;

        if($result == "OK"){
            $select_ejecucion = $request->select_ejecucion;
            $select_entrega_producto = $request->select_entrega_producto;
            $monto_pagado = $request->monto_pagado;
            $id_etapas = $request->id_etapas;

            $esEmp = true;
            $nombre = $request->session()->get('nombre');

            //buscar el nombre de la carpeta
            $pasosEtapas  = PasosEtapas::get_registro($id_etapas);

            $nombre_carpeta = 'pdf/'. $pasosEtapas->nombre_proyecto . '/ejecucion';
            $path = storage_path($nombre_carpeta);

            if (!file_exists($path)) {
                mkdir($path, 0775, true);
            }

            if($request->hasFile("pdf")){
                $file=$request->file("pdf");
                
                // $nombre = "pdf_".time().".".$file->guessExtension();
                $nombrepdfproducto = "acta_de_entrega.";
                
                if($select_entrega_producto != "municipalidad")
                {
                    $nombrepdfproducto = "remito.";
                }

                $nombre_pdf = $nombrepdfproducto . $file->guessExtension();
                $ruta = $path . "/" . $nombre_pdf;
                

                if($file->guessExtension()=="pdf"){
                    if (file_exists($pasosEtapas->nombre_proyecto)) {
                        //File::delete($image_path);
                        unlink($nombre_pdf);
                    }
                    copy($file, $ruta);
                    // $pasosEtapas->nombre_proyecto = $nombre_pdf;
                    // return $ruta;
                }else{
                    dd("NO ES UN PDF");
                }
                
    
    
            }
    
            // $pasos1->save();

            $pasosEtapas->paso2 = "SI";
            $pasosEtapas->save();

            $pasos2 = new Paso2;
            $pasos2->id_etapas = $id_etapas;
            $pasos2->condicion_rendicion = $request->select_ejecucion;
            $pasos2->receptor = $request->select_entrega_producto;
            $pasos2->nombre_archivo = $nombre_pdf;
            // $pasos1->created_at = $request->select_cuenta;
            $pasos2->save();


            $registro  = Paso2::get_registro($id_etapas);
            // return $id_etapas;
            // return $registro;
            return view('empleado.paso2', compact('esEmp', 'registro','nombre', 'id_etapas'));
        }
        else{

        }



        return $request;
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



    public function prueba(Type $var = null)
    {
        // $path = "C:/xampp/htdocs/convenios/storage/pdf/newfolder";
        // $url = Storage::url('newfolder');
        $nombre_carpeta = 'pdf/playón deportivo';
        $path = storage_path($nombre_carpeta);
        // return $path;
        $devu = "false";
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
            $devu = "true";
        }
        return $devu;
    }


}
