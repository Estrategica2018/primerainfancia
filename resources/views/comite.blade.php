@extends('layouts.app')

@section('content')

    <!-- Modal table libros registrados -->
    <div class="modal fade bd-example-modal-xl" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Libros registrados</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="example" class="mt-3 table table-striped table-bordered dt-responsive nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th width="20%">Título</th>
                                <th>Editorial</th>
                                <th>Nivel de lectura</th>
                                <th>Género</th>
                                <th>Categoria</th>
                                <th>Ditribuidor</th>
                                <th>Autor</th>
                                <th>ISBN</th>
                                <th>Acción</th>
                                <th hidden>libro_id</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($libros as $libroU)
                                <tr>
                                    <td>{{$libroU->libros->titulo}}</td>
                                    <td>{{$libroU->libros->editorial}}</td>
                                    <td>{{$libroU->libros->edadf->nombre}}</td>
                                    <td>{{$libroU->libros->generof->nombre}}</td>
                                    <td>{{$libroU->libros->categoriaf->nombre}}</td>
                                    <td>{{$libroU->libros->proveedor}}</td>
                                    <td>{{$libroU->libros->autor}}</td>
                                    <td>{{$libroU->libros->isbn}}</td>
                                    <td><button class="btn btn-sm btn-danger eliminar">Eliminar</button></td>
                                    <td hidden>{{$libroU->libro_id}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="mt-3 col-sm-12 col-md-12 col-lg-12">
            <h3>Comite editorial</h3>
        </div>
        <div class="border-top my-3 col-sm-12 col-md-12 col-lg-12" >
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-success btn-sm" id="registrar">Registrar libros</button>
                    <button class="btn btn-warning btn-sm" id="ver">Ver libros seleccionados</button>
                </div>
                <div class="col-md-4">
                    <h5 id="infoLiteratios">Nº libros literarios : {{$librosLiterarios}} </h5>
                </div>
                <div class="col-md-4">
                    <h5 id="infoInformativos">Nº de libros informativos :{{$librosInformativos}}</h5>
                </div>
            </div>
            <br><br>
            <table id="example2" class="table table-striped table-bordered dt-responsive nowrap"
                   style="width:100%">
                <thead>
                <tr>
                    <th>Check</th>
                    <th width="20%">Título</th>
                    <th>Editorial</th>
                    <th>Nivel lectura</th>
                    <th>Género</th>
                    <th>Categoria</th>
                    <th>Coin/cia Pre</th>
                    <th>Coin/cia Comi</th>
                    <th>Distribuidor</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            var librosSeleccionados = <?php echo json_encode($libros); ?>;
            console.log(librosSeleccionados);
            var infoLiterario = "{{$librosLiterarios}}"
            var infoInformativo = "{{$librosInformativos}}"
            var objectoLibros = [];
            var tablePreseleccionComiteLibros = $('#example2').DataTable({
                //processing: true,
               // serverSide: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Exportar a excel',
                        filename: function(){
                            return `listado de libros en comite`

                        },
                        title:function(){
                            return 'listado de libros en comite'
                        },
                        exportOptions: {
                            columns: [ 1, 2, 3, 4, 5, 6, 8, 9, 10 ]
                        }
                    }
                ],
                'ajax': "{{ route('libros_preseleccion_dt')}}",
                'columns': [
                    {
                        data: 'check', className: 'text-center',
                        defaultContent: '<div class="i-checks"><label> <input class="checkPartial" type="checkbox"  value=""> <i></i> </label></div>'
                    },
                    {data: 'titulo', "width": "20%"},
                    {data: 'editorial', className: ''},
                    {data: 'nivel_lectura', className: 'text-center'},
                    {data: 'genero', className: 'text-center'},
                    {data: 'categoria', className: 'text-center'},
                    {data: 'coincidenciapre', className: 'text-center'},
                    {data: 'coincidenciacom', visible: false},
                    {data: 'proveedor', className: ''},
                    {data: 'autor', className: ''},
                    {data: 'isbn', className: 'text-center'},
                ],
                order: [[1, "asc"]],
                columnDefs: [
                    {
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0
                    },
                ],
                retrieve: true,
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                }
            });

            $('#example2 thead th').each( function (index,value) {
                console.log(index,value)
                if(index == 3 || index == 4 || index == 5 ){
                    var title = $(this).text();
                    $(this).html($(this).text()+'<br><input type="text" placeholder="Buscar '+title+'" />' );
                }

            });
            tablePreseleccionComiteLibros.columns().every( function () {
                var that = this;

                $( 'input', this.header() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            var tableLibrosSeleccionados = $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Exportar a excel',
                        filename: function(){
                            return `Registro individual de comite`

                        },
                        title:function(){
                            return 'listado de libros seleccionados en comite'
                        },
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                        }
                    }
                ],
            })


            tablePreseleccionComiteLibros.on('click', '.checkPartial', function (e) {
                $tr = $(this).closest('tr');
                let dataTable = tablePreseleccionComiteLibros.row($tr).data();
                const index = librosSeleccionados.findIndex(librosSeleccionados => librosSeleccionados.libro_id === parseInt(dataTable.libro_id));
                if ($(this).prop("checked") == true) {
                    $('#exampleFormControlTextarea1').val('');

                    objectoLibros.push(
                        {
                            id: dataTable.id,
                            libro_id:dataTable.libro_id,
                        });

                    if( index === -1){
                        if(dataTable.categoria == 'Literario'){
                            infoLiterario = parseInt(infoLiterario)
                            infoLiterario++
                        }else
                        {
                            infoInformativo = parseInt(infoInformativo)
                            infoInformativo++
                        }
                    }


                } else {

                    objectoLibros = objectoLibros.filter(function (idLibro) {
                        return idLibro.id != dataTable.id;
                    });
                    if(index === -1){
                        if(dataTable.categoria == 'Literario'){
                            infoLiterario = parseInt(infoLiterario)
                            infoLiterario--
                        }else
                        {
                            infoInformativo = parseInt(infoInformativo)
                            infoInformativo--
                        }
                    }

                }

                $('#infoInformativos').html(`Nº libros infotmativos : ${infoInformativo}`)
                $('#infoLiteratios').html(`Nº libros literarios : ${infoLiterario}`)
            });

            $('#registrar').on('click', function () {
                if (objectoLibros.length === 0) {
                    swal({
                        title: "No se puede registrar!",
                        text: "No existen libros seleccionados!",
                        icon: "warning",
                        button: "Ok",
                    });
                } else {
                    var route = '{{ route('registrar_libros_para_priorizacion') }}';
                    var typeAjax = 'POST';
                    var async = async || false;
                    var formDatas = new FormData();
                    formDatas.append('objetolibros', JSON.stringify(objectoLibros));
                    $.ajax({
                        url: route,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        cache: false,
                        type: typeAjax,
                        contentType: false,
                        data: formDatas,
                        processData: false,
                        async: async,
                        beforeSend: function () {

                        },
                        success: function (response, xhr, request) {
                            swal({
                                title: "Buen trabajo!",
                                text: "Libros registrados!",
                                icon: "success",
                                button: "Ok",
                            }).then((willDelete) => {
                                if (willDelete) {
                                    location.reload();
                                } else {
                                    location.reload();
                                }
                            });
                        },
                        error: function (response, xhr, request) {

                        }
                    });

                }
            });
            $('#ver').on('click', function () {
                $('#exampleModalCenter3').modal('show')
            });

            tableLibrosSeleccionados.on('click', '.eliminar', function (e) {
                $tr = $(this).closest('tr');
                let dataTable = tableLibrosSeleccionados.row($tr).data();
                console.log(dataTable,typeof dataTable)
                if(dataTable === undefined){
                    console.log('ingresa');
                    $row = $tr.prev('tr')
                    dataTable = tableLibrosSeleccionados.row($row).data();
                }
                console.log(dataTable)
                var route = '{{ route('elminar_libro_preseleccion') }}';
                var typeAjax = 'POST';
                var async = async || false;
                var formDatas = new FormData();
                formDatas.append('libro_id', dataTable[9]);
                formDatas.append('tipo_lista', 2);
                $.ajax({
                    url: route,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    cache: false,
                    type: typeAjax,
                    contentType: false,
                    data: formDatas,
                    processData: false,
                    async: async,
                    beforeSend: function () {

                    },
                    success: function (response, xhr, request) {
                        console.log(response)
                        swal({
                            title: "Buen trabajo!",
                            text: "Libro eliminado!",
                            icon: "success",
                            button: "Ok",
                        }).then((willDelete) => {
                            if (willDelete) {
                                location.reload();
                            } else {
                                location.reload();
                            }
                        });

                    },
                    error: function (response, xhr, request) {

                    }
                });

            });

        } );
    </script>
@endsection
