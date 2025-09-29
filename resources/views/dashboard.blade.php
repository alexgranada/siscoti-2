@extends('plantilla.app')
@section('titulo', 'Dashboard - SISTEMA DE COTIZACIONES EN LINEA')
@section('contenido')


    <!-- contenido -->
    <div class="content-wrapper">

        <!-- Row start -->
        <div class="row">
            <div class="col-xxl-3 col-sm-6 col-12">
                <div class="stats-tile">
                    <div class="sale-icon shade-red">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div class="sale-details">
                        <h3 class="text-red">{{ $cotizaciones ?? 0 }}</h3>
                        <p>Cotizaciones</p>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6 col-12">
                <div class="stats-tile">
                    <div class="sale-icon shade-blue">
                        <i class="bi bi-tools"></i>
                    </div>
                    <div class="sale-details">
                        <h3 class="text-blue">{{ $servicios ?? 0 }}</h3>
                        <p>Servicios</p>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6 col-12">
                <div class="stats-tile">
                    <div class="sale-icon shade-yellow">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="sale-details">
                        <h3 class="text-yellow">{{ $productos ?? 0 }}</h3>
                        <p>Productos</p>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6 col-12">
                <div class="stats-tile">
                    <div class="sale-icon shade-green">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="sale-details">
                        <h3 class="text-green">{{ $clientes ?? 0 }}</h3>
                        <p>Clientes</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row end -->



        <!-- Row start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Productos</div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table v-middle">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>stock</th>
                                        <th>estado</th>
                                        <th>tipo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produ as $pro)
                                        <tr>
                                            <td style="text-transform: uppercase;">{{ $pro->sku }}</td>
                                            <td>
                                                <div class="media-box">
                                                    @if ($pro->imagen)
                                                        <img src="{{ Storage::url('productos/' . $pro->imagen) }}"
                                                            class="media-avatar" alt="image" />
                                                    @else
                                                        <img src="{{ asset('assets/img/productos/sin-producto-granada.jpg') }}"
                                                            class="media-avatar">
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $pro->nombre }}</td>
                                            <td>S/ {{ number_format($pro->precio, 2) }}</td>
                                            <td>{{ $pro->stock }}</td>
                                            <td>
                                                @if ($pro->estado == 'activo')
                                                    <span class="badge shade-green min-90">ACTIVO</span>
                                                @else
                                                    <span class="badge shade-red min-90">INACTIVO</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($pro->tipo == 'producto')
                                                    <span class="badge shade-blue min-90">PRODUCTO</span>
                                                @else
                                                    <span class="badge shade-yellow min-90">SERVICIO</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->



    </div>

@endsection
