<?php
$host = 'localhost';
$usuario = 'root';   
$clave = '';         
$bd = 'riego_db';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conexion = new mysqli($host, $usuario, $clave, $bd);
    $conexion->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    exit('No se pudo conectar a la base de datos. Verifica que MySQL esté activo en XAMPP y que hayas importado database/riego.sql.');
}
