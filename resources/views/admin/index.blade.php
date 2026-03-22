@extends('layouts.app')

@section('titulo', 'Administración')

@section('contenido')
<div class="max-w-6xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Administrar</h1>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-2 mb-6">
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

    <div class="bg-white border-2 border-gray-300 p-4">
        <h2 class="text-lg font-bold mb-2">Resumen</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2" id="resumen-datos">
            <div class="bg-blue-100 p-2 text-center">
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

<script>
async function cargarResumen() {
    try {
        const response = await fetch('/api/estadisticas');
        const data = await response.json();
        document.getElementById('total-clientes').textContent = data.total_clientes || 0;
        document.getElementById('total-empleados').textContent = data.total_empleados || 0;
        document.getElementById('total-productos').textContent = data.total_productos || 0;
        document.getElementById('total-ventas-hoy').textContent = data.total_ventas || 0;
    } catch (error) {
        console.error('Error cargando resumen:', error);
    }
}

cargarResumen();
</script>
@endsection
