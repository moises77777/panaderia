{{-- @extends('layouts.app') = Usa la plantilla base del layout principal --}}
@extends('layouts.app')

{{-- Define el título que aparece en la pestaña del navegador --}}
@section('titulo', 'Terminal de Ventas')

@section('contenido')
{{-- max-w-4xl = ancho máximo de 4xl (896px). mx-auto = centrado horizontal --}}
<div class="max-w-4xl mx-auto">
    {{-- 
        text-3xl = tamaño de texto 3xl (30px)
        font-bold = negrita
        text-amber-800 = color ámbar oscuro
        mb-6 = margin-bottom de 6 unidades (24px)
        text-center = texto centrado
    --}}
    <h1 class="text-3xl font-bold text-amber-800 mb-6 text-center">
        {{-- i.fas.fa-cash-register = ícono de caja registradora (Font Awesome) --}}
        <i class="fas fa-cash-register"></i> Terminal de Ventas
    </h1>

    {{-- ==================== PASO 1: IDENTIFICAR CLIENTE ==================== --}}
    {{-- 
        id="paso-1" = identificador para mostrar/ocultar con JavaScript
        bg-white = fondo blanco
        rounded-lg = bordes redondeados
        shadow = sombra suave
        p-6 = padding de 6 unidades (24px)
        mb-6 = margin-bottom de 24px
    --}}
    <div id="paso-1" class="bg-white rounded-lg shadow p-6 mb-6">
        {{-- text-xl = tamaño de texto extra large (20px) --}}
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-user"></i> ¿Quién compra?
        </h2>
        {{-- flex = flexbox. gap-4 = espacio de 16px entre elementos --}}
        <div class="flex gap-4">
            {{-- 
                type="text" = campo de texto
                id="nombre-cliente" = identificador para obtener el valor con JS
                placeholder = texto de ayuda cuando está vacío
                flex-1 = ocupa todo el espacio disponible
                px-4 = padding horizontal 16px. py-3 = padding vertical 12px
                border-2 = borde de 2px
                focus:border-amber-500 = cambia color al seleccionar
            --}}
            <input type="text" id="nombre-cliente" placeholder="Escribe tu nombre..." 
                class="flex-1 px-4 py-3 border-2 border-amber-300 rounded-lg focus:outline-none focus:border-amber-500">
            {{-- 
                onclick="buscarOCrearCliente()" = llama a la función JS al hacer click
                btn-principal = clase personalizada (color ámbar)
            --}}
            <button onclick="buscarOCrearCliente()" class="btn-principal text-white px-6 py-3 rounded-lg font-bold">
                <i class="fas fa-arrow-right"></i> Continuar
            </button>
        </div>
        <p class="text-sm text-gray-500 mt-2">Si ya has comprado antes, te reconoceremos</p>
    </div>

    {{-- ==================== PASO 2: SELECCIONAR PANES ==================== --}}
    {{-- class="hidden" = inicialmente oculto (se muestra con JS después del paso 1) --}}
    <div id="paso-2" class="hidden">
        {{-- Lista de productos disponibles --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-bread-slice"></i> Selecciona tus Panes
            </h2>
            {{-- 
                id="lista-productos" = se llena dinámicamente con JS
                grid = CSS Grid. grid-cols-2 = 2 columnas en móvil
                md:grid-cols-3 = 3 columnas en pantallas medianas
                gap-4 = espacio de 16px entre productos
            --}}
            <div id="lista-productos" class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                {{-- Aquí se insertan los productos desde JavaScript --}}
            </div>
        </div>

        {{-- ==================== CARRITO DE COMPRAS ==================== --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-shopping-basket"></i> Tu Pedido
            </h2>
            {{-- id="carrito" = se actualiza dinámicamente al agregar/quitar productos --}}
            <div id="carrito" class="mb-4">
                <p class="text-gray-500 text-center py-4">Aún no has seleccionado panes</p>
            </div>
            {{-- 
                border-t-2 = borde superior de 2px
                flex justify-between = elementos a los lados opuestos
                items-center = alineación vertical centrada
            --}}
            <div class="border-t-2 border-amber-200 pt-4 flex justify-between items-center">
                <span class="text-xl font-bold">Total:</span>
                {{-- text-3xl = texto muy grande (30px) --}}
                <span class="text-3xl font-bold text-amber-600">$<span id="total-carrito">0.00</span></span>
            </div>
        </div>

        {{-- ==================== BOTÓN FINALIZAR COMPRA ==================== --}}
        {{-- 
            disabled = inicialmente deshabilitado (hasta que haya productos en el carrito)
            w-full = ancho 100%
            disabled:bg-gray-300 = color gris cuando está deshabilitado
            disabled:cursor-not-allowed = cursor de prohibido cuando está deshabilitado
        --}}
        <button onclick="finalizarCompra()" id="btn-comprar" disabled
            class="w-full bg-green-500 hover:bg-green-600 text-white py-4 rounded-lg text-xl font-bold disabled:bg-gray-300 disabled:cursor-not-allowed">
            <i class="fas fa-check-circle"></i> Finalizar Compra
        </button>
    </div>

    {{-- ==================== PASO 3: TICKET DE COMPRA ==================== --}}
    {{-- hidden = oculto inicialmente, se muestra después de finalizar la compra --}}
    <div id="ticket" class="hidden bg-white rounded-lg shadow p-6">
        {{-- 
            border-b-2 = borde inferior
            border-dashed = línea punteada (estilo ticket)
        --}}
        <div class="text-center border-b-2 border-dashed border-gray-300 pb-4 mb-4">
            <h2 class="text-2xl font-bold text-amber-800">Panadería Don Pan</h2>
            <p class="text-gray-600">Ticket de Compra</p>
            {{-- id="ticket-fecha" = se llena con la fecha actual en JS --}}
            <p class="text-sm text-gray-500" id="ticket-fecha"></p>
        </div>
        
        <div class="mb-4">
            <p class="font-bold">Cliente: <span id="ticket-cliente" class="font-normal"></span></p>
        </div>
        
        {{-- id="ticket-items" = lista de productos comprados --}}
        <div id="ticket-items" class="mb-4">
            {{-- Se llena dinámicamente con JavaScript --}}
        </div>
        
        <div class="border-t-2 border-dashed border-gray-300 pt-4">
            <div class="flex justify-between text-xl font-bold">
                <span>TOTAL:</span>
                <span class="text-amber-600">$<span id="ticket-total"></span></span>
            </div>
        </div>
        
        <div class="text-center mt-6 text-gray-500 text-sm">
            <p>¡Gracias por tu compra!</p>
            <p>Vuelve pronto</p>
        </div>
        
        {{-- Botones de acción del ticket --}}
        <div class="flex gap-4 mt-6">
            {{-- window.print() = abre el diálogo de impresión del navegador --}}
            <button onclick="window.print()" class="flex-1 bg-blue-500 text-white py-2 rounded-lg">
                <i class="fas fa-print"></i> Imprimir
            </button>
            {{-- nuevaVenta() = reinicia el proceso para una nueva venta --}}
            <button onclick="nuevaVenta()" class="flex-1 btn-principal text-white py-2 rounded-lg">
                <i class="fas fa-plus"></i> Nueva Venta
            </button>
        </div>
    </div>
</div>

<script>
{{-- Variables globales para mantener el estado de la venta --}}
let clienteActual = null;  {{-- Guarda el objeto del cliente seleccionado --}}
let carrito = [];          {{-- Array de productos en el carrito --}}
let productos = [];        {{-- Array de todos los productos disponibles --}}

{{-- 
    Función asíncrona que carga los productos desde la API
    Se ejecuta al cargar la página y después de identificar al cliente
--}}
async function cargarProductos() {
    try {
        {{-- fetch('/api/productos') = petición GET a la API --}}
        const response = await fetch('/api/productos');
        {{-- response.json() = convierte la respuesta a objeto JavaScript --}}
        productos = await response.json();
        mostrarProductos();
    } catch (error) {
        console.error('Error cargando productos:', error);
    }
}

{{-- 
    Genera el HTML para mostrar los productos en cuadrícula
    Usa productos.map() para crear un elemento HTML por cada producto
--}}
function mostrarProductos() {
    const container = document.getElementById('lista-productos');
    {{-- 
        productos.map() = recorre cada producto y devuelve HTML
        p.stock_disponible > 0 ? ... : ... = operador ternario (si hay stock muestra botón, sino "Sin stock")
        .join('') = une todos los elementos en un string
    --}}
    container.innerHTML = productos.map(p => `
        <div class="border-2 border-amber-200 rounded-lg p-4 text-center hover:shadow-md transition ${p.stock_disponible > 0 ? 'cursor-pointer' : 'opacity-50'}">
            <i class="fas fa-bread-slice text-4xl text-amber-500 mb-2"></i>
            <h3 class="font-bold text-gray-800">${p.nombre_pan}</h3>
            <p class="text-amber-600 font-bold">$${p.precio}</p>
            <p class="text-xs text-gray-500">Stock: ${p.stock_disponible}</p>
            ${p.stock_disponible > 0 ? `
                <button onclick="agregarAlCarrito(${p.id_pan})" class="mt-2 w-full bg-amber-100 hover:bg-amber-200 text-amber-800 py-1 rounded text-sm">
                    <i class="fas fa-plus"></i> Agregar
                </button>
            ` : '<p class="text-red-500 text-xs mt-2">Sin stock</p>'}
        </div>
    `).join('');
}

{{-- 
    Busca si el cliente ya existe, si no lo crea nuevo
    Luego muestra el paso 2 para seleccionar productos
--}}
async function buscarOCrearCliente() {
    {{-- .trim() = elimina espacios en blanco al inicio y final --}}
    const nombre = document.getElementById('nombre-cliente').value.trim();
    if (!nombre) {
        alert('Por favor escribe tu nombre');
        return;
    }

    try {
        {{-- Obtiene todos los clientes y busca coincidencia por nombre --}}
        const response = await fetch('/api/clientes');
        const clientes = await response.json();
        {{-- .find() = busca el primer cliente que coincida (ignora mayúsculas/minúsculas) --}}
        {{-- c.nombre?.toLowerCase() = operador opcional (?) por si nombre es null/undefined --}}
        clienteActual = clientes.find(c => c.nombre?.toLowerCase() === nombre.toLowerCase());

        {{-- Si no existe, crea nuevo cliente --}}
        if (!clienteActual) {
            const crearResponse = await fetch('/api/clientes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    {{-- csrf_token() = token de seguridad de Laravel (obligatorio para POST) --}}
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ nombre_cliente: nombre })
            });
            
            const responseData = await crearResponse.json();
            
            if (crearResponse.ok) {
                clienteActual = responseData;
            } else {
                console.error('Error del servidor:', responseData);
                alert('Error al crear cliente: ' + (responseData.error || 'Error desconocido'));
                return;
            }
        }

        {{-- Oculta paso 1, muestra paso 2 y carga productos --}}
        {{-- classList.add('hidden') = agrega clase hidden para ocultar --}}
        {{-- classList.remove('hidden') = quita clase hidden para mostrar --}}
        document.getElementById('paso-1').classList.add('hidden');
        document.getElementById('paso-2').classList.remove('hidden');
        cargarProductos();
    } catch (error) {
        console.error('Error:', error);
        alert('Error al registrar cliente');
    }
}

{{-- Agrega un producto al carrito o incrementa cantidad si ya existe --}}
function agregarAlCarrito(idPan) {
    {{-- Busca el producto en el array de productos --}}
    const producto = productos.find(p => p.id_pan === idPan);
    {{-- Busca si ya está en el carrito --}}
    const item = carrito.find(c => c.id_pan === idPan);

    if (item) {
        {{-- Si ya está, verifica stock antes de aumentar --}}
        if (item.cantidad < producto.stock_disponible) {
            item.cantidad++;
        } else {
            alert('No hay más stock disponible');
            return;
        }
    } else {
        {{-- Si no está, lo agrega con cantidad 1 --}}
        carrito.push({
            id_pan: idPan,
            nombre: producto.nombre_pan,
            precio: producto.precio,
            cantidad: 1
        });
    }

    actualizarCarrito();
}

{{-- Disminuye cantidad o elimina producto del carrito --}}
function quitarDelCarrito(idPan) {
    {{-- findIndex = devuelve la posición del elemento en el array (-1 si no existe) --}}
    const index = carrito.findIndex(c => c.id_pan === idPan);
    if (index > -1) {
        carrito[index].cantidad--;
        {{-- Si cantidad llega a 0, elimina el elemento del array --}}
        if (carrito[index].cantidad === 0) {
            {{-- splice = elimina elementos del array (posición, cantidad a eliminar) --}}
            carrito.splice(index, 1);
        }
    }
    actualizarCarrito();
}

{{-- Actualiza la visualización del carrito y el total --}}
function actualizarCarrito() {
    const container = document.getElementById('carrito');
    
    {{-- Si el carrito está vacío --}}
    if (carrito.length === 0) {
        container.innerHTML = '<p class="text-gray-500 text-center py-4">Aún no has seleccionado panes</p>';
        {{-- Deshabilita botón de comprar --}}
        document.getElementById('btn-comprar').disabled = true;
    } else {
        {{-- Muestra cada item del carrito con nombre, cantidad, precio y botón quitar --}}
        container.innerHTML = carrito.map(item => `
            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <div>
                    <span class="font-bold">${item.nombre}</span>
                    <span class="text-gray-500">x${item.cantidad}</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-amber-600 font-bold">$${(item.precio * item.cantidad).toFixed(2)}</span>
                    <button onclick="quitarDelCarrito(${item.id_pan})" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-minus-circle"></i>
                    </button>
                </div>
            </div>
        `).join('');
        {{-- Habilita botón de comprar --}}
        document.getElementById('btn-comprar').disabled = false;
    }

    {{-- Calcula total usando reduce (suma precio * cantidad de cada item) --}}
    {{-- 0 = valor inicial del acumulador (sum) --}}
    const total = carrito.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
    {{-- toFixed(2) = formatea a 2 decimales --}}
    document.getElementById('total-carrito').textContent = total.toFixed(2);
}

{{-- Envía la venta al servidor y muestra el ticket --}}
async function finalizarCompra() {
    if (carrito.length === 0) return;

    {{-- Calcula el total de la venta --}}
    const total = carrito.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
    
    try {
        {{-- Crea la venta en la base de datos --}}
        const ventaResponse = await fetch('/api/ventas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id_cliente: clienteActual.id_cliente,
                id_empleado: 1, {{-- Empleado por defecto (cajero) --}}
                total_venta: total,
                notas: 'Venta desde terminal',
                {{-- Mapea el carrito a detalles de venta --}}
                detalles: carrito.map(item => ({
                    id_pan: item.id_pan,
                    cantidad: item.cantidad,
                    precio_unitario: item.precio,
                    subtotal: item.precio * item.cantidad
                }))
            })
        });

        if (ventaResponse.ok) {
            mostrarTicket(total);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al procesar la compra');
    }
}

