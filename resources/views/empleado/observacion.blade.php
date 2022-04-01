@extends('template/template')

@section('css')
    <link href="{{ asset('/assets/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet"/>
    
    <style>
        .modal-header {
            background-color: #04205f;
            color: rgb(226, 226, 226);
        }
        .table thead,
        .table tfoot{
            background-color: rgb(116, 112, 112);
            color: azure;

        }
    </style>
@endsection

@section('content')
<br>
<div class="container">
  <div class="col-8 col-sm-6 col-md-6 mx-auto">
    <div class="card text-white bg-info mb-3" style="max-width: 100rem;">
        <div class="card-body text-center">
          <h4 class="card-title">Observaciónes</h4>
        </div>                  
    </div>
  </div>
</div>
<div class="container">
    <article class="container col-12 mx-auto p-0">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="conve_id" class="form-label"><b>N° CONVENIO</b></label>
                    <input type="text" class="form-control" id="conve_id" name="conve_id"  value="{{ $conve_id }}"  readonly required>
                </div> 
            </div> 	
  
    </article>
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex flex-column mx-auto p-0 my-2 gap-1">
        <div class="col-md-3">
            <button id="btnAgregar" type="button" class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#modalObservacion">
                <i class="fas fa-plus-square"></i> Agregar observación
            </button>
        </div>
    </div>

    <br>

    <div class="col-lg-12"> 
      <div class="table-responsive">  
          <table id="tablaObservacion" class="table table-striped table-hover table-bordered display" cellspacing="0" style="width:100%">
              <meta name="csrf-token_convenios" content="{{ csrf_token() }}">
              <thead class="thead-dark text-center">
                  <tr>
                        <th>N° OBSERVACIÓN</th>
                        <th>N° CONVENIO</th>
                        <th>DESCRIPCIÓN</th>
                        <th>FECHA</th>
                        <th>ACCIONES</th>
                  </tr>    
              </thead>
              <tbody>

              </tbody>
          </table>
      </div>    
  </div>       
</div>

<!-- Modal buscar por DNI-->
<div class="modal fade" id="modalObservacion" tabindex="-1" aria-labelledby="modalObservacionLabel" aria-hidden="true" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color: rgb(54, 105, 199)">
          <h5 class="modal-title" id="modalObservacionLabel" style="color: blanchedalmond">Agregar una observación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <form action="{{route('empleado.agregarobservaciones')}}" method="POST" id="formTurnos" class="needs-validation" enctype="multipart/form-data">   
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 mb-3" style="display:none;">
                        <!-- <div class="col-lg-12                                                                                                                 mb-3"> -->
                            <div class="form-group">
                                <label class="formItem" for="opcion_agregar" id="opcion_input"> <b>OPCION</b></label>
                                <input type="text" class="form-control" id="opcion_agregar" name="opcion_agregar" value="{{ $conve_id }}">
                            </div> 
                        </div> 
                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="formItem" for="descripcion"> <b>DESCRIPCIÓN</b></label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="10" id="descripcion" name="descripcion" required></textarea>
                            </div> 
                        </div>     
                    </div>
                </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" id="btnGuardar" class="btn btn-primary">Agregar</button>
                  </div>
            </form> 
      </div>
    </div>
  </div>

@endsection

@section('js')
<script src="{{ asset('assets/moment/moment.min.js') }}"></script>
<script src='{{ asset('/assets/jquery-ui/jquery-ui.min.js') }}'></script>
<script src="{{ asset('/assets/formvalidation/0.6.2-dev/js/formValidation.min.js') }}"></script>
<script src="{{ asset('assets/select2/select2.full.js') }}"></script>
<script src='{{ asset("assets/toastr/toastr.min.js") }}'></script>
<script src='{{ asset("assets/toastr/toastr.min.js") }}'></script>
<script src='{{ asset("assets/validity/jquery.validity.min.js") }}'></script>
<script src='{{ asset("assets/validity/jquery.validity.lang.es.js") }}'></script>
<script src="{{ asset("assets/sweetalert/sweetalert.min.js") }}"></script>

<script>

