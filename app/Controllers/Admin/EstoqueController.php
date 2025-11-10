<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Repositories\EstoqueRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EstoqueController
{
    private View $view;
    private EstoqueRepository $repo;

    public function __construct()
    {
        $this->view = new View();
        $this->repo = new EstoqueRepository();
    }

    public function index(Request $request): Response
    {
        $estoque = $this->repo->getAllWithStock();

        $html = $this->view->render('admin/estoque/index', [
            'estoque' => $estoque,
            'title'   => 'Controle de Estoque'
        ]);

        return new Response($html);
    }

    /**
     * Formulário + processamento de entrada/saída
     */
    public function movimentar(Request $request): Response
    {
        $id   = (int)$request->query->get('id', 0);
        $tipo = $request->query->get('tipo', '');

        if (!$id || !in_array($tipo, ['entrada', 'saida'])) {
            return new RedirectResponse('/admin/estoque');
        }

        // Busca o produto (só para mostrar o nome)
        $produto = \App\Database::getConnection()
            ->query("SELECT nome FROM produtos WHERE id = $id")
            ->fetch();

        if (!$produto) {
            return new RedirectResponse('/admin/estoque');
        }

        // Processa POST
        if ($request->isMethod('POST')) {
            $quantidade = (int)$request->request->get('quantidade', 0);

            if ($quantidade > 0) {
                $this->repo->movimentar($id, $quantidade, $tipo);
            }

            return new RedirectResponse('/admin/estoque');
        }

        // Exibe formulário
        $html = $this->view->render('admin/estoque/movimentar', [
            'produto' => $produto,
            'tipo'    => $tipo,
            'title'   => ucfirst($tipo) . ' de Estoque'
        ]);

        return new Response($html);
    }
}