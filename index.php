<?php
require_once 'connection.php';
$pdo = getPDO();

$stmt = $pdo->query('SELECT * FROM producao_industrial ORDER BY dia ASC');
$rows = $stmt->fetchAll();

session_start();
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Controle de Produção Industrial — Energia</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="container">
    <h1>Produção Industrial — Energia</h1>
    <?php if ($flash): ?>
      <div class="flash"><?=htmlspecialchars($flash)?></div>
    <?php endif; ?>

    <section class="card">
      <h2>Adicionar registro</h2>
      <form action="insert.php" method="post">
        <label>Dia (número)</label>
        <input type="number" name="dia" required min="1">
        <label>Horas trabalhadas</label>
        <input type="number" name="horas_trabalhadas" required min="0">
        <label>Consumo (kWh)</label>
        <input type="number" name="consumo_kwh" required min="0">
        <button type="submit">Adicionar</button>
      </form>
    </section>

    <section class="card">
      <h2>Registros</h2>
      <?php if (count($rows) === 0): ?>
        <p>Nenhum registro encontrado.</p>
      <?php else: ?>
        <table>
          <thead>
            <tr><th>ID</th><th>Dia</th><th>Horas</th><th>Consumo (kWh)</th><th>Ações</th></tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r): ?>
              <tr>
                <td><?=htmlspecialchars($r['id'])?></td>
                <td><?=htmlspecialchars($r['dia'])?></td>
                <td><?=htmlspecialchars($r['horas_trabalhadas'])?></td>
                <td><?=htmlspecialchars($r['consumo_kwh'])?></td>
                <td class="actions">
                  <a href="update.php?id=<?=urlencode($r['id'])?>">Editar</a>
                  <a href="delete.php?id=<?=urlencode($r['id'])?>" onclick="return confirm('Excluir registro #<?=htmlspecialchars($r['id'])?>?')">Excluir</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </section>
  </div>
</body>
</html>
