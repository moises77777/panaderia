<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Mi Panadería')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: Arial, sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="bg-yellow-300 p-3">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-bold text-black">Panaderia</a>
            
            @auth
                <div class="flex items-center space-x-4">
                    <span class="text-sm">
                        @if(auth()->user()->role === 'jefe')
                            👨‍💼 Jefe
                        @else
                            💰 Cajera
                        @endif
                        : {{ auth()->user()->name }}
                    </span>
                    <nav>
                        <a href="/" class="px-2 py-1 bg-white border hover:bg-gray-100">Inicio</a>
                        
                        @if(auth()->user()->role === 'cajera' || auth()->user()->role === 'jefe')
                            <a href="/terminal" class="px-2 py-1 bg-white border hover:bg-gray-100">Vender</a>
                        @endif
                        
                        @if(auth()->user()->role === 'jefe')
                            <a href="/admin" class="px-2 py-1 bg-white border hover:bg-gray-100">Admin</a>
                        @endif

                        <a href="/perfil" class="px-2 py-1 bg-white border hover:bg-gray-100">👤 Perfil</a>
                    </nav>
                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-2 py-1 bg-red-500 text-white border hover:bg-red-600">
                            Salir
                        </button>
                    </form>
                </div>
            @else
                <nav>
                    <a href="/login" class="px-2 py-1 bg-white border hover:bg-gray-100">Login</a>
                </nav>
            @endauth
        </div>
    </header>

    <main class="container mx-auto p-4">
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        @yield('contenido')
    </main>

    <footer class="bg-yellow-200 p-2 mt-auto">
        <div class="container mx-auto text-center text-sm">
            Panaderia - 2026
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
