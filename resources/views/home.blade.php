@extends('layouts.app')

@section('content')
    <!-- Modal observarion-->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Observacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Observaciones:</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="guardarObservacionModal">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal table -->
    <div class="modal fade bd-example-modal-xl" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Libros preseleccionados</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="example2" class="mt-3 table table-striped table-bordered dt-responsive nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th width="20%">Título</th>
                                <th>Editorial</th>
                                <th>Nivel de lectura</th>
                                <th>Género</th>
                                <th>Categoria</th>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
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
                        <table id="example3" class="mt-3 table table-striped table-bordered dt-responsive nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th width="20%">Título</th>
                                <th>Editorial</th>
                                <th>Nivel de lectura</th>
                                <th>Género</th>
                                <th>Categoria</th>
                                <th>Distribuidor</th>
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
                                    <td><button class="btn btn-sm btn-danger eliminar" value={{$libroU->libros->id}}>Eliminar</button></td>
                                    <td hidden>{{$libroU->libros->id}}</td>
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
        <br>
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                         aria-labelledby="v-pills-home-tab">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <h3>Preselección</h3>
                        </div>
                        <hr>
                        <div class="border-top col-sm-12 col-md-12 col-lg-12">
                            <button type="button" class="btn btn-primary mt-3 btn-sm" id="preseleccionados">
                                Cantidad de libros preseleccionados <span class="badge badge-light"
                                                                          id="numeropreseleccion">0</span>
                                <span class="sr-only">unread messages</span>
                            </button>
                            <button type="button" class="btn btn-success mt-3 btn-sm" id="registrar"> Registrar libros</button>
                            <button type="button" class="btn btn-warning mt-3 btn-sm" id="ver"> Ver libros seleccionados</button>
                            <br>
                            <br>
                            <table id="example" class="mt-3 table table-striped table-bordered dt-responsive nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>.
                                    <th>Check</th>
                                    <th width="20%">Título</th>
                                    <th>Editorial</th>
                                    <th>Nivel de lectura</th>
                                    <th>Género</th>
                                    <th>Categoria</th>
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
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            var idObjectModal = null;
            var objectoLibros = [];
            var tablePreseleccionLibros = $('#example').DataTable({
                //processing: true,
                //serverSide: true,
                'ajax': "{{ route('libros_dt')}}",
                'columns': [
                    {
                        data: 'check', className: 'text-center',
                        defaultContent: '<div class="i-checks"><label> <input class="checkPartial" type="checkbox"  value=""> <i></i> </label></div>'
                    },
                    {data: 'titulo', "width": "20%"},
                    {data: 'editorial', className: 'text-center'},
                    {data: 'nivel_lectura', className: 'text-center'},
                    {data: 'genero', className: 'text-center'},
                    {data: 'categoria', className: 'text-center'},
                    {data: 'proveedor', className: 'text-center'},
                    {data: 'autor', className: 'text-center'},
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

            $('#example thead th').each( function (index,value) {
                console.log(index,value)
                if(index == 3 || index == 4 || index == 5 ){
                    var title = $(this).text();
                    $(this).html($(this).text()+'<br><input type="text" placeholder="Buscar '+title+'" />' );
                }

            } );
            var tableListaPreseleccionLibros = $('#example2').DataTable({
            });
            var tableRegistroPreseleccionLibros = $('#example3').DataTable({
            });


            tablePreseleccionLibros.columns().every( function () {
                var that = this;

                $( 'input', this.header() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            tablePreseleccionLibros.on('click', '.checkPartial', function (e) {
                $tr = $(this).closest('tr');
                if ($(this).prop("checked") == true) {
                    $('#exampleFormControlTextarea1').val('');
                    let dataTable = tablePreseleccionLibros.row($tr).data();
                    console.log(dataTable)
                    objectoLibros.push(
                        {
                            id: dataTable.id,
                            observacion: "",
                            data:dataTable
                        });
                    idObjectModal = dataTable.id
                    //$('#exampleModalCenter').modal('show')
                    console.log(objectoLibros);
                } else {
                    let dataTable = tablePreseleccionLibros.row($tr).data();

                    objectoLibros = objectoLibros.filter(function (idLibro) {
                        return idLibro.id != dataTable.id;
                    });
                }
                $('#numeropreseleccion').html(objectoLibros.length);
            });

            $('#registrar').on('click', function () {

                if (objectoLibros.length === 0) {
                    swal({
                        title: "No se puede registrar!",
                        text: "No existen libros preseleccionados!",
                        icon: "warning",
                        button: "Ok",
                    });
                } else {
                    var route = '{{ route('registrar_libros_para_comite') }}';
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
                            console.log(response)
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

            $('#guardarObservacionModal').on('click', function () {

                objectoLibros.find((o, i) => {
                    if (o.id === idObjectModal) {
                        objectoLibros[i].observacion = $('#exampleFormControlTextarea1').val()
                        return true;
                    }
                });

                $('#exampleModalCenter').modal('hide')
            })

            $('#preseleccionados').on('click', function () {
                var newData = '';
                if($.fn.dataTable.isDataTable('#example2')){
                    //tableListaPreseleccionLibros.clear().draw();
                    tableListaPreseleccionLibros.destroy();
                    $('#example2 tbody').html('');
                    $.each(objectoLibros, function (keyFirst, value) {
                        newData += "<tr><td>" + value.data.titulo + "</td>";
                        newData += "<td>" + value.data.editorial + "</td>";
                        newData += "<td>" + value.data.nivel_lectura + "</td>";
                        newData += "<td>" + value.data.genero + "</td>";
                        newData += "<td>" + value.data.categoria + "</td>";
                        newData += "<td>" + value.data.proveedor + "</td>";
                        newData += "<td>" + value.data.autor + "</td>";
                        newData += "<td>" + value.data.isbn + "</td></tr>";
                    });
                    $('#example2').append(newData);
                }
                $('#exampleModalCenter2').modal('show')
            })
            $('#exampleModalCenter2').on('shown.bs.modal', function() {
                tableListaPreseleccionLibros = $('#example2').DataTable({
                })
            });
            $('#ver').on('click',function(){
                tableRegistroPreseleccionLibros.destroy();
               $('#exampleModalCenter3').modal('show')
            })
            $('#exampleModalCenter3').on('shown.bs.modal', function() {
                tableRegistroPreseleccionLibros = $('#example3').DataTable({
                })
            });
            tableRegistroPreseleccionLibros.on('click', '.eliminar', function (e) {
                $tr = $(this).closest('tr');
                let dataTable = tableRegistroPreseleccionLibros.row($tr).data();
                console.log(dataTable,typeof dataTable)
                if(dataTable === undefined){
                    console.log('ingresa');
                    $row = $tr.prev('tr')
                    dataTable = tableRegistroPreseleccionLibros.row($row).data();
                }
                console.log(dataTable)
                var route = '{{ route('elminar_libro_preseleccion') }}';
                var typeAjax = 'POST';
                var async = async || false;
                var formDatas = new FormData();
                formDatas.append('libro_id', dataTable[9]);
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
                            text: "Libros eliminado!",
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
        });
    </script>
@endsection
