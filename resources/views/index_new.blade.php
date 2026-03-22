@extends('layouts.app')

@section('titulo', 'Panadería Valencia - El Sabor Auténtico')

@section('contenido')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-amber-50 to-orange-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-amber-900 mb-6">
                🥖 Panadería Valencia
            </h1>
            <p class="text-xl md:text-2xl text-gray-700 mb-8 max-w-3xl mx-auto">
                Tradición y sabor en cada pan desde 1985. El auténtico sabor casero que te recuerda a casa.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#productos" class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-lg font-semibold transition">
                    Ver Nuestros Panes
                </a>
                <a href="#contacto" class="bg-orange-600 hover:bg-orange-700 text-white px-8 py-3 rounded-lg font-semibold transition">
                    Contáctanos
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Conócenos Section -->
<section id="conocenos" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-amber-900 mb-4">Conócenos</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Más de 35 años dedicados al arte de la panadería, llevando tradición y calidad a cada hogar.
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <img src="https://images.unsplash.com/photo-1586444248902-2f64eddc13df?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="Panadería tradicional" 
                     class="rounded-lg shadow-lg">
            </div>
            <div>
                <h3 class="text-2xl font-bold text-amber-800 mb-4">Nuestra Historia</h3>
                <p class="text-gray-700 mb-4">
                    Fundada en 1985 por la familia Valencia, nuestra panadería nació del sueño de compartir 
                    el pan casero que abuela Isabel preparaba cada mañana.
                </p>
                <p class="text-gray-700 mb-4">
                    Hoy, tres generaciones después, seguimos usando las mismas recetas tradicionales, 
                    ingredientes de primera calidad y el amor artesanal que nos caracteriza.
                </p>
                <div class="grid grid-cols-3 gap-4 mt-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-amber-600">35+</div>
                        <div class="text-sm text-gray-600">Años de Tradición</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-amber-600">50+</div>
                        <div class="text-sm text-gray-600">Variedades de Pan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-amber-600">1000+</div>
                        <div class="text-sm text-gray-600">Clientes Felices</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Servicios Section -->
<section id="servicios" class="py-16 bg-amber-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-amber-900 mb-4">Nuestros Servicios</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Ofrecemos productos frescos diariamente y servicios personalizados para satisfacer tus necesidades.
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-4">🥖</div>
                <h3 class="text-xl font-bold text-amber-800 mb-2">Pan Fresco Diario</h3>
                <p class="text-gray-600">
                    Horneamos nuestros panes cada madrugada para garantizar máxima frescura y sabor.
                </p>
            </div>
            
            <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-4">🎂</div>
                <h3 class="text-xl font-bold text-amber-800 mb-2">Pasteles Personalizados</h3>
                <p class="text-gray-600">
                    Tortas y pasteles para tus celebraciones, hechos con ingredientes de calidad.
                </p>
            </div>
            
            <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-4">🚚</div>
                <h3 class="text-xl font-bold text-amber-800 mb-2">Delivery a Domicilio</h3>
                <p class="text-gray-600">
                    Llevamos el calor de nuestro pan directamente a tu hogar o negocio.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Productos Destacados Section -->
