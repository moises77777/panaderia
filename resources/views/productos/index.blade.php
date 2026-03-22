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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
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
            <form id="form-producto" onsubmit="guardarProducto(event)" enctype="multipart/form-data">
                <input type="hidden" id="producto-id">
                
                <!-- Vista previa de imagen -->
                <div class="mb-4 text-center">
                    <div id="imagen-preview" class="w-32 h-32 mx-auto bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden mb-2">
                        <span class="text-4xl">🍞</span>
                    </div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Foto del Pan</label>
                    <input type="file" id="producto-imagen" name="imagen" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" onchange="previewImagen(this)">
                    <p class="text-xs text-gray-500 mt-1">Máximo 2MB (JPG, PNG, GIF)</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre del Pan</label>
                    <input type="text" id="producto-nombre" name="nombre_pan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Precio</label>
                    <input type="number" step="0.01" id="producto-precio" name="precio" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Stock Disponible</label>
                    <input type="number" id="producto-stock" name="stock_disponible" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
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
        console.log('Cargando productos...');
        try {
            const response = await fetch('/api/productos');
            console.log('Response status:', response.status);
            productos = await response.json();
            console.log('Productos cargados:', productos);
            mostrarProductos();
        } catch (error) {
            console.error('Error cargando productos:', error);
        }
    }

    function mostrarProductos() {
        const tbody = document.getElementById('tabla-productos');
        
        if (productos.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-bread-slice text-4xl mb-2"></i>
                        <p class="text-lg">No hay productos registrados</p>
                        <p class="text-sm">Haz clic en "Nuevo Producto" para agregar uno</p>
                    </td>
                </tr>
            `;
            return;
        }
        
        tbody.innerHTML = productos.map(producto => {
            const materiasCount = producto.materias_primas ? producto.materias_primas.length : 0;
            const imagenHtml = producto.imagen 
                ? `<img src="/storage/${producto.imagen}" alt="${producto.nombre_pan}" class="w-12 h-12 rounded-lg object-cover">`
                : `<div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center text-2xl">🍞</div>`;
            
            return `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">${imagenHtml}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${producto.id_pan}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">${producto.nombre_pan}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$${parseFloat(producto.precio).toFixed(2)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${producto.stock_disponible}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${materiasCount} materias</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="editarProducto(${producto.id_pan})" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg font-bold mr-2" title="Editar">
                        ✏️ Editar
                    </button>
                    <button onclick="eliminarProducto(${producto.id_pan})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg font-bold" title="Eliminar">
                        🗑️ Eliminar
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
        document.getElementById('producto-imagen').value = '';
        document.getElementById('imagen-preview').innerHTML = '<span class="text-4xl">🍞</span>';
        document.getElementById('modal').classList.remove('hidden');
    }

    function previewImagen(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagen-preview').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function abrirModalEditar(producto) {
        document.getElementById('modal-titulo').textContent = 'Editar Producto';
        document.getElementById('producto-id').value = producto.id_pan;
        document.getElementById('producto-nombre').value = producto.nombre_pan;
        document.getElementById('producto-precio').value = producto.precio;
        document.getElementById('producto-stock').value = producto.stock_disponible;
        document.getElementById('producto-imagen').value = '';
        
        // Mostrar imagen actual si existe
        const previewDiv = document.getElementById('imagen-preview');
        if (producto.imagen) {
            previewDiv.innerHTML = `<img src="/storage/${producto.imagen}" class="w-full h-full object-cover">`;
        } else {
            previewDiv.innerHTML = '<span class="text-4xl">🍞</span>';
        }
        
        document.getElementById('modal').classList.remove('hidden');
    }

    function cerrarModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    async function guardarProducto(event) {
        event.preventDefault();
        const id = document.getElementById('producto-id').value;
        
        // Usar FormData para enviar archivo
        const formData = new FormData();
        formData.append('nombre_pan', document.getElementById('producto-nombre').value);
        formData.append('precio', document.getElementById('producto-precio').value);
        formData.append('stock_disponible', document.getElementById('producto-stock').value);
        
        const imagenInput = document.getElementById('producto-imagen');
        if (imagenInput.files.length > 0) {
            formData.append('imagen', imagenInput.files[0]);
        }

        try {
            const url = id ? `/api/productos/${id}` : '/api/productos';
            const method = id ? 'POST' : 'POST'; // POST con _method para PUT
            
            if (id) {
                formData.append('_method', 'PUT');
            }

            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const responseData = await response.json();

            if (response.ok) {
                cerrarModal();
                cargarProductos();
            } else {
                console.error('Error del servidor:', responseData);
                alert('Error: ' + (responseData.error || JSON.stringify(responseData)));
            }
        } catch (error) {
            console.error('Error guardando producto:', error);
            alert('Error al guardar producto');
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
