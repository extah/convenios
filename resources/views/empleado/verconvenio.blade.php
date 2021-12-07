@extends('template/template')

@section('css')


            <!-- <link rel="stylesheet" href="{{ asset('css/login.css') }}"> -->
            <link href="{{ asset('/assets/bootstrap-datepicker-1.7.1/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>

@endsection

@section('content')

    <article class="container col-12 mx-auto p-0"> 

        <hr>

        <div class="row">
              <div class="col-sm-3  p-1">
                  <div class="card">
                    
                    <div class="card-header"  style="background-color: #3f4348; color:beige">Paso 1</div>
                    <div class="card-body">
                      <h5 class="card-title">{{ $paso1[0]->organismo_financiador }}</h5>
                      <p class="card-text">
                        {{ $paso1[0]->nombre_proyecto }}
                      </p>
                      <a href="#" class="btn btn-info"><i class="fas fa-eye"></i> VER</a>
                      
                    </div>
                  </div>
              </div>
              <div class="col-sm-3  p-1">
                  <div class="card">
                    
                    <div class="card-header"  style="background-color: #3f4348; color:beige">Paso 2</div>
                    <div class="card-body">
                      <h5 class="card-title">{{ $paso1[0]->organismo_financiador }}</h5>
                      <p class="card-text">
                        {{ $paso1[0]->nombre_proyecto }}
                      </p>
                      <a href="#" class="btn btn-info"><i class="fas fa-eye"></i> VER</a>
                      
                    </div>
                  </div>
              </div>
              <div class="col-sm-3  p-1">
                  <div class="card">
                    
                    <div class="card-header"  style="background-color: #3f4348; color:beige">Paso 3</div>
                    <div class="card-body">
                      <h5 class="card-title">{{ $paso1[0]->organismo_financiador }}</h5>
                      <p class="card-text">
                        {{ $paso1[0]->nombre_proyecto }}
                      </p>
                      <a href="#" class="btn btn-info"><i class="fas fa-eye"></i> VER</a>
                      
                    </div>
                  </div>
              </div>
              <div class="col-sm-3  p-1">
                  <div class="card">
                    
                    <div class="card-header"  style="background-color: #3f4348; color:beige">Paso 4</div>
                    <div class="card-body">
                      <h5 class="card-title">{{ $paso1[0]->organismo_financiador }}</h5>
                      <p class="card-text">
                        {{ $paso1[0]->nombre_proyecto }}
                      </p>
                      <a href="#" class="btn btn-info"><i class="fas fa-eye"></i> VER</a>
                      
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