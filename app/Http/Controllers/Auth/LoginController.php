<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }


    protected function authenticated(Request $request, $user)
    {
        return redirect($this->redirectTo($user));
    }

    protected function redirectTo($user)
    {
        switch ($user->level) {
            case 'SUPERADMIN':
                return route('superadmin.dashboard'); // Sesuaikan dengan route yang ada

            case 'TUSEKOLAH':
                return route('tusekolah.dashboard'); // Sesuaikan dengan route yang ada

            case 'TUKEUANGAN':
                return route('tukeuangan.dashboard'); // Sesuaikan dengan route yang ada

            case 'ORANGTUA':
                return route('orangtua.dashboard'); // Sesuaikan dengan route yang ada

            case 'GURU':
                return route('guru.dashboard'); // Sesuaikan dengan route yang ada

            case 'KEUANGANPUSAT':
                return route('keuanganpusat.dashboard'); // Sesuaikan dengan route yang ada

            default:
                return route('welcome'); // Redirect default jika level tidak sesuai
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
