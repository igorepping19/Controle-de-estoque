<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class EstoqueRepository
{
    // NÃO precisa do $pdo nem do __construct() aqui

    public function getAllWithStock(): array
    {
        // ← deixa exatamente assim (estava funcionando)
        $stmt = Database::getConnection()->query("
            SELECT 
                p.id,
                p.name AS nome,
                p.image_path,
                c.name AS categoria,
                COALESCE(e.quantidade, 0) AS qtd,
                COALESCE(e.estoque_minimo, 5) AS minimo
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN estoque e ON p.id = e.produto_id
            ORDER BY p.name
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Os outros métodos podem continuar com $this->pdo se você quiser, ou também usar Database::getConnection()
    // (os dois funcionam, o importante é o getAllWithStock() que é usado no index)

    public function movimentar(int $produtoId, int $quantidade, string $tipo): void
    {
        if ($quantidade <= 0 || !in_array($tipo, ['entrada', 'saida'])) return;

        $sinal = $tipo === 'entrada' ? '+' : '-';
        Database::getConnection()->exec("
            INSERT INTO estoque (produto_id, quantidade) 
            VALUES ($produtoId, 0)
            ON DUPLICATE KEY UPDATE quantidade = GREATEST(quantidade $sinal $quantidade, 0)
        ");
    }

    public function findProductName(int $id): ?string
    {
        $stmt = Database::getConnection()->prepare("SELECT name FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() ?: null;
    }

    public function findProductWithStock(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare("
            SELECT 
                p.id, p.name AS nome, p.image_path, p.price, p.created_at,
                c.name AS categoria,
                COALESCE(e.quantidade, 0) AS qtd,
                COALESCE(e.estoque_minimo, 5) AS minimo,
                e.updated_at
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN estoque e ON p.id = e.produto_id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
