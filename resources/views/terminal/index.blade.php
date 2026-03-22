@extends('layouts.app')

@section('titulo', 'Comprar Pan')

@section('contenido')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6 mb-6 text-center">
        <h1 class="text-3xl font-bold text-amber-800 mb-2">
            🍞 Bienvenido a Pan Panadero
        </h1>
        <p class="text-gray-600">Ingresa tu nombre para comenzar tu compra</p>
    </div>

    <div id="paso-1" class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-user"></i> ¿Quién compra?
        </h2>
        <div class="flex gap-4">
            <input type="text" id="nombre-cliente" placeholder="Escribe tu nombre..." 
                class="flex-1 px-4 py-3 border-2 border-amber-300 rounded-lg focus:outline-none focus:border-amber-500">
            <button onclick="buscarOCrearCliente()" class="btn-principal text-white px-6 py-3 rounded-lg font-bold">
                <i class="fas fa-arrow-right"></i> Continuar
            </button>
        </div>
        <p class="text-sm text-gray-500 mt-2">Si ya has comprado antes, te reconoceremos</p>
    </div>

    <div id="paso-2" class="hidden">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-bread-slice"></i> Selecciona tus Panes
            </h2>
            
            <div id="lista-productos" class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-shopping-basket"></i> Tu Pedido
            </h2>
            <div id="carrito" class="mb-4 space-y-3">
                <p class="text-gray-500 text-center py-4">Aún no has seleccionado panes</p>
            </div>
            <div class="border-t-2 border-amber-200 pt-4 flex justify-between items-center">
                <span class="text-xl font-bold">Total:</span>
                <span class="text-3xl font-bold text-amber-600">$<span id="total-carrito">0.00</span></span>
            </div>
        </div>

        <!-- Botón de compra -->
        <button onclick="finalizarCompra()" id="btn-comprar" disabled
            class="w-full bg-green-500 hover:bg-green-600 text-white py-4 rounded-lg text-xl font-bold disabled:bg-gray-300 disabled:cursor-not-allowed">
            <i class="fas fa-check-circle"></i> Finalizar Compra
        </button>
    </div>

    <!-- Ticket (inicialmente oculto) -->
    <div id="ticket" class="hidden bg-white rounded-lg shadow p-6">
        <div class="text-center border-b-2 border-dashed border-gray-300 pb-4 mb-4">
            <h2 class="text-2xl font-bold text-amber-800">Panadería Don Pan</h2>
            <p class="text-gray-600">Ticket de Compra</p>
            <p class="text-sm text-gray-500" id="ticket-fecha"></p>
        </div>
        
        <div class="mb-4">
            <p class="font-bold">Cliente: <span id="ticket-cliente" class="font-normal"></span></p>
        </div>
        
        <div id="ticket-items" class="mb-4">
            <!-- Items del ticket -->
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
        
        <div class="flex gap-4 mt-6">
            </button>
            <button onclick="nuevaVenta()" class="flex-1 btn-principal text-white py-2 rounded-lg">
                <i class="fas fa-plus"></i> Nueva Venta
            </button>
        </div>
    </div>
</div>

<script>
let clienteActual = null;
let carrito = [];
let productos = [];

// Cargar productos al iniciar
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
    const container = document.getElementById('lista-productos');
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

