<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // CREATE
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|unique:clientes',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
        ]);

        $cliente = Cliente::create($request->all());

        return response()->json($cliente, 201);
    }

    // READ (todos os clientes)
    public function index()
    {
        return response()->json(Cliente::all());
    }

    // READ (um cliente)
    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        return response()->json($cliente);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|unique:clientes,email,' . $id,
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
        ]);

        $cliente->update($request->all());

        return response()->json($cliente);
    }

    // DELETE
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return response()->json(['message' => 'Cliente removido com sucesso']);
    }
}
