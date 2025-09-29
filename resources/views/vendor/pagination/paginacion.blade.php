@if ($paginator->hasPages())
    <div class="btn-group me-2" role="group" aria-label="Pagination">
        {{-- Recorremos todos los elementos de la paginación --}}
        @foreach ($elements as $element)
            {{-- Si el elemento es una cadena (como "..."), lo mostramos deshabilitado --}}
            @if (is_string($element))
                <button type="button" class="btn btn-outline-primary disabled">{{ $element }}</button>
            @endif

            {{-- Si el elemento es un array de enlaces (los números de página) --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    {{-- Si es la página actual, la mostramos como activa y sin enlace --}}
                    @if ($page == $paginator->currentPage())
                        <button type="button" class="btn btn-primary active" aria-current="page">{{ $page }}</button>
                    @else
                        {{-- Para las demás páginas, creamos un enlace --}}
                        <a href="{{ $url }}" class="btn btn-outline-primary">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>
@endif
