<?php

require_once "config/conexao.php";

// Permite somente envio pelo formulário
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// Recebe os dados
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$codigo = strtoupper(trim($_POST["codigo"] ?? ""));
$porcentagem = $_POST["porcentagem"] ?? "";
$validade = trim($_POST["validade"] ?? "");

// Verifica o ID
if (!$id) {
    header("Location: index.php");
    exit;
}

// Verifica campos vazios
if ($codigo === "" || $porcentagem === "" || $validade === "") {
    header("Location: editar.php?id=$id&erro=campos");
    exit;
}

// Verifica a porcentagem
if (!is_numeric($porcentagem) || $porcentagem <= 0 || $porcentagem > 100) {
    header("Location: editar.php?id=$id&erro=porcentagem");
    exit;
}

// Verifica a data
$data = DateTime::createFromFormat("Y-m-d", $validade);

if (!$data || $data->format("Y-m-d") !== $validade) {
    header("Location: editar.php?id=$id&erro=validade");
    exit;
}

try {
    $sql = "UPDATE cupons
            SET codigo = :codigo,
                porcentagem = :porcentagem,
                validade = :validade
            WHERE id = :id";

    $comando = $conexao->prepare($sql);

    $comando->execute([
        ":codigo" => $codigo,
        ":porcentagem" => $porcentagem,
        ":validade" => $validade,
        ":id" => $id
    ]);

    header("Location: index.php?atualizado=1");
    exit;

} catch (PDOException $erro) {

    if ((string) $erro->getCode() === "23000") {
        header("Location: editar.php?id=$id&erro=duplicado");
        exit;
    }

    header("Location: editar.php?id=$id&erro=banco");
    exit;
}
