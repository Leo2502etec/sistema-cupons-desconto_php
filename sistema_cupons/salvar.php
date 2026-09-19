<?php

require_once "config/conexao.php";

// Impede o acesso direto ao arquivo pela URL
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: cadastrar.php");
    exit;
}

// Recebe e organiza os dados do formulário
$codigo = strtoupper(trim($_POST["codigo"] ?? ""));
$porcentagem = $_POST["porcentagem"] ?? "";
$validade = trim($_POST["validade"] ?? "");

// Verifica campos vazios
if ($codigo === "" || $porcentagem === "" || $validade === "") {
    header("Location: cadastrar.php?erro=campos");
    exit;
}

// Verifica a porcentagem
if (!is_numeric($porcentagem) || $porcentagem <= 0 || $porcentagem > 100) {
    header("Location: cadastrar.php?erro=porcentagem");
    exit;
}

// Verifica se a data está no formato correto
$data = DateTime::createFromFormat("Y-m-d", $validade);

if (!$data || $data->format("Y-m-d") !== $validade) {
    header("Location: cadastrar.php?erro=validade");
    exit;
}

try {
    $sql = "INSERT INTO cupons (codigo, porcentagem, validade)
            VALUES (:codigo, :porcentagem, :validade)";

    $comando = $conexao->prepare($sql);

    $comando->execute([
        ":codigo" => $codigo,
        ":porcentagem" => $porcentagem,
        ":validade" => $validade
    ]);

    header("Location: index.php?sucesso=1");
    exit;

} catch (PDOException $erro) {

    if ((string) $erro->getCode() === "23000") {
        header("Location: cadastrar.php?erro=duplicado");
        exit;
    }

    header("Location: cadastrar.php?erro=banco");
    exit;
}
