<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Repositories\EstoqueRepository;
use App\Services\EstoqueService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EstoqueController
{
    private View $view;
    private EstoqueRepository $repo;
    private EstoqueService $service;

    public function __construct()
    {
        $this->view = new View();
        $this->repo = new EstoqueRepository();
        $this->service = new EstoqueService();
    }

    public function index(Request $request): Response
    {
        // CORRIGIDO: usamos $this->repo (a variável que foi instanciada)
        $products = $this->repo->getAllWithStock();

        $html = $this->view->render('admin/estoque/index', [
            'products' => $products ?? [],        // ← nome correto da variável
            'title'    => 'Controle de Estoque'
        ]);

        return new Response($html);
    }

    public function movimentar(Request $request): Response
    {
        $id   = (int)$request->query->get('id', 0);
        $tipo = $request->query->get('tipo', '');

        if (!$id || !in_array($tipo, ['entrada', 'saida'])) {
            return new RedirectResponse('/admin/estoque');
        }

        $nomeProduto = $this->repo->findProductName($id);
        if (!$nomeProduto) {
            return new RedirectResponse('/admin/estoque');
        }

        if ($request->isMethod('POST')) {
            $quantidade = (int)$request->request->get('quantidade', 0);

            $errors = $this->service->validate(['quantidade' => $quantidade]);
            if ($errors) {
                $html = $this->view->render('admin/estoque/movimentar', [
                    'produto' => ['nome' => $nomeProduto],
                    'tipo'    => $tipo,
                    'title'   => ucfirst($tipo) . ' de Estoque',
                    'errors'  => $errors,
                    'old'     => $request->request->all()
                ]);
                return new Response($html, 422);
            }

            $this->repo->movimentar($id, $quantidade, $tipo);
            return new RedirectResponse('/admin/estoque');
        }

        $html = $this->view->render('admin/estoque/movimentar', [
            'produto' => ['nome' => $nomeProduto],
            'tipo'    => $tipo,
            'title'   => ucfirst($tipo) . ' de Estoque',
            'errors'  => [],
            'old'     => []
        ]);

        return new Response($html);
    }

    public function show(Request $request): Response
    {
        $id = (int)$request->query->get('id', 0);
        if (!$id) {
            return new RedirectResponse('/admin/estoque');
        }

        $data = $this->repo->findProductWithStock($id);
        if (!$data) {
            return new Response('Produto não encontrado', 404);
        }

        $html = $this->view->render('admin/estoque/show', [
            'produto' => [
                'id'         => $data['id'],
                'nome'       => $data['nome'],
                'categoria'  => $data['categoria'],
                'image_path' => $data['image_path'] ?? null,
                'price'      => $data['price'] ?? 0,
                'created_at' => $data['created_at'] ?? null
            ],
            'estoque' => [
                'q'          => $data['qtd'],
                'minimo'     => $data['minimo'],
                'updated_at' => $data['updated_at']
            ],
            'title' => 'Detalhes do Estoque'
        ]);

        return new Response($html);
    }
}