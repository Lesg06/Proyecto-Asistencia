<?php
include "../modelo/conexion.php";
date_default_timezone_set("America/Caracas");

$response = ["status" => "error", "message" => "Solicitud inválida."];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ci = trim($_POST["ci"] ?? '');
    $tipo = $_POST["tipo"] ?? '';

    if ($ci === '') {
        $response["message"] = "Ingrese la cédula.";
    } elseif (!in_array($tipo, ["entrada", "salida"])) {
        $response["message"] = "Tipo de acción inválido.";
    } else {
        $res = $conexion->query("SELECT id_empleado FROM empleado WHERE ci='$ci'");
        if ($res->num_rows === 0) {
            $response["message"] = "La cédula ingresada no existe.";
        } else {
            $id_empleado = $res->fetch_object()->id_empleado;
            $fecha = date("Y-m-d H:i:s");

            if ($tipo === "entrada") {
                $ver = $conexion->query("SELECT COUNT(*) AS total FROM asistencia WHERE id_empleado=$id_empleado AND DATE(entrada)=CURDATE() AND salida='0000-00-00 00:00:00'");
                if ($ver->fetch_object()->total > 0) {
                    $response = ["status" => "info", "message" => "Ya registraste tu entrada hoy."];
                } else {
                    $sql = $conexion->query("INSERT INTO asistencia(id_empleado, entrada) VALUES($id_empleado, '$fecha')");
                    $response = $sql
                        ? ["status" => "success", "message" => "CORRECTO"]
                        : ["status" => "error", "message" => "Error al registrar ENTRADA"];
                }
            } elseif ($tipo === "salida") {
                $busqueda = $conexion->query("SELECT id_asistencia FROM asistencia WHERE id_empleado=$id_empleado ORDER BY id_asistencia DESC LIMIT 1");
                if ($busqueda->num_rows > 0) {
                    $id_asistencia = $busqueda->fetch_object()->id_asistencia;
                    $sql = $conexion->query("UPDATE asistencia SET salida='$fecha' WHERE id_asistencia=$id_asistencia");
                    $response = $sql
                        ? ["status" => "success", "message" => "Adiós, vuelve pronto!!"]
                        : ["status" => "error", "message" => "Error al registrar SALIDA"];
                } else {
                    $response = ["status" => "info", "message" => "No hay entrada registrada."];
                }
            }
        }
    }
}

echo json_encode($response);
