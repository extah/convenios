<!DOCTYPE html>
<html lang="es" >
<head>
	<meta charset="utf-8">
	<!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link href="{{ asset("assets/bootstrap-5.1.0/css/bootstrap.min.css") }}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous"> --}}
    <link href='{{ asset("css/inicio.css") }}' rel="stylesheet">
    <!--datables estilo bootstrap 5 CSS-->   

    <!--datables estilo bootstrap 5 CSS-->   
    <link rel="stylesheet" href="{{ asset("assets/bootstrap-5.1.0/css/bootstrap-ajax-twitter.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/bootstrap-5.1.0/css/dataTables.bootstrap5.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/bootstrap-5.1.0/css/responsive.bootstrap5.min.css") }}">
    <link href='{{ asset("assets/bootstrap-5.1.0/css/toastr.min.css") }}' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset("assets/bootstrap-5.1.0/css/select.bootstrap5.min.css") }}">

    {{-- <link href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css' rel='stylesheet' type='text/css'> --}}

    @yield('css')


</head>
<body>

<main>
  
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-be-1" role="navigation">
      <div class="container">
    
          <a class="navbar-brand" href="#">
              <img alt="Municipalidad de Berisso - Logo" src="{{URL::asset('images/img/logo-be-01.svg')}}">
          </a>
    
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-1" aria-controls="navbar-1" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
          <div class="collapse navbar-collapse" id="navbar-1">
              <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-bold fs-5">

                @if (!$esEmp)
                  <li class="nav-item px-lg-2">
                      <a class="nav-link active" aria-current="page" title="Iniciar Sesion" href="{{route('inicio.index')}}">Iniciar sesion</a>
                  </li>
                  <li class="nav-item px-lg-2">
                      <a class="nav-link active" aria-current="page" title="Convenios" href="#">Ver Convenios</a>
                  </li>
                @endif  
                @if ($esEmp)
                  <div class="dropdown"> 


                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ (($nombre)) ?? '' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="dropdownMenuButton1">
                      <li><a class="dropdown-item" href="{{route('empleado.indexget')}}">Menu</a></li>
                      <li><a class="dropdown-item" href="{{route('empleado.buscarconvenios')}}">Ver convenios</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="{{route('empleado.cerrarsesion')}}">Cerrar sesion</a></li>
                    </ul>
                  </div>
                @endif


              </ul>

          </div>
      </div>
    </nav>
    <div class="bg-be-6 secondary-bar">
      <div class="container">
          <div class="row">
              <div class="col-12 col-md-auto my-2 fs-3 text-center text-md-left">
                  <a class="text-decoration-none ms-2" href="https://es-es.facebook.com/municipiodeberisso">
                      <i class="fab fa-facebook-f color-be-4"></i>
                  </a>
                  <a class="text-decoration-none ms-2" href="https://www.instagram.com/municipiodeberisso/">
                      <i class="fab fa-instagram color-be-4"></i>
                  </a>
                  <a class="text-decoration-none ms-2" href="https://twitter.com/munideberisso">
                      <i class="fab fa-twitter color-be-4"></i>
                  </a>
                  <a class="text-decoration-none ms-2" href="https://www.youtube.com/user/prensaberisso">
                      <i class="fab fa-youtube color-be-4"></i>
                  </a>
                  <a class="text-decoration-none ms-2" href="#">
                      <i class="fas fa-map-marker-alt color-be-4"></i>
                  </a>
                  <a class="text-decoration-none ms-2" href="#">
                      <i class="fas fa-mobile-alt color-be-4"></i>
                  </a>
              </div>
    
              <div class="col-12 col-md-auto my-2 ms-md-auto">
                  <form class="search-form" action="#" method="GET">
                      <div class="input-group">
                          <input type="text" name="search" class="form-control bg-be-3 border-be-3" aria-describedby="search-button">
                          <button class="btn btn-dark" type="button" id="search-button"><i class="fas fa-search"></i></button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
    </div>
</header>

  
@yield('content')


<!-- Footer -->
<footer class="bg-be-4 py-4">
  <div class="container">
      <div class="row">
          <div class="col-12 col-lg-4">
              <h6 class="color-be-2 text-center bg-be-1 py-2 rounded-pill mb-3">
                  Consejo Consultivo Comunitario
              </h6>
              <div class="text-center text-lg-start ps-0 ps-lg-4 ps-xl-5">
                  <ul class="list-unstyled">
                      <li>
                          <a class="link-light text-decoration-none fs-4" title="Presentaci??n" href="#">Presentaci??n</a>
                      </li>
                      <li>
                          <a class="link-light text-decoration-none fs-4" title="Encuentros presenciales" href="#">Encuentros presenciales</a>
                      </li>
                      <li>
                          <a class="link-light text-decoration-none fs-4" title="Plan de acci??n" href="#">Plan de acci??n</a>
                      </li>
                      <li>
                          <a class="link-light text-decoration-none fs-4" title="Evoluci??n de acciones " href="#">Evoluci??n de acciones</a>
                      </li>
                  </ul>
              </div>
            </div>            
            <div class="col-12 col-lg-4">
              <h6 class="color-be-2 text-center bg-be-1 py-2 rounded-pill mb-3">
                  Direcci??n
              </h6>
              <div class="text-center text-lg-start ps-0 ps-lg-4 ps-xl-5">
                  <div class="color-be-2 fs-4">
                  Calle 6 y 166
              </div>
              <div class="color-be-2 fs-4">
                  (1923) Berisso
              </div>
              <div class="color-be-2 fs-4">
                  Tel??fono: (0221) 464-5069
              </div>
              </div>
            </div>            
            <div class="col-12 col-lg-4">
              <h6 class="color-be-2 text-center bg-be-1 py-2 rounded-pill mb-3">
                  Segu?? Nuestras Redes
              </h6>
              <div class="text-center text-lg-start ps-0 ps-lg-4 ps-xl-5">
                  <ul class="list-unstyled">
                      <li>
                          <a class="link-light text-decoration-none fs-4" href="https://es-es.facebook.com/municipiodeberisso">Facebook</a>
                      </li>
                      <li>
                          <a class="link-light text-decoration-none fs-4" href="https://www.instagram.com/municipiodeberisso/">Instagram</a>
                      </li>
                      <li>
                          <a class="link-light text-decoration-none fs-4" href="https://twitter.com/munideberisso">Twitter</a>
                      </li>
                      <li>
                          <a class="link-light text-decoration-none fs-4" href="https://www.youtube.com/user/prensaberisso">Youtube</a>
                      </li>
                  </ul>
              </div>
            </div>        
          </div>
          <div class="px-5">
                <div class="row justify-content-md-center">
                        <div class="col-6 col-lg-2">
                            <img class="image-responsive p-md-2 p-lg-3" alt="N??mero de bomberos: 100" src="{{URL::asset('images/img/100.svg')}}">
                        </div>

                        <div class="col-6 col-lg-2">
                            <img class="image-responsive p-md-2 p-lg-3" alt="N??mero de defensa civil: 103" src="{{URL::asset('images/img/103.svg')}}">
                        </div>

                        <div class="col-6 col-lg-2">
                            <img class="image-responsive p-md-2 p-lg-3" alt="N??mero de same: 107" src="{{URL::asset('images/img/107.svg')}}">
                        </div>

                        <div class="col-6 col-lg-2">
                            <img class="image-responsive p-md-2 p-lg-3" alt="N??mero de violencia de g??nero: 144" src="{{URL::asset('images/img/144.svg')}}">
                        </div>

                        <div class="col-6 col-lg-2">
                            <img class="image-responsive p-md-2 p-lg-3" alt="N??mero de polic??a: 911" src="{{URL::asset('images/img/911.svg')}}">
                        </div>
                </div>        
        </div>
    </div>
</footer>
</main>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script> --}}
<script src="{{ asset("assets/bootstrap-5.1.0/js/popper.min.js") }}"></script>
<script src="{{ asset("assets/bootstrap-5.1.0/js/bootstrap.min.js") }}"></script> 

