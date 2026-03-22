@extends('layouts.app')

@section('titulo', 'Panel de Personal')

@section('contenido')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-amber-800 mb-6 text-center">
        👔 Panel de Personal
    </h1>

    <!-- Staff Info and Daily Sales -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    👋 Hola, {{ auth()->user()->name }}
                </h2>
                <p class="text-sm text-gray-600">
                    Rol: {{ auth()->user()->role === 'jefe' ? 'Administrador' : 'Cajera' }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-600">Fecha: {{ now()->format('d/m/Y') }}</p>
                <button onclick="cargarMisVentasHoy()" class="text-blue-600 hover:text-blue-800 text-sm underline">
                    🔄 Actualizar ventas
                </button>
            </div>
        </div>
        
        <div class="border-t-2 border-amber-200 pt-4">
            <h3 class="text-lg font-bold text-amber-700 mb-3">📊 Mis Ventas de Hoy</h3>
            <div id="mis-ventas-hoy" class="space-y-2 max-h-60 overflow-y-auto">
                <p class="text-gray-500 text-center py-4">Cargando tus ventas...</p>
            </div>
            <div class="border-t border-gray-200 mt-3 pt-3 flex justify-between items-center">
                <span class="font-bold text-gray-700">Total vendido hoy:</span>
                <span class="text-2xl font-bold text-green-600">$<span id="total-ventas-hoy">0.00</span></span>
            </div>
        </div>
    </div>

    @if(auth()->user()->role === 'jefe')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="/admin" class="block bg-blue-50 hover:bg-blue-100 border-2 border-blue-300 rounded-lg p-6 text-center">
                <div class="text-3xl mb-2">⚙️</div>
                <h3 class="font-bold text-blue-800">Panel de Admin</h3>
                <p class="text-sm text-blue-600">Configuración completa</p>
            </a>
        </div>
    @endif
</div>

<script>
// Load cajera's daily sales
async function cargarMisVentasHoy() {
    try {
        const response = await fetch('/api/mis-ventas-hoy');
        const ventas = await response.json();
        
        const container = document.getElementById('mis-ventas-hoy');
        const totalElement = document.getElementById('total-ventas-hoy');
        
        if (ventas.length === 0) {
            container.innerHTML = '<p class="text-gray-500 text-center py-4">No has realizado ventas hoy</p>';
            totalElement.textContent = '0.00';
            return;
        }
        
        let totalHoy = 0;
        
        container.innerHTML = ventas.map(venta => {
            totalHoy += parseFloat(venta.total_venta);
            const hora = new Date(venta.fecha_venta).toLocaleTimeString('es-MX', { hour: '2-digit', minute: '2-digit' });
            const items = venta.detalles.map(d => `${d.cantidad}x ${d.producto.nombre_pan}`).join(', ');
            
            return `
                <div class="flex justify-between items-center py-2 border-b border-gray-100 hover:bg-gray-50">
                    <div>
                        <p class="font-bold text-gray-800">${hora} - ${venta.cliente.nombre}</p>
                        <p class="text-sm text-gray-600">${items}</p>
                    </div>
                    <span class="font-bold text-green-600">$${parseFloat(venta.total_venta).toFixed(2)}</span>
                </div>
            `;
        }).join('');
        
        totalElement.textContent = totalHoy.toFixed(2);
    } catch (error) {
        console.error('Error cargando ventas:', error);
        document.getElementById('mis-ventas-hoy').innerHTML = '<p class="text-red-500 text-center py-4">Error al cargar ventas</p>';
    }
}

// Load on page start
cargarMisVentasHoy();
</script>
@endsection
