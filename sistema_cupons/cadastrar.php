<?php
require_once "includes/header.php";
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h3 mb-4">Cadastrar cupom</h1>

                <form action="salvar.php" method="POST">

                    <div class="mb-3">
                        <label for="codigo" class="form-label">
                            Código do cupom
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="codigo"
                            name="codigo"
                            maxlength="50"
                            placeholder="Exemplo: DESCONTO20"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="porcentagem" class="form-label">
                            Porcentagem de desconto
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            id="porcentagem"
                            name="porcentagem"
                            min="0.01"
                            max="100"
                            step="0.01"
                            placeholder="Exemplo: 20"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="validade" class="form-label">
                            Data de validade
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            id="validade"
                            name="validade"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Cadastrar
                    </button>

                    <a href="index.php" class="btn btn-secondary">
                        Voltar
                    </a>

                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once "includes/footer.php";
?>

<?php
$erro = $_GET["erro"] ?? "";

$mensagens = [
    "campos" => "Preencha todos os campos.",
    "porcentagem" => "A porcentagem deve ser maior que 0 e menor ou igual a 100.",
    "validade" => "Informe uma data de validade correta.",
    "duplicado" => "Já existe um cupom com esse código.",
    "banco" => "Não foi possível cadastrar o cupom."
];

if (isset($mensagens[$erro])):
?>
    <div class="alert alert-danger">
        <?= $mensagens[$erro] ?>
    </div>
<?php endif; ?>

