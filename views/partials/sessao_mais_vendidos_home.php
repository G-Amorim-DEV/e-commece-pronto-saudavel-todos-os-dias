<section class="section-carousel">

    <h2 class="section-carousel__title">Mais Vendidos</h2>

    <div class="carousel-container">
        
        <div class="carousel" id="mais-vendidos-carousel">
            <?php
            // --- CORREÇÃO 1: Vamos adicionar dados de verdade no array para testar ---
            $produtosMaisVendidos = [
                ['id' => 1, 'nome' => 'Marmita 1', 'preco' => 27.00, 'imagem_url' => $baseUrl . '/public/images/pg_home_images/marmita.jpeg'],
                ['id' => 2, 'nome' => 'Sopa 1', 'preco' => 19.00, 'imagem_url' => $baseUrl . '/public/images/pg_home_images/sopa.jpg'],
                ['id' => 3, 'nome' => 'Sobremesa 1', 'preco' => 15.00, 'imagem_url' => $baseUrl . '/public/images/pg_home_images/sobremesa.jpg'],
                ['id' => 4, 'nome' => 'Marmita 2', 'preco' => 27.00, 'imagem_url' => $baseUrl . '/public/images/pg_home_images/marmita.jpeg'],
                ['id' => 5, 'nome' => 'Sopa 2', 'preco' => 17.50, 'imagem_url' => $baseUrl . '/public/images/pg_home_images/sopa.jpg'],
                ['id' => 6, 'nome' => 'Sobremesa 2', 'preco' => 18.20, 'imagem_url' => $baseUrl . '/public/images/pg_home_images/sobremesa.jpg'],
                ['id' => 7, 'nome' => 'Marmita 3', 'preco' => 27.00, 'imagem_url' => $baseUrl . '/public/images/pg_home_images/marmita.jpeg'],
                ['id' => 8, 'nome' => 'Sopa 3', 'preco' => 17.50, 'imagem_url' => $baseUrl . '/public/images/pg_home_images/sopa.jpg'],
                ['id' => 9, 'nome' => 'Sobremesa 3', 'preco' => 18.20, 'imagem_url' => $baseUrl . '/public/images/pg_home_images/sobremesa.jpg']
            ];

            foreach ($produtosMaisVendidos as $produto):
                // --- CORREÇÃO 2: Usar o caminho correto com /../ ---
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