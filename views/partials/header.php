<?php

?>
 
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap">

 
<!-- Desktop -->
<header id="desktop">
 
<!-- Pop-up da parte de entregas, para calculo de frete -->
 
    <div id="frete-popup" class="popup-frete">
        <div class="popup-content">
            <h3>Calcular Frete</h3>
            <p> Entregas e retiradas apenas aos sábados na Grande SP </p>
 
            <label for="cep-input">CEP</label>
            <input id="cep-input" type="text" placeholder="Digite seu CEP" maxlength="9">
 
            <button id="btn-calcular-frete">Calcular</button>
 
            <p id="resultado-frete"></p>
 
            <span id="close-popup">×</span>
        </div>
    </div>

    <!-- Começo do menu -->
    <div id="menu">
 
        <div id="logo_busca">
 
            <!-- Logo -->
            <a id="logo" href="<?= $baseUrl ?>/public/index.php?page=home"></a>
 
 
            <!-- Barra de pesquisa -->
            <form id="busca" action="<?= $baseUrl ?>/public/index.php" method="GET">
                <input type="hidden" name="page" value="produtos_buscados">

                <input type="search" name="busca" placeholder="Digite o produto que deseja aqui...">
            </form>
 
        </div>
 
        <!-- Icones -->
        <nav id="icons">
 
            <ul id="lista_icons">
 
                <li>
                    <a href="<?= $baseUrl ?>/public/index.php?page=personalChefe">
                        <div id="chefinho"></div>
                    </a>
                </li>
 
                <li>
                   <a href="#" id="entrega-area">
                        <div id="entrega" title="Entregas"></div>
                    </a>
                </li>
 
                <li>
                    <a href="<?= $baseUrl ?>/public/index.php?page=carrinho_de_compras">
                        <div id="compras"></div>
                    </a>
                </li>
 
                <li>
 
                    <?php if ($usuario_logado): ?>
 
                        <a id="nome_logado" href="<?= $baseUrl ?>/public/index.php?page=dashboard_cliente">Olá, <?= htmlspecialchars($nome_usuario) ?></a>
                        <a id="sair" href="<?= $baseUrl ?>/public/index.php?page=logout">Sair</a>
 
                    <?php else: ?>
                        <a href="<?= $baseUrl ?>/public/index.php?page=login">
                            <div id="usuario"></div>
                        </a>
                    <?php endif; ?>
 
                </li>
 
            </ul>
 
        </nav>
 
        <!-- Fim do menu -->
    </div>
 
    <!-- Navegador -->
    <nav id="nav">
 
        <ul id="lista_nav">
 
            <li><a href="<?= $baseUrl ?>/public/index.php?page=home">Inicio</a></li>
            <li><a href="<?= $baseUrl ?>/public/index.php?page=personalChefe">Personal Chefe</a></li>
            <li class="marmitaSubmenu">
               <a href="<?= $baseUrl ?>/public/index.php?page=marmitas">Marmitas</a>
 
                <ul class="submenuMarmita">
                    <li><a href="<?= $baseUrl ?>/public/index.php?page=fitness">Fitness</a></li>
                    <li><a href="<?= $baseUrl ?>/public/index.php?page=lowcarb">Low Carb</a></li>
                    <li><a href="<?= $baseUrl ?>/public/index.php?page=vegana">Vegana</a></li>
                </ul>
 
 
            </li>
            <li class="produtosSubmenu">
                <a href="<?= $baseUrl ?>/public/index.php?page=outros">Outros Produtos</a>
 
                <ul class="submenuProdutos">
                    <li><a href="<?= $baseUrl ?>/public/index.php?page=caldo">Caldos</a></li>
                    <li><a href="<?= $baseUrl ?>/public/index.php?page=tempero">Temperos</a></li>
                    <li><a href="<?= $baseUrl ?>/public/index.php?page=torta">Tortas</a></li>
                    <li><a href="<?= $baseUrl ?>/public/index.php?page=sopa">Sopas</a></li>
                    <li><a href="<?= $baseUrl ?>/public/index.php?page=sobremesa">Sobremesas</a></li>
                    <li><a href="<?= $baseUrl ?>/public/index.php?page=suco">Sucos</a></li>
                </ul>
            </li>
            <li><a href="<?= $baseUrl ?>/public/index.php?page=about">Quem Somos</a></li>
 
        </ul>
 
    </nav>
 
</header>
 
 
<!-- Mobile -->
<header id="mobile">
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
 
    <div id="menu">
 
        <div id="logo_busca">
 
            <!-- Logo -->
            <a id="logo" href="<?= $baseUrl ?>/public/index.php?page=home"></a>
 
            <!-- Barra de pesquisa -->
            <form id="busca" action="<?= $baseUrl ?>/public/index.php" method="GET">
                <input type="hidden" name="page" value="produtos_buscados">

                <input type="search" name="busca" placeholder="Digite o produto que deseja aqui...">
            </form>
 
        </div>
 
        <div id="hamburguer">
 
            <button class="hamburger-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" aria-label="Abrir menu">
 
                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 -960 960 960">
                    <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                </svg>
 
            </button>
 
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
 
                <div class="offcanvas-header">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
 
                <!-- Itens do menu -->
                <div class="offcanvas-body">
 
                    <ul class="lista_hamburguer">
 
 
 
                        <?php if ($usuario_logado): ?>
                            <a href="<?= $baseUrl ?>/public/index.php?page=dashboard_cliente"> <span id="nome_usuario_logado">Olá, <?= htmlspecialchars($nome_usuario) ?></span> </a>
                            <a href="<?= $baseUrl ?>/public/index.php?page=logout" class="btn">Sair</a>
                        <?php else: ?>
                            <li><a href="<?= $baseUrl ?>/public/index.php?page=login">Entrar</a></li>
                            <li><a href="<?= $baseUrl ?>/public/index.php?page=registrar">Cadastrar</a></li>
                        <?php endif; ?>
 
                    </ul>
                    <hr>
                    <ul class="lista_hamburguer">
 
                        <li><a href="<?= $baseUrl ?>/public/index.php?page=home">Inicio</a></li>
                        <li><a href="<?= $baseUrl ?>/public/index.php?page=personalChefe">Personal Chefe</a></li>
                        <li><a href="">Entregas</a></li>
                        <li><a href="<?= $baseUrl ?>/public/index.php?page=carrinho_de_compras">Carrinho de Compras</a></li>
                        <a href="<?= $baseUrl ?>/public/index.php?page=marmitas">Marmitas</a>
                        <a href="<?= $baseUrl ?>/public/index.php?page=outros">Outros Produtos</a>

                        <li><a href="<?= $baseUrl ?>/public/index.php?page=about">Quem Somos</a></li>
 
                    </ul>
 
                </div>
 
            </div>
 
        </div>
 
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
 
    <script>

        const entregaIcon = document.getElementById("entrega");
        const popup = document.getElementById("frete-popup");
        const closePopup = document.getElementById("close-popup");
    
        entregaIcon.addEventListener("click", () => {
            popup.style.display = "flex";
        });
    
        closePopup.addEventListener("click", () => {
            popup.style.display = "none";
        });
    
        // Fechar ao clicar fora do card
        popup.addEventListener("click", (e) => {
            if (e.target === popup) popup.style.display = "none";
        });

    </script>

</header>
   