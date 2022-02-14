@extends('template/template')

@section('css')


            <!-- <link rel="stylesheet" href="{{ asset('css/login.css') }}"> -->
            <link href="{{ asset('/assets/bootstrap-datepicker-1.7.1/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
            <style>
                .formItem{
                    display: block;
                    text-align: center;
                    line-height: 200%;
                }
                
                /* .visible {
                  display: hide;
                } */
                .invisible {
                  display: none;
                }
            </style>
@endsection

@section('content')
<br>
<div class="container">
  <div class="col-8 col-sm-6 col-md-6 mx-auto">
    <div class="card text-white bg-info mb-3" style="max-width: 100rem;">
        <div class="card-body text-center">
          <h4 class="card-title">CONVENIO EN EJECUCIÓN</h4>
        </div>                  
    </div>
  </div>
</div>

    <article class="container col-12 mx-auto p-0">
      <div class="col-11 col-sm-11 col-md-10 col-lg-10 d-flex flex-column mx-auto p-0 my-4 gap-4">
        @if (!empty($registro))
            @if ("$registro->nombre_archivo" != '')
                <div class="col-md-6">
                <label for="pagos" class="form-label"><b>VER PAGOS POR PDF</b></label>
                <div class="mb-3 mx-auto">
                    {{-- <button id="firma" class="btn btn-primary btn-lg" ><i class="fas fa-eye"></i> VER CONVENIO</button> --}}
                    <a href="{{url('empleado/verconvenio',['id' => $registro->id_etapas, 'paso' => 'paso2', 'pdf' => $registro->nombre_archivo])}}" target="_blank" class="btn btn-primary btn-lg">
                    <i class="fas fa-eye" aria-hidden="true" ></i> VER PAGO
                </a>
                </div>
                </div>
            @endif 
        @endif 
      
        <div>
          <input id="tipo_rendicion" type="text" value="{{$pasos_etapas->tipo_rendicion}}" style ="display: none;">
        </div> 
        <!-- COMPRA -->
        <div class="d-grid gap-2 col-6 mx-auto">
            <button type="button" id="desplegarcompra" class="btn btn-outline-info btn-lg text-start" onclick="desplegarCompra()"> <i class="far fa-plus-square" style='font-size:23px;color:green'></i>    <b>COMPRA</b></button>
            <button type="button" id="replegarcompra" class="btn btn-outline-info btn-lg text-start" onclick="replegarCompra()" style ="display: none;"> <i class="far fa-minus-square" style='font-size:23px;color:red'></i>    <b>COMPRA</b></button>
        </div>                  
          
        <form id="form_compra" style ="display: none;" onsubmit="return miFuncion(this)" class="needs-validation" enctype="multipart/form-data" novalidate method="post" action="{{ url('empleado/ejecucionconveniocompra') }}">
            @csrf
              <div class="row g-3">

                <div class="col-md-6">
                    <label for="orden_compra" class="form-label"><b>ORDEN DE COMPRA</b></label>
                    <input type="text" class="form-control" id="orden_compra" name="orden_compra"  value="" placeholder="ingrese la orden de compra" required>
                </div>

                <div class="col-md-6">
                  <label for="pdf_orden_compra" class="form-label"><b>ADJUNTAR PDF ORDEN DE COMPRA</b></label>
                  <div class="input-group mb-3">
                    <input type="file" class="form-control" id="pdf_orden_compra" name="pdf_orden_compra" accept=".pdf" required>
                    <label class="input-group-text" for="pdf">SUBIR</label>
                  </div>

                </div>

                <div>
                  <input id="id_etapas" name="id_etapas" type="text" value="{{$id_etapas}}" >
                </div> 

                <div class="form-group" >
                  <div id="captcha" class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>
                  <div id='errorRecaptcha' style='display:none; color:#a94442' required>    <span class='glyphicon glyphicon-exclamation-sign'></span>    Por favor, verifica que no seas un robot.</div>
                </div>
                <div class="d-grid gap-2 col-md-10 mx-auto">
                  <button id="boton_guardar" type="submit" class="btn btn-info btn-lg" >Guardar</button>
                </div>
              </div>
          </form>

          <!-- FISICA -->
          <div class="d-grid gap-2 col-6 mx-auto">
              <button type="button" id="desplegarfisica" class="btn btn-outline-dark btn-lg text-start" onclick="desplegarFisica()"> <i class="far fa-plus-square" style='font-size:23px;color:green'></i>    <b>FISICA</b></button>
              <button type="button" id="replegarfisica" class="btn btn-outline-dark btn-lg text-start" onclick="replegarFisica()" style ="display: none;"> <i class="far fa-minus-square" style='font-size:23px;color:red'></i>    <b>FISICA</b></button>
          </div>
          {{-- OBRA --}}
          <form id="form_obra_fisica" style ="display: none;" onsubmit="return miFuncion(this)" class="needs-validation" enctype="multipart/form-data" novalidate method="post" action="{{ url('empleado/ejecucionconvenio') }}">
            @csrf
            
            <div class="row g-3">

              <div class="col-md-6">
                  <label for="nro_certificado" class="form-label"><b>N° DE CERTIFICADO</b></label>
                  <input type="text" class="form-control" id="nro_certificado" name="nro_certificado"  value="" placeholder="ingrese el numero de certificado" required>
              </div>

              <div id="elegir_archivos" class="col-md-6">
                <label id="obra" for="pdf" class="form-label"><b>ADJUNTAR PDF CERTIFICADO DE OBRA</b></label>
                <div class="input-group mb-3">
                  <input type="file" class="form-control" id="pdf" name="pdf" accept=".pdf" required>
                  <label class="input-group-text" for="pdf">SUBIR</label>
                </div>
              </div>

              <div class="col-md-6">
                <label for="avance_obra" class="form-label"><b>PORCENTAJE DEL AVANCE DE OBRA</b></label>
                <input type="number" class="form-control" id="avance_obra" name="avance_obra"  value="0" placeholder="ingrese el porcentaje de la obra" required>
              </div>

              <div class="col-md-6">
                <label for="monto" class="form-label"><b>MONTO</b></label>
                <input type="number" step=".01" class="form-control" id="monto" name="monto" min="0" value="00.0" placeholder="ingrese el monto" required>
              </div>

              <div class="form-group" >
                <div id="captcha" class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>
                <div id='errorRecaptcha' style='display:none; color:#a94442' required>    <span class='glyphicon glyphicon-exclamation-sign'></span>    Por favor, verifica que no seas un robot.</div>
              </div>
              <div class="d-grid gap-2 col-md-10 mx-auto">
                <button id="boton_guardar" type="submit" class="btn btn-dark btn-lg" >Guardar</button>
              </div>
            </div>
        </form> 
        {{-- PRODUCTO ENTREGA --}}
        <form id="form_entrega_fisica" style ="display: none;" onsubmit="return miFuncion(this)" class="needs-validation" enctype="multipart/form-data" novalidate method="post" action="{{ url('empleado/ejecucionconvenio') }}">
          @csrf
          
          <div class="row g-3">
            
              <div class="col-sm-6">
                <form action="">
                  <div class="card text-white bg-secondary">
                    <div class="card-body">
                      <div id="entrega_producto">      
                        <label for="select_entrega_producto" class="form-label"><b>PRODUCTO RECIBIDO</b></label>
                        <select name="select_entrega_producto" id="select_entrega_producto" class="form-control text-center" onchange="showproducto(this)" required>
                          <option value="municipalidad">Municipalidad</option>
                          {{-- <option value="beneficiario" >Otro beneficiario</option>           --}}
                        </select>
                      </div>

                      <div>
                        <label for="porc_producto_recibido" class="form-label"><b>PORCENTAJE DEL PRODUCTO RECIBIDO</b></label>
                        <input type="number" class="form-control" id="porc_producto_recibido" name="porc_producto_recibido"  value="0" placeholder="ingrese el porcentaje del producto recibido" required>
                      </div>

                      <div>
                        <div>
                          {{-- <label id="producto_municipalidad" for="pdf" class="form-label" ><b>ADJUNTAR PDF REMITO</b></label>
                          <label id="producto_beneficiario" for="pdf" class="form-label" style="display: none;"><b>SUBIR ACTA DE ENTREGA</b></label> --}}
                          <label for="pdf_remito" class="form-label" ><b>ADJUNTAR PDF REMITO</b></label>
                        </div>
                        <div class="input-group mb-3">
                          <input type="file" class="form-control" id="pdf_remito" name="pdf_remito" accept=".pdf" multiple required>
                          <label class="input-group-text" for="pdf">SUBIR</label>
                        </div>
                      </div>

                      <div class="form-group" >
                        <div id="captcha" class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>
                        <div id='errorRecaptcha' style='display:none; color:#a94442' required>    <span class='glyphicon glyphicon-exclamation-sign'></span>    Por favor, verifica que no seas un robot.</div>
                      </div>
                      <br>
                      <div class="d-grid gap-2 col-md-10 mx-auto">
                        <button id="boton_guardar" type="submit" class="btn btn-dark btn-lg" >Guardar</button>
                      </div>

                    </div>
                  </div>
              </form>
              </div>
            
            
            
              <div class="col-sm-6">
                <form action="">
                  <div class="card  text-white bg-secondary">
                    <div class="card-body">
                      <div id="entrega_producto">      
                        <label for="select_entrega_producto" class="form-label"><b>PRODUCTO RECIBIDO</b></label>
                        <select name="select_entrega_producto" id="select_entrega_producto" class="form-control text-center" onchange="showproducto(this)" required>
                          {{-- <option value="municipalidad">Municipalidad</option> --}}
                          <option value="beneficiario" >Otro beneficiario</option>          
                        </select>
                      </div>

                      <div>
                        <label for="porc_producto_recibido" class="form-label"><b>PORCENTAJE DEL PRODUCTO QUE SE ENTREGO</b></label>
                        <input type="number" class="form-control" id="porc_producto_recibido" name="porc_producto_recibido"  value="0" placeholder="ingrese el porcentaje del producto recibido" required>
                      </div>



                      {{-- id="elegir_archivos">
                        id="producto"> --}}
                          {{-- <label id="producto_municipalidad" for="pdf" class="form-label" ><b>ADJUNTAR PDF REMITO</b></label> --}}
                          {{-- <label id="producto_beneficiario" for="pdf" class="form-label" style="display: none;"><b>SUBIR ACTA DE ENTREGA</b></label> --}}
                      <div>
                        <div>
                          <label for="pdf_acta" class="form-label"><b>SUBIR ACTA DE ENTREGA</b></label>
                        </div>
                        <div class="input-group mb-3">
                          <input type="file" class="form-control" id="pdf_acta" name="pdf_acta" accept=".pdf" multiple required>
                          <label class="input-group-text" for="pdf">SUBIR</label>
                        </div>
                      </div>
                      <div class="form-group" >
                        <div id="captcha" class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>
                        <div id='errorRecaptcha' style='display:none; color:#a94442' required>    <span class='glyphicon glyphicon-exclamation-sign'></span>    Por favor, verifica que no seas un robot.</div>
                      </div>
                      <br>
                      <div class="d-grid gap-2 col-md-10 mx-auto">
                        <button id="boton_guardar" type="submit" class="btn btn-dark btn-lg" >Guardar</button>
                      </div>

                    </div>
                  </div>
                </form>
              </div>
            
          </div>  
        

        <!-- CONTABILIDAD -->
        <div class="d-grid gap-2 col-6 mx-auto">
          <button id="desplegarcontabilidad" type="button" class="btn btn-outline-primary btn-lg text-start" onclick="desplegarContabilidad()"> <i class="far fa-plus-square" style='font-size:23px;color:green'></i>    <b>CONTABILIDAD</b></button>
          <button id="replegarcontabilidad" type="button" class="btn btn-outline-primary btn-lg text-start" onclick="replegarContabilidad()" style="display: none;"> <i class="far fa-minus-square"  style='font-size:23px;color:red'></i>    <b>CONTABILIDAD</b></button>
        </div> 

          
          <form id="form_contabilidad" style ="display: none;" onsubmit="return miFuncion(this)" class="needs-validation" enctype="multipart/form-data" novalidate method="post" action="{{ url('empleado/ejecucionconvenio') }}">
            @csrf
              <div class="row g-3">

                <div class="col-md-3">
                    <label fior="num_factura" class="form-label"><b>NÚMERO DE FACTURA</b></label>
                    <input type="text" class="form-control" id="num_factura" name="num_factura"  value="" placeholder="ingrese número de la factura" required>
                </div>

                <div class="col-md-3">
                  <label for="fecha_emision" class="form-label"><b>FECHA EMISIÓN</b></label>
                  <input type="date"  class="form-control" id="fecha_emision" name="fecha_emision"  required>
                </div>
                <div class="col-md-6">
                    <label for="beneficiario" class="form-label"><b>BENEFICIARIO</b></label>
                    <input type="text" class="form-control" id="beneficiario" name="beneficiario"  value="" placeholder="ingrese el beneficiario" required>
                </div>
                <div class="col-md-3">
                    <label for="cuit" class="form-label"><b>CUIT/CUIL</b></label>
                    <input type="number" class="form-control" id="cuit" name="cuit"  value="" placeholder="ingrese el cuit o cuil" min="10000000000" max="99999999999" required>
                </div>
                <div class="col-md-3">
                    <label for="importe" class="form-label"><b>IMPORTE</b></label>
                    <input type="number" step=".01" class="form-control" id="importe" name="importe" min="0" value="0.00" placeholder="ingrese el importe" required>
                </div>
                <div class="col-md-3">
                    <label for="cae" class="form-label"><b>CAE</b></label>
                    <input type="number" class="form-control" id="cae" name="cae" min="0" placeholder="ingrese el numero CAE" required>
                </div>
                <div class="col-md-3">
                    <label for="nro_pago" class="form-label"><b>N° DE PAGO</b></label>
                    <input type="number" class="form-control" id="nro_pago" name="nro_pago" min="0" placeholder="ingrese el numero de pago" required>
                </div>

                <div id="elegir_archivos" class="col-md-6">
                  <label for="pdf_pago" class="form-label"><b>ADJUNTAR PDF DE LA FACTURA</b></label>
                  <div class="input-group mb-3">
                    <input type="file" class="form-control" id="pdf_pago" name="pdf_pago" accept=".pdf" required>
                    <label class="input-group-text" for="pdf">SUBIR</label>
                  </div>
                </div>
                
                <div id="elegir_archivos" class="col-md-6">
                  <label for="pdf_afip" class="form-label"><b>ADJUNTAR PDF DEL COMPROBANTE AFIP</b></label>
                  <div class="input-group mb-3">
                    <input type="file" class="form-control" id="pdf_afip" name="pdf_afip" accept=".pdf" required>
                    <label class="input-group-text" for="pdf_afip">SUBIR</label>
                  </div>
                </div>

                <div class="form-group" >
                  <div id="captcha" class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>
                  <div id='errorRecaptcha' style='display:none; color:#a94442' required>    <span class='glyphicon glyphicon-exclamation-sign'></span>    Por favor, verifica que no seas un robot.</div>
                </div>
                <div class="d-grid gap-2 col-md-10 mx-auto">
                  <button id="boton_guardar" type="submit" class="btn btn-primary btn-lg" >Guardar</button>
                </div>
              </div>
          </form>


          <!-- TESORERIA -->
          <div class="d-grid gap-2 col-6 mx-auto">
            <button id="desplegartesoreria" type="button" class="btn btn-outline-warning btn-lg text-start" onclick="desplegarTesoreria()"> <i class="far fa-plus-square" style='font-size:23px;color:green'></i>    <b>TESORERIA</b></button>
            <button id="replegartesoreria" type="button" class="btn btn-outline-warning btn-lg text-start" onclick="replegarTesoreria()" style="display: none;"> <i class="far fa-minus-square"  style='font-size:23px;color:red'></i>    <b>TESORERIA</b></button>
          </div>

          <form id="form_tesoreria" style ="display: none;" onsubmit="return miFuncion(this)" class="needs-validation" enctype="multipart/form-data" novalidate method="post" action="{{ url('empleado/ejecucionconvenio') }}">
              @csrf
                <div class="row g-3">

                  <div class="col-md-3">
                    <label for="fecha_pago" class="form-label"><b>FECHA DE PAGO</b></label>
                    <input type="date" class="form-control" id="fecha_pago" name="fecha_pago"  required>
                  </div>

                  <div class="col-md-6">
                    <label id="recibo_pago" for="recibo_pago" class="form-label"><b>ADJUNTAR PDF DEL RECIBO DE PAGO</b></label>
                    <div class="input-group mb-3">
                      <input type="file" class="form-control" id="recibo_pago" name="recibo_pago" accept=".pdf" required>
                      <label class="input-group-text" for="recibo_pago">SUBIR</label>
                    </div>

                  </div>
                  <div class="form-group" >
                    <div id="captcha" class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>
                    <div id='errorRecaptcha' style='display:none; color:#a94442' required>    <span class='glyphicon glyphicon-exclamation-sign'></span>    Por favor, verifica que no seas un robot.</div>
                  </div>
                  <div class="d-grid gap-2 col-md-10 mx-auto">
                    <button id="boton_guardar" type="submit" class="btn btn-warning btn-lg" >Guardar</button>
                  </div>

                </div>
            </form>




        <!-- <form id="form_guardardatos" onsubmit="return miFuncion(this)" class="needs-validation" enctype="multipart/form-data" novalidate method="post" action="{{ url('empleado/ejecucionconvenio') }}">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
                {{-- @php echo "$registro->cuenta_bancaria" @endphp --}}

                <label for="select_ejecucion" class="form-label"><b>TIPO DE EJECUCIÓN</b></label>
                <select name="select_ejecucion" id="select_ejecucion" class="form-control text-center" disabled="true" onchange="showDiv(this)" required>
                  <option value="obra">Obra</option>
                  <option value="producto" >Entrega de producto</option>          
                </select>

            </div>
            <div id="entrega_producto" style="display: none;" class="col-md-6">
              {{-- @php echo "$registro->cuenta_bancaria" @endphp --}}

              <label for="select_entrega_producto" class="form-label"><b>PRODUCTO ENTREGADO</b></label>
              <select name="select_entrega_producto" id="select_entrega_producto" class="form-control text-center" onchange="showproducto(this)" required>
                <option value="municipalidad">Municipalidad</option>
                <option value="beneficiario" >Otro beneficiario</option>          
              </select>

          </div>

            <div id="elegir_archivos" class="col-md-6">
              <label id="obra" for="pdf" class="form-label"><b>SUBIR CERTIFICADO DE OBRA Y FORMULARIOS CORRESPONDIENTE</b></label>
              <div id="producto">
                <label id="producto_municipalidad" for="pdf" class="form-label" style="display: none;"><b>SUBIR REMITO</b></label>
                <label id="producto_beneficiario" for="pdf" class="form-label" style="display: none;"><b>SUBIR ACTA DE ENTREGA</b></label>
              </div>

              <div class="input-group mb-3">
                <input type="file" class="form-control" id="pdf" name="pdf" accept=".pdf" multiple disabled="true" required>
                <label class="input-group-text" for="pdf">SUBIR</label>
              </div>

            </div>

            <div class="col-md-6">
              {{-- @php echo "$registro->cuenta_bancaria" @endphp --}}

              <label for="monto_pagado" class="form-label"><b>MONTO ABONADO</b></label>
              <input type="number" class="form-control" id="monto_pagado" name="monto_pagado" min="0" step="0.01" value="0.00" disabled="true" required/>
            </div>

            <div class="form-group" >
              <div id="captcha" class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-' style='display:none;'></div>
              <div id='errorRecaptcha' style='display:none; color:#a94442' required>    <span class='glyphicon glyphicon-exclamation-sign'></span>    Por favor, verifica que no seas un robot.</div>
            </div>


            <div class="col-md-6 d-grid gap-2">
              <button id="boton_editar" type="button" class="btn btn-secondary btn-lg" onclick="sacarReadOnly()">Editar</button>
            </div>
              <div class="d-grid gap-2 col-md-6 mx-auto">
                <button id="boton_guardar" type="submit" class="btn btn-primary btn-lg" disabled="true">Guardar</button>
              </div>
              @if (!empty($registro))
                <input id="id_etapas" name="id_etapas" type="hidden" value="{{ $registro->id_etapas}}">        
              @else 
                <input id="id_etapas" name="id_etapas" type="hidden" value="{{ $id_etapas }}">  
              @endif
            
          </div>
        </form>   -->
        
    </div>	

  </article>

