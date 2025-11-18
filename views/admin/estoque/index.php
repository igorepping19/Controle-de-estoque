<?php $this->layout('layouts/admin', ['title' => 'Controle de Estoque']) ?>

<?php $this->start('body') ?>
<div class="card shadow-sm">
    <?php $this->insert('partials/admin/form/header', ['title' => 'Controle de Estoque']) ?>
    
    <div class="card-body">
        <!-- Resumo rápido -->
        <div class="row mb-4 text-center">
            <div class="col-md-3">
                <div class="card border-0 bg-light">
                    <div class="card-body p-3">
                        <h5 class="card-title text-muted mb-1">Total de Produtos</h5>
                        <p class="fs-3 fw-bold text-primary"><?= count($estoque) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-light">
                    <div class="card-body p-3">
                        <h5 class="card-title text-muted mb-1">Em Estoque</h5>
                        <p class="fs-3 fw-bold text-success">
                            <?= array_sum(array_column($estoque, 'qtd')) ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-light">
                    <div class="card-body p-3">
                        <h5 class="card-title text-muted mb-1">Abaixo do Mínimo</h5>
                        <p class="fs-3 fw-bold text-danger">
                            <?= count(array_filter($estoque, fn($i) => $i['qtd'] < $i['minimo'])) ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-light">
                    <div class="card-body p-3">
                        <h5 class="card-title text-muted mb-1">Estoque Mínimo Total</h5>
                        <p class="fs-3 fw-bold text-info">
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
                        <th>Produto</th>
                        <th>Categoria</th>
                        <th class="text-center">Qtd Atual</th>
                        <th class="text-center">Mínimo</