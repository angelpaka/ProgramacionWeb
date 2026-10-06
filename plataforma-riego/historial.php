<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Historial – Riego Responsable</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
  <div class="barra">
    <span class="logo">Riego Responsable</span>
    <nav aria-label="Principal">
      <ul>
        <li><a href="index.html">Inicio</a></li>
        <li><a href="registro_riego.php">Registrar riego</a></li>
        <li><a href="historial.php" aria-current="page">Historial</a></li>
      </ul>
    </nav>
  </div>
</header>
<?php
require_once __DIR__ . '/config/conexion.php';
$res = $conexion->query('SELECT r.fecha, p.nombre AS parcela, r.duracion_min, r.cantidad_litros, r.observaciones
                         FROM riegos r JOIN parcelas p ON p.id = r.parcela_id ORDER BY r.fecha DESC, r.id DESC');
?>
<main>
  <h1>Historial de riegos</h1>
  <?php if (isset($_GET['ok'])): ?><p class="aviso ok" role="status">Riego guardado correctamente.</p><?php endif; ?>
  <div class="tabla-wrap">
    <table>
      <thead><tr><th>Fecha</th><th>Parcela</th><th>Duración (min)</th><th>Litros</th><th>Observaciones</th></tr></thead>
      <tbody>
      <?php if ($res->num_rows === 0): ?>
        <tr><td colspan="5">Aún no hay riegos. <a href="registro_riego.php">Registra el primero</a>.</td></tr>
      <?php endif; ?>
      <?php while ($r = $res->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($r['fecha']) ?></td>
          <td><?= htmlspecialchars($r['parcela']) ?></td>
          <td><?= (int)$r['duracion_min'] ?></td>
          <td><?= number_format((float)$r['cantidad_litros'], 2) ?></td>
          <td><?= htmlspecialchars($r['observaciones'] ?? '') ?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>
<footer><p>Programación Web – Universidad Continental, Cusco 2026</p></footer>
</body></html>
