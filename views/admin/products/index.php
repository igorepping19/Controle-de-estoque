<?php $this->layout('layouts/admin', ['title' => 'Produtos']) ?>

<?php $this->start('body') ?>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Lista de Produtos</h4>
        <a href="/admin/products/create" class="btn btn-primary">Novo Produto</a>
    </div>
    <div class="card-body">
        <?php if (empty($products)): ?>
            <div class="alert alert-info">Nenhum produto cadastrado.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td>
                                <img src="<?= $this->e($p['image_path'] ?? '/img/no-image.png') ?>" width="50" class="rounded">
                            </td>
                            <td><strong><?= $this->e($p['name']) ?></strong></td>
                            <td>Sem categoria</td>
                            <td>R$ <?= number_format($p['price'], 2, ',', '.') ?></td>
                            <td>
                                <span class="badge <?= ($p['qtd'] ?? 0) > ($p['minimo'] ?? 0) ? 'bg-success' : 'bg-warning' ?>">
                                    <?= $p['qtd'] ?? 0 ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="/admin/products/edit?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning" title="Editar">Editar</a>
                                    
                                    <!-- NOVO BLOCO: FORMULÁRIO POST para exclusão -->
                                    <form method="POST" action="/admin/products/delete" style="display:inline;">
                                        <!-- O token CSRF deve ser passado para a view pelo Controller. Ele é essencial. -->
                                        <input type="hidden" name="_csrf" value="<?= $csrf ?>">
                                        <!-- O ID é o parâmetro 'id' que o Controller::delete espera -->
                                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Tem certeza que deseja excluir o produto: <?= $this->e($p['name']) ?>?');">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $this->stop() ?>