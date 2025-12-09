<?php
require_once __DIR__ . '/../models/EnderecoModel.php';

class EnderecoController
{
    private $model;

    public function __construct()
    {
        $this->model = new EnderecoModel();
    }

    public function listarEnderecos($usuarioId)
    {
        return $this->model->buscarPorUsuario($usuarioId);
    }

    public function criarEndereco()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/public/index.php?page=enderecos");
            exit;
        }

        $data = [
            "usuario_id"  => $_POST["usuario_id"],
            "cep"         => $_POST["cep"],
            "rua"         => $_POST["rua"],
            "numero"      => $_POST["numero"],
            "complemento" => $_POST["complemento"],
            "bairro"      => $_POST["bairro"],
            "cidade"      => $_POST["cidade"],
            "estado"      => $_POST["estado"],
            "pais"        => $_POST["pais"]
        ];

        $this->model->criar($data);

        header("Location: " . BASE_URL . "/public/index.php?page=enderecos");
        exit;
    }

    public function buscarEndereco($id)
    {
        return $this->model->buscarPorId($id);
    }

    public function atualizarEndereco()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/public/index.php?page=enderecos");
            exit;
        }

        $data = [
            "id"          => $_POST["id"],
            "cep"         => $_POST["cep"],
            "rua"         => $_POST["rua"],
            "numero"      => $_POST["numero"],
            "complemento" => $_POST["complemento"],
            "bairro"      => $_POST["bairro"],
            "cidade"      => $_POST["cidade"],
            "estado"      => $_POST["estado"],
            "pais"        => $_POST["pais"]
        ];

        $this->model->atualizar($data);

        header("Location: " . BASE_URL . "/public/index.php?page=enderecos");
        exit;
    }

    public function excluirEndereco()
    {
        if (!isset($_GET["id"])) {
            header("Location: " . BASE_URL . "/public/index.php?page=enderecos");
            exit;
        }

        $this->model->excluir($_GET["id"]);

        header("Location: " . BASE_URL . "/public/index.php?page=enderecos");
        exit;
    }
}
