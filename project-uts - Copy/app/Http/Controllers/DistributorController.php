<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Distributor;

class DistributorController extends Controller
{
    public function index()
    {
        $distributor = Distributor::all();
        return view('distributor.index', compact('distributor'));
    }

    public function create()
    {
        return view('distributor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_distributor' => 'required|string|max:100',
            'alamat' => 'required',
            'telepon' => 'required|string|max:15',
            'email' => 'required|email|unique:distributor,email',
        ]);

        Distributor::create($request->all());
        return redirect()->route('distributor.index');
    }

    public function show(Distributor $distributor)
    {
        return view('distributor.show', compact('distributor'));
    }

    public function edit(Distributor $distributor)
    {
        return view('distributor.edit', compact('distributor'));
    }

    public function update(Request $request, Distributor $distributor)
    {
        $request->validate([
            'nama_distributor' => 'required|string|max:100',
            'alamat' => 'required',
            'telepon' => 'required|string|max:15',
            'email' => 'required|email|unique:distributor,email,' . $distributor->id,
        ]);

        $distributor->update($request->all());
        return redirect()->route('distributor.index');
    }

    public function destroy(Distributor $distributor)
    {
        $distributor->delete();
        return redirect()->route('distributor.index');
    }
}
