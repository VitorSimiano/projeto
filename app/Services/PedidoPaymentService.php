<?php

namespace App\Services;

use App\Models\Pedido;
use App\Strategies\PaymentStrategy;
use Exception;

class PedidoPaymentService
{
    private PaymentContext $paymentContext;

    public function __construct(PaymentContext $paymentContext)
    {
        $this->paymentContext = $paymentContext;
    }

    public function processPayment(Pedido $pedido, PaymentStrategy $strategy): bool
    {
        try {
            $this->paymentContext->setStrategy($strategy);
            
            if ($this->paymentContext->processPayment($pedido->total)) {
                $pedido->update([
                    'payment_method' => $strategy->getName(),
                    'payment_details' => $strategy->getDetails(),
                    'payment_status' => 'paid'
                ]);
                return true;
            }

            $pedido->update(['payment_status' => 'failed']);
            return false;
        } catch (Exception $e) {
            $pedido->update(['payment_status' => 'failed']);
            throw $e;
        }
    }
}