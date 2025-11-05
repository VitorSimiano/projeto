<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'total',
        'status',
        'payment_method',
        'payment_details',
        'payment_status',
    ];

    protected $casts = [
        'payment_details' => 'array',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'pedido_produto')
                    ->withPivot('quantidade', 'preco_unitario')
                    ->withTimestamps();
    }
}
