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
          <h5 class="card-title">VER LOS PDF DEL CONVENIO</h5>
        </div>                  
    </div>
  </div>
</div>


<div class="col-11 col-sm-11 col-md-10 col-lg-10 d-flex flex-column mx-auto p-0 my-4 gap-3">
        @if (true)
            <div class="col-md-6">
                <label for="firma" class="form-label"><b>VER CONVENIO FIRMADO POR PDF</b></label>
                <div class="mb-3 mx-auto">
                    <a href="{{url('empleado/verpdf',['id' => $paso1->id_etapas])}}" target="_blank" class="btn btn-primary btn-lg">
                        <i class="fas fa-eye" aria-hidden="true" ></i> VER CONVENIO FIRMADO
                    </a>
                </div>
            </div>
        @endif 
</div>  
<article class="container col-12 mx-auto p-0">
  
    @if(true)        
        <div class="row">
            @foreach ($compras as $compra)
                <div class="col-sm-6  p-1">
                    <div class="card">
                        
                        <div class="card-header text-center"  style="background-color: #0B615E; color:beige"><b>ORDEN DE COMPRA {{ $compra->orden_compra }}</b></div>
                        <div class="card-body">
                            <h5>PDF ORDEN DE COMPRA</h5>
                            <div class="mb-2 mx-auto">
                                <a href="{{url('empleado/verpdf',['id' => $paso1->id_etapas])}}" target="_blank" class="btn btn-primary btn-lg">
                                    <i class="fas fa-eye" aria-hidden="true" ></i> {{ $compra->nombre_archivo }}
                                </a>
                            </div>
                            @if(true)
                                <h5>PDF FISICA</h5>
                                @foreach ($fisica_obras as $fisica_obra)
                                    @if($fisica_obra->id_compra == $compra->id)
                                        <div class="mb-2 mx-auto">
                                            <a href="{{url('empleado/verpdf',['id' => $paso1->id_etapas])}}" target="_blank" class="btn btn-primary btn-lg">
                                                <i class="fas fa-eye" aria-hidden="true" ></i> {{ $fisica_obra->nombre_archivo }}
                                            </a>
                                        </div>
                                    @endif    
                                @endforeach
                            @endif
                            @if(true)
                                <h5>PDF CONTABILIDAD</h5>
                                @foreach ($contabilidads as $contabilidad)
                                    @if($contabilidad->id_compra == $compra->id)
                                        <div class="mb-2 mx-auto">
                                            <a href="{{url('empleado/verpdf',['id' => $paso1->id_etapas])}}" target="_blank" class="btn btn-primary btn-lg">
                                                <i class="fas fa-eye" aria-hidden="true" ></i> {{ $contabilidad->nombre_archivo_factura }}
                                            </a>
                                        </div>
                                        <div class="mb-2 mx-auto">
                                            <a href="{{url('empleado/verpdf',['id' => $paso1->id_etapas])}}" target="_blank" class="btn btn-primary btn-lg">
                                                <i class="fas fa-eye" aria-hidden="true" ></i> {{ $contabilidad->nombre_archivo_comprobante_afip }}
                                            </a>
                                        </div>
                                    @endif    
                                @endforeach
                            @endif     
                            @if(true)
                                <h5>PDF TESORERIA</h5>
                                @foreach ($tesorerias as $tesoreria)
                                    @if($tesoreria->id_compra == $compra->id)
                                        <div class="mb-2 mx-auto">
                                            <a href="{{url('empleado/verpdf',['id' => $paso1->id_etapas])}}" target="_blank" class="btn btn-primary btn-lg">
                                                <i class="fas fa-eye" aria-hidden="true" ></i> {{ $tesoreria->nombre_archivo_pago }}
                                            </a>
                                        </div>
                                    @endif    
                                @endforeach
                            @endif 
                        </div>
                    </div>
                </div>
            @endforeach    
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
  document.getElementById("organismo_financiador").readOnly = false;
  document.getElementById("nombre_proyecto").readOnly = false;
  document.getElementById("monto").readOnly = false;
  document.getElementById("monto_recibido").readOnly = false;
  document.getElementById("fecha_inicio").readOnly = false;
  document.getElementById("fecha_finalizacion").readOnly = false;
  document.getElementById("fecha_rendicion").readOnly = false;

  document.getElementById("select_cuenta").disabled = false;
  document.getElementById("boton_guardar").disabled = false;
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