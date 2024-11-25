<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\Request;

class RegisterBasic extends Controller
{
  public function index(): View
  {
    return view('content.user.auth-register-basic');
  }

  public function reg(Request $request): RedirectResponse
  {
    $request->validate([
      'nama' => ['required'],
      'email' => ['required'],
      'password' => ['required'],
      'level' => ['required', 'in:admin,kasir'], // Tambahkan validasi level
    ]);

    $user = Login::create([
      'nama' => $request->nama,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'level' => $request->level ?? 'kasir', // Default level kasir
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect('/tampil'); // Return ke route /tampil untuk semua level user
  }
}
