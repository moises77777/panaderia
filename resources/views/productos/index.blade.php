@extends('layouts.app')

@section('titulo', 'Productos')

@section('contenido')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-bread-slice text-yellow-600 mr-2"></i>
            Gestión de Productos
        </h1>
        <button onclick="abrirModalCrear()" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fas fa-plus mr-2"></i>Nuevo Producto
        </button>
    </div>

    <!-- Tabla de Productos -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materias Primas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-productos" class="divide-y divide-gray-200">
                <!-- Se llena con JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Crear/Editar -->
<div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 id="modal-titulo" class="text-lg font-medium text-gray-900 mb-4">Nuevo Producto</h3>
            <form id="form-producto" onsubmit="guardarProducto(event)">
                <input type="hidden" id="producto-id">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre del Pan</label>
                    <input type="text" id="producto-nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Precio</label>
                    <input type="number" step="0.01" id="producto-precio" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Stock Disponible</label>
                    <input type="number" id="producto-stock" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="cerrarModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
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
    let productos = [];

    async function cargarProductos() {
        try {
            const response = await fetch('/api/productos');
            productos = await response.json();
            mostrarProductos();
        } catch (error) {
            console.error('Error cargando productos:', error);
        }
    }

    function mostrarProductos() {
        const tbody = document.getElementById('tabla-productos');
        tbody.innerHTML = productos.map(producto => {
            const materiasCount = producto.materias_primas ? producto.materias_primas.length : 0;
            return `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${producto.id_pan}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">${producto.nombre_pan}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$${parseFloat(producto.precio).toFixed(2)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${producto.stock_disponible}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${materiasCount} materias</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="editarProducto(${producto.id_pan})" class="text-yellow-600 hover:text-yellow-900 mr-3">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="eliminarProducto(${producto.id_pan})" class="text-red-600 hover:text-red-900">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `}).join('');
    }

    function abrirModalCrear() {
        document.getElementById('modal-titulo').textContent = 'Nuevo Producto';
        document.getElementById('producto-id').value = '';
        document.getElementById('producto-nombre').value = '';
        document.getElementById('producto-precio').value = '';
        document.getElementById('producto-stock').value = '';
        document.getElementById('modal').classList.remove('hidden');
    }

    function abrirModalEditar(producto) {
        document.getElementById('modal-titulo').textContent = 'Editar Producto';
        document.getElementById('producto-id').value = producto.id_pan;
        document.getElementById('producto-nombre').value = producto.nombre_pan;
        document.getElementById('producto-precio').value = producto.precio;
        document.getElementById('producto-stock').value = producto.stock_disponible;
        document.getElementById('modal').classList.remove('hidden');
    }

    function cerrarModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    async function guardarProducto(event) {
        event.preventDefault();
        const id = document.getElementById('producto-id').value;
        const datos = {
            nombre_pan: document.getElementById('producto-nombre').value,
            precio: parseFloat(document.getElementById('producto-precio').value),
            stock_disponible: parseInt(document.getElementById('producto-stock').value)
        };

        try {
            const url = id ? `/api/productos/${id}` : '/api/productos';
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
                cargarProductos();
            }
        } catch (error) {
            console.error('Error guardando producto:', error);
        }
    }

    function editarProducto(id) {
        const producto = productos.find(p => p.id_pan === id);
        if (producto) abrirModalEditar(producto);
    }

    async function eliminarProducto(id) {
        if (!confirm('¿Estás seguro de eliminar este producto?')) return;

        try {
            const response = await fetch(`/api/productos/${id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            });
            if (response.ok) cargarProductos();
        } catch (error) {
            console.error('Error eliminando producto:', error);
        }
    }

    cargarProductos();
</script>
@endsection
