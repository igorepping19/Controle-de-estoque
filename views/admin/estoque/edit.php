<?php $this->layout('layouts/admin', ['title' => 'Detalhes do Estoque']) ?>

<?php $this->start('body') ?>
<div class="card shadow-sm">
    <?php $this->insert('partials/admin/form/header', ['title' => 'Detalhes do Estoque']) ?>
    <div class="card-body">
        <div class="row g-4">
            <!-- Informações do Produto -->
            <div class="col-md-6">
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-box-seam"></i> Produto
                        </h5>
                        <p class="mb-2"><strong>Nome:</strong> <?= $this->e($produto['nome']) ?></p>
                        <p class="mb-2"><strong>Categoria:</strong> <?= $this->e($produto['categoria'] ?? 'Sem categoria') ?></p>
                        <?php if (!empty($produto['image_path'])): ?>
                            <p class="mb-2">
                                <strong>Imagem:</strong><br>
                                <img src="<?= $this->e($produto['image_path']) ?>"
                                    class="img-thumbnail" style="max-height: 120px;" alt="Produto">
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Informações de Estoque -->
            <div class="col-md-6">
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-graph-up"></i> Estoque
                        </h5>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fs-4 fw-bold <?= $estoque['qtd'] < $estoque['minimo'] ? 'text-danger' : 'text-success' ?>">
                                <?= $estoque['qtd'] ?>
                            </span>
                            <span class="badge bg-<?= $estoque['qtd'] < $estoque['minimo'] ? 'danger' : 'success' ?> fs-6">
                                <?= $estoque['qtd'] < $estoque['minimo'] ? 'Estoque Baixo!' : 'OK' ?>
                            </span>
                        </div>
                        <p class="mb-1"><strong>Mínimo permitido:</strong> <?= $estoque['minimo'] ?></p>
                        <p class="mb-1"><strong>Última atualização:</strong>
                            <?= $estoque['updated_at'] ? $this->e($estoque['updated_at']) : 'Nunca' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="mt-4 p-3 bg-light rounded">
            <h6 class="mb-3">
                <i class="bi bi-arrow-left-right"></i> Movimentações Rápidas
            </h6>
            <div class="d-flex gap-2 flex-wrap">
                <a href="/admin/estoque/movimentar?id=<?= $produto['id'] ?>&tipo=entrada"
                    class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Entrada
                </a>
                <a href="/admin/estoque/movimentar?id=<?= $produto['id'] ?>&tipo=saida"
                    class="btn btn-warning">
                    <i class="bi bi-dash-lg"></i> Saída
                </a>
                <a href="/admin/estoque" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar à Lista
                </a>
            </div>
        </div>

        <!-- Histórico (opcional - futuro) -->
        <div class="mt-4">
            <h6 class="text-muted">
                <i class="bi bi-clock-history"></i> Histórico de movimentações (em breve)
            </h6>
        </div>
    </div>
</div>
<?php $this->stop() ?>