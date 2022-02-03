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
      <div class="col-11 col-sm-11 col-md-10 col-lg-10 d-flex flex-column mx-auto p-0 my-4 gap-3">
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
        <form id="form_guardardatos" onsubmit="return miFuncion(this)" class="needs-validation" enctype="multipart/form-data" novalidate method="post" action="{{ url('empleado/ejecucionconvenio') }}">
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
                <label class="input-group-text" for="pdf">Subir</label>
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
        </form>  
        
    </div>	

  </article>

<br>

@endsection

@section('js')
<script src='https://www.google.com/recaptcha/api.js?hl=es' async defer> </script>
<script src="{{ asset('/assets/bootstrap-datepicker-1.7.1/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script>


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