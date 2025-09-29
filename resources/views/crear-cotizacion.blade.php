@extends('plantilla.app')
@section('titulo', 'Crear Cotización')
@section('css')
    {{-- Ya no se necesita bs-select.css, pero sí los iconos --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bs-select/bs-select.css') }}" rel="stylesheet" />
@endsection

@section('contenido')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Creando Cotizaciones</h5>
                    </div>
                    <div class="card-body">
                        <div class="create-invoice-wrapper">
                            <!-- Datos del Cliente y Fechas -->
                            <div class="row">
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <label for="cliente_id" class="form-label">Empresa</label>
                                    <select id="cliente_id" class="select-single js-states form-control"
                                        data-live-search="true" name="cliente_id">
                                        <option value="">SELECCIONE UN CLIENTE</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">
                                                {{ $cliente->num_doc . ' - ' . $cliente->nombres }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-2 mb-2">
                                    <label for="fecha" class="form-label">F. Cotización</label>
                                    <input type="date" id="fecha" class="form-control" name="fecha_cotizacion"
                                        value="{{ today()->toDateString() }}" />
                                </div>
                                <div class="col-sm-6 col-md-2 mb-2">
                                    <label for="fecha_vencimiento" class="form-label">F. Validez</label>
                                    <input type="date" id="fecha_vencimiento" class="form-control"
                                        name="fecha_vencimiento" value="{{ today()->addDays(10)->toDateString() }}"
                                        min="{{ today()->toDateString() }}" />
                                </div>
                                <div class="col-sm-6 col-md-2 mb-2">
                                    <label for="fecha_entrega" class="form-label">F. Entrega</label>
                                    <input type="date" id="fecha_entrega" class="form-control" name="fecha_entrega"
                                        value="{{ today()->addDays(5)->toDateString() }}"
                                        min="{{ today()->toDateString() }}" />
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <label for="observaciones" class="form-label">Comentario</label>
                                    <textarea rows="2" id="observaciones" name="observaciones" class="form-control"
                                        placeholder="Inserta un comentario para esta cotización"></textarea>
                                </div>
                            </div>

                            <!-- Tabla de Productos -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table  table-bordered">
                                            <thead>
                                                <tr>
                                                    <th colspan="7" class="pt-3 pb-3">Productos / Servicios</th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 30%;">Producto</th>
                                                    <th style="width: 12%;">SKU</th>
                                                    <th style="width: 10%;">Stock</th>
                                                    <th style="width: 10%;">Cantidad</th>
                                                    <th style="width: 15%;">Precio Unitario</th>
                                                    <th style="width: 15%;">Total Fila</th>
                                                    <th style="width: 8%;" class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabla-productos">
                                                {{-- La primera fila se carga inicialmente aquí --}}
                                                <tr class="producto-row">
                                                    <td>
                                                        <select class="select-singlea form-select producto-select" name="producto_id[]" data-live-search="true">
                                                            {{-- class="select-single js-states form-control"
                                        data-live-search="true" --}}
                                                            <option value="">SELECCIONE</option>
                                                            @foreach ($productos as $producto)
                                                                <option value="{{ $producto->id }}"
                                                                    data-sku="{{ $producto->sku }}"
                                                                    data-stock="{{ $producto->stock }}"
                                                                    data-precio="{{ $producto->precio }}">
                                                                    {{ $producto->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="text" class="form-control sku" placeholder="SKU"
                                                            disabled></td>
                                                    <td><input type="number" class="form-control stock" placeholder="Stock"
                                                            disabled></td>
                                                    <td><input type="number" class="form-control cantidad" placeholder="0"
                                                            min="1" disabled></td>
                                                    <td>
                                                        <div class="input-group"><span
                                                                class="input-group-text">S/</span><input type="number"
                                                                step="0.01" class="form-control precio-unitario"
                                                                placeholder="0.00" disabled></div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group"><span
                                                                class="input-group-text">S/</span><input type="text"
                                                                class="form-control total-fila" placeholder="0.00" disabled>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-sm btn-eliminar"
                                                            title="Eliminar Fila"><i class="bi bi-trash"></i></button>
                                                        <button type="button"
                                                            class="btn btn-outline-primary btn-sm btn-editar"
                                                            title="Editar Fila"><i class="bi bi-pencil"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>
                                                        <button type="button" id="btn-agregar-fila"
                                                            class="btn btn-dark">
                                                            <i class="bi bi-plus-circle-fill me-2"></i>Agregar Fila
                                                        </button>
                                                    </td>
                                                    <td colspan="6">
                                                        <div class="row justify-content-end align-items-center">
                                                            <div class="col-auto">
                                                                <label class="col-form-label"
                                                                    for="descuento-general">Descuento aplicado:</label>
                                                            </div>
                                                            <div class="col-auto" style="width: 130px;">
                                                                <div class="input-group">
                                                                    <input type="number" id="descuento-general"
                                                                        class="form-control" placeholder="0"
                                                                        min="0" max="100" />
                                                                    <span class="input-group-text">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="border-0"></td>
                                                    <td class="total-summary" colspan="2">
                                                        <div class="row">
                                                            <div class="col-6">Subtotal:</div>
                                                            <div class="col-6" id="subtotal">S/ 0.00</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">Descuento:</div>
                                                            <div class="col-6" id="monto-descuento">S/ 0.00</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">IGV (18%):</div>
                                                            <div class="col-6" id="igv">S/ 0.00</div>
                                                        </div>
                                                        <hr class="my-1">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <h5>Total S/</h5>
                                                            </div>
                                                            <div class="col-6">
                                                                <h5 id="total-general">S/ 0.00</h5>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-success ms-1 btn-lg">Crear Cotización</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script src="{{ asset('assets/vendor/bs-select/bs-select.min.js') }}"></script>
    <script>
        $(".select-single").select2({ });
        document.addEventListener('DOMContentLoaded', function() {
            // --- CONFIGURACIÓN INICIAL ---
            $(".select-single").select2({ });
            
            const tablaProductosBody = document.getElementById('tabla-productos');
            const btnAgregarFila = document.getElementById('btn-agregar-fila');
            const descuentoGeneralInput = document.getElementById('descuento-general');
            const IGV_FACTOR = 1.18;

            // --- LÓGICA DE CÁLCULO (JS PURO) ---
            function calcularTotales() {
                let totalBruto = 0;
                document.querySelectorAll('.producto-row').forEach(row => {
                    const cantidad = parseFloat(row.querySelector('.cantidad').value) || 0;
                    const precioConIgv = parseFloat(row.querySelector('.precio-unitario').value) || 0;
                    const totalFila = cantidad * precioConIgv;
                    row.querySelector('.total-fila').value = totalFila.toFixed(2);
                    totalBruto += totalFila;
                });

                const descuentoPorcentaje = parseFloat(descuentoGeneralInput.value) || 0;
                const montoDescuento = totalBruto * (descuentoPorcentaje / 100);
                const totalConDescuento = totalBruto - montoDescuento;

                const baseImponible = totalConDescuento / IGV_FACTOR;
                const montoIGV = totalConDescuento - baseImponible;

                document.getElementById('subtotal').textContent = `S/ ${baseImponible.toFixed(2)}`;
                document.getElementById('monto-descuento').textContent = `S/ ${montoDescuento.toFixed(2)}`;
                document.getElementById('igv').textContent = `S/ ${montoIGV.toFixed(2)}`;
                document.getElementById('total-general').textContent = `S/ ${totalConDescuento.toFixed(2)}`;
            }

            // --- MANEJO DE FILAS (JS PURO) ---
            function toggleLockFila(fila, lockState) {
                fila.querySelector('.cantidad').disabled = lockState;
                fila.querySelector('.precio-unitario').disabled = lockState;
                fila.querySelector('.producto-select').disabled = lockState;
            }

            function agregarNuevaFila() {
                const filas = tablaProductosBody.querySelectorAll('.producto-row');
                if (filas.length > 0) {
                    const ultimaFila = filas[filas.length - 1];
                    const ultimaCantidad = parseFloat(ultimaFila.querySelector('.cantidad').value);
                    if (!ultimaCantidad || ultimaCantidad <= 0) {
                        alert('Debe definir una cantidad válida en la última fila para agregar una nueva.');
                        return;
                    }
                }

                filas.forEach(fila => toggleLockFila(fila, true));

                const primeraFila = document.querySelector('.producto-row');
                const nuevaFila = primeraFila.cloneNode(true);

                nuevaFila.querySelectorAll('input').forEach(input => input.value = '');
                nuevaFila.querySelector('.producto-select').value = "";
                toggleLockFila(nuevaFila, false);
                nuevaFila.querySelector('.cantidad').disabled = true;
                nuevaFila.querySelector('.precio-unitario').disabled = true;

                tablaProductosBody.appendChild(nuevaFila);
            }

            // --- MANEJO DE EVENTOS (JS PURO) ---
            btnAgregarFila.addEventListener('click', agregarNuevaFila);
            descuentoGeneralInput.addEventListener('input', calcularTotales);

            tablaProductosBody.addEventListener('change', function(e) {
                if (e.target.classList.contains('producto-select')) {
                    const select = e.target;
                    const fila = select.closest('.producto-row');
                    const opcion = select.options[select.selectedIndex];

                    if (select.value) {
                        fila.querySelector('.sku').value = opcion.dataset.sku || '';
                        fila.querySelector('.stock').value = opcion.dataset.stock || '';
                        fila.querySelector('.precio-unitario').value = opcion.dataset.precio || '';

                        const cantidadInput = fila.querySelector('.cantidad');
                        cantidadInput.disabled = false;
                        cantidadInput.max = opcion.dataset.stock || 0;
                        cantidadInput.value = 1;

                        fila.querySelector('.precio-unitario').disabled = false;
                    } else {
                        fila.querySelectorAll('input').forEach(input => input.value = '');
                        fila.querySelector('.cantidad').disabled = true;
                        fila.querySelector('.precio-unitario').disabled = true;
                    }
                    calcularTotales();
                }
            });

            tablaProductosBody.addEventListener('input', function(e) {
                if (e.target.classList.contains('cantidad') || e.target.classList.contains(
                        'precio-unitario')) {
                    const fila = e.target.closest('.producto-row');
                    const stock = parseInt(fila.querySelector('.stock').value, 10);
                    const cantidadInput = fila.querySelector('.cantidad');
                    if (parseInt(cantidadInput.value, 10) > stock) {
                        alert(`La cantidad no puede superar el stock (${stock}).`);
                        cantidadInput.value = stock;
                    }
                    calcularTotales();
                }
            });

            tablaProductosBody.addEventListener('click', function(e) {
                const btn = e.target.closest('button');
                if (!btn) return;

                const fila = btn.closest('.producto-row');
                if (btn.classList.contains('btn-eliminar')) {
                    if (tablaProductosBody.querySelectorAll('.producto-row').length > 1) {
                        fila.remove();
                    } else {
                        fila.querySelector('.producto-select').value = '';
                        fila.querySelectorAll('input').forEach(input => input.value = '');
                        toggleLockFila(fila, false);
                        fila.querySelector('.cantidad').disabled = true;
                        fila.querySelector('.precio-unitario').disabled = true;
                    }
                    calcularTotales();
                }

                if (btn.classList.contains('btn-editar')) {
                    toggleLockFila(fila, false);
                }
            });

            // Lógica de Fechas (JS Puro)
            document.getElementById('fecha').addEventListener('change', function() {
                const fechaBaseStr = this.value;
                if (!fechaBaseStr) return;

                const vencimientoInput = document.getElementById('fecha_vencimiento');
                const entregaInput = document.getElementById('fecha_entrega');
                vencimientoInput.min = fechaBaseStr;
                entregaInput.min = fechaBaseStr;
                const fechaBase = new Date(fechaBaseStr + 'T00:00:00');

                let fechaVencimiento = new Date(fechaBase);
                fechaVencimiento.setDate(fechaVencimiento.getDate() + 10);
                vencimientoInput.value = fechaVencimiento.toISOString().split('T')[0];

                let fechaEntrega = new Date(fechaBase);
                fechaEntrega.setDate(fechaEntrega.getDate() + 5);
                entregaInput.value = fechaEntrega.toISOString().split('T')[0];
            });

            // Activar la primera fila para que esté lista para usar
            const primeraFila = document.querySelector('.producto-row');
            if (primeraFila) {
                toggleLockFila(primeraFila, false);
                primeraFila.querySelector('.cantidad').disabled = true;
                primeraFila.querySelector('.precio-unitario').disabled = true;
            }
        });
    </script>
@endsection