<section id="productos" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-amber-900 mb-4">Nuestros Productos Estrella</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Descubre nuestras especialidades, preparadas con la misma receta de siempre.
            </p>
        </div>
        
        <div class="grid md:grid-cols-4 gap-6">
            <div class="bg-amber-50 p-6 rounded-lg text-center hover:shadow-lg transition">
                <div class="text-5xl mb-4">🥖</div>
                <h3 class="font-bold text-amber-800 mb-2">Baguette Francesa</h3>
                <p class="text-amber-600 font-semibold mb-2">$25.50</p>
                <p class="text-sm text-gray-600">Crujiente por fuera, tierna por dentro</p>
            </div>
            
            <div class="bg-amber-50 p-6 rounded-lg text-center hover:shadow-lg transition">
                <div class="text-5xl mb-4">🥐</div>
                <h3 class="font-bold text-amber-800 mb-2">Croissant</h3>
                <p class="text-amber-600 font-semibold mb-2">$15.00</p>
                <p class="text-sm text-gray-600">Mantequilla pura, hojaldre perfecto</p>
            </div>
            
            <div class="bg-amber-50 p-6 rounded-lg text-center hover:shadow-lg transition">
                <div class="text-5xl mb-4">🍞</div>
                <h3 class="font-bold text-amber-800 mb-2">Pan Campesino</h3>
                <p class="text-amber-600 font-semibold mb-2">$18.00</p>
                <p class="text-sm text-gray-600">Masa madre, corteza crujiente</p>
            </div>
            
            <div class="bg-amber-50 p-6 rounded-lg text-center hover:shadow-lg transition">
                <div class="text-5xl mb-4">🥨</div>
                <h3 class="font-bold text-amber-800 mb-2">Pretzel</h3>
                <p class="text-amber-600 font-semibold mb-2">$12.00</p>
                <p class="text-sm text-gray-600">Tradicional alemán, sal marina</p>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="/terminal" class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-lg font-semibold transition">
                Ver Todos Nuestros Productos
            </a>
        </div>
    </div>
</section>

<!-- Contacto y Ubicación Section -->
<section id="contacto" class="py-16 bg-amber-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-amber-900 mb-4">Contacto y Ubicación</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                ¡Visítanos! Estamos aquí para atenderte con el mejor pan y servicio.
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-12">
            <!-- Información de Contacto -->
            <div>
                <h3 class="text-2xl font-bold text-amber-800 mb-6">Información de Contacto</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="text-2xl mr-4">📍</div>
                        <div>
                            <h4 class="font-semibold text-amber-700">Dirección</h4>
                            <p class="text-gray-600">Calle Principal #123, Colonia Centro</p>
                            <p class="text-gray-600">Ciudad de México, C.P. 06000</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="text-2xl mr-4">📞</div>
                        <div>
                            <h4 class="font-semibold text-amber-700">Teléfono</h4>
                            <p class="text-gray-600">(55) 1234-5678</p>
                            <p class="text-gray-600">(55) 8765-4321</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="text-2xl mr-4">📧</div>
                        <div>
                            <h4 class="font-semibold text-amber-700">Email</h4>
                            <p class="text-gray-600">info@panaderiavalencia.com</p>
                            <p class="text-gray-600">pedidos@panaderiavalencia.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="text-2xl mr-4">🕐</div>
                        <div>
                            <h4 class="font-semibold text-amber-700">Horario</h4>
                            <p class="text-gray-600">Lunes a Sábado: 6:00 AM - 8:00 PM</p>
                            <p class="text-gray-600">Domingo: 7:00 AM - 2:00 PM</p>
                        </div>
                    </div>
                </div>
                
                <!-- Redes Sociales -->
                <div class="mt-8">
                    <h4 class="font-semibold text-amber-700 mb-4">Síguenos en Redes Sociales</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-amber-600 hover:bg-amber-700 text-white w-10 h-10 rounded-full flex items-center justify-center transition">
                            <span>f</span>
                        </a>
                        <a href="#" class="bg-amber-600 hover:bg-amber-700 text-white w-10 h-10 rounded-full flex items-center justify-center transition">
                            <span>📷</span>
                        </a>
                        <a href="#" class="bg-amber-600 hover:bg-amber-700 text-white w-10 h-10 rounded-full flex items-center justify-center transition">
                            <span>🐦</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Mapa -->
            <div>
                <h3 class="text-2xl font-bold text-amber-800 mb-6">Ubicación</h3>
                <div class="bg-gray-200 h-64 rounded-lg flex items-center justify-center">
                    <div class="text-center text-gray-600">
                        <div class="text-6xl mb-4">🗺️</div>
                        <p>Mapa interactivo aquí</p>
                        <p class="text-sm">Calle Principal #123, Colonia Centro</p>
                    </div>
                </div>
                
                <!-- Formulario de Contacto -->
                <div class="mt-8">
                    <h4 class="font-semibold text-amber-700 mb-4">Envíanos un Mensaje</h4>
                    <form class="space-y-4">
                        <div>
                            <input type="text" placeholder="Tu nombre" 
                                   class="w-full px-4 py-2 border border-amber-300 rounded-lg focus:outline-none focus:border-amber-500">
                        </div>
                        <div>
                            <input type="email" placeholder="Tu email" 
                                   class="w-full px-4 py-2 border border-amber-300 rounded-lg focus:outline-none focus:border-amber-500">
                        </div>
                        <div>
                            <textarea placeholder="Tu mensaje" rows="4"
                                      class="w-full px-4 py-2 border border-amber-300 rounded-lg focus:outline-none focus:border-amber-500"></textarea>
                        </div>
                        <button type="submit" 
                                class="w-full bg-amber-600 hover:bg-amber-700 text-white py-3 rounded-lg font-semibold transition">
                            Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Acceso Staff (solo visible para usuarios autenticados) -->
