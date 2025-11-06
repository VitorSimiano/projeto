<?php

namespace App\Factories;

use App\Models\Pedido;

class PedidoBalcaoFactory extends PedidoFactory
{
    public function criarPedido(array $dados): Pedido
    {
        // Aqui poderia ter lógica específica de pedidos de balcão
        $dados['status'] = 'pendente';
        $dados['payment_method'] = $dados['payment_method'] ?? 'cash';

        return Pedido::create($dados);
    }
}
