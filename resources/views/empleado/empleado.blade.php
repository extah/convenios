@extends('template/template')

@section('css')

            <!-- <link rel="stylesheet" href="{{ asset('css/login.css') }}"> -->
            <link href="{{ asset('/assets/bootstrap-datepicker-1.7.1/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>

@endsection

@section('content')
<br>
<div class="container">
  <div class="col-8 col-sm-6 col-md-6 mx-auto">
    <div class="card text-white bg-info mb-3" style="max-width: 100rem;">
        <div class="card-body text-center">
          <h4 class="card-title">Menu principal</h4>
        </div>                  
    </div>
  </div>
</div>

<article class="container px-4"> 
  <div class="row">
    <div class="col-sm-6">
      <div class="card border-info mb-3">
        <div class="card-header text-dark"><b>Nuevo convenio</b></div>
        <div class="card-body text-info">
          <h5 class="card-title">Agregar un convenio nuevo</h5>
          <a class="btn btn-success" href="{{route('empleado.agregarnuevoconvenio')}}" role="button">Agregar</a>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="card border-info mb-3">
        <div class="card-header"><b>Buscar convenio</b></div>
        <div class="card-body text-info">
          <h5 class="card-title">Buscar un convenio existente</h5>
          
          <a class="btn btn-info text-white" href="{{route('empleado.buscarconvenios')}}" role="button">Buscar</a>
        </div>
      </div>
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
    @if ($status_ok)
            toastr.success("{{ $nombre }}", ' {{  $message }} ', {
                // "progressBar": true,
                "closeButton": true,
                "positionClass": "toast-bottom-right",
                "progressBar": true,
                "timeOut": "20000",
            });   
    @endif 
</script>
<script>
  @if ($status_convenio)
          toastr.success("{{ $nombreconvenio }}", ' {{  $message }} ', {
              // "progressBar": true,
              "closeButton": true,
              "positionClass": "toast-bottom-right",
              "progressBar": true,
              "timeOut": "20000",
          });   
  @endif 
</script>

@endsection