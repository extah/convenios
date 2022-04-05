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
                .btn-group { margin-bottom: -45px;z-index: 2;}       
    </style>
@endsection

@section('content')
<br>
<div class="container">
  <div class="col-8 col-sm-6 col-md-6 mx-auto">
    <div class="card text-white bg-info mb-3" style="max-width: 100rem;">
        <div class="card-body text-center">
          <h4 class="card-title">Listado de convenios</h4>
        </div>                  
    </div>
  </div>
</div>
<div class="container">
  {{-- <div class="d-flex justify-content-center">
      <h1 style="color:#428bca">Listado de convenios</h1>
  </div> --}}
  {{-- <hr> --}}

    <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex flex-column mx-auto p-0 my-2 gap-1">
        <div class="row g-2">
            <div class="col-md-3">
                <button id="btnBuscarporNUMERO" type="button" class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#modalTurnos">
                    <i class="fas fa-search"></i> Buscar convenio por numero
                </button>
            </div>
            <div class="col-md-3">
                <button id="btnBuscarPorProyecto" type="button" class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#modalProyecto">
                    <i class="fas fa-search"></i> Buscar convenio por proyecto
                </button>
            </div>
            <div class="col-md-3">
                <button id="btnBuscarPorFinalizado" type="button" class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#modalFinalizar">
                    <i class="fas fa-search"></i> Buscar convenios por estado
                </button>
            </div>
        </div>
    </div>
    <br>
    <div class="col-lg-12"> 
      <div class="table-responsive">  
          <table id="tablaConvenios" class="table table-striped table-hover table-bordered display" cellspacing="0" style="width:100%">
              <meta name="csrf-token_convenios" content="{{ csrf_token() }}">
              <thead class="thead-dark text-center">
                  <tr>
                      <th>N° CONVENIO</th>
                      <th>NOMBRE DEL PROYECTO</th>
                      {{-- <th>CONVENIO CREADO POR</th> --}}
                      <th>CONVENIO FIRMADO</th>
                      <th>CONVENIO EN EJECUCION</th>
                      <th>CONVENIO PENDIENTE DE RENDICION</th>
                      <th>CONVENIO RENDIDO</th>
                      <th>FECHA FINALIZACIÓN</th>
                      <th>CONVENIO FINALIZADO</th>
                      <th>ACCIONES</th>
                  </tr>    
              </thead>
              <tbody>

              </tbody>
          </table>
      </div>    
  </div>       
</div>

<!-- Modal buscar por NUMERO-->
<div class="modal fade" id="modalTurnos" tabindex="-1" aria-labelledby="modalTurnosLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: rgb(54, 105, 199)">
        <h5 class="modal-title" id="modalTurnosLabel" style="color: blanchedalmond">Buscar convenio por numero</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
          <form action="{{route('empleado.tablaconvenios')}}" method="POST" id="formTurnos" class="needs-validation" enctype="multipart/form-data">   
              @csrf
              <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 mb-3" style="display:none;">
                        <!-- <div class="col-lg-12 mb-3"> -->
                            <div class="form-group">
                                <label class="formItem" for="opcion_buscar" id="opcion_input"> <b>OPCION</b></label>
                                <input type="text" class="form-control" id="opcion_buscar" name="opcion_buscar">
                            </div> 
                        </div> 
                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="formItem" for="nro_convenio"> <b>N° de convenio</b></label>
                                <input type="number" class="form-control" id="nro_convenio" name="nro_convenio" required>
                            </div> 
                        </div>     
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btnGuardar" class="btn btn-primary">Buscar</button>
                </div>
          </form> 
    </div>
  </div>
</div>

<!-- Modal buscar por PROYECTO-->
<div class="modal fade" id="modalProyecto" tabindex="-1" aria-labelledby="proyectoLabel" aria-hidden="true" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color: rgb(54, 105, 199)">
          <h5 class="modal-title" id="proyectoLabel" style="color: blanchedalmond">Buscar convenio por nombre del proyecto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <form action="{{route('empleado.tablaconvenios')}}" method="POST" id="formProyecto" class="needs-validation" enctype="multipart/form-data">   
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 mb-3" style="display:none;">
                            <div class="form-group">
                                <label class="formItem" for="opcion_proyecto" id="opcion_input"> <b>OPCION</b></label>
                                <input type="text" class="form-control" id="opcion_proyecto" name="opcion_proyecto">
                            </div> 
                        </div> 
                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="formItem" for="nombre_proyecto"> <b>Nombre del proyecto</b></label>
                                <input type="text" class="form-control" id="nombre_proyecto" name="nombre_proyecto" required>
                            </div> 
                        </div>     
                    </div>
                </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" id="btnGuardar" class="btn btn-primary">Buscar</button>
                  </div>
            </form> 
      </div>
    </div>
</div>
 
