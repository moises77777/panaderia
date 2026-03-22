@extends('layouts.app')

@section('titulo', 'Reporte de Ventas')

@section('contenido')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-amber-800">
            <i class="fas fa-chart-line"></i> Reporte de Ventas
        </h1>
        <a href="/admin" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="flex flex-wrap gap-4 items-center">
            <div>
                <label class="block text-sm font-bold text-gray-700">Desde</label>
                <input type="date" id="fecha-desde" class="border rounded px-3 py-1">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700">Hasta</label>
                <input type="date" id="fecha-hasta" class="border rounded px-3 py-1">
            </div>
            <button onclick="cargarReporte()" class="bg-amber-500 text-white px-4 py-2 rounded hover:bg-amber-600 mt-5">
                <i class="fas fa-search"></i> Filtrar
            </button>
            <button onclick="cargarTodasVentas()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-5">
                <i class="fas fa-list"></i> Todas
            </button>
        </div>
    </div>

    <!-- Totales -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-green-100 p-4 rounded-lg text-center border-2 border-green-300">
            <p class="text-sm text-gray-600">Total Ventas</p>
            <p class="text-3xl font-bold text-green-600" id="total-ventas">$0.00</p>
        </div>
        <div class="bg-blue-100 p-4 rounded-lg text-center border-2 border-blue-300">
            <p class="text-sm text-gray-600">Número de Ventas</p>
            <p class="text-3xl font-bold text-blue-600" id="numero-ventas">0</p>
        </div>
        <div class="bg-amber-100 p-4 rounded-lg text-center border-2 border-amber-300">
            <p class="text-sm text-gray-600">Promedio por Venta</p>
            <p class="text-3xl font-bold text-amber-600" id="promedio-venta">$0.00</p>
        </div>
    </div>

    <!-- Top Vendedores -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-trophy"></i>
        </h2>
        <div id="top-vendedores" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Se llena con JS -->
        </div>
    </div>

    <!-- Tabla de Ventas -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <h2 class="text-xl font-bold text-gray-800 p-4 bg-gray-50">
            <i class="fas fa-list-alt"></i> Detalle de Ventas
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Fecha</th>
                        <th class="px-4 py-2 text-left">Cliente</th>
                        <th class="px-4 py-2 text-left">Vendedor</th>
                        <th class="px-4 py-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody id="tabla-ventas">
                    <!-- Se llena con JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
let todasLasVentas = [];

// Fechas por defecto (últimos 7 días)
document.getElementById('fecha-hasta').value = new Date().toISOString().split('T')[0];
document.getElementById('fecha-desde').value = new Date(Date.now() - 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];

async function cargarTodasVentas() {
    try {
        const response = await fetch('/api/ventas');
        todasLasVentas = await response.json();
        mostrarReporte(todasLasVentas);
    } catch (error) {
        console.error('Error cargando ventas:', error);
        alert('Error al cargar ventas');
    }
}

async function cargarReporte() {
    const desde = document.getElementById('fecha-desde').value;
    const hasta = document.getElementById('fecha-hasta').value;
    
    try {
        const response = await fetch('/api/ventas');
        todasLasVentas = await response.json();
        
        // Filtrar por fecha
        const ventasFiltradas = todasLasVentas.filter(v => {
            const fecha = v.fecha_venta.split('T')[0];
            return fecha >= desde && fecha <= hasta;
        });
        
        mostrarReporte(ventasFiltradas);
    } catch (error) {
        console.error('Error cargando ventas:', error);
        alert('Error al cargar ventas');
    }
}

function mostrarReporte(ventas) {
    // Totales
    const total = ventas.reduce((sum, v) => sum + parseFloat(v.total_venta), 0);
    document.getElementById('total-ventas').textContent = '$' + total.toFixed(2);
    document.getElementById('numero-ventas').textContent = ventas.length;
    document.getElementById('promedio-venta').textContent = '$' + (ventas.length > 0 ? (total / ventas.length).toFixed(2) : '0.00');
    
    // Top vendedores
    const vendedores = {};
    ventas.forEach(v => {
        const nombre = v.empleado ? v.empleado.nombre_empleado : 'Desconocido';
        if (!vendedores[nombre]) vendedores[nombre] = { ventas: 0, total: 0 };
        vendedores[nombre].ventas++;
        vendedores[nombre].total += parseFloat(v.total_venta);
    });
    
   
    // Tabla
    document.getElementById('tabla-ventas').innerHTML = ventas.slice(0, 50).map(v => `
        <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-2">${new Date(v.fecha_venta).toLocaleDateString('es-MX')}</td>
            <td class="px-4 py-2">${v.cliente ? v.cliente.nombre : 'Desconocido'}</td>
            <td class="px-4 py-2">${v.empleado ? v.empleado.nombre_empleado : 'Desconocido'}</td>
            <td class="px-4 py-2 text-right font-bold text-green-600">$${parseFloat(v.total_venta).toFixed(2)}</td>
            <td class="px-4 py-2 text-center">
                <button onclick="verDetalles(${v.id_venta})" class="text-blue-500 hover:text-blue-700">
                    <i class="fas fa-eye"></i>
                </button>
            </td>
        </tr>
    `).join('') || '<tr><td colspan="5" class="text-center py-4 text-gray-500">No hay ventas en este período</td></tr>';
}

function verDetalles(idVenta) {
    const venta = todasLasVentas.find(v => v.id_venta === idVenta);
    if (!venta || !venta.detalles) return;
    
    const detalles = venta.detalles.map(d => 
        `- ${d.producto ? d.producto.nombre_pan : 'Producto'}: ${d.cantidad} x $${parseFloat(d.precio_unitario).toFixed(2)} = $${parseFloat(d.subtotal).toFixed(2)}`
    ).join('\n');
    
    alert(`Venta #${idVenta}\n\n${detalles}\n\nTotal: $${parseFloat(venta.total_venta).toFixed(2)}`);
}

// Cargar al iniciar
cargarTodasVentas();
</script>
@endsection
