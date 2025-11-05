<?php

namespace App\Strategies;

class CreditCardStrategy implements PaymentStrategy
{
    private $cardNumber;
    private $cvv;
    private $expiryDate;

    public function __construct(string $cardNumber, string $cvv, string $expiryDate)
    {
        $this->cardNumber = $cardNumber;
        $this->cvv = $cvv;
        $this->expiryDate = $expiryDate;
    }

    public function pay(float $amount): bool
    {
        // Aqui implementaríamos a lógica real de pagamento com cartão
        // Por exemplo, integração com gateway de pagamento
        return true;
    }

    public function getName(): string
    {
        return 'Cartão de Crédito';
    }

    public function getDetails(): array
    {
        return [
            'tipo' => 'credit_card',
            'numero' => substr($this->cardNumber, -4),
            'bandeira' => $this->detectCardBrand($this->cardNumber)
        ];
    }

    private function detectCardBrand(string $cardNumber): string
    {
        // Implementação simplificada de detecção de bandeira
        $firstDigit = substr($cardNumber, 0, 1);
        return match($firstDigit) {
            '4' => 'Visa',
            '5' => 'Mastercard',
            '3' => 'American Express',
            default => 'Outra'
        };
    }
}