<!-- Modal buscar por finalizacion-->
<div class="modal fade" id="modalFinalizar" tabindex="-1" aria-labelledby="finalizarLabel" aria-hidden="true" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color: rgb(54, 105, 199)">
          <h5 class="modal-title" id="finalizarLabel" style="color: blanchedalmond">Buscar convenios por estado de finalizacion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <form action="{{route('empleado.tablaconvenios')}}" method="POST" id="formFinalizo" class="needs-validation" enctype="multipart/form-data">   
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 mb-3" style="display:none;">
                            <div class="form-group">
                                <label class="formItem" for="opcion_finalizado" id="opcion_input"> <b>OPCION</b></label>
                                <input type="text" class="form-control" id="opcion_finalizado" name="opcion_finalizado">
                            </div> 
                        </div> 
                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="formItem" for="estado"> <b>Estado del proyecto finalizado</b></label>
                                <select name="estado" id="estado" class="form-control text-center" required>
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                </select>
                            </div>
                        </div>     
                    </div>
                </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" id="btnGuardar" class="btn btn-primary">Buscar</button>
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

  var id, opcion, titulo;
        opcion = 4;
    
        tablaConvenios = $('#tablaConvenios').DataTable( 
        {
            "createdRow":function(row,data,index)
            {
                // alert(data['fecha_finalizacion']);
                let date = new Date()

                let day = date.getDate()
                let month = date.getMonth() + 1
                let year = date.getFullYear()
                let fecha_actual;
                if(month < 10){
                    // console.log(`${day}-0${month}-${year}`)
                    fecha_actual = `${day}/0${month}/${year}`;
                }else{
                    // console.log(`${day}-${month}-${year}`)
                    fecha_actual = `${day}/${month}/${year}`;
                }
                // alert(restaFechas(fecha_actual,data['fecha_finalizacion']));
                if (restaFechas(fecha_actual,data['fecha_finalizacion']) < 0 ) {
                    $('td', row).eq(6).css({
                        'background-color': '#ff5252',
                        'color': 'white',
                    });
                }
                else if(restaFechas(fecha_actual,data['fecha_finalizacion']) < 30 ) {
                    $('td', row).eq(6).css({
                        'background-color': '#C6C903',
                        'color': 'white',
                    });
                }
                else
                {
                    $('td', row).eq(6).css({
                        'background-color': '#099E1F',
                        'color': 'white',
                    });
                }

            },
            // "dom": '<"dt-buttons"Bf><"clear">lirtp',
            "ajax":{            
                            "headers": { 'X-CSRF-TOKEN': $('meta[name="csrf-token_convenios"]').attr('content') },    
                            "url": "{{route('empleado.tablaconvenios')}}", 
                            "method": 'post', //usamos el metodo POST
                            "data":{
                                '_token': $('input[name=_token]').val(),
                                opcion:opcion}, //enviamos opcion 1 para que haga un SELECT
                            "dataSrc":""
                        },
            "columns": [
                            { data: "id" },
                            { data: "proyecto"},
                            // { data: "creado"},
                            { data: "paso1" },
                            { data: "paso2" },
                            { data: "paso3" },    
                            { data: "paso4" }, 
                            { data: "fecha_finalizacion" },   
                            { data: "finalizo" },  
                            {"defaultContent": "<div class='text-center'><div class=''><button class='btn btn-primary btn-sm btnVer'><i class='fas fa-eye'></i></button><button class='btn btn-secondary btn-sm btnEditar'><i class='fas fa-edit'></i></button></div></div>"},
                            // {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"},
                        ],
            responsive: {
            },
            "select": true,
            "colReorder": false,
            "autoWidth": false,
            "order": [[ 0, "asc" ]],
            "paging":   true,
            "ordering": false,
            "info":     true,
            // "dom": 'Bfrtilp',
            dom: 'Bfrtip',
            // dom: 'B<"clear">lfrtip',
            lengthChange: false,
            'columnDefs': [
                            {'max-width': '20%', 'targets': 0}
                        ],
            "language": {
                            "sProcessing":     "Procesando...",
                            "sLengthMenu":     "Mostrar _MENU_ registros",
                            "sZeroRecords":    "No se encontraron resultados",
                            "sEmptyTable":     "Ningun dato disponible en esta tabla",
                            "sInfo":           "Mostrando convenios del _START_ al _END_ de un total de _TOTAL_ convenios",
                            "sInfoEmpty":      "Mostrando convenios del 0 al 0 de un total de 0 convenios",
                            "sInfoFiltered":   "(filtrado de un total de _MAX_ convenios)",
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
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fas fa-file-excel"></i> EXCEL ',
                        titleAttr: 'Exportar a Excel',
                        className: 'btn btn-success',
                        exportOptions: {
                            // columns: ':visible',
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                        },
                    },
                    {
                        extend:    'pdfHtml5',
                        text:      '<i class="fas fa-file-pdf"></i> PDF',
                        titleAttr: 'Exportar a PDF',
                        className: 'btn btn-danger',
                        orientation: 'landscape',
                        pageSize: 'LETTER',
                        download: 'open',
                        customize:  function (doc) {
                            doc.layout = 'lightHorizotalLines;'
                            doc.pageMargins = [30, 30, 30, 30];
                            doc.defaultStyle.fontSize = 11;
                            doc.styles.tableHeader.fontSize = 12;
                            doc.styles.title.fontSize = 14;
        
                            // How do I set column widths to [100,150,150,100,100,'*']  ?
        
                        },
                        exportOptions: {
                            // columns: ':visible',
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                        },
                    },
                    {
                        extend:    'print',
                        text:      '<i class="fas fa-print"></i> IMPRIMIR',
                        titleAttr: 'Imprimir',
                        className: 'btn btn-secondary',
                        autoPrint: true,
                        exportOptions: {
                            // columns: ':visible',
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                        },
                        customize: function (win) {
                            $(win.document.body).find('table').addClass('display').css('font-size', '9px');
                            $(win.document.body).find('tr:nth-child(odd) td').each(function(index){
                                $(this).css('background-color','#D0D0D0');
                            });
                            $(win.document.body).find('h1').css('text-align','center');
                        }
                    },
                ]              
        }); 

        var fila; //captura la fila, para editar o eliminar

        $("#btnBuscarporNUMERO").click(function(){        
            fila = $(this).closest("tr");
            opcion = 5; 
            
            $("#formTurnos").trigger("reset");
            $("#opcion_buscar").val('5');
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
                e.preventDefault(); 
                var form = this;

                $('#tablaConvenios').DataTable().clear().draw(); 
                $('#modalTurnos').modal('hide');

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

                        tablaConvenios.rows.add(data).draw();
                    },
                });			        										     			
        });

        //buscar por nombre del proyecto
        $('#formProyecto').submit(function(e){                         
            e.preventDefault(); 
            var formProyecto = this;
            // var dato = formProyecto.elements;
            // console.log(dato["opcion_proyecto"].value);
            $('#tablaConvenios').DataTable().clear().draw(); 
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
                    tablaConvenios.rows.add(data).draw();
                },
            });			        										     			
        });

        //buscar por estado fe finalizacion
        $('#formFinalizo').submit(function(e){                         
            e.preventDefault(); 
            var formFinalizo = this;
            // var dato = formProyecto.elements;
            // console.log(dato["opcion_proyecto"].value);
            $('#tablaConvenios').DataTable().clear().draw(); 
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
                    tablaConvenios.rows.add(data).draw();
                },
            });			        										     			
        });

        //VER CONVENIO
        $(document).on("click", ".btnVer", function(){
            
            fila = $(this).closest("tr");         

            if($(this).parents("tr").hasClass('child')){ //vemos si el actual row es child row
                var id = $(this).parents("tr").prev().find('td:eq(0)').text(); //si es asi, nos regresamos al row anterior, es decir, al padre y obtenemos el id
                var paciente = $(this).parents("tr").prev().find('td:eq(3)').text();
                var fecha = $(this).parents("tr").prev().find('td:eq(4)').text();
                var hora = $(this).parents("tr").prev().find('td:eq(5)').text();
            } else {
                var id = $(this).closest("tr").find('td:eq(0)').text(); //si no lo es, seguimos capturando el id del actual row
                var paciente = $(this).closest("tr").find('td:eq(3)').text();
                var fecha = $(this).closest("tr").find('td:eq(4)').text();
                var hora = $(this).closest("tr").find('td:eq(5)').text();
            }

            var url = "{{route('empleado.verdatosdelconvenio', '')}}"+"/"+id;
            window.open(url, "Ver convenio")

        }); 

        // editar
        $(document).on("click", ".btnEditar", function(){
            
            fila = $(this).closest("tr");         

            if($(this).parents("tr").hasClass('child')){ //vemos si el actual row es child row
                var id = $(this).parents("tr").prev().find('td:eq(0)').text(); //si es asi, nos regresamos al row anterior, es decir, al padre y obtenemos el id
                var paciente = $(this).parents("tr").prev().find('td:eq(3)').text();
                var fecha = $(this).parents("tr").prev().find('td:eq(4)').text();
                var hora = $(this).parents("tr").prev().find('td:eq(5)').text();
            } else {
                var id = $(this).closest("tr").find('td:eq(0)').text(); //si no lo es, seguimos capturando el id del actual row
                var paciente = $(this).closest("tr").find('td:eq(3)').text();
                var fecha = $(this).closest("tr").find('td:eq(4)').text();
                var hora = $(this).closest("tr").find('td:eq(5)').text();
            }

            var url = "{{route('empleado.verconvenio', '')}}"+"/"+id;
            window.open(url, "Editar convenio")

        });
        // Función para calcular los días transcurridos entre dos fechas
        restaFechas = function(f1,f2)
        {
        var aFecha1 = f1.split('/');
        var aFecha2 = f2.split('/');
        var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
        var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
        var dif = fFecha2 - fFecha1;
        var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
        return dias;
        }
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