<br>

@endsection

@section('js')
<script src='https://www.google.com/recaptcha/api.js?hl=es' async defer> </script>
<script src="{{ asset('/assets/bootstrap-datepicker-1.7.1/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script>

<script>
  function desplegarCompra() {
    var desplegarcompra = document.getElementById('desplegarcompra');
    var replegarcompra = document.getElementById('replegarcompra');
    var form_compra = document.getElementById('form_compra');
    
      desplegarcompra.style.display = 'none';
      replegarcompra.style.display = 'inline';
      form_compra.style.display = 'inline';


  }
  function replegarCompra(){
    var desplegarcompra = document.getElementById('desplegarcompra');
    var replegarcompra = document.getElementById('replegarcompra');
    var form_compra = document.getElementById('form_compra');
    
    desplegarcompra.style.display = 'inline';
    replegarcompra.style.display = 'none';
    form_compra.style.display = 'none';
  }
</script>

<script>

  function desplegarContabilidad() {
      var desplegarcontabilidad = document.getElementById('desplegarcontabilidad');
      var replegarcontabilidad = document.getElementById('replegarcontabilidad');
      var form_contabilidad = document.getElementById('form_contabilidad');
      
      desplegarcontabilidad.style.display = 'none';
      replegarcontabilidad.style.display = 'inline';
      form_contabilidad.style.display = 'inline';


    }
  function replegarContabilidad(){
    var desplegarcontabilidad = document.getElementById('desplegarcontabilidad');
    var replegarcontabilidad = document.getElementById('replegarcontabilidad');
    var form_contabilidad = document.getElementById('form_contabilidad');
    
    desplegarcontabilidad.style.display = 'inline';
    replegarcontabilidad.style.display = 'none';
    form_contabilidad.style.display = 'none';
  }
