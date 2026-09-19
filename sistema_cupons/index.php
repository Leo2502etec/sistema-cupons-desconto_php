<?php

require_once "config/conexao.php";

// Busca todos os cupons cadastrados
$sql = "SELECT id, codigo, porcentagem, validade
        FROM cupons
        ORDER BY id DESC";

$comando = $conexao->query($sql);
$cupons = $comando->fetchAll(PDO::FETCH_ASSOC);

require_once "includes/header.php";
?>

<?php if (isset($_GET["sucesso"])): ?>
    <div class="alert alert-success">
        Cupom cadastrado com sucesso!
    </div>
<?php endif; ?>

<?php if (isset($_GET["atualizado"])): ?>
    <div class="alert alert-success">
        Cupom atualizado com sucesso!
    </div>
<?php endif; ?>

<?php if (isset($_GET["excluido"])): ?>
    <div class="alert alert-success">
        Cupom excluído com sucesso!
    </div>
<?php endif; ?>

<?php if (isset($_GET["erro"]) && $_GET["erro"] === "excluir"): ?>
    <div class="alert alert-danger">
        Não foi possível excluir o cupom.
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Cupons cadastrados</h1>

    <a href="cadastrar.php" class="btn btn-primary">
        Novo cupom
    </a>
</div>

<?php if (count($cupons) === 0): ?>

    <div class="alert alert-info">
        Nenhum cupom cadastrado.
    </div>

<?php else: ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Desconto</th>
                            <th>Validade</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($cupons as $cupom): ?>

                            <?php
                            $dataValidade = new DateTime($cupom["validade"]);
                            $hoje = new DateTime("today");

                            if ($dataValidade < $hoje) {
                                $status = "Vencido";
                                $corStatus = "danger";
                            } elseif ($dataValidade == $hoje) {
                                $status = "Vence hoje";
                                $corStatus = "warning";
                            } else {
                                $status = "Válido";
                                $corStatus = "success";
                            }
                            ?>

                          <tr>
    <td><?= $cupom["id"] ?></td>

    <td>
        <?= htmlspecialchars(
            $cupom["codigo"],
            ENT_QUOTES,
            "UTF-8"
        ) ?>
    </td>

    <td>
        <?= number_format(
            (float) $cupom["porcentagem"],
            2,
            ",",
            "."
        ) ?>%
    </td>

    <td>
        <?= $dataValidade->format("d/m/Y") ?>
    </td>

    <td>
        <span class="badge text-bg-<?= $corStatus ?>">
            <?= $status ?>
        </span>
    </td>

    <td>
        <a
            href="editar.php?id=<?= $cupom["id"] ?>"
            class="btn btn-sm btn-warning"
        >
            Editar
        </a>

        <form
            action="excluir.php"
            method="POST"
            class="d-inline formulario-excluir"
        >
            <input
                type="hidden"
                name="id"
                value="<?= $cupom["id"] ?>"
            >

            <button type="submit" class="btn btn-sm btn-danger">
                Excluir
            </button>
        </form>
    </td>
</tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

<?php endif; ?>

<?php
require_once "includes/footer.php";
?>
