<?php

namespace App\Services;

// Mantendo a correção de tipagem para Symfony\Request
use Symfony\Component\HttpFoundation\Request;
use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Faz a validação e cria o objeto Product SEM os dados de estoque.
     */
    public function make(Request $request): Product|array
    {
        $data = $request->request->all();
        $files = $request->files->all();
        $errors = [];

        // 1. Validações básicas...
        if (empty($data['name'])) {
            $errors['name'] = 'O nome do produto é obrigatório.';
        }
        if (!is_numeric($data['price']) || $data['price'] <= 0) {
            $errors['price'] = 'O preço deve ser um valor numérico positivo.';
        }
        if (!isset($data['category_id']) || !is_numeric($data['category_id']) || $data['category_id'] <= 0) {
            $errors['category_id'] = 'A categoria é obrigatória.';
        }

        // 🛑 REMOÇÃO DO ESTOQUE: Não extraímos mais $qtd e $minimo aqui.
        
        // 3. Lógica de Imagem
        $imagePath = null;
        if (isset($files['image']) && $files['image']['error'] === UPLOAD_ERR_OK) {
            try {
                $imagePath = $this->handleImageUpload($files['image']); 
            } catch (\Exception $e) {
                $errors['image'] = 'Erro ao fazer upload da imagem: ' . $e->getMessage();
            }
        } else {
            if (isset($data['id'])) {
                $existingProduct = $this->productRepository->find((int)$data['id']);
                $imagePath = $existingProduct['image_path'] ?? null;
            }
        }
        
        if (!empty($errors)) {
            return $errors;
        }

        // 4. Criação do Objeto Product (AGORA COM MENOS ARGUMENTOS)
        // Removendo os argumentos $qtd e $minimo.
        $product = new Product(
            $data['id'] ?? null, 
            $data['name'],
            (float) $data['price'],
            (int) $data['category_id'],
            $imagePath
            // $qtd e $minimo removidos daqui
        );

        return $product;
    }

    public function store(Product $product): int
    {
        return $this->productRepository->create($product); 
    }
    
    private function handleImageUpload(array $file): string
    {
        $filename = uniqid('img_') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $destination = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new \Exception("Falha ao mover o arquivo para o destino.");
        }
        return '/uploads/' . $filename;
    }
}