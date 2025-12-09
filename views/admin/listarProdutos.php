<?php
$produtos = listarProdutos($conexao);
?>

<div class="container-conteudo-padrao">
    <div class="card-admin listagem">

        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h1>Produtos</h1>
            <a href="<?= BASE_URL ?>/public/index.php?page=inserir_produto" class="btn-salvar" style="font-size:14px;">+ Novo</a>
        </div>

        <table class="tabela-produtos">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td style="text-align: center;">
                            <?php
                            $nomeArquivo = $produto['imagem_url'] ?? null;

                            // Caminho relativo da pasta onde salvamos as fotos
                            // Ajuste se necessário, mas baseado no seu 'require', deve ser este:
                            $caminhoPasta = BASE_URL . '/public/images/products/';
                            $urlImagem = $caminhoPasta . $nomeArquivo;

                            if ($nomeArquivo && file_exists($urlImagem)) {
                                // Se tem nome no banco e o arquivo existe na pasta
                                echo "<img src='{$urlImagem}' alt='Foto' class='miniatura'>";
                            } elseif ($nomeArquivo) {
                                // Se tem nome no banco, mas o arquivo não foi achado (exibe caminho quebrado ou ícone)
                                echo "<img src='{$caminhoPasta}{$nomeArquivo}' alt='Erro img' class='miniatura'>";
                            } else {
                                // Se não tem nada no banco
                                echo "<span style='color: #999; font-size: 12px;'>Sem foto</span>";
                            }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($produto['nome'] ?? 'N/A'); ?></td>
                        <td>R$ <?= number_format($produto['valor'] ?? 0, 2, ',', '.'); ?></td>
                        <td><?= htmlspecialchars($produto['estoque'] ?? 0); ?></td>

                        <td>
                            <a href="<?= BASE_URL ?>/public/index.php?page=atualizar_produto&id=<?= $produto['id']; ?>" style="color:orange; font-weight:bold;">Editar</a> |
                            <a href="<?= BASE_URL ?>/public/index.php?page=excluir_produto&id=<?= $produto['id']; ?>" style="color:red; font-weight:bold;">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


    </div>
</div>
<script src="../admin/js/confirmar_exclusao.js"></script>