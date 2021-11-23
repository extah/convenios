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

    <article class="container px-4"> 
        <div class="col-6 col-sm-6 col-md-6 mx-auto">
            <div class="form-group">
                <label class="formItem" for="nro_expediente"> <b>Numero de expediente</b></label>
                <input  class="form-control text-center" type="text" name="nro_expediente" id="nro_expediente" placeholder="ingresa nro de expediente" required>
            </div>
            <div class="form-group">
                <label class="formItem" for="select_cuenta"> <b>Cuenta bancaria</b></label>
                <select name="select_cuenta" id="select_cuenta" class="form-control text-center" required>
                    <option value="">-Seleccion&aacute el tipo de cuenta-</option>
                    <option value="comun" offset="1">comun</option>
                    <option value="nueva" offset="1">nueva</option>
                </select>
            </div>
        </div>

    </article>

<br>

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