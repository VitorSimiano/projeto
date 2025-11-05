<?php

namespace App\Services;

use App\Strategies\PaymentStrategy;

class PaymentContext
{
    private PaymentStrategy $strategy;

    public function setStrategy(PaymentStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function processPayment(float $amount): bool
    {
        return $this->strategy->pay($amount);
    }

    public function getPaymentDetails(): array
    {
        return [
            'method' => $this->strategy->getName(),
            'details' => $this->strategy->getDetails()
        ];
    }
}