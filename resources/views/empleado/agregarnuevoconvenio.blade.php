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
          <h4 class="card-title">Nuevo convenio</h4>
        </div>                  
    </div>
  </div>
</div>

    <article class="container col-12 mx-auto p-0">
      <div class="col-11 col-sm-11 col-md-10 col-lg-10 d-flex flex-column mx-auto p-0 my-4 gap-3">
        <form id="form_editardatos" onsubmit="return miFuncion(this)" class="needs-validation" novalidate method="post" action="{{ url('empleado/agregarconvenio') }}">
          @csrf
          <div class="row g-3">
            
            <div class="col-md-6">
                <label for="organismo_financiador" class="form-label"><b>ORGANISMO FINANCIADOR</b></label>
                <input type="text" class="form-control" id="organismo_financiador" name="organismo_financiador" placeholder="ingrese el organismo que financia el proyecto" required>
            </div>

            <div class="col-md-6">
                <label for="nombre_proyecto" class="form-label"><b>NOMBRE DEL PPROYECTO</b></label>
                <input type="text" class="form-control" id="nombre_proyecto" name="nombre_proyecto" placeholder="ingrese el nombre del proyecto" required>
            </div>

            <div class="col-md-6">
                <label for="monto" class="form-label"><b>MONTO</b></label>
                <input type="number" step=".01" class="form-control" id="monto" name="monto" min="0" value="0.00" placeholder="ingrese el monto" required>
            </div>

            <div class="col-md-3">
                <label for="dni" class="form-label"><b>CUENTA BANCARIA</b></label>
                <select name="select_cuenta" id="select_cuenta" class="form-control text-center" required>
                  <option value="">-Seleccion&aacute el tipo de cuenta-</option>
                  <option value="comun" offset="1">comun</option>
                  <option value="nueva" offset="2">nueva</option>
                </select>
            </div>

            <div class="col-md-3">
              <label for="cbu" class="form-label"><b>CBU CUENTA BANCARIA</b></label>
              <input type="number" class="form-control" id="cbu" name="cbu" min="0" placeholder="ingrese el cbu" required>
            </div>

            <div class="col-md-6">
              <label for="select_ejecucion" class="form-label"><b>TIPO DE EJECUCIÓN</b></label>
              <select name="select_ejecucion" id="select_ejecucion" class="form-control text-center" required>
                <option value="obra">Obra</option>
                <option value="producto" >Entrega de producto</option>          
              </select>
            </div>

            <div class="col-md-3">
              <label for="fecha_inicio" class="form-label"><b>FECHA INICIO</b></label>
              <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" placeholder="ingrese fecha de inicio">
            </div>

            <div class="col-md-3">
              <label for="fecha_finalizacion" class="form-label"><b>FECHA FINALIZACIÓN</b></label>
              <input type="date" class="form-control" id="fecha_finalizacion" name="fecha_finalizacion" placeholder="ingrese fecha de finalizacón estimada" required>
            </div>

            <div class="col-md-3">
              <label for="fecha_rendicion" class="form-label"><b>FECHA RENDICION</b></label>
              <input type="date" class="form-control" id="fecha_rendicion" name="fecha_rendicion" placeholder="ingrese fecha de rendición">
            </div>


            <div class="form-group" >
              <div class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>
              <div id='errorRecaptcha' style='display:none; color:#a94442' required>    <span class='glyphicon glyphicon-exclamation-sign'></span>    Por favor, verifica que no seas un robot.</div>
            </div>
              <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" class="btn btn-primary btn-lg">Iniciar convenio</button>
              </div>
    
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