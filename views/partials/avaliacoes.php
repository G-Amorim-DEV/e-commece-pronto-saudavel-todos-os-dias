<!--
    ESTRUTURA BASE PARA AS AVALIAÇÕES (se tiver mais né)
 
        <article class="artigo_avaliacao"> -> O card da avaliação
            <div class="avaliacao_header"> -> Aonde vai ter a foto/nome do caba
                <div class="avatar"></div> -> ícone de usuario (não é imagem, é só um quadrado que virou circulo e ficou cinza)
                <span class="nome_usuario">Nome do Usuario aqui</span> -> Nome do caba
            </div>
 
            <p> Texto aqui </p> -> Crítica que o caba deu
 
            <div class="avaliacao_estrelas"> estrelas (★★★★★) <span> nota </span> </div> -> Nota que o caba deu
 
        </article>
-->
 
    <section class="sessao_avaliacoes">
        <h2>Avaliacões</h2>
 
        <div class="carrossel">
            <button class="btn_voltar" aria-label="Voltar avaliação">&lt;</button>
 
            <div class="carrossel_avaliacoes">
 
                <article class="artigo_avaliacao">
 
                    <div class="avaliacao_header">
                        <div class="avatar"><img src="<?= BASE_URL ?>/public/images/icons/icone_usuario_avaliacoes.png" alt=""></div>
                        <span class="nome_usuario"> <b>Maria Flores</b> </span>
                    </div>
 
                    <p>A comida é de verdade, com aquele gostinho caseiro que faz toda a diferença na hora do almoço.</p>
 
                    <div class="avaliacao_estrelas"> ★★★★★ <span> 5.0 </span> </div>
 
                </article>
 
                <article class="artigo_avaliacao">
 
                    <div class="avaliacao_header">
                        <div class="avatar"><img src="<?= BASE_URL ?>/public/images/icons/icone_usuario_avaliacoes.png" alt=""></div>
                        <span class="nome_usuario"> <b>Julio Tavares</b> </span>
                    </div>
 
                    <p>Pra quem busca praticidade sem perder a qualidade, eu super recomendo!</p>
 
                    <div class="avaliacao_estrelas"> ★★★★★ <span> 5.0 </span> </div>
 
                </article>
 
                <article class="artigo_avaliacao">
 
                    <div class="avaliacao_header">
                        <div class="avatar"><img src="<?= BASE_URL ?>/public/images/icons/icone_usuario_avaliacoes.png" alt=""></div>
                        <span class="nome_usuario"> <b>João Victor</b> </span>
                    </div>
 
                    <p>Ter uma refeição completa e saborosa esperando por você é o melhor investimento no meu dia a dia.</p>
 
                    <div class="avaliacao_estrelas"> ★★★★★ <span>5.0</span> </div>
 
                </article>
 
                <article class="artigo_avaliacao">
 
                    <div class="avaliacao_header">
                        <div class="avatar"><img src="<?= BASE_URL ?>/public/images/icons/icone_usuario_avaliacoes.png" alt=""></div>
                        <span class="nome_usuario"> <b>Pedro</b> </span>
                    </div>
 
                    <p> Ter uma refeição completa, balanceada e deliciosa.</p>
                   
                    <div class="avaliacao_estrelas">★★★★☆ <span>4.0</span></div>
 
                </article>
 
                <article class="artigo_avaliacao">
 
                    <div class="avaliacao_header">
                        <div class="avatar"><img src="<?= BASE_URL ?>/public/images/icons/icone_usuario_avaliacoes.png" alt=""></div>
                        <span class="nome_usuario"> <b>Fernanda</b> </span>
                    </div>
 
                    <p> Ter uma refeição completa, balanceada e deliciosa.</p>
 
                    <div class="avaliacao_estrelas"> ★★★★★ <span>5.0</span></div>
 
                </article>
 
                <article class="artigo_avaliacao">
 
                    <div class="avaliacao_header">
                        <div class="avatar"><img src="<?= BASE_URL ?>/public/images/icons/icone_usuario_avaliacoes.png" alt=""></div>
                        <span class="nome_usuario"> <b>Luisa</b> </span>
                    </div>
 
                    <p> Ter uma refeição completa, balanceada e deliciosa.</p>
 
                    <div class="avaliacao_estrelas"> ★★★☆☆ <span>3.0</span></div>
 
                </article>
 
            </div>
 
            <button class="btn_avancar" aria-label="Proxima avaliação">&gt;</button>
 
        </div>
    </section>