</script>

<script>

  function desplegarTesoreria() {
      var desplegartesoreria = document.getElementById('desplegartesoreria');
      var replegartesoreria = document.getElementById('replegartesoreria');
      var form_tesoreria = document.getElementById('form_tesoreria');
      
      desplegartesoreria.style.display = 'none';
      replegartesoreria.style.display = 'inline';
      form_tesoreria.style.display = 'inline';

    }
  function replegarTesoreria(){
    var desplegartesoreria = document.getElementById('desplegartesoreria');
    var replegartesoreria = document.getElementById('replegartesoreria');
    var form_tesoreria = document.getElementById('form_tesoreria');
    
    desplegartesoreria.style.display = 'inline';
    replegartesoreria.style.display = 'none';
    form_tesoreria.style.display = 'none';
  }
</script>

{{-- FISICA --}}
<script>

  function desplegarFisica() {
    
      // var x = document.getElementById("tipo_rendicion");
      var tipo_rendicion = document.getElementById("tipo_rendicion").value;
      var desplegarfisica = document.getElementById('desplegarfisica');
      var replegarfisica = document.getElementById('replegarfisica');
      var form_obra_fisica = document.getElementById('form_obra_fisica');
      var form_entrega_fisica = document.getElementById('form_entrega_fisica');

      desplegarfisica.style.display = 'none';
      replegarfisica.style.display = 'inline';

      if(tipo_rendicion == "obra")
      {
        form_obra_fisica.style.display = 'inline';
      }
      else{
        form_entrega_fisica.style.display = 'inline';
      }

      


    }
  function replegarFisica(){
    var tipo_rendicion = document.getElementById("tipo_rendicion").value;
      var desplegarfisica = document.getElementById('desplegarfisica');
      var replegarfisica = document.getElementById('replegarfisica');
      var form_obra_fisica = document.getElementById('form_obra_fisica');
      var form_entrega_fisica = document.getElementById('form_entrega_fisica');
    
    desplegarfisica.style.display = 'inline';
    replegarfisica.style.display = 'none';

    if(tipo_rendicion == "obra")
      {
        form_obra_fisica.style.display = 'none';
      }
      else{
        form_entrega_fisica.style.display = 'none';
      }
  }
