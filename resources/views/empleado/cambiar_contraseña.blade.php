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
          <h4 class="card-title">Modificar contraseña</h4>
        </div>                  
    </div>
  </div>
</div>

<article class="container col-12 mx-auto p-0"> 
    <div class="container col-12 col-md-12 col-lg-6 d-flex justify-content-center px-0 my-auto">
        <div class="col-md-6">
            <form accept-charset="utf-8" class="row needs-validation form-signup" novalidate action="{{route('empleado.post_cambiar_contraseña')}}" method="post" id="formcambiarcontra" name="formcambiarcontra" onsubmit="return miFuncion(this)">
                @csrf
                <div class="col-md-12 p-2">
                    <input type="text" class="form-control" name="email" id="email" value="{{ $user_login->email }}" placeholder="Email" readonly required>
                    <!-- <div class="invalid-feedback">
                    <b>Por favor ingrese una contraseña</b>
                    </div> -->
                </div>
            
                <div class="col-md-12 p-2 col-sm-12">
                    <input type="password" class="form-control"  name="password" id="password" value="" placeholder="Contraseña"  required>
                </div>
                <div class="col-md-12 p-2 col-sm-12">
                    <input type="password" class="form-control"  name="confirmpassword" id="confirmpassword" value="" placeholder="Confirmar Contraseña"  required>
                </div>
                <div id='errorRecaptcha' style='display:none; color:#a94442'require>    <span></span>    Por favor, verifica que no seas un robot.</div>
            
                <div class="col-md-12 p-3 text-center">
                    <button class="btn btn-primary btn-lg" type="submit"><b>Modificar</b></button>
                </div>
                <!-- <div class="">
                    <a onclick="document.getElementById('formRegistrarse').submit()" class="btn-signup">Registrarse</a>
                </div> -->
               </form>
        </div>
    </div>
    
</article>

@endsection

@section('js')
<script src="{{ asset('/assets/bootstrap-datepicker-1.7.1/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script>


<script>
  @if ($status_contraseña)
          toastr.success("Éxito", ' {{  $message }} ', {
              // "progressBar": true,
              "closeButton": true,
              "positionClass": "toast-bottom-right",
              "progressBar": true,
              "timeOut": "20000",
          });   
  @endif 
</script>
<script>
    function miFuncion() {
        var password = document.getElementById("password").value;
        var password_confirm = document.getElementById("confirmpassword").value;

        if (password != password_confirm) {
        // alert("Captcha no verificado");
        
            $("#errorRecaptcha").show();
            toastr.error("no coinciden las contraseñas", '', {
                        // "progressBar": true,
                        "closeButton": true,
                        "positionClass": "toast-bottom-right",
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