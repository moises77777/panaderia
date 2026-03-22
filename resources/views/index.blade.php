@extends('layouts.app')

@section('titulo', 'Inicio')

@section('contenido')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-4">Panaderia Valencia</h1>
    <p class="mb-6">Tu panadería de confianza</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="/terminal" class="block bg-green-200 p-6 border-2 border-green-400">
            <h2 class="text-xl font-bold">Vender Pan</h2>
            <p>Atiende a tus clientes</p>
        </a>

        <a href="/admin" class="block bg-blue-200 p-6 border-2 border-blue-400">
            <h2 class="text-xl font-bold">Administrar</h2>
            <p>Clientes, panes y más</p>
        </a>
    </div>

    <div class="mt-6 bg-white border-2 border-gray-300 p-4">
        <h2 class="text-lg font-bold mb-2">Hoy vendimos</h2>
        <div class="grid grid-cols-3 gap-2 text-center">
            <div class="bg-yellow-100 p-2">
                <p class="text-2xl font-bold" id="total-ventas-hoy">-</p>
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

@section('scripts')
<script>
async function cargarEstadisticas() {
    try {
        const response = await fetch('/api/estadisticas');
        const data = await response.json();
        
        document.getElementById('total-clientes').textContent = data.total_clientes || 0;
        document.getElementById('total-productos').textContent = data.total_productos || 0;
        document.getElementById('total-ventas-hoy').textContent = data.total_ventas || 0;
    } catch (error) {
        console.error('Error cargando estadísticas:', error);
    }
}

cargarEstadisticas();
</script>
@endsection