async function buscarOCrearCliente() {
    const nombre = document.getElementById('nombre-cliente').value.trim();
    if (!nombre) {
        alert('Por favor escribe tu nombre');
        return;
    }

    try {
        const response = await fetch('/api/clientes');
        const clientes = await response.json();
        clienteActual = clientes.find(c => c.nombre && c.nombre.toLowerCase() === nombre.toLowerCase());

        if (!clienteActual) {
            const crearResponse = await fetch('/api/clientes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ nombre: nombre })
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

        document.getElementById('paso-1').classList.add('hidden');
        document.getElementById('paso-2').classList.remove('hidden');
        cargarProductos();
    } catch (error) {
        console.error('Error:', error);
        alert('Error al registrar cliente');
    }
}

function agregarAlCarrito(idPan) {
    const producto = productos.find(p => p.id_pan === idPan);
    const item = carrito.find(c => c.id_pan === idPan);

    if (item) {
        if (item.cantidad < producto.stock_disponible) {
            item.cantidad++;
        } else {
            alert('No hay más stock disponible');
            return;
        }
    } else {
        carrito.push({
            id_pan: idPan,
            nombre: producto.nombre_pan,
            precio: producto.precio,
            cantidad: 1
        });
    }

    actualizarCarrito();
}

function quitarDelCarrito(idPan) {
    const index = carrito.findIndex(c => c.id_pan === idPan);
    if (index > -1) {
        carrito[index].cantidad--;
        if (carrito[index].cantidad === 0) {
            carrito.splice(index, 1);
        }
    }
    actualizarCarrito();
}

function actualizarCarrito() {
    const container = document.getElementById('carrito');
    
    if (carrito.length === 0) {
        container.innerHTML = '<p class="text-gray-500 text-center py-4">Aún no has seleccionado panes</p>';
        document.getElementById('btn-comprar').disabled = true;
    } else {
        container.innerHTML = carrito.map(item => {
            const producto = productos.find(p => p.id_pan === item.id_pan);
            const stockMax = producto ? producto.stock_disponible : 999;
            const imagen = getProductoImagen(item.nombre);
            
            return `
                <div class="flex items-center gap-3 bg-gray-50 rounded-lg p-3">
                    <div class="w-16 h-16 bg-amber-100 rounded-lg flex items-center justify-center text-3xl flex-shrink-0">
                        ${imagen}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-800 truncate">${item.nombre}</p>
                        <p class="text-amber-600 font-semibold">$${item.precio} c/u</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="cambiarCantidad(${item.id_pan}, -1)" 
                            class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center text-gray-700 font-bold transition"
                            ${item.cantidad <= 1 ? 'disabled' : ''}>
                            -
                        </button>
                        <span class="w-8 text-center font-bold text-gray-800">${item.cantidad}</span>
                        <button onclick="cambiarCantidad(${item.id_pan}, 1)" 
                            class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center text-gray-700 font-bold transition"
                            ${item.cantidad >= stockMax ? 'disabled' : ''}>
                            +
                        </button>
                    </div>
                    <div class="text-right min-w-[60px]">
                        <p class="font-bold text-amber-600">$${(item.precio * item.cantidad).toFixed(2)}</p>
                    </div>
                    <button onclick="eliminarDelCarrito(${item.id_pan})" 
                        class="w-8 h-8 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-full flex items-center justify-center transition ml-1">
                        <span class="text-lg">×</span>
                    </button>
                </div>
            `;
        }).join('');
        document.getElementById('btn-comprar').disabled = false;
    }

    const total = carrito.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
    document.getElementById('total-carrito').textContent = total.toFixed(2);
}

function getProductoImagen(nombre) {
    const imagenes = {
        'baguette': '🥖',
        'baguete': '🥖',
        'croissant': '🥐',
        'cuernito': '🥐',
        'concha': '🍞',
        'mantecada': '🧁',
        'mantecadita': '🧁',
        'canela': '🌀',
        'rol de canela': '🌀',
        'pan blanco': '🍞',
        'pan': '🍞',
        'donut': '🍩',
        'dona': '🍩',
        'galleta': '🍪',
        'cookie': '🍪',
        'pastel': '🎂',
        'cake': '🎂',
        'pie': '🥧',
        'pay': '🥧'
    };
    
    const nombreLower = nombre.toLowerCase();
    for (const [key, emoji] of Object.entries(imagenes)) {
        if (nombreLower.includes(key)) return emoji;
    }
    return '🍞'; // default
}

function cambiarCantidad(idPan, cambio) {
    const item = carrito.find(c => c.id_pan === idPan);
    if (!item) return;
    
    const producto = productos.find(p => p.id_pan === idPan);
    const stockMax = producto ? producto.stock_disponible : 999;
    
    const nuevaCantidad = item.cantidad + cambio;
    
    if (nuevaCantidad < 1) {
        // Si es menos de 1, eliminar del carrito
        eliminarDelCarrito(idPan);
    } else if (nuevaCantidad > stockMax) {
        alert('No hay más stock disponible');
    } else {
        item.cantidad = nuevaCantidad;
        actualizarCarrito();
    }
}

function eliminarDelCarrito(idPan) {
    if (confirm('¿Eliminar este producto del carrito?')) {
        carrito = carrito.filter(c => c.id_pan !== idPan);
        actualizarCarrito();
    }
}

async function finalizarCompra() {
    if (carrito.length === 0) return;

    const total = carrito.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
    
    try {
        const ventaResponse = await fetch('/api/ventas-publico', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id_cliente: clienteActual.id_cliente,
                total_venta: total,
                notas: 'Venta desde terminal publico',
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
        } else {
            const error = await ventaResponse.text();
            console.error('Error response:', error);
            alert('Error al procesar la compra: ' + error);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al procesar la compra');
    }
}

function mostrarTicket(total) {
    document.getElementById('paso-2').classList.add('hidden');
    document.getElementById('ticket').classList.remove('hidden');

    document.getElementById('ticket-cliente').textContent = clienteActual.nombre;
    document.getElementById('ticket-fecha').textContent = new Date().toLocaleString('es-MX');
    document.getElementById('ticket-total').textContent = total.toFixed(2);

    document.getElementById('ticket-items').innerHTML = carrito.map(item => `
        <div class="flex justify-between py-1">
            <span>${item.cantidad}x ${item.nombre}</span>
            <span>$${(item.precio * item.cantidad).toFixed(2)}</span>
        </div>
    `).join('');
}

function nuevaVenta() {
    clienteActual = null;
    carrito = [];
    document.getElementById('nombre-cliente').value = '';
    document.getElementById('ticket').classList.add('hidden');
    document.getElementById('paso-1').classList.remove('hidden');
    actualizarCarrito();
}

cargarProductos();
</script>
@endsection
