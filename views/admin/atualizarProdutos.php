<?php

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: " . BASE_URL . "/public/index.php?page=listar_produtos");
    exit();
}

$produto = buscarProdutoPorId($conexao, $id);

if (!$produto) {
    echo "Produto não encontrado!";
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $valor = filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT);
    $estoque = filter_input(INPUT_POST, 'estoque', FILTER_VALIDATE_INT);
    $imagem_url = $_FILES['imagem_url'] ?? null;

    $msg = atualizarProduto($conexao, $id, $nome, $descricao, $valor, $estoque, $imagem_url);

    // Após atualizar, redireciona
    header("Location: " . BASE_URL . "/public/index.php?page=listar_produtos");
    exit();
}
?>


<style>
    .preview-img {
        display: block;
        margin-top: 10px;
        max-width: 150px;
        border-radius: 8px;
        border: 2px solid #ddd;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
    }

    .form-groupaatualizar {
        margin-bottom: 15px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
</style>


<div class="container-conteudo-padrao">
    <div class="card-admin formulario">
        
        <h1>✏️ Editar Produto</h1>

        <form action="" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" required value="<?= htmlspecialchars($produto['nome']); ?>">
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" rows="4" class="form-control"><?= htmlspecialchars($produto['descricao']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="valor">Preço (R$):</label>
                <input type="number" class="form-control" name="valor" id="valor" required min="0" step="0.01" value="<?= htmlspecialchars($produto['valor']); ?>">
            </div>

            <div class="form-group">
                <label for="estoque">Quantidade:</label>
                <input type="number" class="form-control" name="estoque" id="estoque" required min="0" value="<?= htmlspecialchars($produto['estoque']); ?>">
            </div>

            <div class=".form-groupaatualizar">
                <label for="imagem_url">Imagem do Produto:</label>
                <?php if (!empty($produto['imagem_url'])): ?>
                    <p style="font-size: 0.9em; color: #666;">Imagem Atual:</p>
                    <img src="<?= BASE_URL ?> /public/images/products/<?= htmlspecialchars($produto['imagem_url']) ?>" alt="Imagem Atual" class="preview-img">
                    <br>
                    <p style="font-size: 0.9em; color: #666;">Se quiser trocar, selecione uma nova abaixo:</p>
                <?php else: ?>
                    <p>Sem imagem cadastrada.</p>
                <?php endif; ?>
                <input type="file" name="imagem_url" id="imagem_url" class="form-control">
            </div>
            <div class="botoes-acao">
                <a href="<?= BASE_URL ?>/public/index.php?page=listar_produtos" class="btn-cancelar">Cancelar</a>
                <button type="submit" class="btn-salvar">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>