</script>


<script>
  function sacarReadOnly() {
    
    document.getElementById("select_ejecucion").disabled = false;
  //   document.getElementById("condicion_rendicion").readOnly = false;
    document.getElementById("pdf").disabled = false;
    $("#captcha").show();
    
    document.getElementById("monto_pagado").disabled = false;
    document.getElementById("boton_guardar").disabled = false;
    document.getElementById("boton_editar").disabled = true;
  }
</script>

<script>

function showDiv(element)
{
    var select_ejecucion = document.getElementById("select_ejecucion").value;
    var obra = document.getElementById("obra");
    var producto = document.getElementById("producto");
    var select_entrega_producto = document.getElementById("select_entrega_producto").value;
    var entrega_producto = document.getElementById("entrega_producto");
    var elegir_archivos = document.getElementById("elegir_archivos");
    var producto_municipalidad = document.getElementById("producto_municipalidad");

    if (select_ejecucion == "obra") 
    { 
        elegir_archivos.style.display = "";
        entrega_producto.style.display = "none";
        producto.style.display = "none";
        obra.style.display = "block";

    }
    else { 
        obra.style.display = "none";
        entrega_producto.style.display = "block";
        producto.style.display = "block";
        if(select_entrega_producto == "municipalidad")
        {
          producto_municipalidad.style.display = "block";
        }else
        {
          producto_municipalidad.style.display = "none";
        }

        elegir_archivos.style.display = "block";
        // producto.style.display = "block";
    }
}

