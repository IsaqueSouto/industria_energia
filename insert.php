<?php
require_once 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido');
}

$dia = filter_input(INPUT_POST, 'dia', FILTER_VALIDATE_INT);
$horas = filter_input(INPUT_POST, 'horas_trabalhadas', FILTER_VALIDATE_INT);
$consumo = filter_input(INPUT_POST, 'consumo_kwh', FILTER_VALIDATE_INT);

if ($dia === false || $horas === false || $consumo === false) {
    $_SESSION['flash'] = 'Dados inválidos.';
    header('Location: index.php');
    exit;
}

$pdo = getPDO();
$stmt = $pdo->prepare('INSERT INTO producao_industrial (dia, horas_trabalhadas, consumo_kwh) VALUES (?, ?, ?)');
$stmt->execute([$dia, $horas, $consumo]);

$_SESSION['flash'] = 'Registro adicionado com sucesso.';
header('Location: index.php');
exit;
