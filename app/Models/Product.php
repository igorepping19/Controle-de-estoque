<?php

namespace App\Models;

class Product 
{
    // Propriedades do produto
    public $id;
    public $name;
    public $price;
    public $category_id;
    public $image_path;

    // 🛑 REMOÇÃO DO ESTOQUE: $qtd e $minimo removidos
    
    // O construtor agora só aceita 5 argumentos principais
    public function __construct(
        $id = null, 
        $name, 
        $price, 
        $category_id, 
        $image_path = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->category_id = $category_id;
        $this->image_path = $image_path;
        
    }
    
}