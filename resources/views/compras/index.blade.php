@extends('layouts.app')

@section('titulo', 'Compras')

@section('contenido')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-shopping-cart text-red-600 mr-2"></i>
            Gestión de Compras
        </h1>
        <button onclick="abrirModalCrear()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fas fa-plus mr-2"></i>Nueva Compra
        </button>
    </div>

    <!-- Tabla de Compras -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empleado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-compras" class="divide-y divide-gray-200">
                <!-- Se llena con JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Crear/Editar -->
<div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 id="modal-titulo" class="text-lg font-medium text-gray-900 mb-4">Nueva Compra</h3>
            <form id="form-compra" onsubmit="guardarCompra(event)">
                <input type="hidden" id="compra-id">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Fecha</label>
                    <input type="date" id="compra-fecha" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Empleado</label>
                    <select id="compra-empleado" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Seleccionar empleado...</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Total</label>
                    <input type="number" step="0.01" id="compra-total" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Notas</label>
                    <textarea id="compra-notas" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="3"></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="cerrarModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
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
    let compras = [];
    let empleados = [];

    async function cargarCompras() {
        try {
            const response = await fetch('/api/compras');
            compras = await response.json();
            mostrarCompras();
        } catch (error) {
            console.error('Error cargando compras:', error);
        }
    }

    async function cargarEmpleados() {
        try {
            const response = await fetch('/api/empleados');
            empleados = await response.json();
            const select = document.getElementById('compra-empleado');
            select.innerHTML = '<option value="">Seleccionar empleado...</option>' +
                empleados.map(e => `<option value="${e.id_empleado}">${e.nombre_empleado}</option>`).join('');
        } catch (error) {
            console.error('Error cargando empleados:', error);
        }
    }

    function mostrarCompras() {
        const tbody = document.getElementById('tabla-compras');
        tbody.innerHTML = compras.map(compra => {
            const empleado = compra.empleado ? compra.empleado.nombre_empleado : 'N/A';
            return `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${compra.id_compra}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${compra.fecha_compra}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${empleado}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$${parseFloat(compra.total_compra).toFixed(2)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${compra.notas || '-'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="editarCompra(${compra.id_compra})" class="text-red-600 hover:text-red-900 mr-3">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="eliminarCompra(${compra.id_compra})" class="text-red-800 hover:text-red-900">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `}).join('');
    }

    function abrirModalCrear() {
        document.getElementById('modal-titulo').textContent = 'Nueva Compra';
        document.getElementById('compra-id').value = '';
        document.getElementById('compra-fecha').value = new Date().toISOString().split('T')[0];
        document.getElementById('compra-empleado').value = '';
        document.getElementById('compra-total').value = '';
        document.getElementById('compra-notas').value = '';
        document.getElementById('modal').classList.remove('hidden');
        cargarEmpleados();
    }

    function abrirModalEditar(compra) {
        document.getElementById('modal-titulo').textContent = 'Editar Compra';
        document.getElementById('compra-id').value = compra.id_compra;
        document.getElementById('compra-fecha').value = compra.fecha_compra;
        document.getElementById('compra-empleado').value = compra.id_empleado;
        document.getElementById('compra-total').value = compra.total_compra;
        document.getElementById('compra-notas').value = compra.notas || '';
        document.getElementById('modal').classList.remove('hidden');
        cargarEmpleados();
    }

    function cerrarModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    async function guardarCompra(event) {
        event.preventDefault();
        const id = document.getElementById('compra-id').value;
        const datos = {
            fecha_compra: document.getElementById('compra-fecha').value,
            id_empleado: parseInt(document.getElementById('compra-empleado').value),
            total_compra: parseFloat(document.getElementById('compra-total').value),
            notas: document.getElementById('compra-notas').value
        };

        try {
            const url = id ? `/api/compras/${id}` : '/api/compras';
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
                cargarCompras();
            }
        } catch (error) {
            console.error('Error guardando compra:', error);
        }
    }

    function editarCompra(id) {
        const compra = compras.find(c => c.id_compra === id);
        if (compra) abrirModalEditar(compra);
    }

    async function eliminarCompra(id) {
        if (!confirm('¿Estás seguro de eliminar esta compra?')) return;

        try {
            const response = await fetch(`/api/compras/${id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            });
            if (response.ok) cargarCompras();
        } catch (error) {
            console.error('Error eliminando compra:', error);
        }
    }

    cargarCompras();
</script>
@endsection
