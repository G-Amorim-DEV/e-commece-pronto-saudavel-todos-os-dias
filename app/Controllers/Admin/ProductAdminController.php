<?php
    function cadastrarProduto($conexao,$nome,$descricao,$valor,int $estoque,$imagem){
        if(empty($nome) || empty($valor)){
            return "Nome e Preço são obrigatórios.";
        }
        if(!is_numeric($valor)||$valor<=0){
            return "Preço deve ser um valor numérico positivo.";
        }
        if (!is_numeric($estoque)||$estoque<=0){
            return "Estoque deve ser um valor numérico não negativo.";
        }

        try{
            $sql = "INSERT INTO produtos(nome,descricao,valor,estoque,imagem_url) VALUES
                    (:nome, :descricao, :valor, :estoque, :imagem_url)";
            $consulta = $conexao->prepare($sql);
            $consulta->bindValue(":nome",$nome);
            $consulta->bindValue(":descricao",$descricao);
            $consulta->bindValue(":valor",$valor);
            $consulta->bindValue(":estoque",(int)$estoque, PDO::PARAM_INT);
            $consulta->bindValue(":imagem_url",$imagem);

            $consulta->execute();
        }catch(PDOException $e){
            return "Erro ao cadastra produto.";
        }
    }

    function fazerUploadImagem($arquivo): mixed {
        // 1. Validação básica (se não enviou nada, retorna null)
        if (!$arquivo || !isset($arquivo["tmp_name"]) || !is_uploaded_file($arquivo["tmp_name"])) {
            return null; 
        }

        // 2. Configuração do caminho (Ajuste Crítico aqui)
        // __DIR__ está em: app/Controllers/Admin
        // Voltamos 3 níveis para chegar na raiz do projeto: /../../..
        // E então entramos em: /public/images/products/
        $pastaDestino = __DIR__ . '/../../../public/images/products/'; 
        
        // Verifica se a pasta existe, se não, cria
        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0755, true);
        }

        // 3. Validações de segurança
        $formatosPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp'];
        $tamanhoMaximo = 2 * 1024 * 1024; // 2MB

        $formatoDoArquivoEnviado = mime_content_type($arquivo["tmp_name"]);

        if (!in_array($formatoDoArquivoEnviado, $formatosPermitidos)) {
            throw new Exception("Formato inválido. Apenas JPG, PNG, GIF, SVG e WEBP.");
        }

        if ($arquivo["size"] > $tamanhoMaximo) {
            throw new Exception("Arquivo muito grande. Máximo de 2MB.");
        }

        // 4. Gerar nome único
        $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        $novoNomeArquivo = uniqid() . "." . $extensao;

        $caminhoCompleto = $pastaDestino . $novoNomeArquivo;

        // 5. Mover o arquivo
        if (move_uploaded_file($arquivo["tmp_name"], $caminhoCompleto)) {
            
            // --- MUDANÇA AQUI ---
            // Retorna APENAS O NOME do arquivo para salvar no banco
            return $novoNomeArquivo; 

        } else {
            throw new Exception("Falha ao mover o arquivo. Verifique as permissões da pasta 'products'.");
        }
    }



function listarProdutos($conexao) {
    $sql = "SELECT * FROM produtos ORDER BY nome";

    /* Rxecutamos o comando e guardamos o resultado da consulta  */
    $consulta = $conexao -> query($sql);

    /* Retornamos o resultado em forma de array associativo */
    return $consulta->fetchAll();
}


function listarProdutosDestaque($conexao, $limite = 9) {
    // Ordenamos por ID decrescente para pegar os mais novos, ou RAND() para aleatórios
    // LIMIT limita a quantidade trazida
    $sql = "SELECT * FROM produtos ORDER BY id DESC LIMIT $limite";

    $consulta = $conexao->query($sql);

    // Retorna array associativo
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}


