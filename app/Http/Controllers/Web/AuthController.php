<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $defaultCategories = [
            ['name' => 'Makanan', 'type' => 'expense', 'description' => 'Pembelian makanan dan minuman sehari-hari.'],
            ['name' => 'Transportasi', 'type' => 'expense', 'description' => 'Biaya transportasi seperti bensin, angkutan umum, dan tol.'],
            ['name' => 'Belanja', 'type' => 'expense', 'description' => 'Pembelian barang kebutuhan rumah tangga dan pribadi.'],
            ['name' => 'Gaji', 'type' => 'income', 'description' => 'Pendapatan gaji pokok dan tunjangan.'],
            ['name' => 'Investasi', 'type' => 'income', 'description' => 'Pendapatan dari hasil investasi dan passive income.'],
        ];

        foreach ($defaultCategories as $cat) {
            $user->categories()->create($cat);
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}
