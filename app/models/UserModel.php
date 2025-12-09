<?php
// app/models/UserModel.php

class UserModel
{
    private PDO $db;

    public function __construct(PDO $conn)
    {
        $this->db = $conn;
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Busca usuário por ID (inclui coluna tipo_usuario)
    public function findById(int $id): ?array
    {
        $sql = "SELECT id, nome, email, telefone, data_cadastro, tipo_usuario
                FROM usuario
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }


    /**
     * Buscar usuário por ID
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT id, nome, email, telefone, tipo_usuario
                FROM usuario
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Atualizar nome, email e telefone
     */
    public function updateBasicData(int $id, string $nome, string $email, string $telefone): bool
    {
        $sql = "UPDATE usuario
                SET nome = :nome,
                    email = :email,
                    telefone = :telefone
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':telefone', $telefone);

        return $stmt->execute();
    }

    /**
     * Atualizar senha
     */
    public function updatePassword(int $id, string $senhaHash): bool
    {
        $sql = "UPDATE usuario
                SET senha = :senha
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':senha', $senhaHash);

        return $stmt->execute();
    }

    /**
     * Verificar senha atual
     */
    public function verifyPassword(int $id, string $senhaDigitada): bool
    {
        $sql = "SELECT senha 
                FROM usuario
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !isset($user['senha'])) {
            return false;
        }

        return password_verify($senhaDigitada, $user['senha']);
    }
}
