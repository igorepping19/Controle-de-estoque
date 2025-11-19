<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Product;
use PDO;

class ProductRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function countAll(): int
    {
        return (int)$this->db->query("SELECT COUNT(*) FROM products")->fetchColumn();
    }

    public function paginate(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->db->prepare("SELECT * FROM products ORDER BY id DESC LIMIT ? OFFSET ?");
        $stmt->bindValue(1, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }   

public function create(Product $p): int
{
    // 1. INSERIR APENAS NA TABELA 'products'
    $stmt = $this->db->prepare("INSERT INTO products (category_id, name, price, image_path) VALUES (?, ?, ?, ?)");
    $stmt->execute([$p->category_id, $p->name, $p->price, $p->image_path]);
    
    $productId = (int)$this->db->lastInsertId();

    return $productId;
}


    public function update(Product $p): bool
    {
        $stmt = $this->db->prepare("UPDATE products SET category_id = ?, name = ?, price = ?, image_path = ? WHERE id = ?");
        return $stmt->execute([$p->category_id, $p->name, $p->price, $p->image_path, $p->id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Busca todos os produtos relacionados a uma categoria.
     * Deve retornar um array (vazio ou com resultados).
     */
    public function findByCategoryId(int $id): array
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE category_id = ?");
        $stmt->execute([$id]);
        // CORREÇÃO CRÍTICA: Usar fetchAll() para buscar todos e garantir um array
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        return $rows ?: []; // Retorna um array vazio se nada for encontrado
    }

    // NOVAS FUNÇÕES — COM ESTOQUE
    public function countAllWithStock(): int
    {
        return (int)$this->db->query("
            SELECT COUNT(*) 
            FROM products p
            LEFT JOIN estoque e ON p.id = e.produto_id
        ")->fetchColumn();
    }

    public function paginateWithStock(int $page = 1, int $perPage = 10): array
    {
    $offset = ($page - 1) * $perPage;

    $stmt = $this->db->prepare("
        SELECT 
            p.*,
            COALESCE(e.quantidade, 0) as qtd,
            COALESCE(e.estoque_minimo, 0) as minimo
        FROM products p
        LEFT JOIN estoque e ON p.id = e.produto_id
        ORDER BY p.name ASC
        LIMIT ? OFFSET ?
    ");
    $stmt->bindValue(1, $perPage, PDO::PARAM_INT);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
    }
}