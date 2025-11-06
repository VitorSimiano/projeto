<?php

namespace App\Factories;

use App\Models\Pedido;

abstract class PedidoFactory
{
    abstract public function criarPedido(array $dados): Pedido;
}
