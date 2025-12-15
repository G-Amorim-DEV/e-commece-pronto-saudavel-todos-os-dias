<?php
// public/index.php

session_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/core/DataBaseConecta.php';
require_once __DIR__ . '/../app/core/Session.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/UserModel.php';
require_once __DIR__ . '/../app/Controllers/EnderecoController.php';
require_once __DIR__ . '/../app/Controllers/PedidoController.php';

    $baseUrl = BASE_URL;

ob_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Caminho padrão das views
define('VIEWS_PATH', __DIR__ . '/../views');

// URL base
$baseUrl = BASE_URL;

// Dados do usuário logado
$usuario_logado = isset($_SESSION['user_nome']);
$nome_usuario = $usuario_logado ? $_SESSION["user_nome"] : '';
$ehAdmin = $usuario_logado && ($_SESSION["user_tipo"] ?? '') === 'admin';

// Tratamento para ações via POST
$action = $_POST['action'] ?? null;
if ($action === 'gerenciar_carrinho') {
    require_once VIEWS_PATH . '/partials/gerenciar-carrinho.php';
    exit;
}

// Página sendo acessada
$page = $_GET['page'] ?? 'home';

// Lista de páginas
$allowedPages = [
    'home'                => VIEWS_PATH . '/pages/home.php',
    'marmitas'            => VIEWS_PATH . '/pages/produtos-marmitas.php',
    'caldo'               => VIEWS_PATH . '/pages/produtos-caldo.php',
    'fitness'             => VIEWS_PATH . '/pages/produtos-fitness.php',
    'lowcarb'             => VIEWS_PATH . '/pages/produtos-lowcarb.php',
    'outros'              => VIEWS_PATH . '/pages/produtos-outros.php',
    'sobremesa'           => VIEWS_PATH . '/pages/produtos-sobremesa.php',
    'sopa'                => VIEWS_PATH . '/pages/produtos-sopa.php',
    'suco'                => VIEWS_PATH . '/pages/produtos-suco.php',
    'tempero'             => VIEWS_PATH . '/pages/produtos-tempero.php',
    'torta'               => VIEWS_PATH . '/pages/produtos-torta.php',
    'vegana'              => VIEWS_PATH . '/pages/produtos-vegana.php',

    'carrinho_de_compras' => VIEWS_PATH . '/pages/carrinho_de_compras.php',
    'productDetails'      => VIEWS_PATH . '/pages/productDetails.php',
    'personalChefe'       => VIEWS_PATH . '/pages/personal_chefe.php',
    'about'               => VIEWS_PATH . '/pages/about.php',
    'pedidos'             => VIEWS_PATH . '/pages/pedidos.php',

    // Autenticação
    'dashboard_cliente'   => VIEWS_PATH . '/pages/auth/logado.php',
    'login'               => VIEWS_PATH . '/pages/auth/login.php',
    'registrar'           => VIEWS_PATH . '/pages/auth/register.php',
    'editar_perfil'       => VIEWS_PATH . '/pages/auth/editar_perfil.php',

    // Endereços
    'enderecos'           => VIEWS_PATH . '/pages/listarendereco.php',
    'novo_endereco'       => VIEWS_PATH . '/pages/novoendereco.php',
    'editar_endereco'     => VIEWS_PATH . '/pages/editarendereco.php',

    // Admin
    'painel_adm'          => VIEWS_PATH . '/admin/administracaoPainel.php',
    'listar_produtos'     => VIEWS_PATH . '/admin/listarProdutos.php',
    'inserir_produto'     => VIEWS_PATH . '/admin/inserir.php',
    'atualizar_produto'   => VIEWS_PATH . '/admin/atualizarProdutos.php',
    'excluir_produto'     => VIEWS_PATH . '/admin/excluirProdutos.php',
];

// Páginas que exigem login
$paginasProtegidas = ['dashboard_cliente', 'editar_perfil', 'enderecos', 'novo_endereco', 'editar_endereco',  'pedidos'];

// Páginas visíveis apenas para visitantes
$paginasGuest = ['login', 'registrar'];

// Páginas exclusivas de admin
$paginasAdmin = ['painel_adm', 'listar_produtos', 'inserir_produto', 'atualizar_produto', 'excluir_produto'];


// =======================================================================
//  PROTEÇÃO DE ROTAS
// =======================================================================

// Usuário precisa estar logado
if (in_array($page, $paginasProtegidas) && !$usuario_logado) {
    header("Location: $baseUrl/public/index.php?page=login");
    exit;
}

// Se já está logado, não pode ir para login/registrar
if (in_array($page, $paginasGuest) && $usuario_logado) {
    header("Location: $baseUrl/public/index.php?page=dashboard_cliente");
    exit;
}

// Área do admin
if (in_array($page, $paginasAdmin) && !$ehAdmin) {
    header("Location: " . ($usuario_logado
        ? "$baseUrl/public/index.php?page=dashboard_cliente"
        : "$baseUrl/public/index.php?page=login"));
    exit;
}


// =======================================================================
//  AÇÕES DE ENDEREÇO (POST)
// =======================================================================

if ($page === 'salvar_endereco') {
    $controller = new EnderecoController();
    $controller->criarEndereco();
    exit;
}

if ($page === 'update_endereco') {
    $controller = new EnderecoController();
    $controller->atualizarEndereco();
    exit;
}

if ($page === 'deletar_endereco') {
    $controller = new EnderecoController();
    $controller->excluirEndereco();
    exit;
}

if ($page === 'salvar_edicao' || $page === 'salvar_senha') {
    require_once __DIR__ . '/../app/Controllers/AtualizarClienteController.php';
    exit;
}


// =======================================================================
//  CARREGAR A VIEW FINAL
// =======================================================================

$viewFile = $allowedPages[$page] ?? $allowedPages['home'];

// Layout principal
require_once VIEWS_PATH . '/layouts/main.php';

