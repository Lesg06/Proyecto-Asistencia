<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Establecer zona horaria local para evitar desfase de fechas
date_default_timezone_set("America/Caracas"); // Ajusta a tu país si es diferente

require_once "../controlador/estadistica.controlador.php";
require_once "../modelo/estadistica.modelo.php";


// Si viene ?kpi=true en la URL, devolvemos los KPI
if (isset($_GET['kpi'])) {
    $resultado = [
        'totalEmpleados' => mdlEstadistica::contarEmpleados(),
        'totalCargos' => mdlEstadistica::contarCargos(),
        'entradasHoy' => mdlEstadistica::contarEntradasHoy(),
        'salidasHoy' => mdlEstadistica::contarSalidasHoy()
    ];

    header('Content-Type: application/json');
    echo json_encode($resultado);
    return;
}

// Listado de entradas de hoy
if (isset($_GET['list']) && $_GET['list'] === 'entradas') {
    $hoy = date("Y-m-d");
    $stmt = conexion::conectar()->prepare("
        SELECT e.nombre, e.apellido, a.entrada 
        FROM asistencia a 
        JOIN empleado e ON e.id_empleado = a.id_empleado 
        WHERE DATE(a.entrada) = ?
        ORDER BY a.entrada ASC
    ");
    $stmt->execute([$hoy]);
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($datos) > 0) {
        echo "<ul class='list-group'>";
        foreach ($datos as $d) {
            echo "<li class='list-group-item'><strong>{$d['nombre']} {$d['apellido']}</strong> - Entrada: {$d['entrada']}</li>";
        }
        echo "</ul>";
    } else {
        echo "No hay entradas registradas hoy.";
    }
    return;
}

// Listado de salidas de hoy
if (isset($_GET['list']) && $_GET['list'] === 'salidas') {
    $hoy = date("Y-m-d");
    $stmt = conexion::conectar()->prepare("
        SELECT e.nombre, e.apellido, a.salida 
        FROM asistencia a 
        JOIN empleado e ON e.id_empleado = a.id_empleado 
        WHERE DATE(a.salida) = ?
        ORDER BY a.salida ASC
    ");
    $stmt->execute([$hoy]);
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($datos) > 0) {
        echo "<ul class='list-group'>";
        foreach ($datos as $d) {
            echo "<li class='list-group-item'><strong>{$d['nombre']} {$d['apellido']}</strong> - Salida: {$d['salida']}</li>";
        }
        echo "</ul>";
    } else {
        echo "No hay salidas registradas hoy.";
    }
    return;
}

// Listado de empleados ingresados este mes
if (isset($_GET['list']) && $_GET['list'] === 'empleados_mes') {
    $mesActual = date('m');
    $anioActual = date('Y');

    $stmt = conexion::conectar()->prepare("
        SELECT nombre, apellido, ci, fecha_ingreso 
        FROM empleado 
        WHERE MONTH(fecha_ingreso) = ? AND YEAR(fecha_ingreso) = ?
        ORDER BY fecha_ingreso DESC
    ");
    $stmt->execute([$mesActual, $anioActual]);
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($datos) > 0) {
        echo "<table class='table table-bordered table-striped'>
                <thead><tr><th>Nombre</th><th>Apellido</th><th>Cédula</th><th>Fecha de Ingreso</th></tr></thead><tbody>";
        foreach ($datos as $row) {
            $fechaFormateada = date("d/m/Y", strtotime($row['fecha_ingreso']));
            echo "<tr>
                    <td>{$row['nombre']}</td>
                    <td>{$row['apellido']}</td>
                    <td>{$row['ci']}</td>
                    <td>{$fechaFormateada}</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No hay empleados registrados este mes.</p>";
    }
    return;
}
// Estadísticas por mes del año actual (gráfico anual)
if (isset($_GET['anual']) && $_GET['anual'] === 'true') {
    $entradas = [];
    $salidas = [];
    $anioActual = date("Y");

    for ($mes = 1; $mes <= 12; $mes++) {
        // Entradas
        $stmtEntrada = conexion::conectar()->prepare("
            SELECT COUNT(*) 
            FROM asistencia 
            WHERE MONTH(entrada) = ? AND YEAR(entrada) = ?
        ");
        $stmtEntrada->execute([$mes, $anioActual]);
        $entradas[] = (int)$stmtEntrada->fetchColumn();

        // Salidas
        $stmtSalida = conexion::conectar()->prepare("
            SELECT COUNT(*) 
            FROM asistencia 
            WHERE MONTH(salida) = ? AND YEAR(salida) = ?
        ");
        $stmtSalida->execute([$mes, $anioActual]);
        $salidas[] = (int)$stmtSalida->fetchColumn();
    }

    header('Content-Type: application/json');
    echo json_encode([
        "entradas" => $entradas,
        "salidas" => $salidas
    ]);
    return;
}



/// Estadísticas por día del mes actual (gráfico mensual)
$entradas = [];
$salidas = [];

$year = date("Y");
$month = date("m");
$ultimoDia = cal_days_in_month(CAL_GREGORIAN, $month, $year);

for ($dia = 1; $dia <= $ultimoDia; $dia++) {
    $fecha = "$year-$month-" . str_pad($dia, 2, "0", STR_PAD_LEFT);

    // Entradas por día
    $stmtEntrada = conexion::conectar()->prepare("
        SELECT COUNT(*) FROM asistencia 
        WHERE DATE(entrada) = ?
    ");
    $stmtEntrada->execute([$fecha]);
    $entradas[] = (int)$stmtEntrada->fetchColumn();

    // Salidas por día
    $stmtSalida = conexion::conectar()->prepare("
        SELECT COUNT(*) FROM asistencia 
        WHERE DATE(salida) = ?
    ");
    $stmtSalida->execute([$fecha]);
    $salidas[] = (int)$stmtSalida->fetchColumn();
}

header('Content-Type: application/json');
echo json_encode([
    "entradas" => $entradas,
    "salidas" => $salidas
]);
