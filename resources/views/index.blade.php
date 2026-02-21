{{-- @extends('layouts.app') = Usa el archivo layouts/app.blade.php como plantilla base --}}
@extends('layouts.app')

{{-- @section('titulo', 'Inicio') = Define el título que aparece en la pestaña del navegador --}}
@section('titulo', 'Inicio')

{{-- @section('contenido') = Aquí empieza el contenido que se inserta en el layout --}}
@section('contenido')
{{-- max-w-4xl = ancho máximo de 4xl (896px). mx-auto = centrado horizontal --}}
<div class="max-w-4xl mx-auto">
    {{-- text-3xl = tamaño de texto 3xl (30px). font-bold = negrita. mb-4 = margin-bottom de 4 unidades --}}
    <h1 class="text-3xl font-bold mb-4">Pan de Mamá</h1>
    {{-- mb-6 = margin-bottom de 6 unidades (24px) --}}
    <p class="mb-6">El pan más rico del barrio</p>

    {{-- 
        grid = usa CSS Grid para organizar elementos
        grid-cols-1 = en móvil: 1 columna
        md:grid-cols-2 = en pantallas medianas (md): 2 columnas
        gap-4 = espacio entre elementos de 4 unidades (16px)
    --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- 
            block = elemento de bloque (ocupa todo el ancho)
            bg-green-200 = fondo verde claro
            p-6 = padding de 6 unidades (24px) en todos lados
            border-2 = borde de 2px
            border-green-400 = color del borde verde
        --}}
        <a href="/terminal" class="block bg-green-200 p-6 border-2 border-green-400">
            {{-- text-xl = tamaño de texto extra large (20px) --}}
            <h2 class="text-xl font-bold">Vender Pan</h2>
            <p>Atiende a tus clientes</p>
        </a>

        <a href="/admin" class="block bg-blue-200 p-6 border-2 border-blue-400">
            <h2 class="text-xl font-bold">Administrar</h2>
            <p>Clientes, panes y más</p>
        </a>
    </div>

    {{-- 
        mt-6 = margin-top de 6 unidades (24px)
        bg-white = fondo blanco
        border-2 border-gray-300 = borde gris de 2px
        p-4 = padding de 16px
    --}}
    <div class="mt-6 bg-white border-2 border-gray-300 p-4">
        {{-- text-lg = tamaño de texto large (18px) --}}
        <h2 class="text-lg font-bold mb-2">Hoy vendimos</h2>
        {{-- 
            grid-cols-3 = 3 columnas
            gap-2 = espacio pequeño entre columnas (8px)
            text-center = texto centrado
        --}}
        <div class="grid grid-cols-3 gap-2 text-center">
            {{-- bg-yellow-100 = fondo amarillo muy claro. p-2 = padding de 8px --}}
            <div class="bg-yellow-100 p-2">
                {{-- text-2xl = tamaño de texto 2xl (24px). font-bold = negrita --}}
                {{-- id="total-ventas-hoy" = identificador para que JavaScript lo encuentre --}}
                <p class="text-2xl font-bold" id="total-ventas-hoy">-</p>
                {{-- text-sm = texto pequeño (14px) --}}
                <p class="text-sm">Ventas</p>
            </div>
            <div class="bg-blue-100 p-2">
                <p class="text-2xl font-bold" id="total-clientes">-</p>
                <p class="text-sm">Clientes</p>
            </div>
            <div class="bg-green-100 p-2">
                <p class="text-2xl font-bold" id="total-productos">-</p>
                <p class="text-sm">Panes</p>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- @section('scripts') = Aquí van los scripts JavaScript --}}
@section('scripts')
<script>
{{-- 
    async function = función asíncrona (puede usar await)
    Esta función carga las estadísticas desde el servidor
--}}
async function cargarEstadisticas() {
    try {
        {{-- fetch('/api/estadisticas') = hace petición GET a la API --}}
        const response = await fetch('/api/estadisticas');
        {{-- response.json() = convierte la respuesta a objeto JavaScript --}}
        const data = await response.json();
        
        {{-- 
            document.getElementById('xxx') = busca elemento HTML por su ID
            textContent = cambia el texto del elemento
            || 0 = si es undefined/null, usa 0
        --}}
        document.getElementById('total-clientes').textContent = data.total_clientes || 0;
        document.getElementById('total-productos').textContent = data.total_productos || 0;
        document.getElementById('total-ventas-hoy').textContent = data.total_ventas || 0;
    } catch (error) {
        {{-- console.error = muestra error en consola del navegador --}}
        console.error('Error cargando estadísticas:', error);
    }
}

{{-- Ejecutar la función al cargar la página --}}
cargarEstadisticas();
</script>
@endsection
