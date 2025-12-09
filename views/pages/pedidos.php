<?php
// views/pages/pedidos.php

global $conexao;
require_once __DIR__ . '/../../app/Controllers/PedidoController.php';

$controller = new PedidoController($conexao);
$rows = $controller->listar();

// Reorganiza linhas em pedidos, garantindo que cada pedido tenha seus itens corretos
$pedidos = [];
foreach ($rows as $r) {
    $pedidoId = $r['pedido_id'] ?? null;
    if ($pedidoId === null) continue;

    if (!isset($pedidos[$pedidoId])) {
        $pedidos[$pedidoId] = [
            'id' => $pedidoId,
            'data_pedido' => $r['data_pedido'] ?? '',
            'status' => $r['status'] ?? '',
            'metodo_pagamento' => $r['metodo_pagamento'] ?? '',
            'data_entrega' => $r['data_entrega'] ?? '',
            'observacoes' => $r['observacoes'] ?? '',
            'endereco_id' => $r['endereco_id'] ?? '',
            'usuario_id' => $r['usuario_id'] ?? '',
            'itens' => []
        ];
    }

    if (!empty($r['produto_id'])) {
        $pedidos[$pedidoId]['itens'][] = [
            'produto_id' => $r['produto_id'],
            'produto_nome' => $r['produto_nome'] ?? 'Produto',
            'quantidade' => (int)($r['quantidade'] ?? 0),
            'valor_unitario' => (float)($r['valor_unitario'] ?? 0)
        ];
    }
}

// Reindexa array pelo pedido_id
$pedidos = array_values($pedidos);
?>

<style>
    .page-title {
        margin-top: 140px;
        margin-bottom: 20px;
        font-size: 1.8rem;
        color: #12602c;
    }
    .pedido-card {
        border: 1px solid #ccc;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .pedido-header {
        font-weight: 700;
        margin-bottom: 8px;
    }
    .pedido-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    .pedido-table th, .pedido-table td {
        border: 1px solid #ddd;
        padding: 8px;
    }
    .pedido-table th {
        text-align: left;
        background-color: #f5f5f5;
    }
    .pedido-table td.text-center {
        text-align: center;
    }
    .pedido-table td.text-right {
        text-align: right;
    }
    .pedido-total {
        text-align: right;
        margin-top: 10px;
        font-weight: 700;
    }
</style>

<h2 class="page-title">Meus Pedidos</h2>

<?php if (empty($pedidos)): ?>
    <p>Nenhum pedido encontrado.</p>
<?php else: ?>

<?php foreach ($pedidos as $pedido): ?>
    <div class="pedido-card">
        <div class="pedido-header">
            Pedido #<?= htmlspecialchars((string) $pedido['id']) ?>
        </div>

        <p><strong>Status:</strong> <?= htmlspecialchars((string) $pedido['status']) ?></p>
        <p><strong>Data Pedido:</strong> <?= htmlspecialchars((string) $pedido['data_pedido']) ?></p>
        <p><strong>Método Pagamento:</strong> <?= htmlspecialchars((string) $pedido['metodo_pagamento']) ?></p>
        <p><strong>Data Entrega:</strong> <?= htmlspecialchars((string) $pedido['data_entrega']) ?></p>
        <p><strong>Observações:</strong> <?= nl2br(htmlspecialchars((string) $pedido['observacoes'])) ?></p>

        <table class="pedido-table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th class="text-center">Qtd</th>
                    <th class="text-right">Valor</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $total = 0.0;
                if (!empty($pedido['itens'])):
                    foreach ($pedido['itens'] as $item):
                        $linhaTotal = $item['quantidade'] * $item['valor_unitario'];
                        $total += $linhaTotal;
            ?>
                <tr>
                    <td><?= htmlspecialchars((string) $item['produto_nome']) ?></td>
                    <td class="text-center"><?= (int) $item['quantidade'] ?></td>
                    <td class="text-right">R$ <?= number_format((float) $item['valor_unitario'], 2, ',', '.') ?></td>
                </tr>
            <?php
                    endforeach;
                else:
            ?>
                <tr>
                    <td colspan="3">Nenhum item cadastrado para este pedido.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <div class="pedido-total">
            Total: R$ <?= number_format($total, 2, ',', '.') ?>
        </div>
    </div>
<?php endforeach; ?>

<?php endif; ?>
