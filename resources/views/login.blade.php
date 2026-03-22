<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pan Panadero - Bienvenido</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-yellow-50 to-orange-50 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="w-24 h-24 bg-yellow-400 rounded-full flex items-center justify-center text-4xl">
                    👨‍🍳
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Pan Panadero</h1>
            <p class="text-gray-600">Bienvenido a nuestra panadería</p>
        </div>

        <!-- Two Options -->
        <div class="space-y-4">
            <!-- Customer Option -->
            <a href="/terminal" class="block w-full">
                <div class="bg-green-50 hover:bg-green-100 border-2 border-green-300 rounded-xl p-6 transition duration-200 cursor-pointer text-center">
                    <div class="text-4xl mb-2">🛒</div>
                    <h2 class="text-xl font-bold text-green-800 mb-1">Soy Cliente</h2>
                    <p class="text-green-600 text-sm">Comprar pan - Sin registro</p>
                </div>
            </a>

            <!-- Divider -->
            <div class="flex items-center my-4">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-4 text-gray-500 text-sm">o</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>

            <!-- Staff Option -->
            <button onclick="mostrarLoginPersonal()" class="w-full">
                <div class="bg-blue-50 hover:bg-blue-100 border-2 border-blue-300 rounded-xl p-6 transition duration-200 cursor-pointer text-center">
                    <div class="text-4xl mb-2">👔</div>
                    <h2 class="text-xl font-bold text-blue-800 mb-1">Soy Personal</h2>
                    <p class="text-blue-600 text-sm">Administrar - Cajeras y Jefe</p>
                </div>
            </button>
        </div>

        <!-- Staff Login Form (hidden by default) -->
        <div id="login-personal" class="hidden mt-6 pt-6 border-t-2 border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-4 text-center">Acceso Personal</h3>
            
            <form action="/login" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Usuario
                    </label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Ingrese su usuario"
                    >
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Contraseña
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Ingrese su contraseña"
                    >
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button 
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200"
                >
                    Iniciar Sesión
                </button>
                
                <button type="button" onclick="ocultarLoginPersonal()" class="w-full text-gray-500 hover:text-gray-700 text-sm py-2">
                    ← Volver
                </button>
            </form>
        </div>
    </div>

    <script>
        function mostrarLoginPersonal() {
            document.getElementById('login-personal').classList.remove('hidden');
        }
        
        function ocultarLoginPersonal() {
            document.getElementById('login-personal').classList.add('hidden');
        }
    </script>
</body>
</html>
