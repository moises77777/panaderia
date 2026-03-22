@extends('layouts.app')

@section('titulo', 'Empleados')

@section('contenido')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-user-tie text-green-600 mr-2"></i>
            Gestión de Empleados
        </h1>
        <button onclick="abrirModalCrear()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fas fa-plus mr-2"></i>Nuevo Empleado
        </button>
    </div>

    <!-- Tabla de Empleados -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salario</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-empleados" class="divide-y divide-gray-200">
                <!-- Se llena con JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Crear/Editar -->
<div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 id="modal-titulo" class="text-lg font-medium text-gray-900 mb-4">Nuevo Empleado</h3>
            <form id="form-empleado" onsubmit="guardarEmpleado(event)">
                <input type="hidden" id="empleado-id">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                    <input type="text" id="empleado-nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Rol</label>
                    <input type="text" id="empleado-rol" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Fecha de Ingreso</label>
                    <input type="date" id="empleado-fecha" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Salario ($)</label>
                    <input type="number" step="0.01" id="empleado-salario" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Teléfono</label>
                    <input type="text" id="empleado-telefono" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Estado</label>
                    <select id="empleado-estado" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                        <option value="vacaciones">Vacaciones</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="cerrarModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
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
    let empleados = [];

    async function cargarEmpleados() {
        console.log('Cargando empleados...');
        try {
            const response = await fetch('/api/empleados');
            console.log('Response status:', response.status);
            empleados = await response.json();
            console.log('Empleados cargados:', empleados);
            mostrarEmpleados();
        } catch (error) {
            console.error('Error cargando empleados:', error);
        }
    }

    function mostrarEmpleados() {
        const tbody = document.getElementById('tabla-empleados');
        
        if (empleados.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-user-tie text-4xl mb-2"></i>
                        <p class="text-lg">No hay empleados registrados</p>
                        <p class="text-sm">Haz clic en "Nuevo Empleado" para agregar uno</p>
                    </td>
                </tr>
            `;
            return;
        }
        
        tbody.innerHTML = empleados.map(empleado => {
            const info = empleado.info_empleado || {};
            const salario = info.salario ? `$${parseFloat(info.salario).toFixed(2)}` : '-';
            const estado = info.estado || 'activo';
            const estadoClass = estado === 'activo' ? 'bg-green-100 text-green-800' : estado === 'vacaciones' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800';
            
            return `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${empleado.id_empleado}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">${empleado.nombre_empleado}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${empleado.rol}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${salario}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${estadoClass}">${estado}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="editarEmpleado(${empleado.id_empleado})" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg font-bold mr-2" title="Editar">
                        ✏️ Editar
                    </button>
                    <button onclick="eliminarEmpleado(${empleado.id_empleado})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg font-bold" title="Eliminar">
                        🗑️ Eliminar
                    </button>
                </td>
            </tr>
        `}).join('');
    }

    function abrirModalCrear() {
        document.getElementById('modal-titulo').textContent = 'Nuevo Empleado';
        document.getElementById('empleado-id').value = '';
        document.getElementById('empleado-nombre').value = '';
        document.getElementById('empleado-rol').value = '';
        document.getElementById('empleado-fecha').value = '';
        document.getElementById('modal').classList.remove('hidden');
    }

    function abrirModalEditar(empleado) {
        document.getElementById('modal-titulo').textContent = 'Editar Empleado';
        document.getElementById('empleado-id').value = empleado.id_empleado;
        document.getElementById('empleado-nombre').value = empleado.nombre_empleado;
        document.getElementById('empleado-rol').value = empleado.rol;
        document.getElementById('empleado-fecha').value = empleado.fecha_ingreso;
        
        const info = empleado.info_empleado || {};
        document.getElementById('empleado-salario').value = info.salario || '';
        document.getElementById('empleado-telefono').value = info.telefono || '';
        document.getElementById('empleado-estado').value = info.estado || 'activo';
        
        document.getElementById('modal').classList.remove('hidden');
    }

    function cerrarModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    async function guardarEmpleado(event) {
        event.preventDefault();
        const id = document.getElementById('empleado-id').value;
        const datos = {
            nombre_empleado: document.getElementById('empleado-nombre').value,
            rol: document.getElementById('empleado-rol').value,
            fecha_ingreso: document.getElementById('empleado-fecha').value,
            info: {
                salario: document.getElementById('empleado-salario').value,
                telefono: document.getElementById('empleado-telefono').value,
                estado: document.getElementById('empleado-estado').value,
                fecha_contratacion: document.getElementById('empleado-fecha').value
            }
        };

        try {
            const url = id ? `/api/empleados/${id}` : '/api/empleados';
            const method = id ? 'PUT' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(datos)
            });

            const responseData = await response.json();

            if (response.ok) {
                cerrarModal();
                cargarEmpleados();
            } else {
                console.error('Error del servidor:', responseData);
                alert('Error: ' + (responseData.error || 'Error desconocido'));
            }
        } catch (error) {
            console.error('Error guardando empleado:', error);
            alert('Error al guardar empleado');
        }
    }

    function editarEmpleado(id) {
        const empleado = empleados.find(e => e.id_empleado === id);
        if (empleado) abrirModalEditar(empleado);
    }

    async function eliminarEmpleado(id) {
        if (!confirm('¿Estás seguro de eliminar este empleado?')) return;

        try {
            const response = await fetch(`/api/empleados/${id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            });
            if (response.ok) cargarEmpleados();
        } catch (error) {
            console.error('Error eliminando empleado:', error);
        }
    }

    cargarEmpleados();
</script>
@endsection
