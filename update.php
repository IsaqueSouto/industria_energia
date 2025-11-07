<?php
require_once 'connection.php';
session_start();
$pdo = getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id === false) { exit('ID inválido'); }
    $stmt = $pdo->prepare('SELECT * FROM producao_industrial WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if (!$row) { exit('Registro não encontrado'); }
    ?>
    <!doctype html>
    <html lang="pt-BR">
    <head>
      <meta charset="utf-8">
      <title>Editar registro</title>
      <link rel="stylesheet" href="assets/style.css">
    </head>
    <body>
      <div class="container">
        <h1>Editar registro #<?=htmlspecialchars($row['id'])?></h1>
        <form action="update.php" method="post">
          <input type="hidden" name="id" value="<?=htmlspecialchars($row['id'])?>">
          <label>Dia (número)</label>
          <input type="number" name="dia" required min="1" value="<?=htmlspecialchars($row['dia'])?>">
          <label>Horas trabalhadas</label>
          <input type="number" name="horas_trabalhadas" required min="0" value="<?=htmlspecialchars($row['horas_trabalhadas'])?>">
          <label>Consumo (kWh)</label>
          <input type="number" name="consumo_kwh" required min="0" value="<?=htmlspecialchars($row['consumo_kwh'])?>">
          <button type="submit">Salvar</button>
          <a href="index.php" class="button-link">Cancelar</a>
        </form>
      </div>
    </body>
    </html>
    <?php
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $dia = filter_input(INPUT_POST, 'dia', FILTER_VALIDATE_INT);
    $horas = filter_input(INPUT_POST, 'horas_trabalhadas', FILTER_VALIDATE_INT);
    $consumo = filter_input(INPUT_POST, 'consumo_kwh', FILTER_VALIDATE_INT);

    if ($id === false || $dia === false || $horas === false || $consumo === false) {
        $_SESSION['flash'] = 'Dados inválidos.';
        header('Location: index.php');
        exit;
    }

    $stmt = $pdo->prepare('UPDATE producao_industrial SET dia = ?, horas_trabalhadas = ?, consumo_kwh = ? WHERE id = ?');
    $stmt->execute([$dia, $horas, $consumo, $id]);

    $_SESSION['flash'] = 'Registro atualizado.';
    header('Location: index.php');
    exit;
}

http_response_code(405);
exit('Método não permitido');
