<?php
if (!isset($_SESSION['user_id'])) {
    die("Acesso negado. Faça login para continuar.");
}
?>

<div class="login-wrapper">

    <div class="login-container">
        <h2>Novo Endereço</h2>

        <form class="form-login form-endereco" method="post" action="<?= BASE_URL ?>/public/index.php?page=salvar_endereco">

            <input type="hidden" name="usuario_id" value="<?= htmlspecialchars($_SESSION['user_id']) ?>">

            <div class="grupo-input">
                <label>CEP:</label>
                <input type="text" name="cep" id="cep" class="input-login" maxlength="9" placeholder="00000-000" required>
            </div>

            <div class="grupo-input">
                <label>Rua:</label>
                <input type="text" name="rua" id="rua" class="input-login" required>
            </div>

            <div class="grupo-input">
                <label>Número:</label>
                <input type="text" name="numero" id="numero" class="input-login" required>
            </div>

            <div class="grupo-input">
                <label>Complemento:</label>
                <input type="text" name="complemento" id="complemento" class="input-login">
            </div>

            <div class="grupo-input">
                <label>Bairro:</label>
                <input type="text" name="bairro" id="bairro" class="input-login" required>
            </div>

            <div class="grupo-input">
                <label>Cidade:</label>
                <input type="text" name="cidade" id="cidade" class="input-login" required>
            </div>

            <div class="grupo-input">
                <label>Estado:</label>
                <input type="text" name="estado" id="estado" class="input-login" required>
            </div>

            <div class="grupo-input">
                <label>País:</label>
                <input type="text" name="pais" id="pais" value="Brasil" class="input-login" required>
            </div>

            <div class="dosBotoes">
                <button class="btn-entrar" id="btn-salvar" type="submit">Salvar</button>
            </div>

        </form>
    </div>
</div>

<!-- VIA CEP SCRIPT -->
<script>
// MÁSCARA SIMPLES PARA CEP (00000-000)
document.getElementById('cep').addEventListener('input', function(){
    let v = this.value.replace(/\D/g,'');
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
        } else {
            alert("CEP não encontrado!");
        }
    } catch (error) {
        alert("Erro ao consultar o ViaCEP. Tente novamente.");
    }

    btnSalvar.disabled = false;
    btnSalvar.innerText = "Salvar";
});
</script>
