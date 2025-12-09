<?php
// views/pages/auth/nova_senha.php

$email = $_GET['email'] ?? '';
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailPost = $_POST['email'];
    $codigo = $_POST['codigo'];
    $novaSenha = $_POST['nova_senha'];
    
    $resultado = redefinirSenha($conexao, $emailPost, $codigo, $novaSenha);
    
    if ($resultado === true) {
        echo "<script>
                alert('Senha alterada com sucesso!');
                window.location.href = '" . BASE_URL . "/public/index.php?page=login';
              </script>";
        exit;
    } else {
        $mensagem = "<div class='mensagem erro'>$resultado</div>";
    }
}
?>

<div class="login-wrapper">
    <div class="login-container">
        <h2>Definir Nova Senha</h2>
        
        <?= $mensagem ?>
        
        <form method="post" class="form-login">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
            
            <div class="grupo-input">
                <label>Código Recebido:</label>
                <input type="text" name="codigo" class="input-login" required placeholder="Ex: 123456">
            </div>

            <div class="grupo-input">
                <label>Nova Senha:</label>
                <input type="password" name="nova_senha" class="input-login" required>
            </div>
            
            <div class="dosBotoes">
                <button type="submit" class="btn-entrar">Alterar Senha</button>
            </div>
        </form>
    </div>
</div>