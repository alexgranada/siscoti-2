@extends('plantilla.app')
@section('titulo', 'Clientes')


@section('contenido')
    <div class="content-wrapper">

        {{-- Buscador de clientes --}}
        <div class="card mb-4">
            <div class="card-body">

                {{-- Título y botón agregar --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 fw-bold">CLIENTES</h5>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCrear">
                        <i class="bi bi-person-plus-fill"></i> Agregar Cliente
                    </button>
                </div>

                <div class="modal fade" id="modalCrear" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form id="formCrear" method="POST" action="{{ route('clientes.store') }}">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">Registrar Cliente</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Cerrar"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row g-3">
                                        <!-- Tipo Doc, Número Doc y Botón Buscar -->
                                        <div class="col-md-3">
                                            <label for="create_tipo_doc" class="form-label">Tipo Doc.</label>
                                            <select id="create_tipo_doc" name="tipo_doc" class="form-select" required>
                                                <option value="">Seleccione...</option>
                                                <option value="DNI">DNI</option>
                                                <option value="RUC">RUC</option>
                                                <option value="CE">Carnet Extranjería</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="create_num_doc" class="form-label">Número Doc.</label>
                                            <input type="text" class="form-control" id="create_num_doc" name="num_doc"
                                                required placeholder="Ingrese número de documento" maxlength="15">
                                        </div>

                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="button" id="btnBuscarDoc" class="btn btn-info w-100">
                                                <i class="bi bi-search"></i> Buscar
                                            </button>
                                        </div>

                                        <!-- Nombres -->
                                        <div class="col-md-12">
                                            <label for="create_nombres" class="form-label">Nombres</label>
                                            <input type="text" class="form-control" id="create_nombres" name="nombres"
                                                required placeholder="Ingrese nombres completos">
                                        </div>

                                        <!-- Dirección, Correo, Teléfono -->
                                        <div class="col-md-6">
                                            <label for="create_direccion" class="form-label">Dirección</label>
                                            <input type="text" class="form-control" id="create_direccion"
                                                name="direccion" placeholder="Ingrese dirección">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="create_correo" class="form-label">Correo</label>
                                            <input type="email" class="form-control" id="create_correo" name="correo"
                                                placeholder="Ingrese correo">
                                        </div>

                                        <div class="col-md-2">
                                            <label for="create_telefono" class="form-label">Teléfono</label>
                                            <input type="text" class="form-control" id="create_telefono" name="telefono"
                                                placeholder="Ingrese teléfono" maxlength="15">
                                        </div>

                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Registrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



                {{-- Filtros de búsqueda --}}
                <form method="GET" action="{{ route('clientes.index') }}">
                    <div class="row g-3 align-items-end">

                        {{-- DNI --}}
                        <div class="col-12 col-md-2">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni" placeholder="DNI"
                                maxlength="8" value="{{ request('dni') }}">
                        </div>

                        {{-- Nombres --}}
                        <div class="col-12 col-md-4">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres"
                                placeholder="Buscar por nombres" value="{{ request('nombres') }}">
                        </div>

                        {{-- Fecha inicio --}}
                        <div class="col-12 col-md-2">
                            <label for="fecha_inicio" class="form-label">Desde</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                                value="{{ request('fecha_inicio') }}">
                        </div>

                        {{-- Fecha fin --}}
                        <div class="col-12 col-md-2">
                            <label for="fecha_fin" class="form-label">Hasta</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" disabled
                                value="{{ request('fecha_fin') }}">
                        </div>

                        {{-- Botón buscar --}}
                        <div class="col-12 col-md-2 text-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>

        <!-- Row start -->
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>Nombres</th>
                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th>Dirección</th>
                                        <th>Tipo Doc.</th>
                                        <th>Número Doc.</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clientes as $cliente)
                                        <tr>
                                            <td>{{ $cliente->nombres }}</td>
                                            <td>{{ $cliente->telefono }}</td>
                                            <td>{{ $cliente->correo }}</td>
                                            <td>{{ $cliente->direccion }}</td>
                                            <td>{{ $cliente->tipo_doc }}</td>
                                            <td>{{ $cliente->num_doc }}</td>
                                            <td>
                                                @if ($cliente->estado === 'ACTIVO')
                                                    <span class="badge shade-bdr-green">Activo</span>
                                                @else
                                                    <span class="badge shade-bdr-red">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Botón Editar -->
                                                <button class="btn btn-primary btnEditar" data-id="{{ $cliente->id }}"
                                                    data-nombres="{{ $cliente->nombres }}"
                                                    data-telefono="{{ $cliente->telefono }}"
                                                    data-correo="{{ $cliente->correo }}"
                                                    data-direccion="{{ $cliente->direccion }}"
                                                    data-tipo_doc="{{ $cliente->tipo_doc }}"
                                                    data-num_doc="{{ $cliente->num_doc }}"
                                                    data-estado="{{ $cliente->estado }}" data-toggle="modal"
                                                    data-bs-toggle="modal" data-bs-target="#modalEditar"
                                                    style="padding: 4px 8px;">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <!-- Botón Eliminar -->
                                                <button class="btn btn-danger btn-sm btnEliminar"
                                                    data-id="{{ $cliente->id }}" style="padding: 4px 8px;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-3 d-flex justify-content-end">
                            {{ $clientes->links('vendor.pagination.paginacion') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- Modal Editar (fuera de la tabla) -->
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="formEditar" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h4 class="modal-title">Editando Cliente </h4>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit_id">

                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label for="edit_nombres" class="form-label">Nombres</label>
                                    <input type="text" class="form-control" id="edit_nombres" name="nombres"
                                        required>
                                </div>

                                <div class="col-md-3">
                                    <label for="edit_telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="edit_telefono" name="telefono">
                                </div>

                                <div class="col-md-4">
                                    <label for="edit_correo" class="form-label">Correo</label>
                                    <input type="email" class="form-control" id="edit_correo" name="correo">
                                </div>

                                <div class="col-md-5">
                                    <label for="edit_direccion" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="edit_direccion" name="direccion">
                                </div>

                                <div class="col-md-2">
                                    <label for="edit_tipo_doc" class="form-label">Tipo Doc.</label>
                                    <input type="text" class="form-control" id="edit_tipo_doc" name="tipo_doc">
                                </div>

                                <div class="col-md-3">
                                    <label for="edit_num_doc" class="form-label">Número Doc.</label>
                                    <input type="text" class="form-control" id="edit_num_doc" name="num_doc">
                                </div>

                                <div class="col-md-2">
                                    <label for="edit_estado" class="form-label">Estado</label>
                                    <select id="edit_estado" name="estado" class="form-select">
                                        <option value="ACTIVO">Activo</option>
                                        <option value="INACTIVO">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>
        // Rellenar modal de editar
        document.querySelectorAll('.btnEditar').forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.dataset.id;

                document.getElementById('edit_id').value = id;
                document.getElementById('edit_nombres').value = this.dataset.nombres;
                document.getElementById('edit_telefono').value = this.dataset.telefono;
                document.getElementById('edit_correo').value = this.dataset.correo;
                document.getElementById('edit_direccion').value = this.dataset.direccion;
                document.getElementById('edit_tipo_doc').value = this.dataset.tipo_doc;
                document.getElementById('edit_num_doc').value = this.dataset.num_doc;
                document.getElementById('edit_estado').value = this.dataset.estado;

                // Cambiar la acción del form dinámicamente
                let form = document.getElementById('formEditar');
                form.action = "{{ url('clientes') }}/" + id;
            });
        });

        // Confirmación con SweetAlert2 para eliminar
        document.querySelectorAll('.btnEliminar').forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.dataset.id;

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar petición DELETE
                        fetch("{{ url('clientes') }}/" + id, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            }).then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Eliminado!', data.success, 'success')
                                        .then(() => location.reload());
                                } else {
                                    Swal.fire('Error', 'No se pudo eliminar', 'error');
                                }
                            });
                    }
                });
            });
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33',
            });
        </script>
    @endif

    <script>
        // Permitir solo números en el campo DNI
        document.getElementById('dni').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Controlar fecha fin
        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaFin = document.getElementById('fecha_fin');

        fechaInicio.addEventListener('change', function() {
            if (this.value) {
                fechaFin.disabled = false;
                fechaFin.min = this.value;
            } else {
                fechaFin.value = '';
                fechaFin.disabled = true;
            }
        });
    </script>

    <script>
        document.getElementById('btnBuscarDoc').addEventListener('click', function() {
            let tipo = document.getElementById('create_tipo_doc').value;
            let numDoc = document.getElementById('create_num_doc').value.trim();
            let token =
                "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImtldmluaHVpbGxjYTQ4QGdtYWlsLmNvbSJ9.hX6aYM992PkfK63Ozdx1wYzA58GgKy2N1canrNsYlks";

            if (!tipo || !numDoc) {
                Swal.fire("Atención", "Seleccione tipo de documento e ingrese el número", "warning");
                return;
            }

            // Validaciones básicas
            if (tipo === "DNI" && numDoc.length !== 8) {
                Swal.fire("Error", "El DNI debe tener 8 dígitos", "error");
                return;
            }
            if (tipo === "RUC" && numDoc.length !== 11) {
                Swal.fire("Error", "El RUC debe tener 11 dígitos", "error");
                return;
            }

            let url = (tipo === "DNI") ?
                `https://dniruc.apisperu.com/api/v1/dni/${numDoc}?token=${token}` :
                `https://dniruc.apisperu.com/api/v1/ruc/${numDoc}?token=${token}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Documento no encontrado");
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);

                    if (tipo === "DNI") {
                        if (data.dni) {
                            document.getElementById('create_nombres').value =
                                `${data.nombres} ${data.apellidoPaterno} ${data.apellidoMaterno}`;
                        } else {
                            Swal.fire("Atención", "No se encontraron datos para este DNI", "info");
                        }
                    }

                    if (tipo === "RUC") {
                        if (data.ruc) {
                            document.getElementById('create_nombres').value = data.razonSocial;
                            document.getElementById('create_direccion').value = data.direccion || '';

                        } else {
                            Swal.fire("Atención", "No se encontraron datos para este RUC", "info");
                        }
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire("Error", err.message, "error");
                });
        });
    </script>

@endsection
