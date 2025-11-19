<?php $this->layout('layouts/admin', ['title' => 'Detalhes do Estoque']) ?>

<?php $this->start('body') ?>
<div class="card shadow-sm">
    <?php $this->insert('partials/admin/form/header', ['title' => 'Detalhes do Estoque']) ?>

    <div class="card-body">
        <!-- Alerta de Estoque Baixo -->
        <?php if ($estoque['qtd'] < $estoque['minimo']): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
                <div>
                    <strong>Estoque baixo!</strong> A quantidade atual (<?= $estoque['qtd'] ?>) está abaixo do mínimo (<?= $estoque['minimo'] ?>).
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                <div>
                    <strong>Estoque OK!</strong> Tudo dentro do limite.
                </div>
            </div>
        <?php endif; ?>

        <div class="row g-5">
            <!-- Coluna do Produto -->
            <div class="col-lg-5">
                <div class="card border-0 bg-light h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="bi bi-box-seam text-primary"></i> Informações do Produto
                        </h5>

                        <?php if (!empty($produto['image_path'])): ?>
                            <div class="text-center mb-4">
                                <img src="<?= $this->e($produto['image_path']) ?>"
                                    class="img-fluid rounded shadow-sm"
                                    style="max-height: 200px;" alt="<?= $this->e($produto['nome']) ?>">
                            </div>
                        <?php endif; ?>

                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="40%">Nome:</th>
                                <td><strong><?= $this->e($produto['nome']) ?></strong></td>
                            </tr>
                            <tr>
                                <th>Categoria:</th>
                                <td><?= $this->e($produto['categoria'] ?? '<em class="text-muted">Sem categoria</em>') ?></td>
                            </tr>
                            <tr>
                                <th>Preço:</th>
                                <td>R$ <?= number_format($produto['price'], 2, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <th>Cadastrado em:</th>
                                <td><?= $this->e($produto['created_at'] ?? '—') ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Coluna do Estoque -->
            <div class="col-lg-7">
                <div class="card border-0 bg-light h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="bi bi-graph-up-arrow text-success"></i> Controle de Estoque
                        </h5>

                        <div class="row text-center mb-4">
                            <div class="col-6">
                                <div class="p-3 bg-white rounded shadow-sm">
                                    <