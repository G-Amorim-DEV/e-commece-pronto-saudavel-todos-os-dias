<?php

function exibirProdutosExcetoMarmitas($conexao, $templatePath, $baseUrl)
{
    try {

        $idCategoriaMarmitas = 7;

        $sql = "SELECT * FROM produtos
                WHERE ativo = 1
                AND categoria_id != :categoria_marmitas
                AND nome NOT LIKE '%marmita%'
                ORDER BY nome ASC";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':categoria_marmitas', $idCategoriaMarmitas, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            echo "<p>Nenhum produto encontrado.</p>";
            return;
        }

   
        while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
    
            include $templatePath;
        }

    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao buscar produtos: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}