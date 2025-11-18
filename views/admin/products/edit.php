<?php $this->layout('layouts/admin', ['title' => 'Editar Produto']) ?>

<?php $this->start('body') ?>
<div class="card shadow-sm" id="formView">
    <?php $this->insert('partials/admin/form/header', ['title' => 'Editar Produto']) ?>
    <div class="card-body">
        <form method="post" action="/admin/products/update" enctype="multipart/form-data" class="needs-validation" novalidate>
            <input type="hidden" name="id" value="<?= $this->e($product['id']) ?>">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nome *</label>
                    <input type="text" class="form-control <?= !empty($errors['name']) ? 'is-invalid' : '' ?>" 
                           id="name" name="name" placeholder="Digite o nome"
                           value="<?= $this->e($old['name'] ?? $product['name'] ?? '') ?>" required>
                    <?php if (!empty($errors['name'])): ?>
                        <div class="invalid-feedback"><?= $this->e($errors['name']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Preço *</label>
                    <input type="number" step="0.01" class="form-control <?= !empty($errors['price']) ? 'is-invalid' : '' ?>" 
                           id="price" name="price" placeholder="0,00"
                           value="<?= $this->e($old['price'] ?? $product['price'] ?? '') ?>" required>
                    <?php if (!empty($errors['price'])): ?>
                        <div class="invalid-feedback"><?= $this->e($errors['price']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="quantity" class="form-label">Quantidade em Estoque *</label>
                    <input type="number" min="0" class="form-control <?= !empty($errors['quantity']) ? 'is-invalid' : '' ?>"
                           id="quantity" name="quantity" placeholder="0"
                           value="<?= $this->e($old['quantity'] ?? $product['quantity'] ?? '0') ?>" required>
                    <div class="form-text">Define ou atualiza o estoque atual do produto</div>
                    <?php if (!empty($errors['quantity'])): ?>
                        <div class="invalid-feedback"><?= $this->e($errors['quantity']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Categoria *</label>
                    <select class="form-select <?= !empty($errors['category_id']) ? 'is-invalid' : '' ?>" 
                            id="category_id" name="category_id" required>
                        <option value="">Selecione uma categoria</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"
                                <?= ($old['category_id'] ?? $product['category_id'] ?? '') == $category['id'] ? 'selected' : '' ?>>
                                <?= $this->e($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['category_id'])): ?>
                        <div class="invalid-feedback"><?= $this->e($errors['category_id']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="image" class="form-label">Imagem (JPEG, PNG, WEBP) — substituir atual</label>
                    <?php if (!empty($product['image_path'])): ?>
                        <div class="mb-2">
                            <img src="<?= $this->e($product['image_path']) ?>" 
                                 class="img-thumbnail" style="max-height: 150px;" alt="Imagem atual">
                            <small class="text-muted d-block">Imagem atual</small>
                        </div>
                    <?php endif; ?>
                    <input class="form-control <?= !empty($errors['image']) ? 'is-invalid' : '' ?>" 
                           type="file" id="image" name="image" accept="image/*">
                    <?php if (!empty($errors['image'])): ?>
                        <div class="invalid-feedback"><?= $this->e($errors['image']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="alert alert-info border-0">
                        <i class="bi bi-info-circle"></i>
                        <strong>Dica:</strong> Ao alterar a quantidade aqui, o estoque será atualizado imediatamente.
                        Use o módulo <strong>Estoque</strong> para entradas e saídas com histórico.
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-lg"></i> Atualizar Produto
                </button>
                <a href="/admin/products" class="btn btn-secondary btn-lg">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
                <a href="/admin/estoque/show?id=<?= $product['id'] ?>" class="btn btn-success btn-lg">
                    <i class="bi bi-box-seam"></i> Ver no Estoque
                </a>
            </div>

            <?= \App\Core\Csrf::input() ?>
        </form>
    </div>
</div>

<!-- Validação Bootstrap -->
<script>
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        forms.forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                अलावाform.classList.add('was-validated')
            }, false)
        })
    })()
</script>
<?php $this->stop() ?>