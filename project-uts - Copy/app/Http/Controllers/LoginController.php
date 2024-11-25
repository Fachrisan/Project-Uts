<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('content.user.index');
    }

    public function login_proses(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('tampil');
        }

        return redirect()->back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function user()
    {
        $users = Login::all();
        return view('content.user.user', compact('users'));
    }

    public function edit($id_user)
    {
        $user = Login::findOrFail($id_user);
        return response()->json($user);
    }

    public function store(Request $request)
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

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, $id_user)
    {
        $request->validate([
          'nama' => ['required'],
          'email' => ['required'],
            'level' => ['required', 'in:admin,kasir'], // Tambahkan validasi level
        ]);

        $user = Login::findOrFail($id_user);
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->level = $request->level;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
    }



    public function destroy($id_user)
    {
        $user = Login::findOrFail($id_user);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
}