{{-- Muestra el ticket final con todos los datos de la compra --}}
function mostrarTicket(total) {
    {{-- Oculta paso 2, muestra ticket --}}
    document.getElementById('paso-2').classList.add('hidden');
    document.getElementById('ticket').classList.remove('hidden');

    {{-- Llena los datos del ticket --}}
    document.getElementById('ticket-cliente').textContent = clienteActual.nombre;
    {{-- new Date().toLocaleString('es-MX') = fecha/hora actual en formato mexicano --}}
    document.getElementById('ticket-fecha').textContent = new Date().toLocaleString('es-MX');
    document.getElementById('ticket-total').textContent = total.toFixed(2);

    {{-- Genera el HTML de los items del ticket --}}
    document.getElementById('ticket-items').innerHTML = carrito.map(item => `
        <div class="flex justify-between py-1">
            <span>${item.cantidad}x ${item.nombre}</span>
            <span>$${(item.precio * item.cantidad).toFixed(2)}</span>
        </div>
    `).join('');
}

{{-- Reinicia todo para una nueva venta --}}
function nuevaVenta() {
    clienteActual = null;
    carrito = [];
    document.getElementById('nombre-cliente').value = '';
    document.getElementById('ticket').classList.add('hidden');
    document.getElementById('paso-1').classList.remove('hidden');
    actualizarCarrito();
}

{{-- Ejecuta cargarProductos cuando carga la página --}}
cargarProductos();
</script>
@endsection
