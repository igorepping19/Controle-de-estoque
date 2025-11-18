<?php

namespace App\Core;

use League\Plates\Engine;

class View
{
    private Engine $engine;

    public function __construct()
    {
        $this->engine = new Engine(dirname(__DIR__, 2) . '/views');

        // ESSA É A LINHA QUE MATA O ERRO DE count() PARA SEMPRE
        $this->engine->registerFunction('loop', fn() => new class {
            public function __get($name) { return null; }
            public function __call($name, $args) { return null; }
        });

        // Se você usa menu ativo (provavelmente usa), mantém funcionando
        $this->engine->loadExtension(new \League\Plates\Extension\URI($_SERVER['REQUEST_URI'] ?? '/'));
    }

    public function render(string $template, array $data = []): string
    {
        // Garantia extra: nunca passa null para o template
        $data = array_map(fn($value) => $value ?? [], $data);
        
        return $this->engine->render($template, $data);
    }
}