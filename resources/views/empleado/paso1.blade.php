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
          <h4 class="card-title">CONVENIO FIRMADO</h4>
        </div>                  
    </div>
  </div>
</div>

    <article class="container col-12 mx-auto p-0">
      <div class="col-11 col-sm-11 col-md-10 col-lg-10 d-flex flex-column mx-auto p-0 my-4 gap-3">
        @if ("$registro->nombre_archivo" != '')
        <div class="col-md-6">
          <label for="firma" class="form-label"><b>VER CONVENIO FIRMADO POR PDF</b></label>
          <div class="mb-3 mx-auto">
            {{-- <button id="firma" class="btn btn-primary btn-lg" ><i class="fas fa-eye"></i> VER CONVENIO</button> --}}
            <a href="{{url('empleado/verconvenio',['id' => $registro->id_etapas, 'paso' => 'paso1', 'pdf' => $registro->nombre_archivo])}}" target="_blank" class="btn btn-primary btn-lg">
              <i class="fas fa-eye" aria-hidden="true" ></i> VER CONVENIO
         </a>
          </div>
        </div>
      @endif 
        <form id="form_editardatos" onsubmit="return miFuncion(this)" class="needs-validation" enctype="multipart/form-data" novalidate method="post" action="{{ url('empleado/editarconvenio') }}">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
                <label for="organismo_financiador" class="form-label"><b>ORGANISMO FINANCIADOR</b></label>
                <input type="text" class="form-control" id="organismo_financiador" name="organismo_financiador"  value="{{ $registro->organismo_financiador }}" placeholder="ingrese el organismo que financia el proyecto" readonly required>
            </div>
            <div class="col-md-6">
                <label for="nombre_proyecto" class="form-label"><b>NOMBRE DEL PPROYECTO</b></label>
                <input type="text" class="form-control" id="nombre_proyecto" name="nombre_proyecto" value="{{ $registro->nombre_proyecto }}" placeholder="ingrese el nombre del proyecto" readonly required>
            </div>
            <div class="col-md-6">
                <label for="monto" class="form-label"><b>MONTO</b></label>
                <input type="number" step=".01" class="form-control" id="monto" name="monto" min="0" value="{{ $registro->monto }}" placeholder="ingrese el monto" readonly required>
            </div>
            <div class="col-md-6">
                @php $comun = ""; @endphp
                @php $nueva = ""; @endphp

                @if ("$registro->cuenta_bancaria" == 'comun')
                    @php $comun = "selected"; @endphp
                    
                @endif
                @if ("$registro->cuenta_bancaria" == 'nueva')
                    @php $nueva = "selected"; @endphp
                @endif

                {{-- @php echo "$registro->cuenta_bancaria" @endphp --}}

                <label for="select_cuenta" class="form-label"><b>CUENTA BANCARIA</b></label>
                <select name="select_cuenta" id="select_cuenta" class="form-control text-center" disabled="true" required>

                  <option value="comun" {{ $comun }}>comun</option>
                  <option value="nueva" {{ $nueva }}>nueva</option>
                </select>

            </div>

            <div class="col-md-3">
              <label for="fecha_carga" class="form-label"><b>FECHA CARGA</b></label>
              <input type="datetime" placeholder="dd-MM-dd HH:mm:ss" class="form-control" id="fecha_carga" name="fecha_carga" value="{{ $registro->created_at->format('d-m-Y H:i:s') }}" readonly>
            </div>

            <div class="col-md-3">
              <label for="fecha_inicio" class="form-label"><b>FECHA INICIO</b></label>
              <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" placeholder="ingrese fecha desde" value="{{ $registro->fecha_inicio }}" readonly required>
            </div>
            <div class="col-md-3">
              <label for="fecha_finalizacion" class="form-label"><b>FECHA FINALIZACIÓN</b></label>
              <input type="date" class="form-control" id="fecha_finalizacion" name="fecha_finalizacion" placeholder="ingrese fecha de finalización" value="{{ $registro->fecha_finalizacion }}" readonly required>
            </div>
            <div class="col-md-3">
              <label for="fecha_rendicion" class="form-label"><b>FECHA RENDICIÓN</b></label>
              <input type="date" class="form-control" id="fecha_rendicion" name="fecha_rendicion" placeholder="ingrese fecha de rendición" value="{{ $registro->fecha_rendicion }}" readonly required>
            </div>


            <div class="col-md-6">
              <label for="condicion_rendicion" class="form-label"><b>CONDICIÓN DE RENDICIÓN</b></label>
              <input type="text" class="form-control" id="condicion_rendicion" name="condicion_rendicion"  value="{{ $registro->tipo_rendicion }}" placeholder="ingrese la condición de rendición" readonly required>
            </div>
            <div class="col-md-6">
              <label for="condicion_rendicion" class="form-label"><b>FIRMA CON PDF</b></label>
              <div class="input-group mb-3">
                <input type="file" class="form-control" id="pdf" name="pdf" accept=".pdf" disabled="true" required>
                <label class="input-group-text" for="pdf">Subir</label>
              </div>
            </div>

            <div class="form-group" >
              <div id="captcha" class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-' style='display:none;'></div>
              <div id='errorRecaptcha' style='display:none; color:#a94442' required>    <span class='glyphicon glyphicon-exclamation-sign'></span>    Por favor, verifica que no seas un robot.</div>
            </div>


            <div class="col-md-6 d-grid gap-2">
              <button id="boton_editar" type="button" class="btn btn-secondary btn-lg" onclick="sacarReadOnly()">Editar</button>
            </div>
              <div class="d-grid gap-2 col-6 mx-auto">
                <button id="boton_guardar" type="submit" class="btn btn-primary btn-lg" disabled="true">Guardar</button>
              </div>
            
              <input id="id_etapas" name="id_etapas" type="hidden" value="{{ $registro->id_etapas}}">        
            
            
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
  document.getElementById("organismo_financiador").readOnly = false;
  document.getElementById("nombre_proyecto").readOnly = false;
  document.getElementById("monto").readOnly = false;
  document.getElementById("select_cuenta").disabled = false;
  document.getElementById("boton_guardar").disabled = false;
  document.getElementById("fecha_inicio").readOnly = false;
  document.getElementById("fecha_finalizacion").readOnly = false;
  document.getElementById("fecha_rendicion").readOnly = false;
  document.getElementById("pdf").disabled = false;
  $("#captcha").show();

  document.getElementById("boton_editar").disabled = true;
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