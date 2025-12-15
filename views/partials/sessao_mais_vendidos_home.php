<?php
      require_once __DIR__ . '/../../app/core/DataBaseConecta.php';

        // Sobe 2 níveis para chegar na raiz e entra em 'controllers/Admin'
        // Note que sua pasta se chama 'controllers', não 'app'
      require_once __DIR__ . '/../../app/controllers/Admin/ProductAdminController.php';

      $produtosDetaques =  listarProdutosDestaque($conexao, 9);
?>


<section class="section-carousel">

    <h2 class="section-carousel__title">Mais Vendidos</h2>

    <div class="carousel-container">
        
        <div class="carousel" id="mais-vendidos-carousel">
            <?php

            foreach ($produtosDetaques as $produto):
               
                require __DIR__ . '/../partials/produto-card.php'; 
            endforeach;
            ?>
        </div>

        <button class="carousel-button carousel-button--prev" id="mais-vendidos-prev" aria-label="Anterior">
            &#10094;
        </button>
        <button class="carousel-button carousel-button--next" id="mais-vendidos-next" aria-label="Próximo">
            &#10095;
        </button>
    </div>

</section>