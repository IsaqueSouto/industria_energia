<?php
require_once 'connection.php';
session_start();
$pdo = getPDO();

if (!isset($_GET['id'])) {
    $_SESSION['flash'] = 'ID ausente.';
    header('Location: index.php');
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false) {
    $_SESSION['flash'] = 'ID inválido.';
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('DELETE FROM producao_industrial WHERE id = ?');
$stmt->execute([$id]);

$_SESSION['flash'] = 'Registro excluído.';
header('Location: index.php');
exit;
