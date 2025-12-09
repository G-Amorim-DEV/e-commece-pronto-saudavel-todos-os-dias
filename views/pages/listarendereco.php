<?php
require_once __DIR__ . '/../../app/Controllers/EnderecoController.php';
if (!isset($_SESSION['user_id'])) {
    die("Acesso negado.");
}
$controller = new EnderecoController();
$enderecos = $controller->listarEnderecos($_SESSION['user_id']);
?>

<style>
/* ===== CORREÇÃO EXCLUSIVA PARA LISTAR ENDEREÇOS ===== */
.meus-enderecos-wrapper .login-container {
    max-width: 900px !important;   /* aumenta o card */
    width: 100% !important;
    padding: 30px 40px !important;
    box-shadow: 5px 5px 20px rgba(0,0,0,0.25) !important;
}

/* Espaço entre elementos */
.meus-enderecos-wrapper h2 {
    margin-bottom: 25px !important;
}

/* Centralizar botão */
.meus-enderecos-wrapper .dosBotoes {
    margin-bottom: 20px;
}

/* ===== TABELA ===== */
.meus-enderecos-wrapper table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
}

/* Cabeçalho */
.meus-enderecos-wrapper table th {
    background: #f4f4f4;
    padding: 12px;
    font-weight: 700;
    color: #333;
    text-align: left;
    border-bottom: 2px solid #ddd;
}

/* Células */
.meus-enderecos-wrapper table td {
    padding: 10px 12px;
    border-bottom: 1px solid #eee;
    font-size: 0.95rem;
}

/* Última linha sem borda inferior */
.meus-enderecos-wrapper table tr:last-child td {
    border-bottom: none;
}

/* Links de ação */
.meus-enderecos-wrapper table td a {
    margin-right: 15px;
    font-weight: 600;
}

/* Efeito hover */
.meus-enderecos-wrapper table tr:hover {
    background: #f9f9f9;
}
</style>


<div class="login-wrapper meus-enderecos-wrapper">
    <div class="login-container">
        <h2>Meus Endereços</h2>
        <div class="dosBotoes">
            <a href="<?= BASE_URL ?>/public/index.php?page=novo_endereco" class="btn-entrar">+ Novo Endereço</a>
        </div>

        <?php if (empty($enderecos)) : ?>
            <p style="text-align:center; margin-top:20px;">Você ainda não cadastrou nenhum endereço.</p>
        <?php else : ?>
            <table cellpadding="10" style="border-collapse: collapse; text-align:center; border:1px solid #ccc;">
                <thead>
                    <tr style="background:#f0f0f0;">
                        <th>CEP</th>
                        <th>Rua</th>
                        <th>Número</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($enderecos as $end): ?>
                    <tr>
                        <td><?= htmlspecialchars($end['cep']) ?></td>
                        <td><?= htmlspecialchars($end['rua']) ?></td>
                        <td><?= htmlspecialchars($end['numero']) ?></td>
                        <td><?= htmlspecialchars($end['bairro']) ?></td>
                        <td><?= htmlspecialchars($end['cidade']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/public/index.php?page=editar_endereco&id=<?= $end['id'] ?>">Editar</a>
                            <a href="<?= BASE_URL ?>/public/index.php?page=deletar_endereco&id=<?= $end['id'] ?>"
                               onclick="return confirm('Excluir endereço?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