<script src="{{asset('assets/DataTables-1.10.25/js/jquery-3.5.1.js')}}"></script>
{{-- <script src="{{asset('assets/DataTables-1.10.25/jquery/jquery-3.3.1.min.js')}}"></script> --}}
<script src="{{asset('assets/DataTables-1.10.25/popper/popper.min.js')}}"></script>
<script src="{{asset('assets/bootstrap-4.5.3/js/bootstrap.min.js')}}"></script>



<script src="{{asset('assets/DataTables-1.10.25/datatables.min.js')}}"></script>
<script src="{{asset('assets/DataTables-1.10.25/Buttons-1.7.1/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/DataTables-1.10.25/DataTables-1.10.25/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/DataTables-1.10.25/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/DataTables-1.10.25/responsive.bootstrap4.min.js')}}"></script>

<script src="{{asset('assets/DataTables-1.10.25/JSZip-2.5.0/jszip.min.js')}}"></script>
<script src="{{asset('assets/DataTables-1.10.25/pdfmake-0.1.36/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/DataTables-1.10.25/pdfmake-0.1.36/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/DataTables-1.10.25/Buttons-1.7.1/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/DataTables-1.10.25/jquery.timepicker.min.js')}}"></script>

<script src='{{ asset("assets/toastr/toastr.min.js") }}'></script>
<script src="{{ asset("assets/sweetalert/sweetalert.min.js") }}"></script>
<script src="{{ asset('assets/fontawesome-5.15.3/js/all.js') }}"></script>
<script src="{{asset('js/template.js')}}"></script>


  @yield('js')
</body>
</html>
