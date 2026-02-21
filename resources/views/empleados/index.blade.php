{{-- @extends('layouts.app') = Usa la plantilla base del layout principal --}}
@extends('layouts.app')

{{-- Define el título de la página que aparece en la pestaña del navegador --}}
@section('titulo', 'Empleados')

@section('contenido')
{{-- 
    space-y-6 = espacio vertical de 6 unidades (24px) entre hijos
    space-y aplica margin-bottom a todos los hijos excepto el último
--}}
<div class="space-y-6">
    {{-- 
        Header: Barra superior con título y botón
        flex = usa flexbox para alinear elementos horizontalmente
        justify-between = alinea elementos a los extremos (izquierda y derecha)
        items-center = centra verticalmente los elementos
    --}}
    <div class="flex justify-between items-center">
        {{-- 
            text-3xl = tamaño de texto 3xl (30px)
            font-bold = negrita
            text-gray-800 = color de texto gris oscuro
            i.fas.fa-user-tie = ícono de Font Awesome (usuario con corbata)
            text-green-600 = color verde para el ícono
            mr-2 = margin-right de 2 unidades (8px)
        --}}
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-user-tie text-green-600 mr-2"></i>
            Gestión de Empleados
        </h1>
        {{-- 
            Botón para abrir modal de crear empleado
            onclick="abrirModalCrear()" = llama a la función JS cuando se hace click
            bg-green-600 = fondo verde
            hover:bg-green-700 = al pasar el mouse, fondo verde más oscuro
            transition = transición suave de colores
        --}}
        <button onclick="abrirModalCrear()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fas fa-plus mr-2"></i>Nuevo Empleado
        </button>
    </div>

    {{-- 
        Tabla de Empleados
        bg-white = fondo blanco
        rounded-lg = bordes redondeados
        shadow = sombra suave
        overflow-hidden = oculta contenido que se salga del contenedor
    --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        {{-- w-full = ancho 100% de su contenedor --}}
        <table class="w-full">
            {{-- thead = encabezado de tabla. bg-gray-50 = fondo gris muy claro --}}
            <thead class="bg-gray-50">
                <tr>
                    {{-- 
                        th = celda de encabezado
                        px-6 = padding horizontal 6 unidades (24px)
                        py-3 = padding vertical 3 unidades (12px)
                        text-left = texto alineado a la izquierda
                        text-xs = texto extra small (12px)
                        font-medium = peso medio (no tan bold)
                        text-gray-500 = color gris medio
                        uppercase = texto en mayúsculas
                        tracking-wider = espaciado entre letras más amplio
                    --}}
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salario</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            {{-- 
                tbody = cuerpo de la tabla
                id="tabla-empleados" = identificador para que JavaScript lo encuentre y llene
                divide-y = línea divisoria horizontal entre filas
                divide-gray-200 = color gris claro para las líneas
            --}}
            <tbody id="tabla-empleados" class="divide-y divide-gray-200">
                {{-- Este tbody se llena dinámicamente con JavaScript --}}
            </tbody>
        </table>
    </div>
</div>

{{-- 
    Modal Crear/Editar Empleado
    fixed = posición fija en la pantalla
    inset-0 = se extiende a todos los bordes (top, right, bottom, left: 0)
    bg-gray-600 = fondo gris semitransparente (overlay)
    bg-opacity-50 = opacidad del fondo al 50%
    hidden = inicialmente oculto (se muestra con JS)
    z-50 = z-index alto para que esté encima de todo
--}}
<div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    {{-- 
        relative = posición relativa para que los hijos se posicionen respecto a este
        top-20 = margen superior de 20 unidades (80px)
        mx-auto = centrado horizontal automático
        w-96 = ancho fijo de 96 unidades (384px)
    --}}
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            {{-- id="modal-titulo" = se cambia dinámicamente entre "Nuevo" o "Editar" --}}
            <h3 id="modal-titulo" class="text-lg font-medium text-gray-900 mb-4">Nuevo Empleado</h3>
            {{-- 
                form = formulario para crear/editar empleado
                onsubmit="guardarEmpleado(event)" = prevenir envío normal y usar JS
                event.preventDefault() en la función evita que se recargue la página
            --}}
            <form id="form-empleado" onsubmit="guardarEmpleado(event)">
                {{-- 
                    type="hidden" = campo oculto, no visible para el usuario
                    id="empleado-id" = guarda el ID del empleado cuando se edita
                    Cuando está vacío = crear nuevo, cuando tiene valor = editar existente
                --}}
                <input type="hidden" id="empleado-id">
                
                {{-- Campo Nombre --}}
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                    <input type="text" id="empleado-nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                
                {{-- Campo Rol (puesto de trabajo) --}}
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Rol</label>
                    <input type="text" id="empleado-rol" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                
                {{-- Campo Fecha de Ingreso --}}
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Fecha de Ingreso</label>
                    <input type="date" id="empleado-fecha" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                
                {{-- Campo Salario con step para decimales --}}
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Salario ($)</label>
                    <input type="number" step="0.01" id="empleado-salario" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                
                {{-- Campo Teléfono --}}
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Teléfono</label>
                    <input type="text" id="empleado-telefono" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                
                {{-- Campo Estado (select dropdown) --}}
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Estado</label>
                    {{-- select = menú desplegable con opciones --}}
                    <select id="empleado-estado" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                        <option value="vacaciones">Vacaciones</option>
                    </select>
                </div>
                
                {{-- Botones del formulario --}}
                <div class="flex justify-end gap-2">
                    {{-- type="button" = no envía el formulario al hacer click --}}
                    <button type="button" onclick="cerrarModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancelar
                    </button>
                    {{-- type="submit" = envía el formulario y ejecuta onsubmit --}}
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
    {{-- Variable global para almacenar el array de empleados --}}
    let empleados = [];

    {{-- 
        Función asíncrona para cargar empleados desde la API
        async/await = espera a que la petición termine antes de continuar
        fetch('/api/empleados') = hace petición GET al servidor
        response.json() = convierte la respuesta a objeto JavaScript
    --}}
    async function cargarEmpleados() {
        try {
            const response = await fetch('/api/empleados');
            empleados = await response.json();
            mostrarEmpleados();
        } catch (error) {
            console.error('Error cargando empleados:', error);
        }
    }

    {{-- 
        Función que genera el HTML de la tabla de empleados
        empleados.map() = recorre el array y devuelve nuevo array con HTML
        .join('') = une todos los elementos del array en un string
    --}}
    function mostrarEmpleados() {
        const tbody = document.getElementById('tabla-empleados');
        tbody.innerHTML = empleados.map(empleado => {
            {{-- Obtiene info_adicional del empleado (salario, estado, etc.) --}}
            const info = empleado.info_empleado || {};
            {{-- Si hay salario, lo formatea con $ y 2 decimales, sino muestra '-' --}}
            const salario = info.salario ? `$${parseFloat(info.salario).toFixed(2)}` : '-';
            {{-- Estado por defecto 'activo' si no viene --}}
            const estado = info.estado || 'activo';
            {{-- 
                Operador ternario para asignar clase de color según estado
                condición ? valor_si_true : valor_si_false
            --}}
            const estadoClass = estado === 'activo' ? 'bg-green-100 text-green-800' : estado === 'vacaciones' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800';
            
            return `
            {{-- tr = fila de tabla. hover:bg-gray-50 = cambia color al pasar mouse --}}
            <tr class="hover:bg-gray-50">
                {{-- td = celda de tabla. whitespace-nowrap = no permite saltos de línea --}}
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${empleado.id_empleado}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">${empleado.nombre_empleado}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${empleado.rol}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${salario}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{-- span con clase dinámica según el estado del empleado --}}
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${estadoClass}">${estado}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    {{-- Botón editar: llama a editarEmpleado() con el ID --}}
                    <button onclick="editarEmpleado(${empleado.id_empleado})" class="text-green-600 hover:text-green-900 mr-3">
                        <i class="fas fa-edit"></i>
                    </button>
                    {{-- Botón eliminar: llama a eliminarEmpleado() con el ID --}}
                    <button onclick="eliminarEmpleado(${empleado.id_empleado})" class="text-red-600 hover:text-red-900">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `}).join('');
    }

    {{-- Abre el modal en modo "Crear" (campos vacíos) --}}
    function abrirModalCrear() {
        document.getElementById('modal-titulo').textContent = 'Nuevo Empleado';
        document.getElementById('empleado-id').value = '';
        document.getElementById('empleado-nombre').value = '';
        document.getElementById('empleado-rol').value = '';
        document.getElementById('empleado-fecha').value = '';
        {{-- classList.remove('hidden') = muestra el modal quitando la clase hidden --}}
        document.getElementById('modal').classList.remove('hidden');
    }

    {{-- Abre el modal en modo "Editar" (campos llenos con datos del empleado) --}}
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

    {{-- Cierra el modal agregando clase hidden --}}
    function cerrarModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    {{-- 
        Guarda el empleado (crea nuevo o actualiza existente)
        event.preventDefault() = evita que el formulario se envíe normalmente (sin recargar)
    --}}
    async function guardarEmpleado(event) {
        event.preventDefault();
        {{-- Si hay ID = editar, si no hay ID = crear --}}
        const id = document.getElementById('empleado-id').value;
        {{-- Objeto con los datos del formulario --}}
        const datos = {
            nombre_empleado: document.getElementById('empleado-nombre').value,
            rol: document.getElementById('empleado-rol').value,
            fecha_ingreso: document.getElementById('empleado-fecha').value,
            {{-- info = objeto anidado para la tabla info_empleados --}}
            info: {
                salario: document.getElementById('empleado-salario').value,
                telefono: document.getElementById('empleado-telefono').value,
                estado: document.getElementById('empleado-estado').value,
                fecha_contratacion: document.getElementById('empleado-fecha').value
            }
        };

        try {
            {{-- Operador ternario: si hay id, usa PUT para actualizar, sino POST para crear --}}
            const url = id ? `/api/empleados/${id}` : '/api/empleados';
            const method = id ? 'PUT' : 'POST';

            {{-- fetch con opciones: método, headers y body --}}
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' {{-- Token de seguridad de Laravel --}}
                },
                {{-- JSON.stringify() = convierte el objeto a string JSON --}}
                body: JSON.stringify(datos)
            });

            const responseData = await response.json();

            {{-- response.ok = true si el código HTTP es 200-299 --}}
            if (response.ok) {
                cerrarModal();
                cargarEmpleados(); {{-- Recarga la lista para mostrar cambios --}}
            } else {
                console.error('Error del servidor:', responseData);
                alert('Error: ' + (responseData.error || 'Error desconocido'));
            }
        } catch (error) {
            console.error('Error guardando empleado:', error);
            alert('Error al guardar empleado');
        }
    }

    {{-- Busca el empleado por ID y abre el modal en modo editar --}}
    function editarEmpleado(id) {
        {{-- .find() = busca el primer elemento que cumpla la condición --}}
        const empleado = empleados.find(e => e.id_empleado === id);
        if (empleado) abrirModalEditar(empleado);
    }

    {{-- Elimina un empleado después de confirmar --}}
    async function eliminarEmpleado(id) {
        {{-- confirm() = muestra diálogo de confirmación nativo del navegador --}}
        if (!confirm('¿Estás seguro de eliminar este empleado?')) return;

        try {
            {{-- DELETE = método HTTP para eliminar recursos --}}
            const response = await fetch(`/api/empleados/${id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            });
            if (response.ok) cargarEmpleados();
        } catch (error) {
            console.error('Error eliminando empleado:', error);
        }
    }

    {{-- Ejecuta cargarEmpleados() cuando la página termina de cargar --}}
    cargarEmpleados();
</script>
@endsection
