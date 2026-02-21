<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- @yield('titulo', 'Mi Panadería') = Inserta el título que viene de cada página, si no hay usa el default -->
    <title>@yield('titulo', 'Mi Panadería')</title>
    <!-- Cargar Tailwind CSS desde CDN para estilos -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Arial = fuente básica del sistema */
        body { font-family: Arial, sans-serif; }
    </style>
</head>
<!-- bg-gray-100 = fondo gris claro. min-h-screen = mínimo altura de pantalla completa -->
<body class="bg-gray-100 min-h-screen">
    <!-- ========== HEADER (encabezado) ========== -->
    <!-- bg-yellow-300 = fondo amarillo. p-3 = padding de 3 unidades (12px) -->
    <header class="bg-yellow-300 p-3">
        <!-- container mx-auto = contenedor centrado con ancho máximo -->
        <div class="container mx-auto">
            <!-- text-xl = tamaño de letra extra large. font-bold = negrita -->
            <a href="/" class="text-xl font-bold text-black">Pan de Mamá</a>
            <!-- ml-4 = margin-left de 4 unidades (16px) -->
            <span class="ml-4">
                <!-- px-2 = padding horizontal 2 unidades. py-1 = padding vertical 1 unidad. bg-white = fondo blanco. border = borde sólido -->
                <a href="/" class="px-2 py-1 bg-white border">Inicio</a>
                <a href="/terminal" class="px-2 py-1 bg-white border">Vender</a>
                <a href="/admin" class="px-2 py-1 bg-white border">Admin</a>
            </span>
        </div>
    </header>

    <!-- ========== MAIN CONTENT ========== -->
    <!-- p-4 = padding de 4 unidades (16px) en todos los lados -->
    <main class="container mx-auto p-4">
        <!-- @yield('contenido') = Aquí se inserta el contenido de cada página -->
        @yield('contenido')
    </main>

    <!-- ========== FOOTER (pie de página) ========== -->
    <!-- bg-yellow-200 = fondo amarillo claro. p-2 = padding 2 unidades (8px) -->
    <footer class="bg-yellow-200 p-2 mt-auto">
        <div class="container mx-auto text-center text-sm">
            Pan de Mamá - 2024
        </div>
    </footer>

    <!-- @yield('scripts') = Aquí se insertan los scripts JS de cada página -->
    @yield('scripts')
</body>
</html>
