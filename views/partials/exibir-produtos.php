<?php

function exibirProdutos($conexao, $templatePath, $baseUrl, $filtroNomeOuCategoria = null)
{
    try {
       
        if ($filtroNomeOuCategoria) {
            if (is_numeric($filtroNomeOuCategoria)) {
                $sql = "SELECT * FROM produtos WHERE ativo = 1 AND categoria_id = :categoria ORDER BY nome ASC";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(":categoria", $filtroNomeOuCategoria, PDO::PARAM_INT);
            } else {
                $sql = "SELECT * FROM produtos WHERE ativo = 1 AND nome LIKE :nome ORDER BY nome ASC";
                $stmt = $conexao->prepare($sql);
                $like = "%" . $filtroNomeOuCategoria . "%";
                $stmt->bindParam(":nome", $like);
            }
        } else {
            $sql = "SELECT * FROM produtos WHERE ativo = 1 ORDER BY nome ASC";
            $stmt = $conexao->prepare($sql);
        }

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