<?php
require_once __DIR__ . '/../../app/core/DataBaseConecta.php';

class EnderecoModel
{
    private $db;

    public function __construct()
    {
        // Usa a conexão global criada pelo DataBaseConecta.php
        global $conexao;
        $this->db = $conexao;
    }

    public function buscarPorUsuario($usuarioId)
    {
        $sql = "SELECT * FROM endereco WHERE usuario_id = ?";
        $stm = $this->db->prepare($sql);
        $stm->execute([$usuarioId]);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM endereco WHERE id = ?";
        $stm = $this->db->prepare($sql);
        $stm->execute([$id]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function criar($data)
    {
        $sql = "INSERT INTO endereco
                (usuario_id, cep, rua, numero, complemento, bairro, cidade, estado, pais)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stm = $this->db->prepare($sql);
        return $stm->execute([
            $data["usuario_id"],
            $data["cep"],
            $data["rua"],
            $data["numero"],
            $data["complemento"],
            $data["bairro"],
            $data["cidade"],
            $data["estado"],
            $data["pais"]
        ]);
    }

    public function atualizar($data)
    {
        $sql = "UPDATE endereco SET 
                cep = ?, rua = ?, numero = ?, complemento = ?, bairro = ?, cidade = ?, estado = ?, pais = ?
                WHERE id = ?";

        $stm = $this->db->prepare($sql);
        return $stm->execute([
            $data["cep"],
            $data["rua"],
            $data["numero"],
            $data["complemento"],
            $data["bairro"],
            $data["cidade"],
            $data["estado"],
            $data["pais"],
            $data["id"]
        ]);
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM endereco WHERE id = ?";
        $stm = $this->db->prepare($sql);
        return $stm->execute([$id]);
    }
}
