
    <section class="sessao_personal_chefe_home">

        <div class="cabecalho_personal_chefe">
            <h2>Personal Chefe</h2>
        </div>

        <div class="personal_chefe">
            <div class="bloco_esquerdo_imagem">

                <figure class="imagem_personal_chefe">
                    <img src="../public/images/pg_home_images/personal_chefe.png" alt="Imagem da Glaucia Personal Chefe">
                </figure>

            </div>

            <div class="bloco_direito_informacoes">

                    <div class="informacoes">
                        <p class="texto"><b>Um Personal Chef é um profissional da gastronomia que oferece um serviço de culinária totalmente personalizado, geralmente na casa do cliente ou em um local de evento privado.
                        Diferente do chef de restaurante, o Personal Chef atua de forma exclusiva, adaptando todo o menu aos gostos, necessidades dietéticas (como dietas específicas, restrições ou alergias) e objetivos nutricionais do contratante.</b></p>
                    </div>

                    <div class="botoes">

                        <div class="botoes_personal_chefe">
                           <h6 id="contador-animado">+ de <span data-target="1000">0</span> Marmitas Vendidas</h6>
                        </div>

                        <div class="botoes_personal_chefe">
                            <a href="<?= $baseUrl ?>/public/index.php?page=personalChefe">Contrate Personal Chefe</a>
                        </div>

                    </div>
                
            </div>
        </div>
        
    </section>

    <script>
        // 1. Seleciona o elemento que contém o número a ser animado
        const contadorElemento = document.querySelector('#contador-animado span');
        
        // 2. Pega o valor final (1000) do atributo data-target
        const valorFinal = parseInt(contadorElemento.getAttribute('data-target'));
        
        // 3. Define a duração da animação em milissegundos (ex: 2 segundos)
        const duracao = 80000;
        
        // 4. Calcula o "passo" (o tempo em milissegundos entre cada incremento)
        // Usamos 20ms para um efeito suave (50 frames por segundo)
        const passo = 50; 
        
        // 5. Calcula o valor que deve ser adicionado em cada passo
        // (Valor total / número de passos)
        const incremento = valorFinal / (duracao / passo);
        
        let valorAtual = 0; // Valor que começa em 0

        // Função que faz a contagem
        function contar() {
            // Se o valor atual for menor que o final, ele continua contando
            if (valorAtual < valorFinal) {
                // Adiciona o incremento (pode ser decimal, mas o parseInt arredonda)
                valorAtual = Math.min(valorAtual + incremento, valorFinal); 
                
                // Atualiza o texto, garantindo que seja um número inteiro
                contadorElemento.textContent = Math.ceil(valorAtual);
            } else {
                // Quando a contagem chega ao final, limpa o intervalo para parar
                clearInterval(intervalo);
            }
        }

        // Inicializa o contador chamando a função 'contar' a cada 20 milissegundos
        const intervalo = setInterval(contar, passo); 
    </script>
