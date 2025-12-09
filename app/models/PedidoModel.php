<?php
// app/models/PedidoModel.php

class PedidoModel {

    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Lista pedidos com itens e dados do produto.
     * - $usuario_id: id do usuário (quando não admin)
     * - $isAdmin: se true, ignora filtro por usuário
     *
     * Retorna array de linhas (cada linha = um item do pedido).
     */
    public function listarComItens($usuario_id = null, $isAdmin = false)
    {
        $sql = "
            SELECT 
                p.id AS pedido_id,
                p.data_pedido,
                p.status,
                p.metodo_pagamento,
                p.data_entrega,
                p.observacoes,
                p.endereco_id,
                p.usuario_id,
                ip.produto_id,
                ip.quantidade,
                ip.valor_unitario,
                prod.nome AS produto_nome
            FROM pedido p
            LEFT JOIN item_pedido ip ON ip.pedido_id = p.id
            LEFT JOIN produtos prod ON prod.id = ip.produto_id
        ";

        if (!$isAdmin) {
            $sql .= " WHERE p.usuario_id = :usuario_id ";
        }

        // Ordena por pedido e depois pelo produto dentro do pedido
        $sql .= " ORDER BY p.id DESC, ip.produto_id ASC";

        $stmt = $this->db->prepare($sql);

        if (!$isAdmin) {
            $stmt->bindValue(":usuario_id", $usuario_id, PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
