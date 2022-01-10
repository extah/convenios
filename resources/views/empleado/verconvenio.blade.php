@extends('template/template')

@section('css')

            <link href="{{ asset('/assets/bootstrap-datepicker-1.7.1/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>

@endsection

@section('content')
<br>
<div class="container">
  <div class="col-8 col-sm-6 col-md-6 mx-auto">
    <div class="card text-white bg-info mb-3" style="max-width: 100rem;">
        <div class="card-body text-center">
          <h4 class="card-title">PROYECTO: {{ $paso1[0]->nombre_proyecto }}</h4>
        </div>                  
    </div>
  </div>
</div>

    <article class="container col-12 mx-auto p-0"> 

        <div class="row">
              <div class="col-sm-3  p-1">
                  <div class="card">
                    
                    <div class="card-header"  style="background-color: #3f4348; color:beige">Convenio Firmado</div>
                    <div class="card-body">
                      <h5 class="card-title">{{ $paso1[0]->organismo_financiador }}</h5>
                      <p class="card-text">
                        {{ $paso1[0]->nombre_proyecto }}
                      </p>
                      {{-- <a href="{{route('empleado.verconvenio', '')}}" + "/"+id;" class="btn btn-info"><i class="fas fa-eye"></i> VER</a> --}}
                      <a href="{{url('empleado/verconvenio',['id' => $paso1[0]->id_etapas, 'paso' => 'paso1'])}}" class="btn btn-info"><i class="fas fa-eye"></i> VER</a>
                      
                    </div>
                  </div>
              </div>
              <div class="col-sm-3  p-1">
                  <div class="card">
                    
                    <div class="card-header"  style="background-color: #3f4348; color:beige">Convenio en Ejecucion</div>
                    <div class="card-body">
                      <h5 class="card-title">{{ $paso1[0]->organismo_financiador }}</h5>
                      <p class="card-text">
                        {{ $paso1[0]->nombre_proyecto }}
                      </p>
                      <a href="{{url('empleado/verconvenio',['id' => $paso1[0]->id_etapas, 'paso' => 'paso2'])}}" class="btn btn-info"><i class="fas fa-eye"></i> VER</a>
                      
                    </div>
                  </div>
              </div>
              <div class="col-sm-3  p-1">
                  <div class="card">
                    
                    <div class="card-header"  style="background-color: #3f4348; color:beige">Convenio pendiente de Rendicion</div>
                    <div class="card-body">
                      <h5 class="card-title">{{ $paso1[0]->organismo_financiador }}</h5>
                      <p class="card-text">
                        {{ $paso1[0]->nombre_proyecto }}
                      </p>
                      <a href="{{url('empleado/verconvenio',['id' => $paso1[0]->id_etapas, 'paso' => 'paso3'])}}" class="btn btn-info"><i class="fas fa-eye"></i> VER</a>
                      
                    </div>
                  </div>
              </div>
              <div class="col-sm-3  p-1">
                  <div class="card">
                    
                    <div class="card-header"  style="background-color: #3f4348; color:beige">Convenio finalizado Rendido</div>
                    <div class="card-body">
                      <h5 class="card-title">{{ $paso1[0]->organismo_financiador }}</h5>
                      <p class="card-text">
                        {{ $paso1[0]->nombre_proyecto }}
                      </p>
                      <a href="{{url('empleado/verconvenio',['id' => $paso1[0]->id_etapas, 'paso' => 'paso4'])}}" class="btn btn-info"><i class="fas fa-eye"></i> VER</a>
                      
                    </div>
                  </div>
              </div>
        </div>
    </article>



@endsection

@section('js')
<script src="{{ asset('/assets/bootstrap-datepicker-1.7.1/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script>

<script>

</script>
<script>
	$('#fecha_hasta').datepicker({
		uiLibrary: 'bootstrap4',
    format: "mm/yyyy",
    startView: "year", 
    minViewMode: "months",
		locale: 'es',
		language: 'es',
		autoclose: true,
		todayHighlight: true,
		// startDate: sumarDias(new Date()),
	});
	$('#fecha_hasta').datepicker("setDate", new Date());

	function sumarDias(fecha){
			fecha.setDate(fecha.getDate());
			return fecha;
		}

	
</script>
<script>
	$('#fecha_desde').datepicker({
		uiLibrary: 'bootstrap4',
    format: "mm/yyyy",
    startView: "year", 
    minViewMode: "months",
		locale: 'es',
		language: 'es',
		autoclose: true,
		todayHighlight: true,
		// startDate: sumarDias(new Date()),
	});
	$('#fecha_desde').datepicker("setDate", new Date());

	function sumarDias(fecha){
			fecha.setDate(fecha.getDate());
			return fecha;
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

@endsection