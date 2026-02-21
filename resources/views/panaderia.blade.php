<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Panadería</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-8">🍞 Sistema de Panadería</h1>
        
        <!-- Tabs de Navegación -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex space-x-4 border-b">
                <button onclick="mostrarTab('clientes')" class="px-4 py-2 font-semibold text-blue-600 border-b-2 border-blue-600">Clientes</button>
                <button onclick="mostrarTab('empleados')" class="px-4 py-2 font-semibold text-gray-600 hover:text-blue-600">Empleados</button>
                <button onclick="mostrarTab('productos')" class="px-4 py-2 font-semibold text-gray-600 hover:text-blue-600">Productos</button>
                <button onclick="mostrarTab('materias-primas')" class="px-4 py-2 font-semibold text-gray-600 hover:text-blue-600">Materias Primas</button>
                <button onclick="mostrarTab('compras')" class="px-4 py-2 font-semibold text-gray-600 hover:text-blue-600">Compras</button>
                <button onclick="mostrarTab('ventas')" class="px-4 py-2 font-semibold text-gray-600 hover:text-blue-600">Ventas</button>
            </div>
        </div>

        <!-- Contenido Dinámico -->
        <div id="contenido" class="bg-white rounded-lg shadow-md p-6">
            <!-- Clientes Tab -->
            <div id="clientes-tab" class="tab-content">
                <h2 class="text-2xl font-bold mb-4">👥 Clientes</h2>
                
                <!-- Formulario Nuevo Cliente -->
                <div class="mb-6 p-4 bg-blue-50 rounded">
                    <h3 class="text-lg font-semibold mb-3">➕ Nuevo Cliente</h3>
                    <form onsubmit="guardarCliente(event)">
                        <div class="grid grid-cols-1 gap-4">
                            <input type="text" id="cliente-nombre" placeholder="Nombre del Cliente" required
                                class="px-4 py-2 border rounded w-full">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                Guardar Cliente
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Lista de Clientes -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="clientes-lista">
                    <!-- Se llenará con JavaScript -->
                </div>
            </div>

            <!-- Empleados Tab -->
            <div id="empleados-tab" class="tab-content hidden">
                <h2 class="text-2xl font-bold mb-4">👨‍🍳 Empleados</h2>
                
                <div class="mb-6 p-4 bg-green-50 rounded">
                    <h3 class="text-lg font-semibold mb-3">➕ Nuevo Empleado</h3>
                    <form onsubmit="guardarEmpleado(event)">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="text" id="empleado-nombre" placeholder="Nombre" required
                                class="px-4 py-2 border rounded w-full">
                            <input type="text" id="empleado-rol" placeholder="Rol" required
                                class="px-4 py-2 border rounded w-full">
                            <input type="date" id="empleado-fecha" required
                                class="px-4 py-2 border rounded w-full">
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                                Guardar Empleado
                            </button>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="empleados-lista">
                    <!-- Se llenará con JavaScript -->
                </div>
            </div>

            <!-- Productos Tab -->
            <div id="productos-tab" class="tab-content hidden">
                <h2 class="text-2xl font-bold mb-4">🍞 Productos</h2>
                
                <div class="mb-6 p-4 bg-yellow-50 rounded">
                    <h3 class="text-lg font-semibold mb-3">➕ Nuevo Producto</h3>
                    <form onsubmit="guardarProducto(event)">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="text" id="producto-nombre" placeholder="Nombre del Pan" required
                                class="px-4 py-2 border rounded w-full">
                            <input type="number" id="producto-precio" step="0.01" placeholder="Precio" required
                                class="px-4 py-2 border rounded w-full">
                            <input type="number" id="producto-stock" placeholder="Stock" required
                                class="px-4 py-2 border rounded w-full">
                            <button type="submit" class="bg-yellow-600 text-white px-6 py-2 rounded hover:bg-yellow-700">
                                Guardar Producto
                            </button>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="productos-lista">
                    <!-- Se llenará con JavaScript -->
                </div>
            </div>

            <!-- Materias Primas Tab -->
            <div id="materias-tab" class="tab-content hidden">
                <h2 class="text-2xl font-bold mb-4">🌾 Materias Primas</h2>
                
                <div class="mb-6 p-4 bg-purple-50 rounded">
                    <h3 class="text-lg font-semibold mb-3">➕ Nueva Materia Prima</h3>
                    <form onsubmit="guardarMateria(event)">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="text" id="materia-nombre" placeholder="Nombre" required
                                class="px-4 py-2 border rounded w-full">
                            <input type="number" id="materia-unidad" placeholder="Unidad Fija" required
                                class="px-4 py-2 border rounded w-full">
                            <input type="number" id="materia-stock" placeholder="Stock Actual" required
                                class="px-4 py-2 border rounded w-full">
                            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700">
                                Guardar Materia
                            </button>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="materias-lista">
                    <!-- Se llenará con JavaScript -->
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h2 class="text-2xl font-bold mb-4">📊 Estadísticas</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="estadisticas">
                <!-- Se llenará con JavaScript -->
            </div>
        </div>
    </div>

    <script>
        let datos = {
            clientes: [],
            empleados: [],
            productos: [],
            materias: []
        };

        // Funciones de navegación
        function mostrarTab(tab) {
            // Ocultar todos los tabs
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(t => {
                if (t) t.classList.add('hidden');
            });
            
            // Mostrar tab seleccionado
            const tabSeleccionado = document.getElementById(tab + '-tab');
            if (tabSeleccionado) {
                tabSeleccionado.classList.remove('hidden');
            }
            
            // Actualizar botones
            const botones = document.querySelectorAll('.border-b-2');
            botones.forEach(b => {
                b.classList.remove('border-b-2', 'border-blue-600', 'text-blue-600');
            });
            if (event.target) {
                event.target.classList.add('border-b-2', 'border-blue-600', 'text-blue-600');
            }
            
            // Cargar datos
            if (tab === 'materias-primas') {
                cargarDatos('materias-primas');
            } else {
                cargarDatos(tab);
            }
        }

        // Cargar datos desde la API
        async function cargarDatos(tipo) {
            try {
                const response = await fetch(`/api/${tipo}`);
                const data = await response.json();
                datos[tipo] = data;
                mostrarDatos(tipo);
            } catch (error) {
                console.error('Error cargando datos:', error);
            }
        }

        // Mostrar datos en cards
        function mostrarDatos(tipo) {
            const contenedor = document.getElementById(`${tipo}-lista`);
            if (!contenedor) {
                console.error(`Contenedor ${tipo}-lista no encontrado`);
                return;
            }
            contenedor.innerHTML = '';
            
            datos[tipo].forEach(item => {
                const card = crearCard(tipo, item);
                contenedor.appendChild(card);
            });
        }

        // Crear cards dinámicamente
        function crearCard(tipo, item) {
            const div = document.createElement('div');
            div.className = 'bg-white p-4 rounded-lg shadow border border-gray-200';
            
            let contenido = '';
            switch(tipo) {
                case 'clientes':
                    contenido = `
                        <h3 class="font-bold text-lg mb-2">👤 ${item.nombre}</h3>
                        <p class="text-gray-600">ID: ${item.id_cliente}</p>
                        <p class="text-sm text-gray-500">Ventas: ${item.ventas ? item.ventas.length : 0}</p>
                    `;
                    break;
                case 'empleados':
                    contenido = `
                        <h3 class="font-bold text-lg mb-2">👨‍🍳 ${item.nombre_empleado}</h3>
                        <p class="text-gray-600">Rol: ${item.rol}</p>
                        <p class="text-sm text-gray-500">Ingreso: ${item.fecha_ingreso}</p>
                    `;
                    break;
                case 'productos':
                    contenido = `
                        <h3 class="font-bold text-lg mb-2">🍞 ${item.nombre_pan}</h3>
                        <p class="text-gray-600">Precio: $${item.precio}</p>
                        <p class="text-sm text-gray-500">Stock: ${item.stock_disponible}</p>
                    `;
                    break;
                case 'materias':
                    contenido = `
                        <h3 class="font-bold text-lg mb-2">🌾 ${item.nombre_materia}</h3>
                        <p class="text-gray-600">Unidad: ${item.unidad_fija}</p>
                        <p class="text-sm text-gray-500">Stock: ${item.stock_actual}</p>
                    `;
                    break;
            }
            
            div.innerHTML = contenido;
            return div;
        }

        // Funciones CRUD
        async function guardarCliente(event) {
            event.preventDefault();
            const nombre = document.getElementById('cliente-nombre').value;
            
            try {
                const response = await fetch('/api/clientes', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({nombre})
                });
                
                if (response.ok) {
                    document.getElementById('cliente-nombre').value = '';
                    cargarDatos('clientes');
                }
            } catch (error) {
                console.error('Error guardando cliente:', error);
            }
        }

        async function guardarEmpleado(event) {
            event.preventDefault();
            const datos = {
                nombre_empleado: document.getElementById('empleado-nombre').value,
                rol: document.getElementById('empleado-rol').value,
                fecha_ingreso: document.getElementById('empleado-fecha').value
            };
            
            try {
                const response = await fetch('/api/empleados', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(datos)
                });
                
                if (response.ok) {
                    document.getElementById('empleado-nombre').value = '';
                    document.getElementById('empleado-rol').value = '';
                    document.getElementById('empleado-fecha').value = '';
                    cargarDatos('empleados');
                }
            } catch (error) {
                console.error('Error guardando empleado:', error);
            }
        }

        async function guardarProducto(event) {
            event.preventDefault();
            const datos = {
                nombre_pan: document.getElementById('producto-nombre').value,
                precio: parseFloat(document.getElementById('producto-precio').value),
                stock_disponible: parseInt(document.getElementById('producto-stock').value)
            };
            
            try {
                const response = await fetch('/api/productos', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(datos)
                });
                
                if (response.ok) {
                    document.getElementById('producto-nombre').value = '';
                    document.getElementById('producto-precio').value = '';
                    document.getElementById('producto-stock').value = '';
                    cargarDatos('productos');
                }
            } catch (error) {
                console.error('Error guardando producto:', error);
            }
        }

        async function guardarMateria(event) {
            event.preventDefault();
            const datos = {
                nombre_materia: document.getElementById('materia-nombre').value,
                unidad_fija: parseInt(document.getElementById('materia-unidad').value),
                stock_actual: parseInt(document.getElementById('materia-stock').value),
                fecha_ingreso: new Date().toISOString().split('T')[0]
            };
            
            try {
                const response = await fetch('/api/materias-primas', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(datos)
                });
                
                if (response.ok) {
                    document.getElementById('materia-nombre').value = '';
                    document.getElementById('materia-unidad').value = '';
                    document.getElementById('materia-stock').value = '';
                    cargarDatos('materias');
                }
            } catch (error) {
                console.error('Error guardando materia:', error);
            }
        }

        // Cargar estadísticas
        async function cargarEstadisticas() {
            try {
                const response = await fetch('/api/estadisticas');
                const stats = await response.json();
                
                const contenedor = document.getElementById('estadisticas');
                contenedor.innerHTML = `
                    <div class="bg-blue-100 p-4 rounded">
                        <h4 class="font-bold">👥 Clientes</h4>
                        <p class="text-2xl">${stats.total_clientes}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded">
                        <h4 class="font-bold">👨‍🍳 Empleados</h4>
                        <p class="text-2xl">${stats.total_empleados}</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded">
                        <h4 class="font-bold">🍞 Productos</h4>
                        <p class="text-2xl">${stats.total_productos}</p>
                    </div>
                    <div class="bg-purple-100 p-4 rounded">
                        <h4 class="font-bold">🌾 Materias Primas</h4>
                        <p class="text-2xl">${stats.total_materias_primas}</p>
                    </div>
                `;
            } catch (error) {
                console.error('Error cargando estadísticas:', error);
            }
        }

        // Cargar datos iniciales
        window.onload = function() {
            cargarDatos('clientes');
            cargarEstadisticas();
        };

        // Estilos para tabs
        const style = document.createElement('style');
        style.textContent = `
            .tab-content { display: block; }
            .tab-content.hidden { display: none; }
            .border-b-2 { border-bottom-width: 2px; }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
