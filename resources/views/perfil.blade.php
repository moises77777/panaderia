@extends('layouts.app')

@section('titulo', 'Mi Perfil')

@section('contenido')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="text-center mb-6">
            <div class="w-20 h-20 bg-yellow-400 rounded-full mx-auto mb-3 flex items-center justify-center text-4xl">
                @if(auth()->user()->role === 'jefe')
                    👨‍💼
                @else
                    💰
                @endif
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Mi Perfil</h1>
            <p class="text-gray-500 text-sm">
                @if(auth()->user()->role === 'jefe')
                    Jefe
                @else
                    Cajera
                @endif
            </p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/perfil" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Nombre Completo</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-yellow-500" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Usuario (Username)</label>
                <input type="text" name="username" value="{{ auth()->user()->username }}" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-yellow-500" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-yellow-500" required>
            </div>

            <div class="border-t pt-4 mt-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Cambiar Contraseña</h3>
                <p class="text-xs text-gray-500 mb-3">Deja estos campos vacíos si no quieres cambiar tu contraseña</p>
                
                <div class="mb-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Contraseña Actual</label>
                    <input type="password" name="current_password" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-yellow-500">
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nueva Contraseña</label>
                    <input type="password" name="new_password" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-yellow-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Confirmar Nueva Contraseña</label>
                    <input type="password" name="new_password_confirmation" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-yellow-500">
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <a href="{{ auth()->user()->role === 'jefe' ? '/admin' : '/' }}" 
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded text-center">
                    Cancelar
                </a>
                <button type="submit" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
