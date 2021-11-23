@extends('template/template')

@section('css')

            <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
            <link rel="stylesheet" href="{{ asset('css/login.css') }}">
            <style>
                              html, body * { box-sizing: border-box; font-family: 'Open Sans', sans-serif; }

  body {
    background:
      linear-gradient(
      rgba(222, 229, 241, 0.8),
      rgba(184, 194, 196, 0.8));
    background-size: cover;
  } 
  .frame {
    height: 600px;
    width: 360px;
    background:
      linear-gradient(
      rgba(11, 21, 75, 0.75),
      rgba(0, 13, 79, 0.95)),
      url({{URL::asset('images/img/municipalidad_berisso.jpg')}}) no-repeat center center;
    background-size: cover;
    margin-left: auto;
    margin-right: auto;
    border-top: solid 1px rgba(255,255,255,.5);
    border-radius: 5px;
    box-shadow: 0px 2px 7px rgba(0,0,0,0.2);
  }
</style>

@endsection

@section('content')

    <article class="container col-12 mx-auto p-0">
        <div class="container col-12 col-md-12 col-lg-6 d-flex justify-content-center px-0 my-auto">
            <div class="frame">
            <div class="nav_inicio">
                <ul class"links">
                    <li class="li_inicio signin-active"><a class="btn1">Iniciar sesion</a></li>
                    <li class="li_inicio signup-inactive"><a class="btn1">registrarse</a></li>
                </ul>
            </div>
            <div>
                  <form class="row g-1 needs-validation form-signin" novalidate action="{{route('empleado.home')}}" method="post" id="formIniciarSesion" name="formIniciarSesion">
                          @csrf
                          <div class="col-md-12 p-2">
                            <input type="email" class="form-control" name="email_inicio" id="email_inicio" value="" placeholder="Email"  required>
                            <!-- <div class="valid-feedback">
                              Looks good!
                            </div> -->
                            <div class="invalid-feedback">
                                <b>Por favor ingrese un email valido</b>
                            </div>
                          </div>
                          <div class="col-md-12 p-2">
                            <input type="password" name="password_inicio" placeholder="Contraseña" class="form-control" id="password_inicio" value="" required>
                            <div class="invalid-feedback">
                              <b>Por favor ingrese una contraseña</b>
                            </div>
                          </div>
                          <div class="col-md-12 p-2">
                            <input type="checkbox" id="checkbox"/>
                            <label for="checkbox" ><span class="ui"></span>recordar inicio de sesion</label>
                          </div>

                          <div class="col-md-12 col-sm-12 text-center">
                            <button class="btn btn-primary btn-lg" type="submit"><b>Iniciar Sesion</b></button>
                          </div> 

                          <hr>
                          <div class="text-center">
                            <a href="#">Olvido la contraseña?</a>
                          </div>

                          <!-- <div class="btn-animate">
                            <a onclick="document.getElementById('formIniciarSesion').submit()" class="btn-signin">Iniciar sesion</a>
                            
                          </div> -->
                    </form>
                      
                      <form accept-charset="utf-8" class="row needs-validation form-signup" novalidate action="{{route('empleado.registrarse')}}" method="post" id="formRegistrarse" name="formRegistrarse">
                            @csrf
                          <div class="col-md-12 p-2">
                            <input type="text" class="form-control" name="nombre" id="nombre" value="" placeholder="Nombre"  required>
                            <!-- <div class="invalid-feedback">
                              <b>Por favor ingrese una contraseña</b>
                            </div> -->
                          </div>

                          <div class="col-md-12 p-2 col-sm-12">
                            <input type="text" class="form-control" name="apellido" id="apellido" value="" placeholder="Apellido"  required>
                          </div>

                          <div class="col-md-12 p-2 col-sm-12">
                            <input type="email" class="form-control" name="email" id="email" value="" placeholder="Email"  required>
                          </div>
                          <div class="col-md-12 p-2 col-sm-12">
                            <input type="text" class="form-control"  name="cuit" id="cuit" value="" placeholder="Cuit"  required>
                          </div>
                          <div class="col-md-12 p-2 col-sm-12">
                            <input type="text" class="form-control"  name="dni" id="dni" value="" placeholder="Numero de documento"  required>
                          </div>
                          <div class="col-md-12 p-2 col-sm-12">
                            <input type="password" class="form-control"  name="password" id="password" value="" placeholder="Contraseña"  required>
                          </div>
                          <div class="col-md-12 p-2 col-sm-12">
                            <input type="password" class="form-control"  name="confirmpassword" id="confirmpassword" value="" placeholder="Confirmar Contraseña"  required>
                          </div>
                          <div class="col-md-12 p-3 text-center">
                            <button class="btn btn-primary btn-lg" type="submit"><b>Registrarse</b></button>
                          </div>
                          <!-- <div class="">
                              <a onclick="document.getElementById('formRegistrarse').submit()" class="btn-signup">Registrarse</a>
                          </div> -->
                  </form>
                </div>

            </div>

        </div>
    </article>
@endsection

@section('js')

<script>
    $(function() {
        $(".btn1").click(function() {
            $(".form-signin").toggleClass("form-signin-left");
        $(".form-signup").toggleClass("form-signup-left");
        $(".frame").toggleClass("frame-long");
        $(".signup-inactive").toggleClass("signup-active");
        $(".signin-active").toggleClass("signin-inactive");
        $(".forgot").toggleClass("forgot-left");   
        $(this).removeClass("idle").addClass("active");
        });
    });

</script>
<script>
    @if (Session::get('status_error'))
            toastr.error( '{{ session('message') }}', 'ERROR', {
                // "progressBar": true,
                "closeButton": true,
                "positionClass": "toast-bottom-right",
                "timeOut": "10000",
            });   
    @endif 
</script>

<script>
    @if (Session::get('status_info'))
            toastr.info( '{{ session('message') }}', 'Informar', {
                // "progressBar": true,
                "closeButton": true,
                "positionClass": "toast-bottom-right",
                "timeOut": "10000",
            });   
    @endif 
</script>

<script>
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