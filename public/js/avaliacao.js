document.addEventListener('DOMContentLoaded', () => {
    // Seleção dos elementos do DOM com as suas classes
    const carrosselAvaliacoes = document.querySelector('.carrossel_avaliacoes');
    const btnVoltar = document.querySelector('.btn_voltar');
    const btnAvancar = document.querySelector('.btn_avancar');
    const artigosAvaliacao = document.querySelectorAll('.artigo_avaliacao');
    const totalCards = artigosAvaliacao.length;
    let currentIndex = 0; // Índice do primeiro card visível
 
    // **IMPORTANTE:** A largura da margem/gap entre os cards deve ser a mesma definida no seu CSS
    // Vou assumir que você definirá um espaçamento de 20px (o padrão de carrosséis modernos).
    const MARGIN_RIGHT = 20;
 
    // Função para calcular quantos cards devem ser movidos (e visualizados)
    const getCardsPerSlide = () => {
        // Se a largura da tela for menor ou igual a 768px (breakpoint comum para mobile)
        if (window.innerWidth <= 768) {
            return 1; // Mobile: move 1 card por vez
        }
        return 1; // Desktop: move 3 cards por vez
    };
 
    // Função para atualizar a posição do carrossel
    const updateCarousel = () => {
        if (totalCards === 0) return;
 
        // Largura total a ser rolada até o currentIndex
        let offset = 0;
       
        // Calculamos a soma das larguras dos cards anteriores (incluindo a margem)
        for (let i = 0; i < currentIndex; i++) {
            // Usa offsetWidth (largura do elemento) + a margem direita
            offset += artigosAvaliacao[i].offsetWidth + MARGIN_RIGHT;
        }
 
        // Aplica o deslocamento de rolagem horizontal suavemente
        carrosselAvaliacoes.scrollLeft = offset;
 
        // **Lógica para desabilitar os botões nas extremidades**
 
        // 1. Desabilita o botão VOLTAR no início
        btnVoltar.disabled = currentIndex === 0;
 
        // 2. Desabilita o botão AVANÇAR no fim
        const cardsVisiveis = getCardsPerSlide();
        // O limite é atingido quando o primeiro card visível é o 'totalCards - cardsVisiveis'
        btnAvancar.disabled = currentIndex >= totalCards - cardsVisiveis;
       
        // Se houver menos cards do que o número de slides por vez, desabilita os dois.
        if (totalCards <= cardsVisiveis) {
            btnVoltar.disabled = true;
            btnAvancar.disabled = true;
        }
    };
 
    // Evento do botão AVANÇAR
    btnAvancar.addEventListener('click', () => {
        const cardsPerSlide = getCardsPerSlide();
       
        // Calcula o novo índice, garantindo que não ultrapasse o limite
        currentIndex = Math.min(currentIndex + cardsPerSlide, totalCards - cardsPerSlide);
       
        updateCarousel();
    });
 
    // Evento do botão VOLTAR
    btnVoltar.addEventListener('click', () => {
        const cardsPerSlide = getCardsPerSlide();
        //efs
        // Calcula o novo índice, garantindo que não seja menor que zero
        currentIndex = Math.max(currentIndex - cardsPerSlide, 0);
       
        updateCarousel();
    });
 
    // Lida com o redimensionamento da janela (para mudar a lógica de 3 para 1 card)
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            // Ao redimensionar, volta para o início para recalcular a visualização corretamente
            currentIndex = 0;
            updateCarousel();
        }, 200); // Pequeno delay para evitar execuções excessivas
    });
   
    // Inicializa o carrossel na primeira posição e verifica o estado dos botões
    updateCarousel();
});