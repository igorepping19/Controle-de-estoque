<?php

namespace App\Services;

use App\Models\Estoque;

class EstoqueService
{
    /**
     * Valida os dados de movimentação (entrada/saída)
     */
    public function validate(array $data): array
    {
        $errors = [];
        $quantidade = $data['quantidade'] ?? '';

        if (!is_numeric($quantidade) || (int)$quantidade <= 0) {
            $errors['quantidade'] = 'Quantidade deve ser um número maior que zero';
        }

        return $errors;
    }

    /**
     * Cria uma instância do modelo Estoque
     */
    public function make(int $produto_id, int $quantidade = 0, int $estoque_minimo = 5): Estoque
    {
        return new Estoque(
            $produto_id,
            $quantidade,
            $estoque_minimo
        );
    }
}