@if(auth()->check())
<section class="py-16 bg-gray-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Acceso Staff</h2>
            <p class="text-lg text-gray-600">
                Bienvenido {{ auth()->user()->name }} - Acceso rápido al sistema
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-6">
            @if(auth()->user()->role === 'cajera' || auth()->user()->role === 'jefe')
            <a href="/terminal" class="block bg-green-200 hover:bg-green-300 p-6 border-2 border-green-400 rounded-lg transition">
                <h2 class="text-xl font-bold text-green-800">🛒 Punto de Venta</h2>
                <p class="text-green-700">Atiende a tus clientes y procesa ventas</p>
            </a>
            @endif
            
            @if(auth()->user()->role === 'jefe')
            <a href="/admin" class="block bg-blue-200 hover:bg-blue-300 p-6 border-2 border-blue-400 rounded-lg transition">
                <h2 class="text-xl font-bold text-blue-800">⚙️ Administración</h2>
                <p class="text-blue-700">Gestiona productos, clientes y empleados</p>
            </a>
            @endif
        </div>
        
        <!-- Estadísticas rápidas -->
        <div class="mt-8 bg-white border-2 border-gray-300 p-6 rounded-lg">
            <h3 class="text-lg font-bold mb-4 text-gray-800">Resumen del Día</h3>
            <div class="grid grid-cols-3 gap-4 text-center">
                <div class="bg-yellow-100 p-4 rounded">
                    <p class="text-2xl font-bold text-yellow-800" id="total-ventas-hoy">-</p>
                    <p class="text-sm text-yellow-600">Ventas Hoy</p>
                </div>
                <div class="bg-blue-100 p-4 rounded">
                    <p class="text-2xl font-bold text-blue-800" id="total-clientes">-</p>
                    <p class="text-sm text-blue-600">Clientes Totales</p>
                </div>
                <div class="bg-green-100 p-4 rounded">
                    <p class="text-2xl font-bold text-green-800" id="total-productos">-</p>
                    <p class="text-sm text-green-600">Productos</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection

@section('scripts')
<script>
// Smooth scrolling para navegación
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Cargar estadísticas si está autenticado
@if(auth()->check())
async function cargarEstadisticas() {
    try {
        const response = await fetch('/api/estadisticas');
        const data = await response.json();
        
        document.getElementById('total-clientes').textContent = data.total_clientes || 0;
        document.getElementById('total-productos').textContent = data.total_productos || 0;
        document.getElementById('total-ventas-hoy').textContent = data.total_ventas || 0;
    } catch (error) {
        console.error('Error cargando estadísticas:', error);
    }
}

cargarEstadisticas();
@endif
</script>
@endsection
