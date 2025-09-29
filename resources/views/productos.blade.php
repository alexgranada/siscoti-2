@extends('plantilla.app')
@section('titulo', 'Productos')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote-bs4.css') }}" />
@endsection

@section('contenido')
    <div class="content-wrapper">

        {{-- Buscador de productos --}}
        <div class="card mb-4">
            <div class="card-body">

                {{-- Título y botón agregar --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 fw-bold">PRODUCTOS</h5>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCrear">
                        <i class="bi bi-person-plus-fill"></i> Agregar Producto
                    </button>
                </div>

                <div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true"
                    data-bs-backdrop="static">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <!-- El 'enctype' es VITAL para poder subir archivos -->
                            <form id="formCrear" method="POST" action="{{ route('productos.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalCrearLabel">Agregar Nuevo Producto</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Cerrar"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row g-3">

                                        <div class="col-md-12">
                                            <label for="nombre_crear" class="form-label">Nombre del Producto</label>
                                            <input type="text" class="form-control" id="nombre_crear" name="nombre"
                                                required placeholder="Ej: Laptop Gamer XYZ">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="precio_crear" class="form-label">Precio</label>
                                            <div class="input-group">
                                                <span class="input-group-text">S/.</span>
                                                <input type="text" step="0.01" class="form-control numero"
                                                    id="precio_crear" name="precio" required placeholder="0.00">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="stock_crear" class="form-label">Stock</label>
                                            <input type="number" class="form-control" id="stock_crear" name="stock"
                                                required placeholder="0">
                                        </div>

                                        <div class="col-md-3">
                                            <label for="estado_crear" class="form-label">Estado</label>
                                            <select id="estado_crear" name="estado" class="form-select">
                                                <option value="activo" selected>Activo</option>
                                                <option value="inactivo">Inactivo</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="tipo_crear" class="form-label">Tipo</label>
                                            <select id="tipo_crear" name="tipo" class="form-select">
                                                <option value="producto" selected>Producto</option>
                                                <option value="servicio">Servicio</option>
                                            </select>
                                        </div>

                                        <!-- Editor de texto para la descripción -->
                                        <div class="col-12">
                                            <label for="descripcion_crear" class="form-label">Descripción</label>
                                            <textarea id="descripcion_crear" name="descripcion"></textarea>
                                        </div>

                                        <!-- Campo para subir imagen -->
                                        <div class="col-md-6">
                                            <label for="imagen_crear" class="form-label">Imagen del Producto</label>
                                            <input class="form-control" type="file" id="imagen_crear" name="imagen"
                                                accept="image/png, image/jpeg, image/webp">
                                            <small class="form-text text-muted">Sube una imagen (JPG, PNG, WEBP).</small>
                                        </div>

                                        <!-- Vista previa de la imagen -->
                                        <div class="col-md-6">
                                            <label class="form-label">Vista Previa</label>
                                            <div class="text-center border rounded p-2">
                                                <img id="imagen_preview_crear"
                                                    src="https://placehold.co/400x300/eef2f5/9da5b3?text=Vista+Previa"
                                                    alt="Vista previa de la imagen" class="img-fluid"
                                                    style="max-height: 250px;">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success">Guardar Producto</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



                {{-- Filtros de búsqueda --}}
                <form method="GET" action="{{ route('productos.index') }}">
                    <div class="row g-3 align-items-end">

                        {{-- sku --}}
                        <div class="col-12 col-md-2">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="sku" name="sku" placeholder="sku"
                                value="{{ request('sku') }}">
                        </div>

                        {{-- Nombre --}}
                        <div class="col-12 col-md-4">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                placeholder="Buscar por nombre" value="{{ request('nombre') }}">
                        </div>
                        {{-- Tipo --}}
                        <div class="col-12 col-md-2">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select id="tipo" name="tipo" class="form-select">
                                <option value="" {{ request('tipo') == '' ? 'selected' : '' }}>Todos</option>
                                <option value="producto" {{ request('tipo') == 'producto' ? 'selected' : '' }}>Producto
                                </option>
                                <option value="servicio" {{ request('tipo') == 'servicio' ? 'selected' : '' }}>Servicio
                                </option>
                            </select>
                        </div>
                        {{-- Estado --}}
                        <div class="col-12 col-md-2">
                            <label for="estado" class="form-label">Estado</label>
                            <select id="estado" name="estado" class="form-select">
                                <option value="" {{ request('estado') == '' ? 'selected' : '' }}>Todos</option>
                                <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo
                                </option>
                                <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo
                                </option>
                            </select>
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
                                        <th>Img.</th>
                                        <th>SKU</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th>Estado</th>
                                        <th>Tipo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $producto)
                                        <tr>
                                            <td>
                                                <div class="media-box">
                                                    @if ($producto->imagen)
                                                        <a href="#" class="btnEditarImagen" data-bs-toggle="modal"
                                                            data-bs-target="#modalEditarImagen"
                                                            data-id="{{ $producto->id }}"
                                                            data-nombre="{{ $producto->nombre }}"
                                                            data-imagen-actual="{{ asset('storage/productos/' . $producto->imagen) }}">

                                                            <img src="{{ asset('storage/productos/' . $producto->imagen) }}"
                                                                alt="Imagen de {{ $producto->nombre }}"
                                                                class="media-avatar img-thumbnail">
                                                        </a>

                                                        <div class="modal fade" id="modalEditarImagen" tabindex="-1"
                                                            aria-labelledby="modalEditarImagenLabel" aria-hidden="true"
                                                            data-bs-backdrop="static">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    {{-- La acción se establecerá dinámicamente con JavaScript --}}
                                                                    <form id="formEditarImagen" method="POST"
                                                                        action="" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PATCH') {{-- Usamos PATCH porque solo actualizamos un campo --}}

                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="modalEditarImagenLabel">Cambiar imagen
                                                                                de: <span id="nombreProductoImagen"
                                                                                    class="fw-bold"></span></h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Cerrar"></button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <div class="col-12 mb-3">
                                                                                    <label for="imagen_input_editar"
                                                                                        class="form-label">Selecciona la
                                                                                        nueva imagen</label>
                                                                                    <input class="form-control"
                                                                                        type="file"
                                                                                        id="imagen_input_editar"
                                                                                        name="imagen" required
                                                                                        accept="image/png, image/jpeg, image/webp">
                                                                                </div>
                                                                                <div class="col-12 text-center">
                                                                                    <label class="form-label">Vista
                                                                                        Previa</label>
                                                                                    <div class="border rounded p-2">
                                                                                        <img id="imagen_preview_editar"
                                                                                            src=""
                                                                                            alt="Vista previa de la nueva imagen"
                                                                                            class="img-fluid"
                                                                                            style="max-height: 250px;">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Cancelar</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Guardar
                                                                                Imagen</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <img src="{{ asset('assets/img/productos/sin-producto-granada.jpg') }}"
                                                            class="media-avatar">
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $producto->sku }}</td>
                                            <td>{{ $producto->nombre }}</td>
                                            <td>S/ {{ number_format($producto->precio, 2) }}</td>
                                            <td>{{ $producto->stock }}</td>
                                            <td>
                                                @if ($producto->estado === 'activo')
                                                    <span class="badge shade-bdr-green">Activo</span>
                                                @else
                                                    <span class="badge shade-bdr-red">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>{{ $producto->tipo }}</td>
                                            <td>
                                                <!-- Botón Editar -->
                                                <button class="btn btn-primary btnEditar" data-id="{{ $producto->id }}"
                                                    data-img="{{ $producto->imagen }}" data-sku="{{ $producto->sku }}"
                                                    data-nombre="{{ $producto->nombre }}"
                                                    data-precio="{{ $producto->precio }}"
                                                    data-stock="{{ $producto->stock }}"
                                                    data-estado="{{ $producto->estado }}" data-toggle="modal"
                                                    data-tipo="{{ $producto->tipo }}"
                                                    data-descripcion="{{ $producto->descripcion }}"
                                                    data-bs-toggle="modal" data-bs-target="#modalEditar"
                                                    style="padding: 4px 8px;">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <!-- Botón Eliminar -->
                                                <button class="btn btn-danger btn-sm btnEliminar"
                                                    data-id="{{ $producto->id }}" style="padding: 4px 8px;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 d-flex justify-content-end">
                            {{ $productos->links('vendor.pagination.paginacion') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Modal Editar (fuera de la tabla) -->
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form id="formEditar" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h4 class="modal-title">Editando Producto </h4>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" id="id_edit">

                            <div class="row g-3">
                                <!-- CAMBIO: Añadido el campo para el SKU que faltaba -->
                                <div class="col-md-3">
                                    <label for="sku_edit" class="form-label">SKU</label>
                                    <input type="text" class="form-control" id="sku_edit" name="sku" disabled>
                                </div>

                                <div class="col-md-9">
                                    <label for="nombre_edit" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_edit" name="nombre" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="precio_edit" class="form-label">Precio</label>
                                    <input type="number" step="0.01" class="form-control" id="precio_edit"
                                        name="precio">
                                </div>

                                <div class="col-md-2">
                                    <label for="stock_edit" class="form-label">Stock</label>
                                    <input type="number" class="form-control" id="stock_edit" name="stock">
                                </div>

                                <div class="col-md-3">
                                    <label for="estado_edit" class="form-label">Estado</label>
                                    <select id="estado_edit" name="estado" class="form-select">
                                        <option value="activo">Activo</option>
                                        <option value="inactivo">Inactivo</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="tipo_edit" class="form-label">Tipo</label>
                                    <select id="tipo_edit" name="tipo" class="form-select">
                                        <option value="producto">Producto</option>
                                        <option value="servicio">Servicio</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="descripcion_edit" class="form-label">Descripción</label>
                                    <!-- Usamos un textarea que será reemplazado por el editor -->
                                    <textarea id="descripcion_edit" name="descripcion"></textarea>
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
    <script src="{{ asset('assets/vendor/summernote/summernote-bs4.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalEditarImagenEl = document.getElementById('modalEditarImagen');
            const formEditarImagen = document.getElementById('formEditarImagen');
            const imagenInputEditar = document.getElementById('imagen_input_editar');
            const imagenPreviewEditar = document.getElementById('imagen_preview_editar');
            const nombreProductoSpan = document.getElementById('nombreProductoImagen');

            // 1. Escuchar clicks en todas las imágenes con la clase 'btnEditarImagen'
            document.querySelectorAll('.btnEditarImagen').forEach(btn => {
                btn.addEventListener('click', function(event) {
                    event.preventDefault();

                    const productoId = this.dataset.id;
                    const productoNombre = this.dataset.nombre;
                    const imagenActualUrl = this.dataset.imagenActual;

                    // 2. Poblar el modal con los datos del producto
                    nombreProductoSpan.textContent = productoNombre;
                    imagenPreviewEditar.src = imagenActualUrl;

                    // 3. Construir y establecer dinámicamente la URL de la acción del formulario
                    let urlTemplate =
                        "{{ route('productos.editarfoto', ['producto' => ':id']) }}";
                    let actionUrl = urlTemplate.replace(':id', productoId);
                    formEditarImagen.action = actionUrl;
                });
            });

            // 4. Lógica para la vista previa de la nueva imagen
            imagenInputEditar.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagenPreviewEditar.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });

            // 5. (Opcional pero recomendado) Limpiar el input al cerrar el modal
            modalEditarImagenEl.addEventListener('hidden.bs.modal', function() {
                formEditarImagen.reset(); // Resetea el input de archivo
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const modalEditarEl = document.getElementById('modalEditar'); // Asegúrate de que tu modal tenga este ID
            const editor = $('#descripcion_edit'); // Usamos jQuery para seleccionar el textarea

            // 1. Configuración de Summernote
            const summernoteConfig = {
                height: 80, // Un poco más de espacio para escribir es mejor
                tabsize: 2,
                focus: false, // Evita que tome el foco automáticamente al abrir el modal
                toolbar: [
                    // Toolbar más compacto para un diseño más pequeño
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol']],
                    ['insert', ['link']],
                ]
            };

            // 2. Evento: Cuando el modal de edición se MUESTRA
            modalEditarEl.addEventListener('shown.bs.modal', function() {
                // Inicializamos Summernote en el textarea
                editor.summernote(summernoteConfig);
            });

            // 3. Evento: Cuando el modal de edición se OCULTA
            modalEditarEl.addEventListener('hidden.bs.modal', function() {
                // Destruimos la instancia de Summernote para limpiar y evitar conflictos
                editor.summernote('destroy');
            });


            // 4. Rellenar el modal (tu código, pero adaptado para Summernote)
            document.querySelectorAll('.btnEditar').forEach(btn => {
                btn.addEventListener('click', function() {
                    const dataset = this.dataset;

                    // Rellenar campos normales

                    document.getElementById('id_edit').value = dataset.id;
                    document.getElementById('nombre_edit').value = dataset.nombre;
                    document.getElementById('sku_edit').value = dataset.sku;
                    document.getElementById('precio_edit').value = dataset.precio;
                    document.getElementById('stock_edit').value = dataset.stock;
                    document.getElementById('estado_edit').value = dataset.estado;
                    document.getElementById('tipo_edit').value = dataset.tipo;
                    document.getElementById('descripcion_edit').value = dataset.descripcion;

                    setTimeout(() => {
                        // Usamos el método 'code' para insertar el HTML
                        editor.summernote('code', dataset.descripcion);
                    }, 100); // 100ms es suficiente

                    // Cambiar la acción del form
                    let form = document.getElementById('formEditar');
                    if (form) {
                        form.action = `{{ url('productos') }}/${dataset.id}`;
                    }
                });
            });

            // 5. IMPORTANTE: Antes de enviar el formulario de edición
            const formEditar = document.getElementById('formEditar');
            if (formEditar) {
                formEditar.addEventListener('submit', function() {
                    // Summernote actualiza automáticamente el textarea subyacente,
                    // por lo que no necesitas hacer nada extra aquí.
                    // El valor de 'descripcion' se enviará correctamente.
                });
            }

        });

        //logica para numero con decimales
        $('.numero').on('input', function() {
            let valor = $(this).val();
            // Permitir solo números y un punto decimal
            valor = valor.replace(/[^0-9.]/g, '');
            // Asegurarse de que solo haya un punto decimal
            const partes = valor.split('.');
            if (partes.length > 2) {
                valor = partes[0] + '.' + partes.slice(1).join('');
            }
            // Limitar a dos decimales
            if (partes[1]) {
                partes[1] = partes[1].slice(0, 2);
                valor = partes.join('.');
            }
            $(this).val(valor);
        });


        document.addEventListener('DOMContentLoaded', function() {
            const modalCrearEl = document.getElementById('modalCrear');
            const formCrear = document.getElementById('formCrear');
            const editorCrear = $('#descripcion_crear');
            const imagenInput = document.getElementById('imagen_crear');
            const imagenPreview = document.getElementById('imagen_preview_crear');
            const imagenPlaceholder = 'https://placehold.co/400x300/eef2f5/9da5b3?text=Vista+Previa';

            imagenInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagenPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    imagenPreview.src = imagenPlaceholder;
                }
            });
            const summernoteConfigCrear = {
                height: 150,
                tabsize: 2,
                focus: false,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen']],
                ]
            };

            // Inicializar Summernote cuando el modal se muestra
            modalCrearEl.addEventListener('shown.bs.modal', function() {
                editorCrear.summernote(summernoteConfigCrear);
            });

            // Destruir Summernote y limpiar el formulario cuando el modal se oculta
            modalCrearEl.addEventListener('hidden.bs.modal', function() {
                editorCrear.summernote('destroy');
                formCrear.reset();
                imagenPreview.src = imagenPlaceholder;
            });
        });


        document.addEventListener('DOMContentLoaded', function() {

            // ===================================
            // LÓGICA PARA ELIMINAR CON SWEETALERT
            // ===================================
            document.querySelectorAll('.btnEliminar').forEach(btn => {
                btn.addEventListener('click', function() {
                    let id = this.dataset.id; // Captura el ID del botón

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
                            fetch("{{ url('productos') }}/" + id, {
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
                                        Swal.fire('Error', 'No se pudo eliminar',
                                            'error');
                                    }
                                });
                        }
                    });
                });
            });
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: "{{ session('success') }}",
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('error') }}",
                });
            @endif
        });
    </script>



@endsection
