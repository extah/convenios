@extends('template/template')

@section('css')

            <link href="{{ asset('/assets/bootstrap-datepicker-1.7.1/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
            <style>
                .formItem{
                    display: block;
                    text-align: center;
                    line-height: 200%;
                }
                .btn-primary {
                color: rgba(255, 255, 255, 0.87);;
                background-color: #321fdb !important;
                border-color: #321fdb !important
                }

                .btn-primary:hover {
                color: rgba(255, 255, 255, 0.87);
                background-color: #5141e0 !important;
                border-color: #5141e0 !important
                }

                .btn-primary:focus,
                .btn-primary.focus {
                box-shadow: 0 0 0 .2rem rgba(50, 31, 219, 0.5);
                }

                .btn-primary.disabled,
                .btn-primary:disabled {
                color: rgba(255, 255, 255, 0.87);
                background-color: #321fdb;
                border-color: #4735df
                } 

                .btn-primary:active{
                    background-color: #5141e0 !important;
                    border-color: #5141e0 !important;
                }

                .btn-convenio {
                color: rgba(255, 255, 255, 0.87);;
                background-color: #407406 !important;
                border-color: #407406 !important
                }

                .btn-convenio:hover {
                color: rgba(255, 255, 255, 0.87);
                background-color: #6fc50d !important;
                border-color: #6fc50d !important
                }

                .btn-rendicion {
                color: rgba(255, 255, 255, 0.87);;
                background-color: #066774 !important;
                border-color: #066774 !important
                }

                .btn-rendicion:hover {
                color: rgba(255, 255, 255, 0.87);
                background-color: #0aafc5 !important;
                border-color: #0aafc5 !important
                }

                
            </style>
@endsection

@section('content')
<br>
<div class="container">
  <div class="col-8 col-sm-6 col-md-6 mx-auto">
    <div class="card text-white bg-primary mb-3" style="max-width: 100rem;">
        <div class="card-body text-center">
          <h5 class="card-title">VER LOS PDF DEL CONVENIO</h5>
        </div>                  
    </div>
  </div>
</div>



