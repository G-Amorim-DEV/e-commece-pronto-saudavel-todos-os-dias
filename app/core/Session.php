<?php
//para usar o $conexao
require_once 'DataBaseConecta.php';

//Cria uma sessão ou retorna se já estiver uma.
//session_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Função Para verificar se o usuário esta logado, se não tiver ele volta para a página de login
function verificaLogin() {
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit;
    }
}

// Verifica se já esta com uma sessão ativa, apenas na página de login, se já estiver vai para a página de logado que depois será um dashboard. 
function verificaLoginPaginaLogin(){
    if (isset($_SESSION["user_id"])) {
    header("Location: logado.php");
    exit;
}
}


//Só retorna o nome do usuário, para mostrar o nome do cliente dinamicamente.
function usuarioNome() {
    return $_SESSION["user_nome"] ?? 'Usuário';
}

//Destroi a sessão atual.
function logout() {
    // 1. Limpa e destrói a sessão no servidor
    session_unset();
    session_destroy();

    // 2. Define o URL de destino
    //$url_destino = "/e-commece-pronto-saudavel-todos-os-dias/public/index.php?page=home";

    // 3. Imprime o script JavaScript para o alert e redirecionamento
    // O JS usa 'window.location.href' para redirecionar após o alert ser fechado.
    echo "<script>";
    // Usa '\n' para a quebra de linha dentro do alert
    echo "alert('Você deslogou com sucesso\\nObrigado e volte sempre!');";
    // Redireciona o navegador
    //echo "window.location.href = '{$url_destino}';";
    echo "</script>";
    
    header("Location: " . BASE_URL . "/public/index.php?page=home");
    exit();
}

function verificaAdmin() {
    verificaLogin(); // Primeiro, verifica se o usuário está logado
    
    // Verifica o nível de acesso (ajuste TIPO_ADMIN se necessário)
    if ($_SESSION["user_tipo"] !== "admin") {
        // Redireciona para uma página de erro ou a página inicial
        header("Location: logado.php"); // Ou 'acesso_negado.php'
        exit;
    }
}