$(document).ready(function() {

  var id, opcion;
        opcion = document.getElementById("conve_id").value;
    
        tablaObservacion = $('#tablaObservacion').DataTable( 
        {
        //"dom": '<"dt-buttons"Bf><"clear">lirtp',
        "ajax":{            
                        "headers": { 'X-CSRF-TOKEN': $('meta[name="csrf-token_convenios"]').attr('content') },    
                        "url": "{{route('empleado.datosobservaciones')}}", 
                        "method": 'post', //usamos el metodo POST
                        "data":{
                            '_token': $('input[name=_token]').val(),
                            opcion:opcion}, //enviamos opcion 1 para que haga un SELECT
                        "dataSrc":""
                    },
        "columns": [
                        { data: "id"},
                        { data: "id_etapas"},
                        { data: "descripcion"},
                        { data: "fecha"},
                        {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-danger btn-sm btnEliminar'><i class='fa fa-trash-alt'></i></button></div></div>"},
                        
                    ],
        responsive: {
        },
        select: true,
        colReorder: true,
        "autoWidth": false,
         "order": [[ 0, "DES" ]],
         "paging":   true,
         "ordering": true,
         "info":     false,
         "dom": 'Bfrtip',
         'columnDefs': [
                          {'max-width': '100%', 'targets': 0}
                       ],
         
         "language": {
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "No se encontraron resultados",
                        "sEmptyTable":     "Ningun dato disponible en esta tabla",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sSearch":         "Buscar:",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":     "�ltimo",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        },
                        "buttons": {
                            "copy": "Copiar",
                            "colvis": "Visibilidad"
                        }
                    },   
                "buttons":[
                    //     {
                    //     extend:    'copyHtml5',
                    //     text:      '<i class="fas fa-copy"></i> COPIAR ',
                    //     titleAttr: 'Copiar datos',
                    //     className: 'btn btn-dark'
                    // },
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fas fa-file-excel"></i> EXCEL ',
                        titleAttr: 'Exportar a Excel',
                        className: 'btn btn-success'
                    },
                    {
                        extend:    'pdfHtml5',
                        text:      '<i class="fas fa-file-pdf"></i> PDF',
                        titleAttr: 'Exportar a PDF',
                        className: 'btn btn-danger',

                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                        // customize: function(doc)
                        // {
                        //     doc.styles.fontSize = 16;
                        //     doc.pageMargins = [ 59, 50, 59, 50 ];
                        //     doc.defaultStyle.border='solid';
                        //     doc.styles.tableHeader.fillColor = '#d0e9c6';
                        //     doc.styles.tableHeader.alignment = 'center';
                        //     doc.styles.tableBodyEven.alignment = 'center';
                        // }

                    },
                    {
                        extend:    'print',
                        text:      '<i class="fas fa-print"></i> IMPRIMIR',
                        titleAttr: 'Imprimir',
                        className: 'btn btn-secondary',
                        autoPrint: true,
                        exportOptions: {
                            // columns: ':visible',
                            columns: [ 0, 1, 2, 3]
                        },
                        customize: function (win) {
                            $(win.document.body).find('table').addClass('display').css('font-size', '9px');
                            $(win.document.body).find('tr:nth-child(odd) td').each(function(index){
                                $(this).css('background-color','#D0D0D0');
                            });
                            $(win.document.body).find('h1').css('text-align','center');
                        }
                    },
                ],
                content:[
                    {
                        columns: [
                            {
                                width: 50
                            }
                        ],
                        columnGap: 10
                    }
                ]              
        });    
        var fila; //captura la fila, para editar o eliminar

        $("#btnBuscarporNUMERO").click(function(){        
            fila = $(this).closest("tr");
            opcion = 5; 
            
            $("#formTurnos").trigger("reset");
            $("#opcion_agregar").val('5');
        });

        $("#btnBuscarPorProyecto").click(function(){        
            fila = $(this).closest("tr");
            opcion = 6; 
            
            $("#formProyecto").trigger("reset");
            $("#opcion_proyecto").val('6');
        });

        $("#btnBuscarPorFinalizado").click(function(){        
            fila = $(this).closest("tr");
            opcion = 7; 
            
            $("#formProyecto").trigger("reset");
            $("#opcion_finalizado").val('7');
        });

       

        //submit para el Alta y Actualizaci�n
        $('#formTurnos').submit(function(e){  
                // alert("asdas");                       
                e.preventDefault(); 
                var form = this;

                $('#tablaObservacion').DataTable().clear().draw(); 
                $('#modalObservacion').modal('hide');

                $.ajax({
                    url: $(form).attr("action"),
                    method: $(form).attr('method'),
                    data: new FormData(form), 
                    datatype: "json",   
                    cache:  false,
                    processData:  false,
                    contentType:  false, 

                    success: function(data) {

                        var text = data;
                        var data = JSON.parse(text);

                        tablaObservacion.rows.add(data).draw();
                    },
                });			        										     			
        });

        //buscar por nombre del proyecto
        $('#formProyecto').submit(function(e){                         
            e.preventDefault(); 
            var formProyecto = this;
            // var dato = formProyecto.elements;
            // console.log(dato["opcion_proyecto"].value);
            $('#tablaObservacion').DataTable().clear().draw(); 
            $('#modalProyecto').modal('hide');

            $.ajax({
                url: $(formProyecto).attr("action"),
                method: $(formProyecto).attr('method'),
                data: new FormData(formProyecto), 
                datatype: "json",   
                cache:  false,
                processData:  false,
                contentType:  false, 

                success: function(data) {

                    var text = data;
                    var data = JSON.parse(text);
                    tablaObservacion.rows.add(data).draw();
                },
            });			        										     			
        });

        //buscar por estado fe finalizacion
        $('#formFinalizo').submit(function(e){                         
            e.preventDefault(); 
            var formFinalizo = this;
            // var dato = formProyecto.elements;
            // console.log(dato["opcion_proyecto"].value);
            $('#tablaObservacion').DataTable().clear().draw(); 
            $('#modalFinalizar').modal('hide');

            $.ajax({
                url: $(formFinalizo).attr("action"),
                method: $(formFinalizo).attr('method'),
                data: new FormData(formFinalizo), 
                datatype: "json",   
                cache:  false,
                processData:  false,
                contentType:  false, 

                success: function(data) {

                    var text = data;
                    var data = JSON.parse(text);
                    tablaObservacion.rows.add(data).draw();
                },
            });			        										     			
        });

        //Borrar
        $(document).on("click", ".btnEliminar", function(){
            fila = $(this).closest("tr");  
                  

            if($(this).parents("tr").hasClass('child')){ //vemos si el actual row es child row
                var id = $(this).parents("tr").prev().find('td:eq(0)').text(); //si es asi, nos regresamos al row anterior, es decir, al padre y obtenemos el id
                var id_convenio = $(this).parents("tr").prev().find('td:eq(1)').text();
                var descripcion = $(this).parents("tr").prev().find('td:eq(2)').text();
                // var hora = $(this).parents("tr").prev().find('td:eq(5)').text();
            } else {
                var id = $(this).closest("tr").find('td:eq(0)').text(); //si no lo es, seguimos capturando el id del actual row
                var id_convenio = $(this).closest("tr").find('td:eq(1)').text();
                var descripcion = $(this).closest("tr").find('td:eq(2)').text();
                // var hora = $(this).closest("tr").find('td:eq(5)').text();
            }
            // alert(id_convenio); 
            opcion = 3; //eliminar 
            swal({
                  title: "Esta seguro de eliminar la observación N° " + id + " con descripción: "+ descripcion +"?",
                  icon: "warning",
                  buttons: ["No", "Si"],
                })
                .then((willDelete) => {
                  if (willDelete) {
                    $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token_turnos"]').attr('content') },
                                url: "{{route('empleado.eliminarobservaciones')}}",
                                type: "POST",
                                datatype:"json",      
                                data:  {
                                    '_token': $('input[name=_token]').val(),
                                    param_id_etapa:id_convenio, id:id},    
                                success: function() {
                                    tablaObservacion.row(this).remove().draw(); 
                                    swal("Observación eliminada con Exito!!!", {
                                    icon: "success",
                                    });                
                                }
                            });

                  } else {
                    swal("La observación no fue eliminado");
                  }
                }); 
        }) 

        //ver
        // $(document).on("click", ".btnVer", function(){
            
        //     fila = $(this).closest("tr");         

        //     if($(this).parents("tr").hasClass('child')){ //vemos si el actual row es child row
        //         var id = $(this).parents("tr").prev().find('td:eq(0)').text(); //si es asi, nos regresamos al row anterior, es decir, al padre y obtenemos el id
        //         var paciente = $(this).parents("tr").prev().find('td:eq(3)').text();
        //         var fecha = $(this).parents("tr").prev().find('td:eq(4)').text();
        //         var hora = $(this).parents("tr").prev().find('td:eq(5)').text();
        //     } else {
        //         var id = $(this).closest("tr").find('td:eq(0)').text(); //si no lo es, seguimos capturando el id del actual row
        //         var paciente = $(this).closest("tr").find('td:eq(3)').text();
        //         var fecha = $(this).closest("tr").find('td:eq(4)').text();
        //         var hora = $(this).closest("tr").find('td:eq(5)').text();
        //     }

        //     var url = "{{route('empleado.verconvenio', '')}}"+"/"+id;
        //     window.open(url, "Convenio")

        // }) 

    });                 

</script>

<script>
  (function () {
    'use strict'
  
    var forms = document.querySelectorAll('.needs-validation')
  
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