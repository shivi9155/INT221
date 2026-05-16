<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return $this->showUserLogin();
    }

    public function showUserLogin(): View
    {
        return view('auth.login', [
            'portal' => 'user',
            'portalTitle' => 'User Login',
            'portalSubtitle' => 'Access your grievance dashboard',
            'loginRoute' => route('user.login.store'),
            'sampleEmail' => 'founder@gmail.com',
            'switchLabel' => 'Admin login',
            'switchRoute' => route('admin.login'),
        ]);
    }

    public function showAdminLogin(): View
    {
        return view('auth.login', [
            'portal' => 'admin',
            'portalTitle' => 'Admin Login',
            'portalSubtitle' => 'Access the ResolveX command center',
            'loginRoute' => route('admin.login.store'),
            'sampleEmail' => 'admin@gmail.com',
            'switchLabel' => 'User login',
            'switchRoute' => route('user.login'),
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        return $this->attemptLogin($request, 'user');
    }

    public function userLogin(Request $request): RedirectResponse
    {
        return $this->attemptLogin($request, 'user');
    }

    public function adminLogin(Request $request): RedirectResponse
    {
        return $this->attemptLogin($request, 'admin');
    }

    private function attemptLogin(Request $request, string $portal): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
        }

        if ($request->user()?->is_active === false) {
            Auth::logout();

            return back()->withErrors(['email' => 'Your account is currently inactive. Please contact an administrator.'])->onlyInput('email');
        }

        $user = $request->user();

        if ($portal === 'admin' && ! $user->isAdmin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('admin.login')
                ->withErrors(['email' => 'Please use an admin account for Admin Login.'])
                ->onlyInput('email');
        }

        if ($portal === 'user' && $user->isStaff()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('user.login')
                ->withErrors(['email' => 'Please use a user account for User Login.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended($user->isAdmin() ? route('admin.dashboard') : route('dashboard'));
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
            'user_type' => ['required', 'in:founder,employee'],
            'startup_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'user',
            'user_type' => $data['user_type'],
            'startup_name' => $data['startup_name'] ?? null,
            'phone' => $data['phone'] ?? null,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login');
    }
}
