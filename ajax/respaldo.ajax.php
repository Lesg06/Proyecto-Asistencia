<?php
require_once "../controlador/RespaldoController.php";

if ($_POST['accion'] == 'listar') {
    $respaldos = RespaldoController::ctrMostrarRespaldos();
    echo json_encode(['status' => 'success', 'data' => $respaldos]);
}

if ($_POST['accion'] == 'restaurar') {
    $id = intval($_POST['id']);
    $resultado = RespaldoController::ctrRestaurarRespaldo($id);
    echo json_encode($resultado);
}
