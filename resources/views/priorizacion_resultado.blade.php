
@extends('layouts.app')

@section('content')
    <div class=" container-fluid">
        <div class="border-top my-3 col-sm-12 col-md-12 col-lg-12" >
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
                        </form>
                    @endif
                </div>
            </div>
            <br>
            <h4>Colección de libros</h4>
            <br><br>
            <!--table table-striped table-bordered dt-responsive nowrap-->
            <table id="example1" class="table table-striped table-bordered dt-responsive nowrap"
                   style="width:100%">
                <thead>
                <tr>
                    <th>ISBN</th>
                    <th width="20%">Título</th>
                    <th>Autor</th>
                    <th>Editorial</th>
                    <th>Nivel de lectura</th>
                    <th>Género</th>
                    <th>Resultado Priorización</th>
                    <th>Distribuidor</th>
                </tr>
                </thead>
                <tbody>
                @foreach($objeto as $obj)
                    <tr>
                        <td>{{$obj->isbn}}</td>
                        <td>{{$obj->titulo}}</td>
                        <td>{{$obj->autor}}</td>
                        <td>{{$obj->editorial}}</td>
                        <td>{{$obj->nom_edad}}</td>
                        <td>{{$obj->nom_genero}}</td>
                        <td>{{$obj->sum}}</td>
                        <td>{{$obj->proveedor}}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <div class="border-top my-3 col-sm-12 col-md-12 col-lg-12" >
            <br>
            <h4>Resultado logistica de priorización</h4><br>
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
                    <th>Resultado priorización</th>
                    <th>Distribuidor</th>
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
            var tableResultadoPriorizacion = $('#example2').DataTable({
                processing: true,
                serverSide: true,
                'ajax': "{{ route('resultado_libros_logistica_priorizacion_dt')}}",
                'columns': [
                    {data: 'isbn', className: 'text-center'},
                    {data: 'titulo', "width": "20%"},
                    {data: 'autor', className: 'text-center'},
                    {data: 'editorial', className: 'text-center'},
                    {data: 'nivel_lectura', className: 'text-center'},
                    {data: 'genero', className: 'text-center'},
                    {data: 'resultado', className: 'text-center'},
                    {data: 'proveedor', className: 'text-center'},
                ]
            });

            $('#example1').DataTable({
            });
        } );
    </script>
@endsection
