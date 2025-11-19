<?php $this->layout('layouts/admin', ['title' => 'Movimentação de Estoque']) ?>
<?php $this->start('body') ?>
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">
            <?= $tipo === 'entrada' ? 'Entrada' : 'Saída' ?> de Estoque
        </h4>
        <a href="/admin/estoque" class="btn btn-secondary btn-sm">Voltar</a>
    </div>

    <div class="card-body">
        <div class="alert alert-info mb-4">
            <strong>Produto:</strong> <?= $this->e($produto['nome']) ?>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= $this->e($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $produto['id'] ?>">
            <input type="hidden" name="tipo" value="<?= $tipo ?>">

            <div class="mb-3">
                <label class="form-label">Quantidade</label>
                <input
                    type="number"
                    name="quantidade"
                    class="form-control <?= isset($errors['quantidade']) ? 'is-invalid' : '' ?>"
                    min="1"
                    required
                    autofocus
                    value="<?= $old['quantidade'] ?? '' ?>">
                <?php if (isset($errors['quantidade'])): ?>
                    <div class="invalid-feedback"><?= $this->e($errors['quantidade']) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Observação (opcional)</label>
                <textarea name="observacao" class="form-control" rows="3"><?= $this->e($old['observacao'] ?? '') ?></textarea>
            </div>

            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-lg <?= $tipo === 'entrada' ? 'btn-success' : 'btn-danger' ?>">
                    Confirmar <?= $tipo === 'entrada' ? 'Entrada' : 'Saída' ?>
                </button>
                <a href="/admin/estoque" class="btn btn-lg btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php $this->stop() ?>