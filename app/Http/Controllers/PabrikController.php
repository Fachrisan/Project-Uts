<?php

namespace App\Http\Controllers;
use App\Models\Pabrik;
use Illuminate\Http\Request;

class PabrikController extends Controller
{
    public function index()
    {
        $pabrik = Pabrik::all();
        return view('pabrik.index', compact('pabrik'));
    }

    public function create()
    {
        return view('pabrik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pabrik' => 'required|string|max:100',
            'alamat' => 'required',
            'telepon' => 'required|string|max:15',
            'email' => 'required|email|unique:pabrik,email',
        ]);

        Pabrik::create($request->all());
        return redirect()->route('pabrik.index');
    }

    public function show(Pabrik $pabrik)
    {
        return view('pabrik.show', compact('pabrik'));
    }

    public function edit(Pabrik $pabrik)
    {
        return view('pabrik.edit', compact('pabrik'));
    }

    public function update(Request $request, Pabrik $pabrik)
    {
        $request->validate([
            'nama_pabrik' => 'required|string|max:100',
            'alamat' => 'required',
            'telepon' => 'required|string|max:15',
            'email' => 'required|email|unique:pabrik,email,' . $pabrik->id,
        ]);

        $pabrik->update($request->all());
        return redirect()->route('pabrik.index');
    }

    public function destroy(Pabrik $pabrik)
    {
        $pabrik->delete();
        return redirect()->route('pabrik.index');
    }
}
