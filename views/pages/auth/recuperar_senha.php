<?php
// views/pages/auth/recuperar_senha.php

// Importações do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Ajuste os caminhos conforme sua estrutura real
require __DIR__ . '/../../../vendor/autoload.php';
// Certifique-se que as constantes (SMTP_HOST, SMTP_USER, etc) estão definidas neste arquivo
require __DIR__ . '/../../../config/mailConfig.php'; 

$mensagemFeedback = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    
    // Tenta gerar o código
    $codigoGerado = solicitarRecuperacaoSenha($conexao, $email);

    // Lógica de Segurança:
    // Se o código foi gerado (email existe), enviamos o email.
    // Se NÃO foi gerado (email não existe), fingimos que enviamos para não revelar dados.
    
    if ($codigoGerado) {
        $mail = new PHPMailer(true);

        try {
            // --- CONFIGURAÇÕES DO SERVIDOR ---
            // IMPORTANTE: Desative o Debug em produção para não quebrar o JS
            $mail->SMTPDebug = SMTP::DEBUG_OFF; 
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;     
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS; // Lembre-se: Senha de App do Google
            $mail->SMTPSecure = 'tls'; // Para porta 465
            $mail->Port       = SMTP_PORT; // Geralmente 465 com ENCRYPTION_SMTPS

            // --- REMETENTE E DESTINATÁRIO ---
            // O Gmail força o "From" a ser o mesmo usuário autenticado, mas o nome pode mudar
            $mail->setFrom('prontoesaudavel18@gmail.com', 'Pronto e Saudavel'); 
            $mail->addAddress($email);

            // --- CONTEÚDO ---
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8'; // Garante acentuação correta
            $mail->Subject = 'Recuperação de Senha - Pronto Saudável';
            
            $body  = "Olá!<br><br>";
            $body .= "Recebemos uma solicitação para redefinir sua senha.<br>";
            $body .= "Seu código de verificação é: <b>" . $codigoGerado . "</b><br><br>";
            $body .= "Este código é válido por 15 minutos.";
            
            $mail->Body = $body;
            $mail->AltBody = strip_tags($body); // Versão texto puro para clientes antigos

            $mail->send();

            // SUCESSO REAL
            echo "<script>
                    alert('E-mail enviado com sucesso! Verifique sua caixa de entrada (e o Spam).');
                    window.location.href = '" . BASE_URL . "/public/index.php?page=nova_senha&email=$email';
                  </script>";
            exit;

        } catch (Exception $e) {
            // ERRO NO ENVIO (Problema no PHPMailer/Gmail)
            // O erro técnico fica no log, para o usuário mostramos mensagem amigável
            // Dica: No InfinityFree, portas SMTP as vezes são bloqueadas.
            $mensagemFeedback = "<div class='mensagem erro'>Erro ao enviar: O servidor de e-mail não respondeu. Tente mais tarde.</div>";
        }

    } else {
        // EMAIL NÃO EXISTE NO BANCO (Simulação de sucesso)
        echo "<script>
                alert('Se este e-mail estiver cadastrado, você receberá um código em instantes.');
                window.location.href = '" . BASE_URL . "/public/index.php?page=login';
              </script>";
        exit;
    }
}
?>
    



<div class="login-wrapper">
    <div class="login-container">
        <?= $mensagemFeedback ?>
        <div class="topo">
            <a href="<?= BASE_URL ?>/public/index.php?page=login" class="bt-voltar">↩</a>
        </div>
        <h2>Recuperar Senha</h2>
        <p style="text-align:center; font-size:0.9em; margin-bottom:15px;">
            Digite seu e-mail para receber o código de verificação.
        </p>
        
        <form method="post" class="form-login">
            <div class="grupo-input">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" class="input-login" required>
            </div>
            
            <div class="dosBotoes">
                <button type="submit" class="btn-entrar">Enviar Código</button>
            </div>
        </form>
    </div>
</div>







