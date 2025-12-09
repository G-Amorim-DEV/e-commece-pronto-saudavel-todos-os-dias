<?php

// Função de Cadastro de Novos Usuarios
function cadastrar_usuario($conexao, $nome, $email, $senha, $telefone)
{

    // 1. Validação básica de campos obrigatórios
    if (empty($nome) || empty($email) || empty($senha)) {
        return "Preencha todos os campos obrigatórios.";
    }

    // 2. Validação do formato do email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Email inválido.";
    }

    // 3. MELHORIA: Validação do Telefone (se preenchido)
    if (!empty($telefone) && !ctype_digit(str_replace([' ', '(', ')', '-'], '', $telefone))) {
        return "Formato de telefone inválido. Use apenas números, parênteses e traços.";
    }

    // 4. MELHORIA: Criptografia da senha (Hashing) com trim()
    // Remove espaços em branco antes/depois da senha e usa o algoritmo padrão recomendado.
    $senha_hash = password_hash(trim($senha), PASSWORD_DEFAULT);

    // 5. Bloco Try-Catch para execução da query SQL e tratamento de erros
    try {
        // Define a query SQL de inserção (usa placeholders nomeados para segurança)
        $sql = "INSERT INTO usuario (nome, email, senha, telefone)
                VALUES (:nome, :email, :senha_hash, :telefone)"; //placeholder renomeado para clareza

        // Prepara a instrução SQL para execução (evita SQL Injection)
        $Statement = $conexao->prepare($sql); // Statement -> significa Instrução

        // Executa a instrução, passando os valores como um array associativo
        $Statement->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha_hash' => $senha_hash, // Salva a senha hasheada
            ':telefone' => $telefone
        ]);

        // Se a execução for bem-sucedida, retorna true
        return true;
    } catch (PDOException $e) {
        // Captura exceções geradas pelo PDO

        // Verifica se o erro é de violação de restrição única (código 23000)
        // Isso geralmente ocorre quando o email (que deve ser UNIQUE) já existe.
        if ($e->getCode() == 23000) {
            return "Erro: este email já está cadastrado.";
        } else {
            // error_log("Erro no cadastro de usuário: " . $e->getMessage(), 0);
            return "Erro ao realizar o cadastro. Tente novamente mais tarde.";
        }
    }
}

function realizarLogin($conexao, $email, $senha){
    try {
        //Consulta ao banco de dados, o prepare com :mail é importante para evitar SQL inject
        $stmt = $conexao->prepare("SELECT * FROM usuario WHERE email = :email LIMIT 1");
        //Executa o SQL acima
        $stmt->execute([":email" => $email]);
        //Retorna o resultado da consulta, o fetch especifica um array associativo com as informações do BD relacionados com o email. se não tiver o retorno é false.
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário existe e a senha está correta
        if ($user && password_verify($senha, $user["senha"])) {
            //Importante!!!  Isso faz gerar um novo id a cada sessão, isso impede o cliente de ter seus dados sequestrados por meio de roubo de cookies.
            session_regenerate_id(true);
            //Uma variavel global como um array, onde armazena os dados, quando tiver o adm tem que mudar aqui.
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_email"] = $user["email"];
            $_SESSION["user_nome"] = $user["nome"];
            $_SESSION["user_tipo"] = $user["tipo_usuario"];
            //Se tudo for bem sucedido, retorna um true para a função, vai ser usado para liberar o login.
            return true;
        } else {

            $mensagem = "Email ou senha inválidos!";
            echo "<script>alert('$mensagem'); window.history.back();</script>";
            exit; // Encerra o script PHP para garantir que nada mais seja processado

        }
        // caso falhe o try
    } catch (Exception $e) {

        $mensagem = "Erro ao tentar fazer login: " . $e->getMessage();
        echo "<script>alert('$mensagem'); window.history.back();</script>";
        exit; // Encerra o script PHP
    }
    }
    

    function solicitarRecuperacaoSenha($conexao, $email)
    {
        // Verifica se o email existe
        $sql = "SELECT id FROM usuario WHERE email = :email";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            return false; // Email não existe (por segurança, não avisamos que não existe na tela)
        }

        // Gera um código de 6 números
        $codigo = rand(100000, 999999);

        // Define validade para DAQUI A 15 MINUTOS
        // (Pega a hora atual do servidor e soma 15 min)
        $validade = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        // Salva no banco
        $sql = "UPDATE usuario SET reset_token = :token, reset_expires = :expires WHERE email = :email";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':token', $codigo);
        $stmt->bindValue(':expires', $validade);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $codigo; // Retorna o código para a gente "simular" o envio
    }

    // 2. Verifica o código e troca a senha
function redefinirSenha($conexao, $email, $codigo, $novaSenha)
{
    // 1. Verifica se o código é válido (Corrige tabela para 'usuario')
    $sql = "SELECT id FROM usuario 
            WHERE email = :email 
            AND reset_token = :token 
            AND reset_expires > NOW()";

    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':token', $codigo);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        
        // --- A CORREÇÃO ESTÁ AQUI ---
        // Criptografa a nova senha antes de salvar
        $senhaHash = password_hash(trim($novaSenha), PASSWORD_DEFAULT);

        // Atualiza a senha no banco (Corrige tabela para 'usuario')
        $sqlUrl = "UPDATE usuario SET senha = :senha, reset_token = NULL, reset_expires = NULL WHERE email = :email";
        
        $update = $conexao->prepare($sqlUrl);
        $update->bindValue(':senha', $senhaHash); // Agora salvamos o hash!
        $update->bindValue(':email', $email);
        $update->execute();

        return true;
    }

    return "Código inválido ou expirado.";
}