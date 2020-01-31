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
                                <th>ISBN</th>
                                <th width="20%">Título</th>
                                <th>Autor</th>
                                <th>Editorial</th>
                                <th>Nivel de lectura</th>
                                <th>Género</th>
                                <th>Observación</th>
                                <th>Proveedor</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="guardarObservacionModal">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                         aria-labelledby="v-pills-home-tab">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <h3>Preselección</h3>
                        </div>
                        <hr>
                        <div class="border-top my-3 col-sm-12 col-md-12 col-lg-12">
                            <button type="button" class="btn btn-primary mt-3" id="preseleccionados">
                                Cantidad de libros preseleccionados <span class="badge badge-light"
                                                                          id="numeropreseleccion">0</span>
                                <span class="sr-only">unread messages</span>
                            </button>
                            <button type="button" class="btn btn-success mt-3" id="registrar"> Registrar libros</button>
                            <br>
                            <br>
                            <table id="example" class="mt-3 table table-striped table-bordered dt-responsive nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>Check</th>
                                    <th>ISBN</th>
                                    <th width="20%">Título</th>
                                    <th>Autor</th>
                                    <th>Editorial</th>
                                    <th>Nivel de lectura</th>
                                    <th>Género</th>
                                    <th>Proveedor</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <h3>Comité educativo</h3>
                        </div>
                        <hr>
                        <div class="border-top my-3 col-sm-12 col-md-12 col-lg-12">
                            <br>
                            <form class="was-validated">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="customControlValidation2"
                                           name="radio-stacked" required>
                                    <label class="custom-control-label" for="customControlValidation2">Rango
                                        edades</label>
                                </div>
                                <div class="custom-control custom-radio mb-3">
                                    <input type="radio" class="custom-control-input" id="customControlValidation3"
                                           name="radio-stacked" required>
                                    <label class="custom-control-label" for="customControlValidation3">Género</label>
                                    <div class="invalid-feedback">Seleccione el tipo de filtro</div>
                                </div>
                            </form>
                            <br>
                            <table id="example2" class="table table-striped table-bordered dt-responsive nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>Check</th>
                                    <th>ISBN</th>
                                    <th width="20%">Título</th>
                                    <th>Autor</th>
                                    <th>Editorial</th>
                                    <th>Proveedor</th>
                                    <th>Nivel de lectura</th>
                                    <th>Género</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                         aria-labelledby="v-pills-messages-tab">...
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
                processing: true,
                serverSide: true,
                'ajax': "{{ route('libros_dt')}}",
                'columns': [
                    {
                        data: 'check', className: 'text-center',
                        defaultContent: '<div class="i-checks"><label> <input class="checkPartial" type="checkbox"  value=""> <i></i> </label></div>'
                    },
                    {data: 'isbn', className: 'text-center'},
                    {data: 'titulo', "width": "20%"},
                    {data: 'autor', className: 'text-center'},
                    {data: 'editorial', className: 'text-center'},
                    {data: 'nivel_lectura', className: 'text-center'},
                    {data: 'genero', className: 'text-center'},
                    {data: 'proveedor', className: 'text-center'},
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
            var tableListaPreseleccionLibros = $('#example2').DataTable({
            });

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
                    $('#exampleModalCenter').modal('show')
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
                        newData += "<tr><td>" + value.data.isbn + "</td>";
                        newData += "<td>" + value.data.titulo + "</td>";
                        newData += "<td>" + value.data.autor + "</td>";
                        newData += "<td>" + value.data.editorial + "</td>";
                        newData += "<td>" + value.data.nivel_lectura + "</td>";
                        newData += "<td>" + value.data.genero + "</td>";
                        newData += "<td>" + value.observacion + "</td>";
                        newData += "<td>" + value.data.proveedor + "</td></tr>";
                    });
                    $('#example2').append(newData);
                }
                $('#exampleModalCenter2').modal('show')
            })
            $('#exampleModalCenter2').on('shown.bs.modal', function() {
                tableListaPreseleccionLibros = $('#example2').DataTable({
                })
            });
        });
    </script>
@endsection
