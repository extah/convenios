$("#form-register").validate({
    rules: {

        nombre: {
            required: true,
            minlength: 3,
            maxlength: 30 
        },
        apellido: {
            required: true,
            minlength: 3,
            maxlength: 50 
        },
        email: {
            required: true,
            email: true
        },
        telefono: {
            required: true,
            number: true,
            minlength: 10,
            maxlength: 10
        },
        dni: {
            required: true,
            number: true,
            minlength: 8,
            maxlength: 8
        },
        password: {
            required: true,
            minlength: 5,
            maxlength: 16,
        },
        confirmpassword: {
            minlength: 5,
            maxlength: 16,
            equalTo: "#pass",
            required: true            
        }

    }
});

$("#registrarse").click(function(){
    if($("#form-register").valid() == false) {
        return
    }
    let nombre = $("#nombre").val();
    let apellido = $("#apellido").val();
    let email = $("#email").val();
    let telefono = $("#telefono").val();
    let dni = $("#dni").val();
    let password = $("#password").val();
    let confirmpassword = $("#confirmpassword").val();
})