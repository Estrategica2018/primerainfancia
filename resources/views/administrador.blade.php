@extends('layouts.app')
@section('content')
    <div class="modal fade bd-example-modal-xl" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Crear usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" id="formCrearPosicion" action="javascript:void(0);">
                        <div class="form-group">
                            <label for="inputAddress">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="" required>
                            <div class="valid-feedback">
                                Completo
                            </div>
                            <div class="invalid-feedback">
                                Campo requerido
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Cedula</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" placeholder="" required>
                            <div class="valid-feedback">
                                Completo
                            </div>
                            <div class="invalid-feedback">
                                Campo requerido
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail4">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                            <div class="valid-feedback">
                                Completo
                            </div>
                            <div class="invalid-feedback">
                                Campo requerido
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail4">Entidad</label>
                            <input type="text" class="form-control" id="entidad" required>
                            <div class="valid-feedback">
                                Completo
                            </div>
                            <div class="invalid-feedback">
                                Campo requerido
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail4">Cargo</label>
                            <input type="text" class="form-control" id="cargo" required>
                            <div class="valid-feedback">
                                Completo
                            </div>
                            <div class="invalid-feedback">
                                Campo requerido
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Contraseña</label>
                                <input type="password" class="form-control" id="password1" required>
                                <div class="valid-feedback">
                                    Completo
                                </div>
                                <div class="invalid-feedback">
                                    Campo requerido
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Confirmar contraseña</label>
                                <input type="password" class="form-control" id="password2" required>
                                <div class="valid-feedback">
                                    Completo
                                </div>
                                <div class="invalid-feedback">
                                    Campo requerido
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Roles</label>
                            <select class="selectpicker" multiple data-selected-text-format="count > 3" data-width="100%" title="Seleccione una o mas opciónes" data-live-search="true" id="roles">
                                @foreach($roles as $role)
                                    <option value={{$role->id}}>{{$role->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-xl" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Editar usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" id="formCrearPosicion" action="javascript:void(0);">
                        <div class="form-group">
                            <label for="inputAddress">Nombre</label>
                            <input type="text" class="form-control" id="nombreEditar" name="nombreEditar" placeholder="" required>
                            <div class="valid-feedback">
                                Completo
                            </div>
                            <div class="invalid-feedback">
                                Campo requerido
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Cedula</label>
                            <input type="text" class="form-control" id="cedulaEditar" name="cedulaEditar" placeholder="" required>
                            <div class="valid-feedback">
                                Completo
                            </div>
                            <div class="invalid-feedback">
                                Campo requerido
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail4">Correo</label>
                            <input type="email" class="form-control" id="correoEditar" name="correoEditar" required>
                            <div class="valid-feedback">
                                Completo
                            </div>
                            <div class="invalid-feedback">
                                Campo requerido
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail4">Entidad</label>
                            <input type="text" class="form-control" id="entidadEditar" required>
                            <div class="valid-feedback">
                                Completo
                            </div>
                            <div class="invalid-feedback">
                                Campo requerido
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail4">Cargo</label>
                            <input type="text" class="form-control" id="cargoEditar" required>
                            <div class="valid-feedback">
                                Completo
                            </div>
                            <div class="invalid-feedback">
                                Campo requerido
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Roles</label>
                            <select class="selectpicker" multiple data-selected-text-format="count > 3" data-width="100%" title="Seleccione una o mas opciónes" data-live-search="true" id="roles">
                                @foreach($roles as $role)
                                    <option value={{$role->id}}>{{$role->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-warning" id="btnSubmit">Editar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-md-12">
            <button class="btn btn-success" id="crearUsuario">Crear usuario</button>
            <br><br>
            <table id="example3" class="table table-striped table-bordered dt-responsive nowrap"
                   style="width:100%">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cedula</th>
                    <th>Correo</th>
                    <th>Entidad</th>
                    <th>Cargo</th>
                    <th>Acción</th>
                    <th>Roles</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('js/formvalidation/validate.min.js') }}"></script>
    <script src="{{ asset('js/formvalidation/form-validation-md.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            // To style only selects with the my-select class
            $('.selectpicker').selectpicker();
            var tableUsuarios = $('#example3').DataTable({
                processing: true,
                serverSide: true,
                'ajax': "{{ route('usuarios_dt')}}",
                'columns': [
                    {data: 'nombre', className: ''},
                    {data: 'cedula', "width": "20%"},
                    {data: 'correo', className: ''},
                    {data: 'entidad', className: 'text-center'},
                    {data: 'cargo', className: 'text-center'},
                    {data: 'accion', className: 'text-center'},
                    {data: 'roles', className: ''},
                ]
            });
            var save_posicion = function () {
                return {
                    init: function () {
                        console.log('ingresa');

                    }
                }
            };
            var form_report_posicion = $('#formCrearPosicion2') ;
            var rules_form_report_posicion = {

                nombre:{
                    required: true
                },
                cedula:{
                    required: true
                },
                correo:{
                    required: true
                },

            }
            var messages_report_posicion = {
                nombre:{
                    required: "Campo requerido"
                },
                cedula:{
                    required: "Campo requerido"
                },
                correo:{
                    required: "Campo requerido"
                },

            }
            FormValidationMd.init(form_report_posicion, rules_form_report_posicion, messages_report_posicion, save_posicion());

            $("#btnSubmit").click(function(event) {
                // Fetch form to apply custom Bootstrap validation
                var form = $("#formCrearPosicion")

                if (form[0].checkValidity() === false) {
                    event.preventDefault()
                    event.stopPropagation()
                    console.log('faltan campos')
                }else{
                    $('#exampleModalCenter2').modal('show')
                    console.log('campos validados')
                    var formDatas = new FormData();
                    formDatas.append('name',$('#nombre').val() );
                    formDatas.append('email',$('#correo').val() );
                    formDatas.append('password1',$('#password1').val() );
                    formDatas.append('password2',$('#password2').val() );
                    formDatas.append('cargo',$('#cargo').val() );
                    formDatas.append('entidad',$('#entidad').val() );
                    formDatas.append('numero_identificacion',$('#cedula').val() );
                    formDatas.append('roles',$('#roles').val() );

                    console.log(formDatas);
                    var route = '{{ route('registrar_usuarios') }}';
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
                                    tableUsuarios.ajax.reload()
                                } else {
                                    tableUsuarios.ajax.reload()
                                }
                            })
                        },
                        error: function (response, xhr, request) {

                        }
                    });
                }

                form.addClass('was-validated');
                // Perform ajax submit here...
            });
            $('#crearUsuario').on('click',function(){

                $('#exampleModalCenter2').modal('show')

            })

            tableUsuarios.on('click', '.editar', function (e) {
                $tr = $(this).closest('tr');
                let dataTable = tableUsuarios.row($tr).data();
                console.log(dataTable)
                $('#nombreEditar').val(dataTable.name)
                $('#cedulaEditar').val(dataTable.numero_identificacion)
                $('#correoEditar').val(dataTable.email)
                $('#entidadEditar').val(dataTable.entidad)
                $('#cargoEditar').val(dataTable.cargo)
                $('#editarModal').modal('show')
            });
        } );
    </script>
@endsection