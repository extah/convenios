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
          <h4 class="card-title">CONVENIO PENDIENTE DE RENDICIÓN</h4>
        </div>                  
    </div>
  </div>
</div>

<article class="container col-12 mx-auto p-0"> 

  {{-- CONVENIO FIRMADO --}}
  
  @if ($if_paso1 == 1)
  
    <div class="row">
        <div class="col-sm-12  p-1">
          <div class="card">
            
            <div class="card-header text-center"  style="background-color: #9e151c; color:beige"><b>CONVENIO FIRMADO</b></div>
            <div class="card-body">
              @foreach ($datos_paso1 as $dato_paso1)
                <h5 class="card-title"><b>* </b>{{ $dato_paso1 }}</h5>
              @endforeach
              {{-- <h5 class="card-title">Emma</h5> --}}
              <p class="card-text">
                {{-- {{ $paso1[0]->nombre_proyecto }} --}}
              </p>
              {{-- <a href="{{route('empleado.verconvenio', '')}}" + "/"+id;" class="btn btn-info"><i class="fas fa-eye"></i> VER</a> --}}
              {{-- <a href="{{url('empleado/verconvenio',['id' => $paso1[0]->id_etapas, 'paso' => 'paso1'])}}" class="btn btn-info"><i class="fas fa-eye"></i> VER</a> --}}
              
            </div>
          </div>
        </div>
    </div>
  @else
  @endif

  {{-- COMPRA --}}
  @if (true)
    <div class="row">
      @foreach($arreglo_completo as $arreglo)
        <div class="col-sm-6  p-1">
          <div class="card">
            
            <div class="card-header"  style="background-color: #3f4348; color:beige"><b>COMPRA N° :  {{ $arreglo[0] }}</b></div>
            <div class="card-body">
              @for ($i = 1; $i < count($arreglo) ; $i++)
                  <h5><b>* </b>{{ $arreglo[$i] }}</h5>
              @endfor   
            </div>
          </div>
        </div>
      @endforeach

    </div>
  @else
  <div class="col-sm-12  p-1">
    <div class="card">
      
      <div class="card-header text-center"  style="background-color: #3f4348; color:beige">PROYECTO OBRA 1</div>
      <div class="card-body">
        <h5 class="card-title text-center">NO POSEE NINGUNA COMPRA</h5>
        <p class="card-text">
          {{-- {{ $paso1[0]->nombre_proyecto }} --}}
        </p>
        {{-- <a href="{{route('empleado.verconvenio', '')}}" + "/"+id;" class="btn btn-info"><i class="fas fa-eye"></i> VER</a> --}}
        {{-- <a href="{{url('empleado/verconvenio',['id' => $paso1[0]->id_etapas, 'paso' => 'paso1'])}}" class="btn btn-info"><i class="fas fa-eye"></i> VER</a> --}}
        
      </div>
    </div>
  </div>
  @endif

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
@endsection