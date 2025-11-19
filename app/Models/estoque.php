<?php

namespace App\Models;

class Estoque
{
    public int $produto_id;
    public int $quantidade;
    public int $estoque_minimo;
    public string $created_at;
    public ?string $updated_at;

    public function __construct(
        int $produto_id,
        int $quantidade = 0,
        int $estoque_minimo = 5,
        string $created_at = '',
        ?string $updated_at = null
    ) {
        $this->produto_id = $produto_id;
        $this->quantidade = $quantidade;
        $this->estoque_minimo = $estoque_minimo;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
