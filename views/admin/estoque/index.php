<?php $this->layout('layouts/admin', ['title' => 'Controle de Estoque']) ?>

<?php $this->start('body') ?>

<?php 
// Proteção definitiva contra null (obrigatório com League\Plates + seções)
$estoque = $estoque ?? [];
?>

<div class="card shadow-sm mb-4">
    <?php $this->insert('partials/admin/form/header', ['title' => 'Controle de Estoque']) ?>
    
    <div class="card-body">
        <!-- Resumo rápido -->
        <div class="row mb-4 text-center">
            <div class="col-md-3">
                <div class="card border-0 bg-light shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title text-muted mb-2">Total de Produtos</h5>
                        <p class="fs-2 fw-bold text-primary mb-0"><?= count($estoque) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-light shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title text-muted mb-2">Em Estoque</h5>
                        <p class="fs-2 fw-bold text-success mb-0">
                            <?= array_sum(array_column($estoque, 'qtd')) ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-light shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title text-muted mb-2">Abaixo do Mínimo</h5>
                        <p class="fs-2 fw-bold text-danger mb-0">
                            <?= count(array_filter($estoque, fn($i) => $i['qtd'] < $i['minimo'])) ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-light shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title text-muted mb-2">Estoque Mínimo Total</h5>
                        <p class="fs-2 fw-bold text-info mb-0">
                            <?= array_sum(array_column($estoque, 'minimo')) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Estoque -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Imagem</th>
                        <th>Produto</th>
                        <th>Categoria</th>
                        <th class="text-center">Qtd Atual</th>
                        <th class="text-center">Mínimo</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estoque as $item): ?>
                    <tr>
                        <td>
                            <img src="<?= $this->e($item['image_path'] ?? '/img/no-image.png') ?>" 
                                 class="rounded" width="50" height="50" style="object-fit:cover;">
                        </td>
                        <td><strong><?= $this->e($item['nome']) ?></strong></td>
                        <td><?= $this->e($item['categoria'] ?? 'Sem categoria') ?></td>
                        <td class="text-center">
                            <span class="badge fs-5 <?= $item['qtd'] > $item['minimo'] ? 'bg-success' : 'bg-warning text-dark' ?>">
                                <?= $item['qtd'] ?>
                            </span>
                        </td>
                        <td class="text-center"><?= $item['minimo'] ?></td>
                        <td class="text-center">
                            <?php if ($item['qtd'] <= 0): ?>
                                <span class="text-danger fw-bold">SEM ESTOQUE</span>
                            <?php elseif ($item['qtd'] < $item['minimo']): ?>
                                <span class="text-warning fw-bold">BAIXO</span>
                            <?php else: ?>
                                <span class="text-success fw-bold">NORMAL</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="/admin/estoque/movimentar?id=<?= $item['id'] ?>&tipo=entrada" 
                               class="btn btn-success btn-sm">Entrada</a>
                            <a href="/admin/estoque/movimentar?id=<?= $item['id'] ?>&tipo=saida" 
                               class="btn btn-danger btn-sm">Saída</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->stop() ?>