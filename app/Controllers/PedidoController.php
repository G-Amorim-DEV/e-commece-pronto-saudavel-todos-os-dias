<?php
// app/Controllers/PedidoController.php

require_once __DIR__ . '/../models/PedidoModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class PedidoController {

    private $pedidoModel;
    private $userModel;

    public function __construct($db) {
        $this->pedidoModel = new PedidoModel($db);
        $this->userModel   = new UserModel($db);
    }

    public function listar() {

        if (!isset($_SESSION['user_id'])) {
            die("Acesso negado.");
        }

        $usuario_id = (int) $_SESSION['user_id'];
        $usuario = $this->userModel->findById($usuario_id);

        if (!$usuario) {
            die("Erro: usuário não encontrado.");
        }

        $isAdmin = isset($usuario['tipo_usuario']) && $usuario['tipo_usuario'] === 'admin';

        return $this->pedidoModel->listarComItens($usuario_id, $isAdmin);
    }
}
