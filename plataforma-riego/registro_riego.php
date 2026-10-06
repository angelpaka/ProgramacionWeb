<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrar riego – Riego Responsable</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
  <div class="barra">
    <span class="logo">Riego Responsable</span>
    <nav aria-label="Principal">
      <ul>
        <li><a href="index.html">Inicio</a></li>
        <li><a href="registro_riego.php" aria-current="page">Registrar riego</a></li>
        <li><a href="historial.php">Historial</a></li>
      </ul>
    </nav>
  </div>
</header>
<?php
require_once __DIR__ . '/config/conexion.php';
$parcelas = $conexion->query('SELECT id, nombre FROM parcelas ORDER BY nombre');
?>
<main>
  <h1>Registrar riego</h1>
  <?php if (isset($_GET['error'])): ?>
    <p class="aviso mal" role="alert">Los datos no son válidos. Revisa el formulario e inténtalo de nuevo.</p>
  <?php endif; ?>
  <form id="form-riego" action="php/guardar_riego.php" method="post" novalidate>
    <div>
      <label for="parcela_id">Parcela o área</label>
      <select id="parcela_id" name="parcela_id">
        <option value="">Selecciona…</option>
        <?php while ($p = $parcelas->fetch_assoc()): ?>
          <option value="<?= (int)$p['id'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
        <?php endwhile; ?>
      </select>
      <span class="error" id="err-parcela_id"></span>
    </div>
    <div><label for="fecha">Fecha</label><input type="date" id="fecha" name="fecha"><span class="error" id="err-fecha"></span></div>
    <div><label for="duracion_min">Duración (minutos)</label><input type="number" id="duracion_min" name="duracion_min" min="1" step="1"><span class="error" id="err-duracion_min"></span></div>
    <div><label for="cantidad_litros">Agua utilizada (litros)</label><input type="number" id="cantidad_litros" name="cantidad_litros" min="0.01" step="0.01"><span class="error" id="err-cantidad_litros"></span></div>
    <div><label for="observaciones">Observaciones (opcional)</label><input type="text" id="observaciones" name="observaciones" maxlength="255"></div>
    <button class="btn" type="submit">Guardar riego</button>
  </form>
</main>
<footer><p>Programación Web – Universidad Continental, Cusco 2026</p></footer>
<script src="js/validaciones.js"></script></body></html>