function atualizarProduto($conexao, $id, $nome, $descricao, $valor, int $estoque, $imagem) {
    if (empty($id)) {
        return "ID do produto é obrigatório para atualização.";
    }
    if (empty($nome) || empty($valor)) {
        return "Nome e Preço são obrigatórios.";
    }
    if (!is_numeric($valor) || $valor <= 0) {
        return "Preço deve ser um valor numérico positivo.";
    }
    if (!is_numeric($estoque) || $estoque < 0) {
        return "Estoque deve ser um valor numérico não negativo.";
    }

    try {
        // Busca a imagem atual para preservar ou apagar ela.
        $sqlImg = "SELECT imagem_url FROM produtos WHERE id = :id";
        $consultaImg = $conexao->prepare($sqlImg);
        $consultaImg->bindValue(":id", (int)$id, PDO::PARAM_INT);
        $consultaImg->execute();
        $produtoAtual = $consultaImg->fetch(PDO::FETCH_ASSOC);

        if(!$produtoAtual) return "Produto não encontrado.";
        // Por padrão a img é a mesma de antes.
        $nomeFinalImagem = $produtoAtual['imagem_url'];

        //Lógica para uma nova imagem

        if(isset($imagem) && is_array($imagem) && $imagem['error'] === 0){
            // Subimos a nova imagem
            $novaImg = fazerUploadImagem($imagem);
            if($novaImg){
                $nomeFinalImagem = $novaImg;
                //Apagamos a antiga
                if(!empty($produtoAtual['imagem_url'])){
                    $caminhoAntigo = __DIR__ . '/../../../public/images/products/' . $produtoAtual['imagem_url'];
                    if(file_exists($caminhoAntigo)){
                        unlink($caminhoAntigo);
                    }
                }
            }
        }



        $sql = "UPDATE produtos 
                SET nome = :nome, descricao = :descricao, valor = :valor, 
                    estoque = :estoque, imagem_url = :imagem_url
                WHERE id = :id";
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":id", (int)$id, PDO::PARAM_INT);
        $consulta->bindValue(":nome", $nome);
        $consulta->bindValue(":descricao", $descricao);
        $consulta->bindValue(":valor", $valor);
        $consulta->bindValue(":estoque", (int)$estoque, PDO::PARAM_INT);
        $consulta->bindValue(":imagem_url", $nomeFinalImagem);

        $consulta->execute();

        return "Produto atualizado com sucesso!";
    } catch (PDOException $e) {
        return "Erro ao atualizar produto.";
    }
}


function excluirProduto($conexao, $id) {
    if (empty($id)) {
        return "ID do produto é obrigatório para exclusão.";
    }

    try {
        // --- PASSO 1: Descobrir o nome da imagem antes de deletar ---
        $sqlImg = "SELECT imagem_url FROM produtos WHERE id = :id";
        $consultaImg = $conexao->prepare($sqlImg);
        $consultaImg->bindValue(":id", (int)$id, PDO::PARAM_INT);
        $consultaImg->execute();

        $selecionaImg = $consultaImg->fetch(PDO::FETCH_ASSOC);

        // --- PASSO 2: Se o produto existe e tem imagem, apaga o arquivo ---
        if($selecionaImg && !empty($selecionaImg['imagem_url'])){

            // Define o caminho completo até a pasta products
            $caminhoArquivo = __DIR__ . '/../../../public/images/products/' . $selecionaImg['imagem_url'];
            // Verifica se o arquivo existe fisicamente antes de tentar apagar
            if(file_exists($caminhoArquivo)){
                unlink($caminhoArquivo); // A função mágica que deleta o arquivo
            }
        }

        $sql = "DELETE FROM produtos WHERE id = :id";
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":id", (int)$id, PDO::PARAM_INT);
        $consulta->execute();

        if ($consulta->rowCount() > 0) {
            return "Produto excluído com sucesso!";
        } else {
            return "Produto não encontrado.";
        }
    } catch (PDOException $e) {
        return "Erro ao excluir produto.";
    }
}

function buscarProdutoPorId($conexao, $id) {
    if (empty($id) || !is_numeric($id)) {
        return null; // ID inválido
    }

    try {
        $sql = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();

        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        return $produto ?: null; // retorna null se não encontrar
    } catch (PDOException $e) {
        return null;
    }
}

    function buscarProdutos($conexao, string $termo): array {

        $termo = trim($termo);

        // Pesquisa no Nome OU na Descrição OU nas Palavras-Chave
        $sql = "SELECT * FROM produtos 
                WHERE nome LIKE :termo 
                OR descricao LIKE :termo 
                OR keywords LIKE :termo 
                AND ativo = 1";

        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":termo", "%". $termo ."%");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

?>
