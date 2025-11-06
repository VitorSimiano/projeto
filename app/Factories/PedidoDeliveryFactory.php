<?php

namespace App\Factories;

use App\Models\Pedido;

class PedidoDeliveryFactory extends PedidoFactory
{
    public function criarPedido(array $dados): Pedido
    {
        // Exemplo: aplicar taxa de entrega
        $taxaEntrega = 5.00;
        $dados['total'] = ($dados['total'] ?? 0) + $taxaEntrega;
        $dados['status'] = 'pendente';

        return Pedido::create($dados);
    }
}
