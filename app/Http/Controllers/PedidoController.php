<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Produto;
use App\Services\PedidoPaymentService;
use App\Strategies\CreditCardStrategy;
use App\Strategies\PixStrategy;
use App\Factories\PedidoBalcaoFactory;
use App\Factories\PedidoDeliveryFactory;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    private $pedidoPaymentService;

    public function __construct(PedidoPaymentService $pedidoPaymentService)
    {
        $this->pedidoPaymentService = $pedidoPaymentService;
    }

    // Listar pedidos
    public function index()
    {
        return Pedido::with('cliente', 'produtos')->get();
    }

    // Ver pedido específico
    public function show($id)
    {
        return Pedido::with('cliente', 'produtos')->findOrFail($id);
    }

    // Criar pedido (usando Factory Method)
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo' => 'required|in:balcao,delivery',
            'produtos' => 'required|array',
            'produtos.*.produto_id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
        ]);

        // Calcula o total dos produtos
        $total = 0;
        foreach ($request->produtos as $item) {
            $produto = Produto::findOrFail($item['produto_id']);
            $total += $produto->preco * $item['quantidade'];
        }

        // Dados iniciais do pedido
        $dadosPedido = [
            'cliente_id' => $request->cliente_id,
            'total' => $total,
            'status' => 'pendente',
        ];

        // Escolhe a fábrica de acordo com o tipo de pedido
        $factory = match ($request->tipo) {
            'balcao' => new PedidoBalcaoFactory(),
            'delivery' => new PedidoDeliveryFactory(),
            default => throw new \InvalidArgumentException('Tipo de pedido inválido')
        };

        // Cria o pedido via Factory Method
        $pedido = $factory->criarPedido($dadosPedido);

        // Relaciona os produtos ao pedido
        foreach ($request->produtos as $item) {
            $produto = Produto::findOrFail($item['produto_id']);
            $pedido->produtos()->attach($produto->id, [
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $produto->preco,
            ]);
        }

        return response()->json($pedido->load('cliente', 'produtos'), 201);
    }

    // Processar pagamento do pedido
    public function processPayment(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        
        $request->validate([
            'payment_method' => 'required|in:credit_card,pix',
            'payment_details' => 'required|array'
        ]);

        try {
            $strategy = match($request->payment_method) {
                'credit_card' => new CreditCardStrategy(
                    $request->input('payment_details.card_number'),
                    $request->input('payment_details.cvv'),
                    $request->input('payment_details.expiry_date')
                ),
                'pix' => new PixStrategy(
                    $request->input('payment_details.pix_key'),
                    $request->input('payment_details.pix_key_type')
                ),
                default => throw new \InvalidArgumentException('Método de pagamento inválido')
            };

            $success = $this->pedidoPaymentService->processPayment($pedido, $strategy);

            if ($success) {
                return response()->json([
                    'message' => 'Pagamento processado com sucesso',
                    'pedido' => $pedido->fresh()
                ]);
            }

            return response()->json([
                'message' => 'Falha no processamento do pagamento'
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao processar pagamento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Atualizar status do pedido
    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pendente,entregue,cancelado',
        ]);

        $pedido->update([
            'status' => $request->status
        ]);

        return response()->json($pedido->load('cliente', 'produtos'));
    }

    // Deletar pedido
    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return response()->json(['message' => 'Pedido removido com sucesso']);
    }
}
