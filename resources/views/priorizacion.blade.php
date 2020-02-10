@extends('layouts.app')

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Priorización</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 align-content-center" style="text-align-last: center;">
                            <button class="btn btn-success calificacion" value="10">Muy alta</button>
                        </div>
                        <div class="col-md-3 align-content-center" style="text-align-last: center;">
                            <button class="btn btn-warning calificacion" value="8">Alta</button>
                        </div>
                        <div class="col-md-3" style="text-align-last: center;">
                            <button class="btn btn-primary calificacion" value="6">Media</button>
                        </div>
                        <div class="col-md-3" style="text-align-last: center;">
                            <button class="btn btn-danger calificacion" value="4">Baja</button>
                        </div>
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
                        <table id="example" class="mt-3 table table-striped table-bordered dt-responsive nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th width="20%">Título</th>
                                <th>Editorial</th>
                                <th>Nivel de lectura</th>
                                <th>Género</th>
                                <th>Categoria</th>
                                <th>Priorización</th>
                                <th>Distribuidor</th>
                                <th>Autor</th>
                                <th>ISBN</th>
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
                                    @switch ($libroU->priorizacion)
                                        @case('10')
                                            <td><h5><span class="badge badge-success">Muy Alta</span></h5></td>
                                        @break
                                        @case('8')
                                            <td><h5><span class="badge badge-warning">Alta</span></h5></td>
                                        @break
                                        @case('6')
                                            <td><h5><span class="badge badge-primary">Media</span></h5></td>
                                        @break
                                        @case('4')
                                            <td><h5><span class="badge badge-danger">Baja</span></h5></td>
                                        @break
                                    @endswitch
                                    <td>{{$libroU->libros->proveedor}}</td>
                                    <td>{{$libroU->libros->autor}}</td>
                                    <td>{{$libroU->libros->isbn}}</td>
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

    <div class=" container-fluid">
        <div class="mt-3 col-sm-12 col-md-12 col-lg-12">
            <h3>Priorización</h3>
        </div>
        <hr>
        <div class="border-top my-3 col-sm-12 col-md-12 col-lg-12" >
            <br>
            <button class="btn btn-primary" id="finalizar_registro">Finalizar registro de priorización</button>
            <button class="btn btn-warning" id="ver">ver libros priorizados</button>
            <br><br>
            <!--table table-striped table-bordered dt-responsive nowrap-->
            <table id="example2" class="table table-striped table-bordered dt-responsive nowrap"
                   style="width:100%">
                <thead>
                <tr>
                    <th width="20%">Título</th>
                    <th>Editorial</th>
                    <th>Nivel de lectura</th>
                    <th>Género</th>
                    <th>Categoria</th>
                    <th>Priorización</th>
                    <th>Evaluar</th>
                    <th>Distribuidor</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                    <th hidden>nivel_id</th>
                    <th hidden>genero_id</th>
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
            var evaluarCupos = null;
            $row = null
            var objectCuposPriorizacion = [];
            var objectLibrosPriorizacion = [];
            var tablePreseleccionComiteLibros = $('#example2').DataTable({
                "processing": true,
                "serverSide": false,
                'ajax': "{{ route('libros_priorizacion_dt')}}",
                'columns': [
                    {data: 'titulo', "width": "20%"},
                    {data: 'editorial', className: ''},
                    {data: 'nivel_lectura', className: 'text-center'},
                    {data: 'genero', className: 'text-center'},
                    {data: 'categoria', className: 'text-center'},
                    {data: 'priorizacion', className: 'text-center'},
                    {data: 'evaluar', className: 'text-center'},
                    {data: 'proveedor', className: ''},
                    {data: 'autor', className: ''},
                    {data: 'isbn', className: ''},
                    {data: 'nivel_id', "visible": false,},
                    {data: 'genero_id', "visible": false,},
                ]
            });

            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                    }
                ],
            });
            tablePreseleccionComiteLibros.on('click', '.evaluardt', function (e) {
                $tr = $(this).closest('tr');
                let dataTable = tablePreseleccionComiteLibros.row($tr).data();
                if(dataTable === undefined){
                    $row = $tr.prev('tr')
                }else{
                    $row = $tr
                }
                console.log(dataTable);
                $('#exampleModalCenter').modal('show')

            });
            $('.calificacion').on('click',function(){
                console.log(this.value);
                var priorizacion = this.value;
                let dataTable = tablePreseleccionComiteLibros.row($row).data();
                switch (this.value) {
                    case '10':
                        dataTable.priorizacion = '<h5><span class="badge badge-success">Muy Alta</span></h5>'
                        break;
                    case '8':
                        dataTable.priorizacion = '<h5><span class="badge badge-warning">Alta</span></h5>'
                        break;
                    case '6':
                        dataTable.priorizacion = '<h5><span class="badge badge-primary">Media</span></h5>'
                        break;
                    case '4':
                        dataTable.priorizacion = '<h5><span class="badge badge-danger">Baja</span></h5>'
                        break;
                }
                if( evaluarCupos != null){
                    if( evaluarCupos == 1 ){
                        objectCuposPriorizacion.find((o, i) => {
                            if (parseInt(o.edad_lectura_id) ===  parseInt(dataTable.nivel_id)) {
                                objectCuposPriorizacion[i].cupo--
                                objectCuposPriorizacion[i].priorizado++
                                $(`#edadCompletar${o.edad_lectura_id}`).val(objectCuposPriorizacion[i].priorizado);
                                return true;
                            }
                        });
                        const index = objectLibrosPriorizacion.findIndex(objectLibrosPriorizacion => objectLibrosPriorizacion.id === dataTable.id);
                        if( index === -1){
                            objectLibrosPriorizacion.push({
                                id:dataTable.id,
                                libro_id:dataTable.libro_id,
                                priorizacion:priorizacion
                            })
                        }else{
                            objectLibrosPriorizacion[index].priorizacion = priorizacion

                        }
                        console.log(objectCuposPriorizacion,index,objectLibrosPriorizacion);
                    }
                    else{
                        objectCuposPriorizacion.find((o, i) => {
                            if (parseInt(o.genero_id) ===  parseInt(dataTable.genero_id)) {
                                objectCuposPriorizacion[i].cupo--
                                objectCuposPriorizacion[i].priorizado++
                                $(`#edadCompletarG${o.genero_id}`).val(objectCuposPriorizacion[i].priorizado);
                                return true;
                            }
                        });
                        const index = objectLibrosPriorizacion.findIndex(objectLibrosPriorizacion => objectLibrosPriorizacion.id === dataTable.id);
                        if( index === -1){
                            objectLibrosPriorizacion.push({
                                id:dataTable.id,
                                libro_id:dataTable.libro_id,
                                priorizacion:priorizacion
                            })
                        }else{
                            objectLibrosPriorizacion[index].priorizacion = priorizacion

                        }
                        console.log(objectCuposPriorizacion,index,objectLibrosPriorizacion);
                    }

                }
                tablePreseleccionComiteLibros.row($row).data(dataTable).draw(false);
                $('#exampleModalCenter').modal('hide')
            })
            $('#finalizar_registro').on('click',function(){
                var route = '{{ route('registrar_calificacion_priorizacion') }}';
                var typeAjax = 'POST';
                var async = async || false;
                var formDatas = new FormData();
                formDatas.append('objetolibros', JSON.stringify(objectLibrosPriorizacion));
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
            })
            $('#ver').on('click', function () {
                $('#exampleModalCenter3').modal('show')
            });
        } );
    </script>
@endsection
