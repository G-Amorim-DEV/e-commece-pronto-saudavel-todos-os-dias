<?php
// Cria uma variável com a URL base do seu projeto.
// Isso funciona mesmo que seu projeto não esteja na raiz do localhost.
$baseUrl = sprintf(
    "%s://%s%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['HTTP_HOST'],
    dirname($_SERVER['SCRIPT_NAME']) === DIRECTORY_SEPARATOR ? '' : dirname($_SERVER['SCRIPT_NAME'])
);

// Remove a pasta /public da URL base se ela existir, para apontar para a raiz correta
$baseUrl = rtrim(str_replace('/public', '', $baseUrl), '/');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pronto Saudável</title>

    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/home.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/produto_card.css">

    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/avaliacaoes.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/marmitas.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/carrinho-de-compras.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/marmita-compra.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/pg_personal_chefe.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/about.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/produtos_buscados.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/style.css">
   
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/header.css">

    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/dialog_login.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/footer.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/administracaoPainel.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/produtos-crud.css">
</head>
<body>

      <?php require_once VIEWS_PATH . '/partials/header.php'; ?>

   <main>
        <?php
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "<p>Erro: Página não encontrada.</p>";
        }
        ?>
    </main>

        <?php require_once VIEWS_PATH . '/partials/btn_flutuante.php'?>
        <?php require_once VIEWS_PATH . '/partials/footer.php' ?>

   


    <script src="<?= $baseUrl ?>/public/js/carrossel-produtos.js"></script>
    <script src="<?= $baseUrl ?>/public/js/avaliacao.js"></script>
     <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous">
    </script>
    
</body>
</html>