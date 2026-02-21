@extends('layouts.app')

@section('titulo', 'Clientes')

@section('contenido')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-users text-blue-600 mr-2"></i>
            Gestión de Clientes
        </h1>
        <button onclick="abrirModalCrear()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fas fa-plus mr-2"></i>Nuevo Cliente
        </button>
    </div>

    <!-- Tabla de Clientes -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ventas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-clientes" class="divide-y divide-gray-200">
                <!-- Se llena con JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Crear/Editar -->
<div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 id="modal-titulo" class="text-lg font-medium text-gray-900 mb-4">Nuevo Cliente</h3>
            <form id="form-cliente" onsubmit="guardarCliente(event)">
                <input type="hidden" id="cliente-id">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                    <input type="text" id="cliente-nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="cerrarModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
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
    let clientes = [];

    async function cargarClientes() {
        try {
            const response = await fetch('/api/clientes');
            clientes = await response.json();
            mostrarClientes();
        } catch (error) {
            console.error('Error cargando clientes:', error);
        }
    }

    function mostrarClientes() {
        const tbody = document.getElementById('tabla-clientes');
        tbody.innerHTML = clientes.map(cliente => `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${cliente.id_cliente}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">${cliente.nombre}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cliente.ventas ? cliente.ventas.length : 0}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="editarCliente(${cliente.id_cliente})" class="text-blue-600 hover:text-blue-900 mr-3">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="eliminarCliente(${cliente.id_cliente})" class="text-red-600 hover:text-red-900">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    }

    function abrirModalCrear() {
        document.getElementById('modal-titulo').textContent = 'Nuevo Cliente';
        document.getElementById('cliente-id').value = '';
        document.getElementById('cliente-nombre').value = '';
        document.getElementById('modal').classList.remove('hidden');
    }

    function abrirModalEditar(cliente) {
        document.getElementById('modal-titulo').textContent = 'Editar Cliente';
        document.getElementById('cliente-id').value = cliente.id_cliente;
        document.getElementById('cliente-nombre').value = cliente.nombre;
        document.getElementById('modal').classList.remove('hidden');
    }

    function cerrarModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    async function guardarCliente(event) {
        event.preventDefault();
        const id = document.getElementById('cliente-id').value;
        const nombre = document.getElementById('cliente-nombre').value;

        try {
            const url = id ? `/api/clientes/${id}` : '/api/clientes';
            const method = id ? 'PUT' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({nombre})
            });

            if (response.ok) {
                cerrarModal();
                cargarClientes();
            }
        } catch (error) {
            console.error('Error guardando cliente:', error);
        }
    }

    function editarCliente(id) {
        const cliente = clientes.find(c => c.id_cliente === id);
        if (cliente) abrirModalEditar(cliente);
    }

    async function eliminarCliente(id) {
        if (!confirm('¿Estás seguro de eliminar este cliente?')) return;

        try {
            const response = await fetch(`/api/clientes/${id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            });
            if (response.ok) cargarClientes();
        } catch (error) {
            console.error('Error eliminando cliente:', error);
        }
    }

    // Cargar datos al iniciar
    cargarClientes();
</script>
@endsection
