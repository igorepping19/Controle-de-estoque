<?php $this->layout('layouts/admin', ['title' => 'Controle de Estoque']) ?>

<?php $this->start('body') ?>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Controle de Estoque</h4>
    </div>
    <div class="card-body">

        <?php 
        // Isso garante que $products nunca seja null (defesa extra)
        $products = $products ?? [];
        ?>

        <?php if (empty($products)): ?>
            <div class="alert alert-info">Nenhum produto com estoque cadastrado.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th>Estoque Atual</th>
                            <th>Estoque Mínimo</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td>
                                <img src="<?= $this->e($p['image_path'] ?? '/img/no-image.png') ?>" 
                                     class="rounded" width="50" height="50" style="object-fit:cover;">
                            </td>
                            <td><strong><?= $this->e($p['nome']) ?></strong></td>
                            <td><?= $this->e($p['categoria']) ?></td>
                            <td>
                                <span class="badge fs-6 <?= $p['qtd'] > $p['minimo'] ? 'bg-success' : 'bg-warning' ?>">
                                    <?= $p['qtd'] ?>
                                </span>
                            </td>
                            <td><?= $p['minimo'] ?></td>
                            <td>
                                <?php if ($p['qtd'] <= 0): ?>
                                    <span class="text-danger fw-bold">SEM ESTOQUE</span>
                                <?php elseif ($p['qtd'] <= $p['minimo']): ?>
                                    <span class="text-warning fw-bold">ESTOQUE BAIXO</span>
                                <?php else: ?>
                                    <span class="text-success">Normal</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/admin/estoque/movimentar?id=<?= $p['id'] ?>&tipo=entrada" class="btn btn-sm btn-success">Entrada</a>
                                <a href="/admin/estoque/movimentar?id=<?= $p['id'] ?>&tipo=saida" class="btn btn-sm btn-danger">Saída</a>
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