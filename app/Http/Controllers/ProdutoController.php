<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    // CREATE
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric',
            'quantidade' => 'required|integer',
        ]);

        $produto = Produto::create($request->all());

        return response()->json($produto, 201);
    }

    // READ (todos os produtos)
    public function index()
    {
        return response()->json(Produto::all());
    }

    // READ (um produto)
    public function show($id)
    {
        $produto = Produto::findOrFail($id);
        return response()->json($produto);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'sometimes|required|numeric',
            'quantidade' => 'sometimes|required|integer',
        ]);

        $produto->update($request->all());

        return response()->json($produto);
    }

    // DELETE
    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();

        return response()->json(['message' => 'Produto removido com sucesso']);
    }
}
