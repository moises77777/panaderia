@extends('layouts.app')

@section('titulo', 'Materias Primas')

@section('contenido')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-wheat-awn text-purple-600 mr-2"></i>
            Gestión de Materias Primas
        </h1>
        <button onclick="abrirModalCrear()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fas fa-plus mr-2"></i>Nueva Materia Prima
        </button>
    </div>

    <!-- Tabla de Materias Primas -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unidad Fija</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Ingreso</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-materias" class="divide-y divide-gray-200">
                <!-- Se llena con JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Crear/Editar -->
<div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 id="modal-titulo" class="text-lg font-medium text-gray-900 mb-4">Nueva Materia Prima</h3>
            <form id="form-materia" onsubmit="guardarMateria(event)">
                <input type="hidden" id="materia-id">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                    <input type="text" id="materia-nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Unidad Fija</label>
                    <input type="number" id="materia-unidad" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Stock Actual</label>
                    <input type="number" id="materia-stock" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Fecha de Ingreso</label>
                    <input type="date" id="materia-fecha" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="cerrarModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
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
    let materias = [];

    async function cargarMaterias() {
        console.log('Cargando materias primas...');
        try {
            const response = await fetch('/api/materias-primas');
            console.log('Response status:', response.status);
            materias = await response.json();
            console.log('Materias primas cargadas:', materias);
            mostrarMaterias();
        } catch (error) {
            console.error('Error cargando materias:', error);
        }
    }

    function mostrarMaterias() {
        const tbody = document.getElementById('tabla-materias');
        
        if (materias.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-wheat-awn text-4xl mb-2"></i>
                        <p class="text-lg">No hay materias primas registradas</p>
                        <p class="text-sm">Haz clic en "Nueva Materia Prima" para agregar una</p>
                    </td>
                </tr>
            `;
            return;
        }
        
        tbody.innerHTML = materias.map(materia => `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${materia.id_materia_prima}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">${materia.nombre_materia}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${materia.unidad_fija}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${materia.stock_actual}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${materia.fecha_ingreso}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="editarMateria(${materia.id_materia_prima})" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg font-bold mr-2" title="Editar">
                        ✏️ Editar
                    </button>
                    <button onclick="eliminarMateria(${materia.id_materia_prima})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg font-bold" title="Eliminar">
                        🗑️ Eliminar
                    </button>
                </td>
            </tr>
        `).join('');
    }

    function abrirModalCrear() {
        document.getElementById('modal-titulo').textContent = 'Nueva Materia Prima';
        document.getElementById('materia-id').value = '';
        document.getElementById('materia-nombre').value = '';
        document.getElementById('materia-unidad').value = '';
        document.getElementById('materia-stock').value = '';
        document.getElementById('materia-fecha').value = new Date().toISOString().split('T')[0];
        document.getElementById('modal').classList.remove('hidden');
    }

    function abrirModalEditar(materia) {
        document.getElementById('modal-titulo').textContent = 'Editar Materia Prima';
        document.getElementById('materia-id').value = materia.id_materia_prima;
        document.getElementById('materia-nombre').value = materia.nombre_materia;
        document.getElementById('materia-unidad').value = materia.unidad_fija;
        document.getElementById('materia-stock').value = materia.stock_actual;
        document.getElementById('materia-fecha').value = materia.fecha_ingreso;
        document.getElementById('modal').classList.remove('hidden');
    }

    function cerrarModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    async function guardarMateria(event) {
        event.preventDefault();
        const id = document.getElementById('materia-id').value;
        const datos = {
            nombre_materia: document.getElementById('materia-nombre').value,
            unidad_fija: parseInt(document.getElementById('materia-unidad').value),
            stock_actual: parseInt(document.getElementById('materia-stock').value),
            fecha_ingreso: document.getElementById('materia-fecha').value
        };

        try {
            const url = id ? `/api/materias-primas/${id}` : '/api/materias-primas';
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
                cargarMaterias();
            }
        } catch (error) {
            console.error('Error guardando materia:', error);
        }
    }

    function editarMateria(id) {
        const materia = materias.find(m => m.id_materia_prima === id);
        if (materia) abrirModalEditar(materia);
    }

    async function eliminarMateria(id) {
        if (!confirm('¿Estás seguro de eliminar esta materia prima?')) return;

        try {
            const response = await fetch(`/api/materias-primas/${id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            });
            if (response.ok) cargarMaterias();
        } catch (error) {
            console.error('Error eliminando materia:', error);
        }
    }

    cargarMaterias();
</script>
@endsection
