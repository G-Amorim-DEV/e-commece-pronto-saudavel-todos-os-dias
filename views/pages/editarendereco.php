<?php
require_once __DIR__ . "/../../app/models/EnderecoModel.php";

if (!isset($_SESSION['user_id'])) {
    die("Acesso negado. Faça login.");
}

if (!isset($_GET['id'])) {
    die("ID do endereço não informado.");
}

$id = intval($_GET['id']);
$model = new EnderecoModel();
$endereco = $model->buscarPorId($id);

if (!$endereco) {
    die("Endereço não encontrado.");
}

if ($endereco['usuario_id'] != $_SESSION['user_id']) {
    die("Acesso negado.");
}
?>

<div class="login-wrapper">

    <div class="login-container">
        <h2>Editar Endereço</h2>

        <!-- MESMAS CLASSES DO novoendereco.php -->
        <form class="form-login form-endereco" method="post" action="<?= BASE_URL ?>/public/index.php?page=update_endereco">

            <input type="hidden" name="id" value="<?= $endereco['id'] ?>">
            <input type="hidden" name="usuario_id" value="<?= htmlspecialchars($_SESSION['user_id']) ?>">

            <div class="grupo-input">
                <label>CEP:</label>
                <input type="text" name="cep" id="cep" class="input-login"
                    maxlength="9" value="<?= htmlspecialchars($endereco['cep']) ?>" required>
            </div>

            <div class="grupo-input">
                <label>Rua:</label>
                <input type="text" name="rua" id="rua" class="input-login"
                    value="<?= htmlspecialchars($endereco['rua']) ?>" required>
            </div>

            <div class="grupo-input">
                <label>Número:</label>
                <input type="text" name="numero" id="numero" class="input-login"
                    value="<?= htmlspecialchars($endereco['numero']) ?>" required>
            </div>

            <div class="grupo-input">
                <label>Complemento:</label>
                <input type="text" name="complemento" id="complemento" class="input-login"
                    value="<?= htmlspecialchars($endereco['complemento']) ?>">
            </div>

            <div class="grupo-input">
                <label>Bairro:</label>
                <input type="text" name="bairro" id="bairro" class="input-login"
                    value="<?= htmlspecialchars($endereco['bairro']) ?>" required>
            </div>

            <div class="grupo-input">
                <label>Cidade:</label>
                <input type="text" name="cidade" id="cidade" class="input-login"
                    value="<?= htmlspecialchars($endereco['cidade']) ?>" required>
            </div>

            <div class="grupo-input">
                <label>Estado:</label>
                <input type="text" name="estado" id="estado" class="input-login"
                    maxlength="2" value="<?= htmlspecialchars($endereco['estado']) ?>" required>
            </div>

            <div class="grupo-input">
                <label>País:</label>
                <input type="text" name="pais" id="pais" class="input-login"
                    value="<?= htmlspecialchars($endereco['pais']) ?>" required>
            </div>

            <div class="dosBotoes">
                <button class="btn-entrar" id="btn-salvar" type="submit">Atualizar</button>
            </div>

        </form>
    </div>
</div>

<!-- MESMO SCRIPT DO novoendereco.php -->
<script>
// Máscara do CEP (00000-000)
document.getElementById('cep').addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '');
    if (v.length > 5) {
        v = v.replace(/(\d{5})(\d)/, "$1-$2");
    }
    this.value = v;
});

document.getElementById('cep').addEventListener('blur', async function () {

    let cep = this.value.replace(/\D/g, '');
    if (cep.length !== 8) {
        alert("CEP inválido!");
        return;
    }

    const btnSalvar = document.getElementById('btn-salvar');
    btnSalvar.disabled = true;
    btnSalvar.innerText = "Consultando CEP...";

    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();

        if (!data.erro) {
            document.getElementById('rua').value = data.logradouro || '';
            document.getElementById('bairro').value = data.bairro || '';
            document.getElementById('cidade').value = data.localidade || '';
            document.getElementById('estado').value = data.uf || '';
            document.getElementById('pais').value = "Brasil";
        } else {
            alert("CEP não encontrado!");
        }
    } catch (error) {
        alert("Erro ao consultar o ViaCEP. Tente novamente.");
    }

    btnSalvar.disabled = false;
    btnSalvar.innerText = "Atualizar";
});
</script>
