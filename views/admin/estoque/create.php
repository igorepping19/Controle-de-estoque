<?php $this->layout('layouts/admin', ['title' => ucfirst($tipo) . ' de Estoque']) ?>

<?php $this->start('body') ?>
<div class="card shadow-sm" id="formView">
    <?php $this->insert('partials/admin/form/header', ['title' => ucfirst($tipo) . ' de Estoque']) ?>
    <div class="card-body">
        <form method="post" action="" class="needs-validation" novalidate>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Produto</label>
                    <p class="form-control-plaintext"><?= $this->e($produto['nome']) ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tipo de Movimentação</label>
                    <p class="form-control-plaintext">
                        <span class="badge bg-<?= $tipo === 'entrada' ? 'success' : 'warning' ?>">
                            <?= ucfirst($tipo) ?>
                        </span>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="quantidade" class="form-label">Quantidade *</label>
                    <input type="number"
                        class="form-control <?= !empty($errors['quantidade']) ? 'is-invalid' : '' ?>"
                        id="quantidade"
                        name="quantidade"
                        min="1"
                        value="<?= $this->e($old['quantidade'] ?? '') ?>"
                        required>
                    <?php if (!empty($errors['quantidade'])): ?>
                        <div class="invalid-feedback">
                            <?= $this->e($errors['quantidade']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3"></div>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-<?= $tipo === 'entrada' ? 'success' : 'warning' ?>">
                    <i class="bi bi-check-lg"></i> Confirmar <?= ucfirst($tipo) ?>
                </button>
                <a href="/admin/estoque" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>

            <?= \App\Core\Csrf::input() ?>
        </form>
    </div>
</div>

<!-- Validação Bootstrap -->
<script>
    // Validação nativa do Bootstrap
    (function() {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

<?php $this->stop() ?>