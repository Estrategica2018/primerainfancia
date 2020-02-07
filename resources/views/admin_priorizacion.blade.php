@extends('layouts.app')

@section('content')
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
                        <table id="libros_preseleccion_usuarios" class="mt-3 table table-striped table-bordered dt-responsive nowrap"
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
                                <th>Distribuidor</th>
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
                        <table id="example" class="mt-3 table table-striped table-bordered dt-responsive nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>ISBN</th>
                                <th width="20%">Título</th>
                                <th>Autor</th>
                                <th>Editorial</th>
                                <th>Nivel de lectura</th>
                                <th>Género</th>
                                <th>Distribuidor</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($libros as $libroU)
                                <tr>
                                    <td>{{$libroU->libros->isbn}}</td>
                                    <td>{{$libroU->libros->titulo}}</td>
                                    <td>{{$libroU->libros->autor}}</td>
                                    <td>{{$libroU->libros->editorial}}</td>
                                    <td>{{$libroU->libros->edadf->nombre}}</td>
                                    <td>{{$libroU->libros->generof->nombre}}</td>
                                    <td>{{$libroU->libros->proveedor}}</td>
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
        <div class="border-top my-3 col-sm-12 col-md-12 col-lg-12" >
            <br><br><br>
            <div class="row">
                <div class="col-md-2">
                    <form class="was-validated">
                        <div class="custom-control custom-radio">
                            @if($tipoPriorizacion === "rango_edad")
                                <input {{$disabled}} checked type="radio" class="custom-control-input check1" id="customControlValidation2" name="radio-stacked" required>
                            @else
                                <input {{$disabled}} checked type="radio" class="custom-control-input check1" id="customControlValidation2" name="radio-stacked" required>
                            @endif
                            <label class="custom-control-label" for="customControlValidation2">Rango edades</label>
                        </div>
                        <div class="custom-control custom-radio mb-3">
                            @if($tipoPriorizacion === "rango_genero")
                                <input {{$disabled}} checked type="radio" class="custom-control-input check1" id="customControlValidation2" name="radio-stacked" required>
                            @else
                                <input {{$disabled}} type="radio" class="custom-control-input check2" id="customControlValidation3" name="radio-stacked" required>
                            @endif

                            <label class="custom-control-label" for="customControlValidation3">Género</label>
                            <div class="invalid-feedback">Seleccione el tipo de filtro</div>
                        </div>
                    </form>
                </div>
                <div class="col-md-10">
                    @if($hiddenGenero == "hidden")
                        <form action="javascript:void(0);" class="was-validated" id="rango_edades" {{$hiddenEdad}}>
                            <h4>Rango de edades</h4>
                            <div class="form-row">
                                @foreach($edadeslecturas as $edadlectura)
                                    <div class="col-md-3 mb-3">
                                        <label>{{$edadlectura->nombre}}</label>
                                        @if($registroPriorizacion)
                                            <input disabled type="number" class="form-control is-valid" id="edad{{$edadlectura->id}}"  required value={{\App\EdadLecturaPrioriza::select('cupo')->where('edad_lectura_id',$edadlectura->id)->first()->cupo}}></input>
                                        @else
                                            <input type="number" class="form-control is-invalid" id="edad{{$edadlectura->id}}"  required></input>
                                        @endif
                                        <div class="valid-feedback">
                                            Correcto
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if(!$registroPriorizacion)
                                @if(auth()->user()->hasAnyRole(['admin_comite','administrador_plataforma']))
                                    <button class="btn btn-primary" id="registrarEdad">Registrar</button>
                                @endif
                            @endif
                        </form>
                    @endif

                    <form action="javascript:void(0);" class="was-validated" id="rango_generos" {{$hiddenGenero}}>
                        <h4>Géneros</h4>
                        <div class="form-row">
                            @foreach($generos as $genero)
                                <div class="col-md-3 mb-3">
                                    <label>{{$genero->nombre}}</label>
                                    @if($registroPriorizacion)
                                        @if($hiddenGenero != "hidden")
                                            <input  disabled type="number" class="form-control is-valid" id="genero{{$genero->id}}"  required value={{\App\GeneroPrioriza::select('cupo')->where('genero_id',$genero->id)->first()->cupo}}></input>
                                        @endif
                                    @else
                                        <input onchange="sumar(this.value)" type="number" class="form-control is-invalid" id="genero{{$genero->id}}"  required></input>
                                    @endif
                                    <div class="valid-feedback">
                                        Correcto
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if(!$registroPriorizacion)
                            @if(auth()->user()->hasAnyRole(['admin_comite','administrador_plataforma']))
                                <button class="btn btn-primary" type="" id="registrarGenero">Registrar</button>
                            @endif
                        @endif
                        <button type="button" class="btn btn-warning">
                            Libros para colección <span class="badge badge-light"
                                                        id="numeropreseleccion">0</span>
                            <span class="sr-only">unread messages</span>
                        </button>
                    </form>

                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <form action="javascript:void(0);" class="was-validated" id="" >
                            <h4>Porcentaje colección</h4>
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label>Informativo %</label>

                                    <input type="text" class="form-control is-invalid" id="informativo"  required value={{$informativoPorcentaje}}></input>
                                    <div class="valid-feedback">
                                        Correcto
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Literario %</label>
                                    <input type="text" class="form-control is-invalid" id="literario"  required value={{$literarioPorcentaje}}></input>
                                    <div class="valid-feedback">
                                        Correcto
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
            @if(auth()->user()->hasAnyRole(['admin_comite','administrador_plataforma']))
                <div class="row my-3">
                    <div class="col-md-12">
                        <table id="example3" class="table table-striped table-bordered dt-responsive nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Cedula</th>
                                <th>Correo</th>
                                <th>Entidad</th>
                                <th>Cargo</th>
                                <th class="text-center">Libros</th>
                                <th hidden></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($usuarios as $usario)
                                <tr>
                                    <td>{{$usario->name}}</td>
                                    <td>{{$usario->numero_identificacion}}</td>
                                    <td>{{$usario->email}}</td>
                                    <td>{{$usario->entidad}}</td>
                                    <td>{{$usario->cargo}}</td>
                                    <td class="text-center"><button class="btn btn-success ver_libros btn-sm">
                                            <svg class="bi bi-book" width="40px" height="22px" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M5.214 3.072c1.599-.32 3.702-.363 5.14 1.074a.5.5 0 01.146.354v11a.5.5 0 01-.854.354c-.843-.844-2.115-1.059-3.47-.92-1.344.14-2.66.617-3.452 1.013A.5.5 0 012 15.5v-11a.5.5 0 01.276-.447L2.5 4.5l-.224-.447.002-.001.004-.002.013-.006a5.116 5.116 0 01.22-.103 12.958 12.958 0 012.7-.869zM3 4.82v9.908c.846-.343 1.944-.672 3.074-.788 1.143-.118 2.387-.023 3.426.56V4.718c-1.063-.929-2.631-.956-4.09-.664A11.958 11.958 0 003 4.82z" clip-rule="evenodd"></path>
                                                <path fill-rule="evenodd" d="M14.786 3.072c-1.598-.32-3.702-.363-5.14 1.074A.5.5 0 009.5 4.5v11a.5.5 0 00.854.354c.844-.844 2.115-1.059 3.47-.92 1.344.14 2.66.617 3.452 1.013A.5.5 0 0018 15.5v-11a.5.5 0 00-.276-.447L17.5 4.5l.224-.447-.002-.001-.004-.002-.013-.006-.047-.023a12.582 12.582 0 00-.799-.34 12.96 12.96 0 00-2.073-.609zM17 4.82v9.908c-.846-.343-1.944-.672-3.074-.788-1.143-.118-2.386-.023-3.426.56V4.718c1.063-.929 2.631-.956 4.09-.664A11.956 11.956 0 0117 4.82z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </td>
                                    <td hidden>{{$usario->id}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            @endif
            <hr>
            <button class="btn btn-success" id="registrar">Enviar lista a logística de priorización</button>
            <button class="btn btn-warning" id="ver">Libros registrados</button>
            <br><br>
            <table id="example2" class="table table-striped table-bordered dt-responsive nowrap"
                   style="width:100%">
                <thead>
                <tr>
                    <th>Check</th>
                    <th>ISBN</th>
                    <th width="20%">Título</th>
                    <th>Autor</th>
                    <th>Editorial</th>
                    <th>Distribuidor</th>
                    <th>Nivel lectura</th>
                    <th>Género</th>
                    <th>Categoria</th>
                    <th>Coin/cia Pre</th>
                    <th>Coin/cia Comi</th>
                    <th hidden>categoria_id</th>
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
            var literarioPorcentaje = "{{$literarioPorcentaje}}"
            var informativoPorcentaje = "{{$informativoPorcentaje}}"
            var lengEdadLectura ="{{count($edadeslecturas)}}"
            var lengGeneros ="{{count($generos)}}"
            var objectoLibros = [];
            var tablePreseleccionComiteLibros = $('#example2').DataTable({
                processing: true,
                serverSide: true,
                'ajax': "{{ route('libros_preseleccion_dt')}}",
                'columns': [
                    {
                        data: 'check', className: 'text-center',
                        defaultContent: '<div class="i-checks"><label> <input class="checkPartial" type="checkbox"  value=""> <i></i> </label></div>'
                    },
                    {data: 'isbn', className: 'text-center'},
                    {data: 'titulo', "width": "20%"},
                    {data: 'autor', className: 'text-center'},
                    {data: 'editorial', className: 'text-center'},
                    {data: 'proveedor', className: 'text-center'},
                    {data: 'nivel_lectura', className: 'text-center'},
                    {data: 'genero', className: 'text-center'},
                    {data: 'categoria', className: 'text-center'},
                    {data: 'coincidenciapre', className: 'text-center'},
                    {data: 'coincidenciacom', className: 'text-center'},
                    {data: 'categoria_id', "visible": false},
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
            var tableLibrosUsuarios = $('#example3').DataTable({
            })
            var libros_preseleccion_usuarios = $('#libros_preseleccion_usuarios').DataTable({
            })
            $('.check1').on('click',function(){

                if(this.checked){
                    console.log('true1');
                    $('#rango_edades').attr('hidden',false)
                    $('#rango_generos').attr('hidden',true)
                }
            })
            $('.check2').on('change',function(){
                if(this.checked){
                    console.log('true2');
                    $('#rango_edades').attr('hidden',true)
                    $('#rango_generos').attr('hidden',false)
                }
            })
            $('#registrarEdad').on('click',function(){
                var objectCupos = [];
                for(var i=1;i<=lengEdadLectura;i++){
                    objectCupos.push(
                        {
                            id:i,
                            cupo:$(`#edad${i}`).val()
                        });
                    console.log('ingresa',$(`#edad${i}`).val());

                }
                var formDatas = new FormData();
                formDatas.append('objectCupos', JSON.stringify(objectCupos));

                console.log(formDatas);
                var route = '{{ route('registrar_cupos_edades_priorizacion') }}';
                var typeAjax = 'POST';
                var async = async || false;
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
                        })
                    },
                    error: function (response, xhr, request) {

                    }
                });
            })

            $('#registrarGenero').on('click',function(){
                var objectCupos = [];
                for(var i=1;i<=lengGeneros;i++){
                    objectCupos.push(
                        {
                            id:i,
                            cupo:$(`#genero${i}`).val()
                        });
                    console.log('ingresa',$(`#genero${i}`).val());

                }
                var formDatas = new FormData();
                formDatas.append('objectCupos', JSON.stringify(objectCupos));
                var route = '{{ route('registrar_cupos_genero_priorizacion') }}';
                var typeAjax = 'POST';
                var async = async || false;
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
                        })
                    },
                    error: function (response, xhr, request) {

                    }
                });
            })
            tablePreseleccionComiteLibros.on('click', '.checkPartial', function (e) {
                $tr = $(this).closest('tr');
                if ($(this).prop("checked") == true) {
                    $('#exampleFormControlTextarea1').val('');
                    let dataTable = tablePreseleccionComiteLibros.row($tr).data();
                    console.log(dataTable)
                    objectoLibros.push(
                        {
                            id: dataTable.id,
                            libro_id:dataTable.libro_id,
                        });
                    if(dataTable.categoria_id == 1){
                        informativoPorcentaje = parseFloat(informativoPorcentaje)
                        informativoPorcentaje  += (0.0045454545454545*100);
                    }else{
                        literarioPorcentaje = parseFloat(literarioPorcentaje)
                        console.log(literarioPorcentaje,'resultadi0')
                        literarioPorcentaje  += (0.0045454545454545*100);
                        console.log(literarioPorcentaje,'resultadi2')
                    }
                    $('#informativo').val(informativoPorcentaje)
                    $('#literario').val(literarioPorcentaje)

                } else {
                    let dataTable = tablePreseleccionComiteLibros.row($tr).data();
                    objectoLibros = objectoLibros.filter(function (idLibro) {
                        return idLibro.id != dataTable.id;
                    });
                    if(dataTable.categoria_id == 1){
                        informativoPorcentaje = parseFloat(informativoPorcentaje)
                        informativoPorcentaje  -= (0.0045454545454545*100);
                    }else{
                        literarioPorcentaje = parseFloat(literarioPorcentaje)
                        literarioPorcentaje  -= (0.0045454545454545*100);
                    }
                    $('#informativo').val(informativoPorcentaje)
                    $('#literario').val(literarioPorcentaje)
                }
                console.log(objectoLibros)
            });
            tableLibrosUsuarios.on('click', '.ver_libros', function (e) {
                $tr = $(this).closest('tr');
                let dataTable = tableLibrosUsuarios.row($tr).data();
                console.log(dataTable)
                let route = "{{route('libros_preseleccion_usuarios_dt')}}"+'/'+dataTable[6]
                if($.fn.dataTable.isDataTable('#libros_preseleccion_usuarios')){
                    libros_preseleccion_usuarios.destroy();
                    libros_preseleccion_usuarios = $('#libros_preseleccion_usuarios').DataTable({
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        fixedHeader: true,
                        ajax: route,
                        order: [],
                        language: {
                            "decimal": "",
                            "emptyTable": "No hay información",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ Entradas",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscar:",
                            "zeroRecords": "Sin resultados encontrados",
                            "paginate": {
                                "first": "Primeros",
                                "last": "Ultimo",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            }
                        },
                        columns: [
                            {data: 'isbn', className: 'text-center'},
                            {data: 'titulo', "width": "20%"},
                            {data: 'autor', className: 'text-center'},
                            {data: 'editorial', className: 'text-center'},
                            {data: 'nivel_lectura', className: 'text-center'},
                            {data: 'genero', className: 'text-center'},
                            {data: 'observacion', className: 'text-center'},
                            {data: 'proveedor', className: 'text-center'},

                        ]
                    })
                }

                $('#exampleModalCenter2').modal('show')
            });

            $('#exampleModalCenter2').on('shown.bs.modal', function() {
                libros_preseleccion_usuarios.destroy();
                libros_preseleccion_usuarios = $('#libros_preseleccion_usuarios').DataTable({
                })
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
                    var route = '{{ route('registrar_libros_administrador_para_priorizacion') }}';
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
                            })
                        },
                        error: function (response, xhr, request) {

                        }
                    });

                }
            });
            $('#ver').on('click', function () {
                $('#exampleModalCenter3').modal('show')
            });

        } );
    </script>
@endsection
