<?php
// Recibe el formulario, valida en el servidor y guarda con consulta preparada (evita SQL Injection)
// Recibe el formulario 02
require_once __DIR__ . '/../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ../registro_riego.php'); exit; }

$parcela = filter_input(INPUT_POST, 'parcela_id', FILTER_VALIDATE_INT);
$fecha   = $_POST['fecha'] ?? '';
$min     = filter_input(INPUT_POST, 'duracion_min', FILTER_VALIDATE_INT);
$litros  = filter_input(INPUT_POST, 'cantidad_litros', FILTER_VALIDATE_FLOAT);
$obs     = trim($_POST['observaciones'] ?? '');

$f = DateTime::createFromFormat('Y-m-d', $fecha);
$fechaOk = $f && $f->format('Y-m-d') === $fecha && $fecha <= date('Y-m-d');

if (!$parcela || !$fechaOk || !$min || $min <= 0 || !$litros || $litros <= 0 || strlen($obs) > 255) {
    header('Location: ../registro_riego.php?error=1'); exit;
}

$sql = 'INSERT INTO riegos (parcela_id, fecha, duracion_min, cantidad_litros, observaciones) VALUES (?, ?, ?, ?, ?)';
$stmt = $conexion->prepare($sql);
$stmt->bind_param('isids', $parcela, $fecha, $min, $litros, $obs);
$stmt->execute();

header('Location: ../historial.php?ok=1');
exit;
