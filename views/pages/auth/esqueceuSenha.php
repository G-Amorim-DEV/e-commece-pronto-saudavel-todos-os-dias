<?php
    //require_once __DIR__ . '/../../../app/core/DataBaseConecta.php'; 
    //require_once __DIR__ . '/../../../app/models/User.php';
    //verificaLoginPaginaLogin();

    if (function_exists('verificaLoginPaginaLogin')) {
        verificaLoginPaginaLogin();
    }

    $erro = "";
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = trim($_POST["email"] ?? '');
        $senha = trim($_POST["senha"] ?? '');
        if (empty($email) || empty($senha)) {
            echo "<script>alert('Por favor, preencha todos os campos: e-mail e senha!'); window.history.back();</script>";
            exit;
        } else {
            $podeLogar = realizarLogin($conexao, $email, $senha);
            if ($podeLogar === true) {
                header("Location: " . BASE_URL . "/public/index.php?page=dashboard_cliente");
                exit;
            } else {
                $erro = $podeLogar;
            }
        }
    }

?>
<!-- Criei este ID "login-wrapper" para simular o que o body fazia antes -->
<div class="login-wrapper">
    
    <!-- Mudei de "container" para "login-container" para não brigar com o Bootstrap -->
    <div class="login-container">

        <div class="topo">
            <!-- Botão de voltar (mantive a lógica, só ajustei classe se precisar) -->
             <a href="<?= BASE_URL ?>/public/index.php" class="bt-voltar">↩</a>
        </div>

        <h2>Login</h2>

        <form action="<?= BASE_URL ?>/public/index.php?page=login" method="post" class="form-login">
            
            <?php if (!empty($erro)): ?>
                <div class="mensagem erro"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <div class="grupo-input">
                <label for="email">E-mail:</label>
                <input type="text" name="email" id="email" class="input-login">
            </div>

            <div class="grupo-input">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" class="input-login">
            </div>

            <div class="dosBotoes">
                <!-- Adicionei a classe btn-entrar -->
                <button type="submit" class="btn-entrar">Entrar</button>

                <!-- Atualizei o link para o padrão de rotas -->
                <a href="<?= BASE_URL ?>/public/index.php?page=registrar" class="bt-cadastrar">Cadastrar</a>
            </div>

        </form>
    </div>
</div>