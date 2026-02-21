@extends('layouts.app')

@section('titulo', 'Ventas')

@section('contenido')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-cash-register text-emerald-600 mr-2"></i>
            Gestión de Ventas
        </h1>
        <button onclick="abrirModalCrear()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fas fa-plus mr-2"></i>Nueva Venta
        </button>
    </div>

    <!-- Tabla de Ventas -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empleado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-ventas" class="divide-y divide-gray-200">
                <!-- Se llena con JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Crear/Editar -->
<div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 id="modal-titulo" class="text-lg font-medium text-gray-900 mb-4">Nueva Venta</h3>
            <form id="form-venta" onsubmit="guardarVenta(event)">
                <input type="hidden" id="venta-id">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Fecha</label>
                    <input type="date" id="venta-fecha" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Cliente</label>
                    <select id="venta-cliente" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Seleccionar cliente...</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Empleado</label>
                    <select id="venta-empleado" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Seleccionar empleado...</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Total</label>
                    <input type="number" step="0.01" id="venta-total" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Notas</label>
                    <textarea id="venta-notas" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="3"></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="cerrarModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let ventas = [];
    let clientes = [];
    let empleados = [];

    async function cargarVentas() {
        try {
            const response = await fetch('/api/ventas');
            ventas = await response.json();
            mostrarVentas();
        } catch (error) {
            console.error('Error cargando ventas:', error);
        }
    }

    async function cargarClientes() {
        try {
            const response = await fetch('/api/clientes');
            clientes = await response.json();
            const select = document.getElementById('venta-cliente');
            select.innerHTML = '<option value="">Seleccionar cliente...</option>' +
                clientes.map(c => `<option value="${c.id_cliente}">${c.nombre}</option>`).join('');
        } catch (error) {
            console.error('Error cargando clientes:', error);
        }
    }

    async function cargarEmpleados() {
        try {
            const response = await fetch('/api/empleados');
            empleados = await response.json();
            const select = document.getElementById('venta-empleado');
            select.innerHTML = '<option value="">Seleccionar empleado...</option>' +
                empleados.map(e => `<option value="${e.id_empleado}">${e.nombre_empleado}</option>`).join('');
        } catch (error) {
            console.error('Error cargando empleados:', error);
        }
    }

    function mostrarVentas() {
        const tbody = document.getElementById('tabla-ventas');
        tbody.innerHTML = ventas.map(venta => {
            const cliente = venta.cliente ? venta.cliente.nombre : 'N/A';
            const empleado = venta.empleado ? venta.empleado.nombre_empleado : 'N/A';
            return `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${venta.id_venta}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${venta.fecha_venta}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cliente}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${empleado}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$${parseFloat(venta.total_venta).toFixed(2)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="editarVenta(${venta.id_venta})" class="text-emerald-600 hover:text-emerald-900 mr-3">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="eliminarVenta(${venta.id_venta})" class="text-red-600 hover:text-red-900">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `}).join('');
    }

    function abrirModalCrear() {
        document.getElementById('modal-titulo').textContent = 'Nueva Venta';
        document.getElementById('venta-id').value = '';
        document.getElementById('venta-fecha').value = new Date().toISOString().split('T')[0];
        document.getElementById('venta-cliente').value = '';
        document.getElementById('venta-empleado').value = '';
        document.getElementById('venta-total').value = '';
        document.getElementById('venta-notas').value = '';
        document.getElementById('modal').classList.remove('hidden');
        cargarClientes();
        cargarEmpleados();
    }

    function abrirModalEditar(venta) {
        document.getElementById('modal-titulo').textContent = 'Editar Venta';
        document.getElementById('venta-id').value = venta.id_venta;
        document.getElementById('venta-fecha').value = venta.fecha_venta;
        document.getElementById('venta-cliente').value = venta.id_cliente;
        document.getElementById('venta-empleado').value = venta.id_empleado;
        document.getElementById('venta-total').value = venta.total_venta;
        document.getElementById('venta-notas').value = venta.notas || '';
        document.getElementById('modal').classList.remove('hidden');
        cargarClientes();
        cargarEmpleados();
    }

    function cerrarModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    async function guardarVenta(event) {
        event.preventDefault();
        const id = document.getElementById('venta-id').value;
        const datos = {
            fecha_venta: document.getElementById('venta-fecha').value,
            id_cliente: parseInt(document.getElementById('venta-cliente').value),
            id_empleado: parseInt(document.getElementById('venta-empleado').value),
            total_venta: parseFloat(document.getElementById('venta-total').value),
            notas: document.getElementById('venta-notas').value
        };

        try {
            const url = id ? `/api/ventas/${id}` : '/api/ventas';
            const method = id ? 'PUT' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(datos)
            });

            if (response.ok) {
                cerrarModal();
                cargarVentas();
            }
        } catch (error) {
            console.error('Error guardando venta:', error);
        }
    }

    function editarVenta(id) {
        const venta = ventas.find(v => v.id_venta === id);
        if (venta) abrirModalEditar(venta);
    }

    async function eliminarVenta(id) {
        if (!confirm('¿Estás seguro de eliminar esta venta?')) return;

        try {
            const response = await fetch(`/api/ventas/${id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            });
            if (response.ok) cargarVentas();
        } catch (error) {
            console.error('Error eliminando venta:', error);
        }
    }

    cargarVentas();
</script>
@endsection
