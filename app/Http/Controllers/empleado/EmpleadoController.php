<?php

namespace App\Http\Controllers\empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use PDFVillca;
use App\Users;
use App\PasosEtapas;
use App\Paso1;
use App\Paso2;
use App\Paso3;
use App\Paso4;
use App\Compra;
use App\Fisica_obra;
use App\Contabilidad;
use App\Tesoreria;
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
        // $nombre = $request->session()->get('nombre');
        $result = $this->isUsuario($usuario);

        if($result == "OK")
        {
            $user_login  = Users::get_registro($usuario);
            $nombre = $user_login->nombreyApellido;

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
        // $nombre = $request->session()->get('nombre');
        $result = $this->isUsuario($usuario);

        if($result == "OK")
        {
            $user_login  = Users::get_registro($usuario);
            $nombre = $user_login->nombreyApellido;

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
        // $nombre = $request->session()->get('nombre');
        $result = $this->isUsuario($usuario);

        if($result == "OK")
        {
            $user_login  = Users::get_registro($usuario);
            $nombre = $user_login->nombreyApellido;

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
        // $nombre = $request->session()->get('nombre');
        $result = $this->isUsuario($usuario);
        // return $request;
        if($result == "OK")
        {
            $user_login  = Users::get_registro($usuario);
            $nombre = $user_login->nombreyApellido;

            $pasos1  = Paso1::get_registro($request->id_etapas);

            // if($request->monto_recibido != '0')
            // {
            //     $pasos1_monto_recibido = new Paso1;
            //     $pasos1_monto_recibido->id_etapas = $request->id_etapas;
            //     $pasos1_monto_recibido->monto_recibido = $request->monto_recibido;

            //     $pasos1_monto_recibido->save();
            // }
            
            $pasos1->organismo_financiador = $request->organismo_financiador;
            $pasos1->nombre_proyecto = $request->nombre_proyecto;
            $pasos1->monto = $request->monto;
            $pasos1->cuenta_bancaria = $request->select_cuenta;
            $pasos1->fecha_inicio = $request->fecha_inicio;
            $pasos1->fecha_rendicion = $request->fecha_rendicion;
            $pasos1->fecha_finalizacion =  $request->fecha_finalizacion;
            $pasos1->tipo_rendicion = $request->condicion_rendicion;

            $pasos1->monto_recibido = $request->monto_recibido;
            


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
        // $nombre = $request->session()->get('nombre');
        $result = $this->isUsuario($usuario);

        if($result == "OK")
        {
            $user_login  = Users::get_registro($usuario);
            $nombre = $user_login->nombreyApellido;

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
            $user_login  = Users::get_registro($usuario);
            $nombre = $user_login->nombreyApellido;
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

            $user_login  = Users::get_registro($usuario);
            $nombre = $user_login->nombreyApellido;
            

            if ($paso == 'paso1') {

                $registro  = Paso1::get_registro($id_etapa);

                return view('empleado.paso1', compact('esEmp', 'registro','nombre',));
            } else {
                if ($paso == 'paso2') {
                    // $registro  = Paso1::get_registro($id_etapa);
                    $registro  = Paso2::get_registro($id_etapa);
                    $pasos_etapas  = PasosEtapas::get_registro($id_etapa);
                    $compra  = Compra::get_registro($id_etapa);
                    $contabilidad = Contabilidad::get_registro($id_etapa);
                    // return $compra;
                    return view('empleado.paso2', compact('esEmp', 'registro','nombre', 'id_etapas', 'pasos_etapas', 'compra', 'contabilidad'));
                } else {
                    if ($paso == 'paso3') {
                        // $registro  = Paso3::get_registro($id_etapa);
                        $if_paso1 = false;

                        // PASOS 1
                        $paso1 = DB::select(DB::raw("SELECT paso1s.monto, paso1s.fecha_inicio, paso1s.fecha_finalizacion, paso1s.fecha_rendicion, paso1s.monto_recibido, paso1s.nombre_archivo, paso1s.tipo_rendicion
                        FROM paso1s
                        WHERE paso1s.id_etapas = '" . $id_etapa . "' "));

                        if(count($paso1) > 0)
                        {
                            $datos_paso1 = array();
                            if($paso1[0]->monto > $paso1[0]->monto_recibido)
                            {
                                $faltante = $paso1[0]->monto - $paso1[0]->monto_recibido;
                                $datos_paso1['monto_faltante'] = "Falta recibir un total de $" . $faltante;
                            }

                            if($paso1[0]->fecha_inicio == null)
                            {
                                $datos_paso1['fecha_inicio'] = "La fecha de inicio se encuentra vacia";
                            }

                            if($paso1[0]->fecha_rendicion == null)
                            {
                                $datos_paso1['fecha_rendicion'] = "La fecha de rendición se encuentra vacia";
                            }

                            if($paso1[0]->fecha_finalizacion == null)
                            {
                                $datos_paso1['fecha_finalizacion'] = "La fecha de finalización se encuentra vacia";
                            }

                            if($paso1[0]->nombre_archivo == null)
                            {
                                $datos_paso1['nombre_archivo'] = "Falta cargar el convenio firmado en PDF";
                            }

                            $if_paso1 = true;

                            // COMPRAS
                            $compra  = Compra::get_registro($id_etapa);
                            
                            $arreglo_completo = array();
                            $monto_compra = 0;

                            if(count($compra) > 0)
                            {
                                // recorro compras
                                $i = 0;
                                foreach ($compra as $key => $compra_value) {
                                    $arreglo = array();
                                    // "id": 1,
                                    // "id_etapas": 1,
                                    // "orden_compra": "123456",
                                    // "importe_compra": 100,
                                    // "nombre_archivo": "ddjj_horaria.pdf",
                                    // "created_at": "2022-02-22T22:46:05.000000Z",
                                    // "updated_at": "2022-02-22T22:46:05.000000Z"
                                    $monto_compra += $compra_value->importe_compra;
                                    $json_1 = $compra_value->orden_compra;


                                    // FISICA DE OBRA O ENTREGA
                                    $fisica = $paso1[0]->tipo_rendicion;

                                    if ($fisica == 'obra') {

                                        $fisica  = Fisica_obra::get_registro($id_etapa);
                                        
                                    }
                                    else {
                                        // $fisica  = Fisica_entrega::get_registro($id_etapa);
                                    }

                                    // return $fisica;
                                    // recorro fisica
                                    $suma_importe_fisica = 0;

                                    foreach ($fisica as $key => $fisica_value) {

                                        $suma_importe_fisica += $fisica_value->monto;

                                    }

                                    if ($suma_importe_fisica < $compra_value->importe_compra) {
                                        $resto_importe_fisica = $compra_value->importe_compra - $suma_importe_fisica;
                                        $json_2 = "Para completar el monto de la compra generada, falta crear una o mas fisica. Resta : $" . $resto_importe_fisica;
                                    }
                                    // return $json;

                                    // $arreglo = $json;
                                    $i++;
                                    array_push($arreglo, $json_1, $json_2);
                                    // $arreglo[$i] = $json;

                                    $arreglo_completo[$compra_value->orden_compra] = $arreglo;
                                    
                                }
                                // $arreglo = htmlspecialchars($arreglo[], ENT_QUOTES, 'UTF-8');
                                if($monto_compra < $paso1[0]->monto){
                                    $resto_compra = $paso1[0]->monto - $monto_compra;
                                    $datos_paso1['compra'] = "Para completar el monto total del convenio, falta crear una o mas compras. Resta : $" . $resto_compra;
                                }

                                // $arreglo = array();
                                // for ($x = 1; $x <= 10; $x++)
                                // {
                                //     array_push($arreglo, $json);
                                    
                                // }
                                // return $arreglo_completo;
                                

                            }

                            
                        }



                         return view('empleado.paso3', compact('esEmp', 'compra','nombre', 'datos_paso1', 'if_paso1', 'arreglo_completo'));
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

    public function verdatosdelconvenio($param_id_etapa, Request $request)
    {
        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);

        if($result == "OK")
        {
            $user_login  = Users::get_registro($usuario);
            $nombre = $user_login->nombreyApellido;
            $registro  = Paso1::get_registro($param_id_etapa);
            $no_hay_datos = false;
            $inicio = "";
            $esEmp = true;
            $status_ok = false;

            return view('empleado.datosconvenio', compact('inicio', 'esEmp', 'nombre', 'usuario', 'registro'));
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

    public function datosdelconvenio(Request $request)
    {
        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);
        // $param_id_etapa = 1;
        if($result == "OK")
        {
            $user_login  = Users::get_registro($usuario);
            $nombre = $user_login->nombreyApellido;


            $param_id_etapa = $request->opcion;

            // $pasosEtapas  = PasosEtapas::get_registro(param_id_etapa);

            $orderby = " ORDER BY compras.id ASC ";
            $limit = " LIMIT 500"; 
    
            $data = DB::select(DB::raw("SELECT compras.orden_compra, compras.importe_compra, contabilidads.nro_factura, DATE_FORMAT( contabilidads.fecha_emision,'%d/%m/%Y') AS fecha_emision, contabilidads.beneficiario, contabilidads.cuit, contabilidads.importe, contabilidads.cae, contabilidads.nro_pago, DATE_FORMAT( tesorerias.fecha_pago,'%d/%m/%Y') AS fecha_pago
            FROM compras
            LEFT JOIN contabilidads ON contabilidads.id_compra = compras.id
            LEFT JOIN tesorerias ON tesorerias.id_contabilidad = contabilidads.id
            WHERE compras.id_etapas = '" . $param_id_etapa . "'"
                    . $orderby." ".$limit));

            return json_encode($data, JSON_UNESCAPED_UNICODE);

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
        $result = $this->isUsuario($usuario);
        
        if($result == "OK")
        {
            $user_login  = Users::get_registro($usuario);
            $nombre = $user_login->nombreyApellido;

            $pasosEtapas  = PasosEtapas::get_registro($request->id_etapas);

            $compras = new Compra;
            $compras->id_etapas = $request->id_etapas;
            $compras->orden_compra = $request->orden_compra;
            $compras->importe_compra = $request->importe;
            

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
            

            // return view('empleado.paso2', compact('esEmp', 'registro','nombre', 'id_etapas', 'pasos_etapas', 'compra'));
            // return $nombre;
            return redirect('empleado/verconvenio/' . $id_etapas .'/paso2')->with(['registro' => $registro, 'pasos_etapas' => $pasos_etapas, 'nombre' => $nombre, 'id_etapas' => $id_etapas, 'compra' => $compra,]);
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


    // fisica obra
    public function ejecucionconveniofisicaobra(Request $request)
    {
        $usuario = $request->session()->get('usuario');
        // $nombre = $request->session()->get('nombre');
        $result = $this->isUsuario($usuario);
        return $request;

        if($result == "OK")
        {
            $user_login  = Users::get_registro($usuario);
            $nombre = $user_login->nombreyApellido;

            $pasosEtapas  = PasosEtapas::get_registro($request->id_etapas);

            $fisica_obra = new Fisica_obra;
            $fisica_obra->id_etapas = $request->id_etapas;
            $fisica_obra->id_compra = $request->orden_compra;
            $fisica_obra->nro_certificado = $request->nro_certificado;
            $fisica_obra->porcentaje = $request->avance_obra;
            $fisica_obra->monto = $request->importe;

            $nombre_carpeta = 'pdf/'. $pasosEtapas->nombre_proyecto . '/fisica_obra';
            $path = storage_path($nombre_carpeta);

            if (!file_exists($path)) {
                mkdir($path, 0775, true);
            }

            if($request->hasFile("pdf_certificado_obra")){
                $file=$request->file("pdf_certificado_obra");
                
                // $nombre = "pdf_".time().".".$file->guessExtension();
                $nombre_pdf = $file->getClientOriginalName() ;
                $ruta = $path . "/" . $nombre_pdf;
                

                if($file->guessExtension()=="pdf"){
                    if (file_exists($pasosEtapas->nombre_archivo)) {
                        //File::delete($image_path);
                        unlink($nombre_pdf);
                    }
                    copy($file, $ruta);
                    $fisica_obra->nombre_archivo = $nombre_pdf;
                    // return $ruta;
                }else{
                    dd("NO ES UN PDF");
                }
    
    
    
            }

            $fisica_obra->save();

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
            

            // return view('empleado.paso2', compact('esEmp', 'registro','nombre', 'id_etapas', 'pasos_etapas', 'compra'));

            return redirect('empleado/verconvenio/' . $id_etapas .'/paso2')->with(['registro' => $registro, 'pasos_etapas' => $pasos_etapas, 'nombre' => $nombre, 'id_etapas' => $id_etapas, 'compra' => $compra,]);
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

    // CONTABILIDAD
    public function ejecucionconveniocontabilidad(Request $request)
    {
        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);
        // return $request;
        if($result == "OK")
        {
            $user_login  = Users::get_registro($usuario);
            $nombre = $user_login->nombreyApellido;

            $pasosEtapas  = PasosEtapas::get_registro($request->id_etapas);

            $contabilidad = new Contabilidad;
            $contabilidad->id_etapas = $request->id_etapas;
            $contabilidad->id_compra = $request->orden_compra;
            $contabilidad->nro_factura = $request->nro_factura;
            $contabilidad->fecha_emision = $request->fecha_emision;
            $contabilidad->beneficiario = $request->beneficiario;
            $contabilidad->cuit = $request->cuit;
            $contabilidad->importe = $request->importe;
            $contabilidad->cae = $request->cae;
            $contabilidad->nro_pago = $request->nro_pago;
            // $contabilidad->nombre_archivo_factura
            // $contabilidad->nombre_archivo_comprobante_afip

            $nombre_carpeta = 'pdf/'. $pasosEtapas->nombre_proyecto . '/contabilidad';
            $path = storage_path($nombre_carpeta);

            if (!file_exists($path)) {
                mkdir($path, 0775, true);
            }

             // PDF FACTURA
            if($request->hasFile("pdf_factura")){
                $file=$request->file("pdf_factura");
                
                $nombre_pdf = $file->getClientOriginalName() ;
                $ruta = $path . "/" . $nombre_pdf;
                

                if($file->guessExtension()=="pdf"){
                    if (file_exists($pasosEtapas->nombre_archivo)) {
                        //File::delete($image_path);
                        unlink($nombre_pdf);
                    }
                    copy($file, $ruta);
                    $contabilidad->nombre_archivo_factura = $nombre_pdf;
                }else{
                    dd("NO ES UN PDF");
                }
            }

            // PDF AFIP
            if($request->hasFile("pdf_afip")){
                $file=$request->file("pdf_afip");
                
                // $nombre = "pdf_".time().".".$file->guessExtension();
                $nombre_pdf = $file->getClientOriginalName() ;
                $ruta = $path . "/" . $nombre_pdf;
                

                if($file->guessExtension()=="pdf"){
                    if (file_exists($pasosEtapas->nombre_archivo)) {
                        //File::delete($image_path);
                        unlink($nombre_pdf);
                    }
                    copy($file, $ruta);
                    $contabilidad->nombre_archivo_comprobante_afip = $nombre_pdf;
                }else{
                    dd("NO ES UN PDF");
                }
            }

            $contabilidad->save();

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

            return redirect('empleado/verconvenio/' . $id_etapas .'/paso2')->with(['registro' => $registro, 'pasos_etapas' => $pasos_etapas, 'nombre' => $nombre, 'id_etapas' => $id_etapas, 'compra' => $compra,]);
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

    // TESORERIA
    public function ejecucionconveniotesoreria(Request $request)
    {
        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);

        if($result == "OK")
        {
            $user_login  = Users::get_registro($usuario);
            $nombre = $user_login->nombreyApellido;

            $pasosEtapas  = PasosEtapas::get_registro($request->id_etapas);

            $tesoreria = new Tesoreria;
            $tesoreria->id_etapas = $request->id_etapas;
            $tesoreria->id_compra = $request->orden_compra;
            $tesoreria->id_contabilidad = $request->nro_factura;
            $tesoreria->fecha_pago = $request->fecha_pago;
            // $contabilidad->nombre_archivo_pago

            $nombre_carpeta = 'pdf/'. $pasosEtapas->nombre_proyecto . '/tesoreria';
            $path = storage_path($nombre_carpeta);

            if (!file_exists($path)) {
                mkdir($path, 0775, true);
            }

             // PDF PAGO
            if($request->hasFile("pdf_recibo_pago")){
                $file=$request->file("pdf_recibo_pago");
                
                $nombre_pdf = $file->getClientOriginalName() ;
                $ruta = $path . "/" . $nombre_pdf;
                

                if($file->guessExtension()=="pdf"){
                    if (file_exists($pasosEtapas->nombre_archivo)) {
                        //File::delete($image_path);
                        unlink($nombre_pdf);
                    }
                    copy($file, $ruta);
                    $tesoreria->nombre_archivo_pago = $nombre_pdf;
                }else{
                    dd("NO ES UN PDF");
                }
            }

            $tesoreria->save();

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

            return redirect('empleado/verconvenio/' . $id_etapas .'/paso2')->with(['registro' => $registro, 'pasos_etapas' => $pasos_etapas, 'nombre' => $nombre, 'id_etapas' => $id_etapas, 'compra' => $compra,]);
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
        $param_id_etapa = 1;
        $orderby = " ORDER BY compras.id ASC ";
        $limit = " LIMIT 500"; 

        $data = DB::select(DB::raw("SELECT compras.orden_compra, contabilidads.nro_factura, DATE_FORMAT( contabilidads.fecha_emision,'%d/%m/%Y') AS fecha_emision, contabilidads.beneficiario, contabilidads.cuit,
        contabilidads.importe, contabilidads.cae, contabilidads.nro_pago, DATE_FORMAT( tesorerias.fecha_pago,'%d/%m/%Y') AS fecha_pago
        FROM compras
        LEFT JOIN contabilidads ON contabilidads.id_compra = compras.id
        LEFT JOIN tesorerias ON tesorerias.id_compra = compras.id
        WHERE compras.id_etapas = 1"
                . $orderby." ".$limit));


        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }


}
