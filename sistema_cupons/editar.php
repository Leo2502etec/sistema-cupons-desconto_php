<?php

require_once "config/conexao.php";

// Recebe o ID pela URL e verifica se é um número inteiro
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: index.php");
    exit;
}

// Procura o cupom pelo ID
$sql = "SELECT id, codigo, porcentagem, validade
        FROM cupons
        WHERE id = :id";

$comando = $conexao->prepare($sql);
$comando->execute([":id" => $id]);

$cupom = $comando->fetch(PDO::FETCH_ASSOC);

// Volta ao início se o cupom não existir
if (!$cupom) {
    header("Location: index.php");
    exit;
}

require_once "includes/header.php";

$erro = $_GET["erro"] ?? "";

$mensagens = [
    "campos" => "Preencha todos os campos.",
    "porcentagem" => "A porcentagem deve estar entre 0 e 100.",
    "validade" => "Informe uma data válida.",
    "duplicado" => "Já existe outro cupom com esse código.",
    "banco" => "Não foi possível atualizar o cupom."
];
?>

<?php if (isset($mensagens[$erro])): ?>
    <div class="alert alert-danger">
        <?= $mensagens[$erro] ?>
    </div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-body">

                <h1 class="h3 mb-4">Editar cupom</h1>

                <form action="atualizar.php" method="POST">

                    <input
                        type="hidden"
                        name="id"
                        value="<?= $cupom["id"] ?>"
                    >

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
                            value="<?= htmlspecialchars(
                                $cupom["codigo"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>"
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
                            value="<?= $cupom["porcentagem"] ?>"
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
                            value="<?= $cupom["validade"] ?>"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-warning">
                        Atualizar
                    </button>

                    <a href="index.php" class="btn btn-secondary">
                        Cancelar
                    </a>

                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once "includes/footer.php";
?>
