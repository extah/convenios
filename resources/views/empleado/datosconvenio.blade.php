@extends('template/template')

@section('css')
    <link href="{{ asset('/assets/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet"/>
    
    <style>
        .modal-header {
            background-color: #04205f;
            color: rgb(226, 226, 226);
        }
    </style>
@endsection

@section('content')
<br>
<div class="container">
  <div class="col-8 col-sm-6 col-md-6 mx-auto">
    <div class="card text-white bg-info mb-3" style="max-width: 100rem;">
        <div class="card-body text-center">
          <h4 class="card-title">Datos del convenio</h4>
        </div>                  
    </div>
  </div>
</div>
<div class="container">
    <article class="container col-12 mx-auto p-0">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="conve_id" class="form-label"><b>CONVENIO ID</b></label>
                    <input type="text" class="form-control" id="conve_id" name="conve_id"  value="{{ $registro->id }}"  readonly required>
                </div>
                <div class="col-md-6">
                    <label for="organismo_financiador" class="form-label"><b>ORGANISMO FINANCIADOR</b></label>
                    <input type="text" class="form-control" id="organismo_financiador" name="organismo_financiador"  value="{{ $registro->organismo_financiador }}"  readonly required>
                </div>
                <div class="col-md-6">
                    <label for="nombre_proyecto" class="form-label"><b>NOMBRE DEL PPROYECTO</b></label>
                    <input type="text" class="form-control" id="nombre_proyecto" name="nombre_proyecto" value="{{ $registro->nombre_proyecto }}" readonly required>
                </div>
                <div class="col-md-6">
                    <label for="tipo_rendicion" class="form-label"><b>TIPO DE RENDICIÓN</b></label>
                    <input type="text" step=".01" class="form-control" id="tipo_rendicion" name="tipo_rendicion" min="0" value="{{ $registro->tipo_rendicion }}"  readonly required>
                </div>    
                <div class="col-md-6">
                    <label for="monto" class="form-label"><b>MONTO TOTAL</b></label>
                    <input type="number" step=".01" class="form-control" id="monto" name="monto" min="0" value="{{ $registro->monto }}" readonly required>
                </div>   
                <div class="col-md-6">
                    <label for="monto_recibido" class="form-label"><b>MONTO RECIBIDO</b></label>
                    <input type="number" step=".01" class="form-control" id="monto_recibido" name="monto_recibido" min="0" value="{{ $registro->monto_recibido }}"readonly required>
                </div>               

            </div> 	
  
    </article>

    <br>

    <div class="col-lg-12"> 
      <div class="table-responsive">  
          <table id="tablaConvenios" class="table table-striped table-hover table-bordered display" cellspacing="0" style="width:100%">
              <meta name="csrf-token_convenios" content="{{ csrf_token() }}">
              <thead class="thead-dark text-center">
                  <tr>
                      <th>ORDEN DE COMPRA</th>
                      <th>IMPORTE ORDEN COMPRA</th>
                      <th>N° FACTURA</th>
                      <th>FECHA EMISION</th>
                      <th>BENEFICIARIO</th>
                      <th>CUIT</th>
                      <th>IMPORTE</th>
                      <th>CAE</th>
                      <th>N° DE PAGO</th>
                      <th>FECHA DE PAGO</th>
                      {{-- <th>VER</th> --}}
                  </tr>    
              </thead>
              <tbody>

              </tbody>
          </table>
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
    
        tablaConvenios = $('#tablaConvenios').DataTable( 
        {
        //"dom": '<"dt-buttons"Bf><"clear">lirtp',
        "ajax":{            
                        "headers": { 'X-CSRF-TOKEN': $('meta[name="csrf-token_convenios"]').attr('content') },    
                        "url": "{{route('empleado.datosdelconvenio')}}", 
                        "method": 'post', //usamos el metodo POST
                        "data":{
                            '_token': $('input[name=_token]').val(),
                            opcion:opcion}, //enviamos opcion 1 para que haga un SELECT
                        "dataSrc":""
                    },
        "columns": [
                        { data: "orden_compra"},
                        { data: "importe_compra"},
                        { data: "nro_factura"},
                        { data: "fecha_emision"},
                        { data: "beneficiario" },
                        { data: "cuit" },
                        { data: "importe" },
                        { data: "cae" },    
                        { data: "nro_pago" },
                        { data: "fecha_pago" },
                        // {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnVer'><i class='fas fa-eye'></i></button></div></div>"},
                        
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
         "dom": 'Bfrtilp',
         'columnDefs': [
                          {'max-width': '20%', 'targets': 0}
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
    
                    }
                },
                {
                    extend:    'print',
                    text:      '<i class="fas fa-print"></i> IMPRIMIR',
                    titleAttr: 'Imprimir',
                    className: 'btn btn-secondary',
                    autoPrint: true,
                    exportOptions: {
                        columns: ':visible',
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

        //Borrar
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

            var url = "{{route('empleado.verconvenio', '')}}"+"/"+id;
            window.open(url, "Convenio")

        }) 

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