<article class="container col-sm-12 mx-auto p-1">
        
            <div class="col-sm-12 mb-3">
                @if ($paso1->nombre_archivo != null)
                    <div class="card text-center">
                        <div class="card-header" style="background-color: #407406; color:beige">
                        <B>CONVENIO</B> 
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $paso1->nombre_proyecto }}</h5>
                            <p class="card-text">Convenio en formato PDF completo y firmado.</p>
                            <a href="{{url('empleado/verpdf',['id' => $paso1->id_etapas, 'tipo' => 'firma', 'nombre_archivo' => $paso1->nombre_archivo])}}" target="_blank" class="btn btn-convenio">
                                <i class="fas fa-eye" aria-hidden="true" ></i> VER CONVENIO
                            </a>
                        </div>
                        <div class="card-footer text-muted">
                            Última actualización {{ $paso1->updated_at->format('d-m-Y H:i:s') }}
                        </div>
                    </div>
                @else
                <h2>*)EL PDF DEL CONVENIO NO EXISTE</h2>

                @endif   
            </div>
        
    @if($compras->count() > 0)
        <div class="row">
            @foreach ($compras as $compra)
                <div class="col-sm-6 mb-3">
                    <div class="card border-dark" style="">
                        
                        <div class="card-header text-center" style="background-color: #321fdb; color:beige"><b>ORDEN DE COMPRA '{{ $compra->orden_compra }}'</b></div>
                        <div class="card-body">
                            <h5>PDF ORDEN DE COMPRA</h5>
                            <div class="mb-2 mx-auto">
                                <a href="{{url('empleado/verpdf',['id' => $paso1->id_etapas, 'tipo' => 'compras', 'nombre_archivo' => $compra->nombre_archivo])}}" target="_blank" class="btn btn-primary" >
                                    <i class="fas fa-eye" aria-hidden="true" ></i> {{ $compra->nombre_archivo }}
                                </a>
                            </div>
                            @if($fisica_obras->count() > 0)
                                <h5>PDF FISICA</h5>
                                @foreach ($fisica_obras as $fisica_obra)
                                    @if($fisica_obra->id_compra == $compra->id)
                                        <div class="mb-2 mx-auto">
                                            <a href="{{url('empleado/verpdf',['id' => $paso1->id_etapas, 'tipo' => 'fisica_obra', 'nombre_archivo' => $fisica_obra->nombre_archivo])}}" target="_blank" class="btn btn-primary">
                                                <i class="fas fa-eye" aria-hidden="true" ></i> {{ $fisica_obra->nombre_archivo }}
                                            </a>
                                        </div>
                                    @endif    
                                @endforeach
                            @endif
                            @if($contabilidads->count() > 0)
                                <h5>PDF CONTABILIDAD</h5>
                                @foreach ($contabilidads as $contabilidad)
                                    @if($contabilidad->id_compra == $compra->id)
                                        <div class="mb-2 mx-auto">
                                            <a href="{{url('empleado/verpdf',['id' => $paso1->id_etapas, 'tipo' => 'contabilidad', 'nombre_archivo' => $contabilidad->nombre_archivo_factura])}}" target="_blank" class="btn btn-primary">
                                                <i class="fas fa-eye" aria-hidden="true" ></i> {{ $contabilidad->nombre_archivo_factura }}
                                            </a>
                                        </div>
                                        <div class="mb-2 mx-auto">
                                            <a href="{{url('empleado/verpdf',['id' => $paso1->id_etapas, 'tipo' => 'contabilidad', 'nombre_archivo' => $contabilidad->nombre_archivo_comprobante_afip])}}" target="_blank" class="btn btn-primary">
                                                <i class="fas fa-eye" aria-hidden="true" ></i> {{ $contabilidad->nombre_archivo_comprobante_afip }}
                                            </a>
                                        </div>
                                        <div class="mb-2 mx-auto">
                                            <a href="{{url('empleado/verpdf',['id' => $paso1->id_etapas, 'tipo' => 'contabilidad', 'nombre_archivo' => $contabilidad->nombre_archivo_constancia_inscripcion])}}" target="_blank" class="btn btn-primary">
                                                <i class="fas fa-eye" aria-hidden="true" ></i> {{ $contabilidad->nombre_archivo_constancia_inscripcion }}
                                            </a>
                                        </div>
                                        <div class="mb-2 mx-auto">
                                            <a href="{{url('empleado/verpdf',['id' => $paso1->id_etapas, 'tipo' => 'contabilidad', 'nombre_archivo' => $contabilidad->nombre_archivo_comprobante_actividades])}}" target="_blank" class="btn btn-primary">
                                                <i class="fas fa-eye" aria-hidden="true" ></i> {{ $contabilidad->nombre_archivo_comprobante_actividades }}
                                            </a>
                                        </div>
                                    @endif    
                                @endforeach
                            @endif     
                            @if($tesorerias->count() > 0)
                                <h5>PDF TESORERIA</h5>
                                @foreach ($tesorerias as $tesoreria)
                                    @if($tesoreria->id_compra == $compra->id)
                                        <div class="mb-2 mx-auto">
                                            <a href="{{url('empleado/verpdf',['id' => $paso1->id_etapas, 'tipo' => 'tesoreria', 'nombre_archivo' => $tesoreria->nombre_archivo_pago])}}" target="_blank" class="btn btn-primary">
                                                <i class="fas fa-eye" aria-hidden="true" ></i> {{ $tesoreria->nombre_archivo_pago }}
                                            </a>
                                        </div>
                                    @endif    
                                @endforeach
                            @endif 
                        </div>
                        <div class="card-footer text-muted">
                            Creada el {{ $compra->created_at->format('d-m-Y H:i:s') }}
                        </div>
                    </div>
                </div>
            @endforeach    
        </div>
    @else
        <div class="col-sm-12 mb-3">
            <h2>*)NO EXISTEN COMPRAS</h2>
        </div>
    @endif
    

    <div class="col-sm-12 mb-3">
        @if ($paso4->count() > 0)
            <div class="card text-center">
                <div class="card-header" style="background-color: #066774; color:beige">
                <B>DICTÁMEN</B> 
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $paso4[0]->condicion_rendicion }}</h5>
                    <p class="card-text">Convenio finalizado rendido en formato PDF.</p>
                    <a href="{{url('empleado/verpdf',['id' => $paso4[0]->id_etapas, 'tipo' => 'dictamenes', 'nombre_archivo' => $paso4[0]->nombre_archivo])}}" target="_blank" class="btn btn-rendicion">
                        <i class="fas fa-eye" aria-hidden="true" ></i> VER DICTÁMEN
                    </a>
                </div>
                <div class="card-footer text-muted">
                    Última actualización {{ $paso1->updated_at->format('d-m-Y H:i:s') }}
                </div>
            </div>
        @else
            <h2>*)NO EXISTE UN DICTÁMEN</h2>    
        @endif   
    </div>          
    	
</article>

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