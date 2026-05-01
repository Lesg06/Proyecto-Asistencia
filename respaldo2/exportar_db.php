<?php

$mysqli = new mysqli('localhost', 'root', '', 'sistema_asistencia');
if ($mysqli->connect_error) {
    die('Conexión fallida: ' . $mysqli->connect_error);
}

$fechaActual = date('Y-m-d H:i:s');
$nombreArchivo = "sistema_asistencia_" . date('Y-m-d_H-i-s') . ".sql";
$backupDir = __DIR__ . '/backups';

if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}

$salida_sql = $backupDir . '/' . $nombreArchivo;

// Obtener todas las tablas
$tablas = [];
$result = $mysqli->query("SHOW TABLES");
while ($row = $result->fetch_array()) {
    $tablas[] = $row[0];
}

// Iniciar contenido SQL
$sqlDump = "-- Respaldo generado automáticamente\n";
$sqlDump .= "-- Fecha: {$fechaActual}\n\n";
$mysqli->query("SET NAMES 'utf8'");

foreach ($tablas as $tabla) {
    // Estructura
    $res = $mysqli->query("SHOW CREATE TABLE `$tabla`");
    $row = $res->fetch_assoc();
    $sqlDump .= "-- Estructura para tabla `$tabla`\n";
    $sqlDump .= "DROP TABLE IF EXISTS `$tabla`;\n";
    $sqlDump .= $row['Create Table'] . ";\n\n";

    // Datos
    $res = $mysqli->query("SELECT * FROM `$tabla`");
    if ($res->num_rows > 0) {
        $sqlDump .= "-- Datos para tabla `$tabla`\n";
        while ($fila = $res->fetch_assoc()) {
            $escapedValues = array_map([$mysqli, 'real_escape_string'], array_values($fila));
            $values = array_map(fn($v) => "'$v'", $escapedValues);
            $sqlDump .= "INSERT INTO `$tabla` VALUES (" . implode(",", $values) . ");\n";
        }
        $sqlDump .= "\n";
    }
}

// Guardar a archivo SQL
file_put_contents($salida_sql, $sqlDump);

// Guardar registro en la tabla respaldos
$stmt = $mysqli->prepare("INSERT INTO respaldos (nombre, fecha) VALUES (?, ?)");
if ($stmt) {
    $stmt->bind_param("ss", $nombreArchivo, $fechaActual);
    $stmt->execute();
    $stmt->close();
}

// Descargar el archivo .sql directamente
header('Content-Type: application/sql');
header('Content-Disposition: attachment; filename="' . basename($salida_sql) . '"');
header('Content-Length: ' . filesize($salida_sql));
readfile($salida_sql);
exit;
