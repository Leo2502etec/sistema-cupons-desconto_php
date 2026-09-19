<?php

require_once "config/conexao.php";

// Permite a exclusão somente pelo formulário
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// Recebe e valida o ID
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: index.php?erro=excluir");
    exit;
}

try {
    $sql = "DELETE FROM cupons WHERE id = :id";

    $comando = $conexao->prepare($sql);
    $comando->execute([":id" => $id]);

    header("Location: index.php?excluido=1");
    exit;

} catch (PDOException $erro) {
    header("Location: index.php?erro=excluir");
    exit;
}
