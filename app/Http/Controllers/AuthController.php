<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate with username
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirect based on role
            if ($user->role === 'jefe') {
                return redirect()->intended('/admin');
            } elseif ($user->role === 'cajera') {
                return redirect()->intended('/terminal');
            }
            
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('username');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        // Validar datos básicos
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        // Actualizar datos básicos
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        // Si quiere cambiar la contraseña
        if ($request->filled('new_password')) {
            // Verificar contraseña actual
            if (!\Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'La contraseña actual es incorrecta.',
                ]);
            }

            $user->password = \Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
