<?php

$nomeArquivo = trim($produto['imagem_url'] ?? $produto['foto'] ?? $produto['img'] ?? '');


$caminhoRelativoProjeto = parse_url($baseUrl, PHP_URL_PATH);
$caminhoRelativoProjeto = rtrim($caminhoRelativoProjeto ?? '', '/');


$pastaFisicaBase = $_SERVER['DOCUMENT_ROOT'] . $caminhoRelativoProjeto;
$caminhoArquivoNoServidor = $pastaFisicaBase . '/public/images/products/' . $nomeArquivo;


if (!empty($nomeArquivo) && file_exists($caminhoArquivoNoServidor)) {
     
    $nomeImagemCodificado = rawurlencode($nomeArquivo);

    $urlFinal = $caminhoRelativoProjeto . '/public/images/products/' . $nomeImagemCodificado;

} else {
    
    $urlFinal = $caminhoRelativoProjeto . '/public/images/sem-imagem.png';
}


$produto['imagem_url'] = str_replace('\\', '/', $urlFinal);

?>

<article class="product-card">
 
    <a href="<?= $baseUrl ?>/public/index.php?page=productDetails&id=<?= $produto['id'] ?>">
       
        <figure class="product-card__figure">
            <img
                class="product-card__image"
                src="<?= $produto['imagem_url'] ?>" 
                alt="<?= htmlspecialchars($produto['nome']) ?>">
        </figure>
 
        <div class="product-card__content">
            <div class="product-card__tags">
                <span class="tag-item">CONTÉM GLÚTEN</span>
                <span class="tag-item">CONTÉM LACTOSE</span>
            </div>
 
            <div class="product-card__nutrition">
                <div class="nutrition-item"><strong>444</strong><span>KCAL</span></div>
                <div class="nutrition-item"><strong>56</strong><span>PROT.</span></div>
                <div class="nutrition-item"><strong>120</strong><span>CARB.</span></div>
                <div class="nutrition-item"><strong>17</strong><span>GORD.</span></div>
            </div>
           
            <h3 class="product-card__title">
                <?= htmlspecialchars($produto['nome']) ?>
            </h3>
 
            <p class="product-card__price preco-display">
                R$ <?= number_format($produto['valor'] * 5, 2, ',', '.') ?>
            </p>
        </div>
    </a>
 
    <div class="product-card__actions" data-preco-unitario="<?= $produto['valor'] ?>">
        <form action="<?= $baseUrl ?>/public/index.php" method="POST">
            <input type="hidden" name="action" value="gerenciar_carrinho">
            <input type="hidden" name="acao_carrinho" value="adicionar">
            <input type="hidden" name="id_produto" value="<?= $produto['id'] ?>">
 
            <div class="quantity-selector">
                <button class="quantity-selector__button" type="button" onclick="atualizarPrecoCard(this, -5)">-</button>
                <input class="quantity-selector__input input-quantidade" type="number" name="quantidade" value="5" min="5" step="5" readonly>
                <button class="quantity-selector__button" type="button" onclick="atualizarPrecoCard(this, 5)">+</button>
            </div>
            <button type="submit" class="button button--primary">Adicionar</button>
        </form>
    </div>
 
    <script>
        if (typeof atualizarPrecoCard === 'undefined') {
            function atualizarPrecoCard(botao, delta) {
                const containerAcoes = botao.closest('.product-card__actions');
                const card = botao.closest('.product-card');
                const input = containerAcoes.querySelector('.input-quantidade');
                const displayPreco = card.querySelector('.product-card__price');
                let quantidade = parseInt(input.value);
                let precoUnitario = parseFloat(containerAcoes.getAttribute('data-preco-unitario'));
                let novaQuantidade = quantidade + delta;
                if (novaQuantidade < 5) novaQuantidade = 5;
                input.value = novaQuantidade;
                if (novaQuantidade >= 10) precoUnitario -= 2.00;
                let novoTotal = precoUnitario * novaQuantidade;
                displayPreco.innerText = novoTotal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            }
        }
    </script>
</article>