</script>

<script>

  function showproducto(element)
  {
      // var select_ejecucion = document.getElementById("select_ejecucion").value;
      // var obra = document.getElementById("obra");
      var producto_beneficiario = document.getElementById("producto_beneficiario");
      var producto_municipalidad = document.getElementById("producto_municipalidad");
      var entrega_producto = document.getElementById("entrega_producto");
      var elegir_archivos = document.getElementById("elegir_archivos");
      var producto = document.getElementById("producto");
      var select_entrega_producto = document.getElementById("select_entrega_producto").value;

      elegir_archivos.style.display = "block";
      producto.style.display = "block";

      if (select_entrega_producto == "municipalidad") 
      { 
        // alert(select_entrega_producto);
          producto_beneficiario.style.display = "none";
          
          producto_municipalidad.style.display = "block";
          // obra.style.display = "block";
  
      }
      else { 
        
        producto_municipalidad.style.display = "none";
        producto_beneficiario.style.display = "block";
          // producto.style.display = "block";
      }
  }
  
  </script>

<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
  </script>


<script>
  function miFuncion(a) {
      var response = grecaptcha.getResponse();
      if(response.length == 0){
          // alert("Captcha no verificado");
          
          $("#errorRecaptcha").show();
          toastr.error("validar reCAPTCHA", 'VERIFICA QUE NO SOS UN ROBOT', {
                      // "progressBar": true,
                      "closeButton": true,
                      "positionClass": "toast-top-right",
                      "timeOut": "10000",
                  });  
          return false;
        event.preventDefault();
      } else {
      //   alert("Captcha verificado");
        return true;
      }
    }
  </script>
@endsection