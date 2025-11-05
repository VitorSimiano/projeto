<?php

namespace App\Strategies;

class PixStrategy implements PaymentStrategy
{
    private $pixKey;
    private $pixKeyType;

    public function __construct(string $pixKey, string $pixKeyType)
    {
        $this->pixKey = $pixKey;
        $this->pixKeyType = $pixKeyType;
    }

    public function pay(float $amount): bool
    {
        // Aqui implementaríamos a lógica real de pagamento com PIX
        // Por exemplo, integração com API do Banco Central
        return true;
    }

    public function getName(): string
    {
        return 'PIX';
    }

    public function getDetails(): array
    {
        return [
            'tipo' => 'pix',
            'chave_tipo' => $this->pixKeyType,
            'chave' => $this->pixKey
        ];
    }
}