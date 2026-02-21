{{-- @extends('layouts.app') = Usa la plantilla base layouts/app.blade.php --}}
@extends('layouts.app')

{{-- Define el título que aparece en la pestaña del navegador --}}
@section('titulo', 'Administración')

@section('contenido')
{{-- max-w-6xl = ancho máximo de 6xl (1152px). mx-auto = centrado --}}
<div class="max-w-6xl mx-auto">
    {{-- text-2xl = tamaño de texto 2xl (24px). font-bold = negrita. mb-4 = margin-bottom 16px --}}
    <h1 class="text-2xl font-bold mb-4">Administrar</h1>

    {{-- 
        grid = CSS Grid para organizar elementos
        grid-cols-2 = 2 columnas en móvil
        md:grid-cols-5 = 5 columnas en pantallas medianas
        gap-2 = espacio de 2 unidades (8px) entre elementos
        mb-6 = margin-bottom de 6 unidades (24px)
    --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-2 mb-6">
        {{-- 
            block = elemento de bloque
            bg-blue-200 = fondo azul claro
            p-3 = padding de 12px
            border = borde sólido 1px
            border-blue-400 = color azul para el borde
            text-center = texto centrado
        --}}
        <a href="/clientes" class="block bg-blue-200 p-3 border border-blue-400 text-center">
            <h3 class="font-bold">Clientes</h3>
        </a>
        
        <a href="/empleados" class="block bg-green-200 p-3 border border-green-400 text-center">
            <h3 class="font-bold">Trabajadores</h3>
        </a>
        
        <a href="/productos" class="block bg-yellow-200 p-3 border border-yellow-400 text-center">
            <h3 class="font-bold">Panes</h3>
        </a>
        
        <a href="/materias-primas" class="block bg-orange-200 p-3 border border-orange-400 text-center">
            <h3 class="font-bold">Harinas</h3>
        </a>
        
        <a href="/admin/ventas" class="block bg-purple-200 p-3 border border-purple-400 text-center">
            <h3 class="font-bold">Ventas</h3>
        </a>
    </div>

    {{-- bg-white = fondo blanco. border-2 = borde de 2px. border-gray-300 = borde gris --}}
    <div class="bg-white border-2 border-gray-300 p-4">
        {{-- text-lg = texto large (18px). font-bold = negrita. mb-2 = margin-bottom 8px --}}
        <h2 class="text-lg font-bold mb-2">Resumen</h2>
        {{-- grid-cols-2 = 2 columnas. md:grid-cols-4 = 4 columnas en pantalla mediana --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2" id="resumen-datos">
            {{-- bg-blue-100 = fondo azul muy claro. p-2 = padding 8px. text-center = centrado --}}
            <div class="bg-blue-100 p-2 text-center">
                {{-- text-xl = texto 20px. font-bold = negrita --}}
                {{-- id="total-clientes" = ID para que JS lo actualice --}}
                <p class="text-xl font-bold" id="total-clientes">-</p>
                <p class="text-sm">Clientes</p>
            </div>
            <div class="bg-green-100 p-2 text-center">
                <p class="text-xl font-bold" id="total-empleados">-</p>
                <p class="text-sm">Trabajadores</p>
            </div>
            <div class="bg-yellow-100 p-2 text-center">
                <p class="text-xl font-bold" id="total-productos">-</p>
                <p class="text-sm">Panes</p>
            </div>
            <div class="bg-purple-100 p-2 text-center">
                <p class="text-xl font-bold" id="total-ventas-hoy">-</p>
                <p class="text-sm">Ventas Hoy</p>
            </div>
        </div>
    </div>
</div>

{{-- Sección para scripts JavaScript --}}
@section('scripts')
<script>
{{-- 
    Función asíncrona que carga estadísticas desde la API
    async/await = espera a que termine la petición antes de continuar
--}}
async function cargarResumen() {
    try {
        {{-- fetch = hace petición HTTP GET a /api/estadisticas --}}
        const response = await fetch('/api/estadisticas');
        {{-- Convierte la respuesta JSON a objeto JavaScript --}}
        const data = await response.json();
        
        {{-- Actualiza los elementos HTML con los datos recibidos --}}
        document.getElementById('total-clientes').textContent = data.total_clientes || 0;
        document.getElementById('total-empleados').textContent = data.total_empleados || 0;
        document.getElementById('total-productos').textContent = data.total_productos || 0;
        document.getElementById('total-ventas-hoy').textContent = data.total_ventas || 0;
    } catch (error) {
        {{-- Si hay error, lo muestra en consola --}}
        console.error('Error cargando resumen:', error);
    }
}

{{-- Ejecutar la función cuando carga la página --}}
cargarResumen();
</script>
@endsection
