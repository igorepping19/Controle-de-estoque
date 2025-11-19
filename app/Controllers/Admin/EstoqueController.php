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
        $this->view    = new View();
        $this->repo    = new EstoqueRepository();
        $this->service = new EstoqueService();
    }

    public function index(Request $request): Response
    {
        $estoque = $this->repo->getAllWithStock()  ?? [];

        $html = $this->view->render('admin/estoque/index', [
            'estoque' => $estoque,
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

        // Buscando o nome do produto.
        // Se este método 'findProductName' retorna apenas a string do nome,
        // precisamos montar o array do produto completo:
        $nomeProduto = $this->repo->findProductName($id); 
        if (!$nomeProduto) {
            return new RedirectResponse('/admin/estoque');
        }
        
        // 🚨 CORREÇÃO: Criação do array $produto que inclui 'id' e 'nome'.
        // Este array será passado para a View, satisfazendo as chaves $produto['id'] e $produto['nome'].
        $produto = [
            'id' => $id,
            'nome' => $nomeProduto
        ];

        if ($request->isMethod('POST')) {
            $quantidade = (int)$request->request->get('quantidade', 0);
            $observacao = $request->request->get('observacao', '');
            
            // Certifique-se de validar $observacao também se for necessário no service
            $errors = $this->service->validate(['quantidade' => $quantidade, 'observacao' => $observacao]); 
            
            if ($errors) {
                $html = $this->view->render('admin/estoque/movimentar', [
                    'produto' => $produto, // Usando a nova variável $produto
                    'tipo'    => $tipo,
                    'title'   => ucfirst($tipo) . ' de Estoque',
                    'errors'  => $errors,
                    'old'     => $request->request->all(),
                    'csrf'    => 'TODO: Obter o token CSRF' // Você deve obter o token real aqui
                ]);
                return new Response($html, 422);
            }

            // Ação de Movimentação do Estoque
            $this->repo->movimentar($id, $quantidade, $tipo, $observacao);
            return new RedirectResponse('/admin/estoque');
        }

        // Renderização para o método GET (primeira carga da página)
        $html = $this->view->render('admin/estoque/movimentar', [
            'produto' => $produto, // Usando a nova variável $produto
            'tipo'    => $tipo,
            'title'   => ucfirst($tipo) . ' de Estoque',
            'errors'  => [],
            'old'     => [],
            'csrf'    => 'TODO: Obter o token CSRF' // Você deve obter o token real aqui
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