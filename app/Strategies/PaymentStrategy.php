<?php

namespace App\Strategies;

interface PaymentStrategy
{
    public function pay(float $amount): bool;
    public function getName(): string;
    public function getDetails(): array;
}