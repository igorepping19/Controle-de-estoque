<?php
namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\View;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Symfony\Component\HttpFoundation\RedirectResponse;
// Este é o objeto Request que o Controller recebe: Symfony\Component\HttpFoundation\Request
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController {
    private View $view;
    private ProductRepository $repo;
    private ProductService $service;
    private CategoryRepository $categoryRepo;

    public function __construct() {
        $this->view = new View();
        $this->repo = new ProductRepository();
        // O Controller passa o Repositório para o Service
        $this->service = new ProductService($this->repo); 
        $this->categoryRepo = new CategoryRepository();
    }

    public function index(Request $request): Response {
        $page = max(1, (int)$request->query->get('page', 1));
        $perPage = 10;
        $total = $this->repo->countAllWithStock();
        $products = $this->repo->paginateWithStock($page, $perPage);
        $pages = (int)ceil($total / $perPage);
        $categories = $this->categoryRepo->getArray();

        $csrf = \App\Core\Csrf::token(); 

        $html = $this->view->render('admin/products/index', compact('products','page','pages', 'categories', 'csrf'));
        return new Response($html);
    }

    public function create(): Response {
        $categories = $this->categoryRepo->findAll();
        $html = $this->view->render('admin/products/create', ['csrf' => Csrf::token(), 'errors' => [], 'old' => [], 'categories' => $categories]);
        return new Response($html);
    }

    /**
     * MÉTODO STORE CORRIGIDO: Passa o objeto $request COMPLETO.
     */
    public function store(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        
        // CORREÇÃO: Passa o objeto Request COMPLETO para o Service
        $productOrErrors = $this->service->make($request); 

        if (is_array($productOrErrors)) {
            $errors = $productOrErrors;
            $categories = $this->categoryRepo->findAll();
            $html = $this->view->render('admin/products/create', ['csrf' => Csrf::token(), 'errors' => $errors, 'old' => $request->request->all(), 'categories' => $categories]);
            return new Response($html, 422);
        }
        
        $product = $productOrErrors;
        // Chama o método store no Service, que persiste o Produto e o Estoque
        $id = $this->service->store($product); 
        
        return new RedirectResponse('/admin/products/show?id=' . $id);
    }

    public function show(Request $request): Response {
        $id = (int)$request->query->get('id', 0);
        $product = $this->repo->find($id); 
        if (!$product) return new Response('Produto não encontrado', 404);
        $html = $this->view->render('admin/products/show', ['product' => $product]);
        return new Response($html);
    }

    public function edit(Request $request): Response {
        $id = (int)$request->query->get('id', 0);
        $product = $this->repo->find($id); 
        $categories = $this->categoryRepo->findAll();
        if (!$product) return new Response('Produto não encontrado', 404);
        $html = $this->view->render('admin/products/edit', ['product' => $product, 'csrf' => Csrf::token(), 'errors' => [], 'categories' => $categories]);
        return new Response($html);
    }

    /**
     * MÉTODO UPDATE CORRIGIDO: Passa o objeto $request COMPLETO.
     */
    public function update(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        
        // CORREÇÃO: Passa o objeto Request COMPLETO para o Service
        $productOrErrors = $this->service->make($request, true); 

        if (is_array($productOrErrors)) {
            $errors = $productOrErrors;
            $data = $request->request->all();
            $categories = $this->categoryRepo->findAll();
            $html = $this->view->render('admin/products/edit', [
                'product' => array_merge($this->repo->find((int)$data['id']) ?: [], $data), 
                'csrf' => Csrf::token(), 
                'errors' => $errors, 
                'categories' => $categories
            ]);
            return new Response($html, 422);
        }
        
        $product = $productOrErrors;
        if (!$product->id) return new Response('ID inválido para atualização', 422);
        
        $this->repo->update($product); 
        
        return new RedirectResponse('/admin/products/show?id=' . $product->id);
    }

    public function delete(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        $id = (int)$request->request->get('id', 0);
        if ($id > 0) $this->repo->delete($id);
        return new RedirectResponse('/admin/products');
    }
}