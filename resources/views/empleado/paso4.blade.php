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
          <h4 class="card-title">CONVENIO FINALIZADO RENDIDO</h4>
        </div>                  
    </div>
  </div>
</div>

    <article class="container col-12 mx-auto p-0">
      <div class="col-11 col-sm-11 col-md-10 col-lg-10 d-flex flex-column mx-auto p-0 my-4 gap-3">
        <form id="form_editardatos" class="needs-validation" enctype="multipart/form-data" novalidate method="post" action="{{ url('empleado/conveniofinalizadorendido') }}">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
                {{-- @php echo "$registro->cuenta_bancaria" @endphp --}}

                <label for="dictamen" class="form-label"><b>DICTAMENES</b></label>
                <input type="text" class="form-control" id="dictamen" name="dictamen"  value="" placeholder="ingrese el dictamen" required>

            </div>
            {{-- <div class="col-md-6"> --}}
                {{-- <input id="input-b3" name="input-b3[]" type="file" class="file" multiple  id = "entrada-b3" nombre = "entrada-b3[]" tipo = "archivo" clase = "archivo" múltiple     
                    data-show-upload = "false" data-show-caption = "true" data-msg-placeholder = "Seleccione {archivos} para cargar..." >   --}}
            
            {{-- </div> --}}
            <div class="col-md-6">
              <label for="pdf" class="form-label"><b>SUBIR DICTAMENES DE RENDICIÓN</b></label>
              <div class="input-group mb-3">
                <input type="file" class="form-control" id="pdf" name="pdf" accept=".pdf" required>
                <label class="input-group-text" for="pdf">Subir</label>
              </div>
            </div>            

            <div class="d-grid gap-2 col-6 mx-auto">
              <button id="boton_guardar" type="submit" class="btn btn-primary btn-lg" >Guardar</button>
            </div>
            @if (!empty($registro))
              <input id="id_etapas" name="id_etapas" type="hidden" value="{{ $registro->id_etapas}}">        
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
  <script>
    @if (Session::get('status_agregado'))
            toastr.success( 'Dictamen cargado!!!', 'Éxito', {
                // "progressBar": true,
                "closeButton": true,
                "positionClass": "toast-bottom-right",
                "timeOut": "10000",
            });   
    @endif 
  </script>
@endsection