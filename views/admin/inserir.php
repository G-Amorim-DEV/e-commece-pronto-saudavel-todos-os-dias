<?php
/*     require_once '../../app/core/Session.php';
    require_once '../../app/Controllers/Admin/ProductAdminController.php';
    require_once '../../app/core/DataBaseConecta.php'; */

// verificaAdmin();
$erro = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $nome = trim(filter_var($_POST['nome'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS));
        $descricao = trim(filter_var($_POST['descricao'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS));
        $valor = filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT);
        $estoque = filter_input(INPUT_POST, 'estoque', FILTER_VALIDATE_INT);

        // --- PARTE DO UPLOAD ---
        $caminhoImagem = ''; // Valor padrão caso não tenha imagem ou falhe

        if (isset($_FILES['imagem_url'])) {
            // Chama a função que criamos no controller
            // Ela vai retornar o texto (caminho) para salvar no banco
            $caminhoImagem = fazerUploadImagem($_FILES['imagem_url']);
        }
        // -----------------------

        // Agora passamos o $caminhoImagem (que é uma string) para a função
        $resultado = cadastrarProduto($conexao, $nome, $descricao, $valor, $estoque, $caminhoImagem);

        // Se a função cadastrarProduto retornar uma string, é erro (conforme sua lógica original)
        if (is_string($resultado)) {
            $erro = $resultado;
        } else {
            header("Location: " . BASE_URL . "/public/index.php?page=listar_produtos");
            exit();
        }
    } catch (Exception $e) {
        $erro = "Erro: " . $e->getMessage();
    }
}
?>

<div class="container-conteudo-padrao">
    <div class="card-admin formulario">
        <?php if ($erro): ?>
            <p style="color: red;"><?php echo $erro; ?></p>
        <?php endif; ?>
        <h1>Novo produto</h1>
        <form action="" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" required placeholder="Ex: Marmita Fitness">
            </div>

            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea name="descricao" id="descricao" rows="4" class="form-control" placeholder="Detalhes do prato..."></textarea>
            </div>

            <div class="form-group">
                <label for="valor">Preço (R$):</label>
                <input type="number" name="valor" id="valor" class="form-control" step="0.01" min="0" required>
            </div>

            <div class="form-group">
                <label for="estoque">Quantidade:</label>
                <input type="number" name="estoque" id="estoque" class="form-control" min="0" required>
            </div>

            <div class="form-group">
                <label for="imagem_url">Imagem do Produto:</label>
                <input type="file" name="imagem_url" id="imagem_url" class="form-control" style="padding: 10px;">
            </div>

            <div class="botoes-acao">
                <a href="<?= BASE_URL ?>/public/index.php?page=listar_produtos" class="btn-cancelar">Cancelar</a>
                <button type="submit" class="btn-salvar">Salvar Produto</button>
            </div>

        </form>
    </div>
</div>