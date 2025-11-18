<?php

namespace App\Services;

use App\Models\Product;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductService
{
    public function validate(array $data, ?UploadedFile $file = null): array
    {
        $errors = [];

        // Validação dos campos básicos
        $name = trim($data['name'] ?? '');
        $price = $data['price'] ?? '';
        $category_id = $data['category_id'] ?? '';

        if ($name === '') {
            $errors['name'] = 'O nome do produto é obrigatório';
        }

        if ($price === '' || !is_numeric($price) || (float)$price <= 0) {
            $errors['price'] = 'O preço deve ser um valor numérico maior que zero';
        }

        if ($category_id === '' || !is_numeric($category_id)) {
            $errors['category_id'] = 'Selecione uma categoria válida';
        }

        // Validação da quantidade em estoque
        $quantity = $data['quantity'] ?? null;

        if ($quantity === null || $quantity === '' || trim($quantity) === '') {
            $errors['quantity'] = 'A quantidade em estoque é obrigatória';
        } elseif (!is_numeric($quantity)) {
            $errors['quantity'] = 'A quantidade deve ser um número válido';
        } elseif ((int)$quantity < 0) {
            $errors['quantity'] = 'A quantidade não pode ser negativa';
        }

        // Validação da imagem (se enviada)
        if ($file) {
            $maxMb = (int)($_ENV['UPLOAD_MAX_MB'] ?? 5);
            $allowed = ['image/jpeg', 'image/png', 'image/webp'];

            if (!in_array($file->getMimeType(), $allowed, true)) {
                $errors['image'] = 'A imagem deve ser do tipo JPEG, PNG ou WEBP';
            }

            if ($file->getSize() > $maxMb * 1024 * 1024) {
                $errors['image'] = "A imagem não pode ter mais de {$maxMb}MB";
            }
        }

        return $errors;
    }

    public function storeImage(?UploadedFile $file): ?string
    {
        if (!$file || !$file->isValid()) {
            return null;
        }

        $ext = strtolower($file->guessExtension() ?: $file->getClientOriginalExtension());
        $name = bin2hex(random_bytes(8)) . '.' . $ext;
        $dest = dirname(__DIR__, 2) . '/public/uploads';

        $file->move($dest, $name);

        return '/uploads/' . $name;
    }

    public function make(array $data, ?string $imagePath = null): Product
    {
        $name = trim($data['name'] ?? '');
        $price = (float)($data['price'] ?? 0);
        $category_id = (int)($data['category_id'] ?? 0);
        $id = isset($data['id']) ? (int)$data['id'] : null;

        return new Product($id, $name, $price, $category_id, $imagePath);
    }
}