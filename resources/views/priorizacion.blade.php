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
    <div class=" container-fluid">
        <div class="card border-success mb-3">
            <div class="card-body text-success">
                @if($hiddenEdad != "hidden")
                <form action="javascript:void(0);" class="was-validated" id="rango_edades" {{$hiddenEdad}}>
                    <h5>Cupos para rango de edades</h5>
                    <div class="form-row">
                        @foreach($edadeslecturas as $edadlectura)
                            <div class="col-md-3 mb-3">
                                <label>{{$edadlectura->nombre}}</label>
                                @if($registroPriorizacion)
                                    <input disabled type="number" class="form-control is-valid" id="edad{{$edadlectura->id}}"  required value={{\App\EdadLecturaPrioriza::select('cupo')->where('edad_lectura_id',$edadlectura->id)->first()->cupo}}></input>
                                @else
                                    <input type="number" class="form-control is-invalid" id="edad{{$edadlectura->id}}"  required></input>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <h5>Prioriozación realizada</h5>
                    <div class="form-row">
                        @foreach($edadeslecturas as $edadlectura)
                            <div class="col-md-3 mb-3">
                                <label>{{$edadlectura->nombre}}</label>
                                <input type="number" class="form-control is-invalid" id="edadCompletar{{$edadlectura->id}}"  required value="0"></input>
                            </div>
                        @endforeach
                    </div>
                </form>
                @endif
                @if($hiddenGenero != "hidden")
                <form id="rango_generos"  class="was-validated" {{$hiddenGenero}}>
                    <h3>Géneros</h3>
                    <div class="form-row">
                        @foreach($generos as $genero)
                            <div class="col-md-3 mb-3">
                                <label>{{$genero->nombre}}</label>
                                @if($registroPriorizacion)
                                    <input disabled type="number" class="form-control is-valid" id="edad{{$genero->id}}"  required value={{\App\GeneroPrioriza::select('cupo')->where('genero_id',$genero->id)->first()->cupo}}></input>
                                @else
                                    <input type="number" class="form-control is-invalid" id="edad{{$edadlectura->id}}"  required></input>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <h5>Prioriozación realizada</h5>
                    <div class="form-row">
                        @foreach($generos as $genero)
                            <div class="col-md-3 mb-3">
                                <label>{{$genero->nombre}}</label>
                                <input type="number" class="form-control is-invalid" id="edadCompletarG{{$genero->id}}"  required value="0"></input>
                            </div>
                        @endforeach
                    </div>
                </form>
                @endif
            </div>
        </div>
        <div class="border-top my-3 col-sm-12 col-md-12 col-lg-12" >
            <br>
            <button class="btn btn-primary" id="finalizar_registro">Finalizar registro de priorización</button>
            <br><br>
            <!--table table-striped table-bordered dt-responsive nowrap-->
            <table id="example2" class="table table-striped table-bordered dt-responsive nowrap"
                   style="width:100%">
                <thead>
                <tr>
                    <th>ISBN</th>
                    <th width="20%">Título</th>
                    <th>Autor</th>
                    <th>Editorial</th>
                    <th>Nivel de lectura</th>
                    <th>Género</th>
                    <th>Priorización</th>
                    <th>Evaluar</th>
                    <th>Proveedor</th>
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
            if("{{$hiddenGenero}}" == "hidden"){
                evaluarCupos=1;
                let route =  "{{route('consultar_cupos_priorizacion',1)}}"
                $.ajax({
                    contentType: "application/json; chartset=utf-8",
                    dataType: "json",
                    type: "GET",
                    url: route,
                    success: function (data) {
                        $(data).each(function (key, value) {
                            objectCuposPriorizacion.push({
                                id :value.id,
                                edad_lectura_id : value.edad_lectura_id,
                                cupo : value.cupo,
                                priorizado:0
                            })
                        });
                        console.log(objectCuposPriorizacion,'jbj');
                    }
                });
            }else{
                if("{{$hiddenEdad}}" == "hidden"){
                    evaluarCupos=2;
                    let route =  "{{route('consultar_cupos_priorizacion',2)}}"
                    $.ajax({
                        contentType: "application/json; chartset=utf-8",
                        dataType: "json",
                        type: "GET",
                        url: route,
                        success: function (data) {
                            $(data).each(function (key, value) {
                                objectCuposPriorizacion.push({
                                    id :value.id,
                                    genero_id : value.genero_id,
                                    cupo : value.cupo,
                                    priorizado:0
                                })
                            });
                            console.log(objectCuposPriorizacion,'jbj');
                        }
                    });
                }
            }
            var tablePreseleccionComiteLibros = $('#example2').DataTable({
                'ajax': "{{ route('libros_priorizacion_dt')}}",
                'columns': [
                    {data: 'isbn', className: 'text-center'},
                    {data: 'titulo', "width": "20%"},
                    {data: 'autor', className: 'text-center'},
                    {data: 'editorial', className: 'text-center'},
                    {data: 'nivel_lectura', className: 'text-center'},
                    {data: 'genero', className: 'text-center'},
                    {data: 'priorizacion', className: 'text-center'},
                    {data: 'evaluar', className: 'text-center'},
                    {data: 'proveedor', className: 'text-center'},
                    {data: 'nivel_id', "visible": false,},
                    {data: 'genero_id', "visible": false,},
                ]
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
                        dataTable.priorizacion = '<h5><span class="badge badge-primary">Alta</span></h5>'
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
                        });
                    },
                    error: function (response, xhr, request) {

                    }
                });
            })
        } );
    </script>
@endsection
