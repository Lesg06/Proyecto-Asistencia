<?php
require_once "../controlador/cargos.controlador.php";
require_once "../modelo/cargos.modelo.php";
if (isset($_POST['opcion']) && $_POST['opcion'] === 'editarCargo') {
    header('Content-Type: application/json');

    if (empty($_POST['id_cargoE']) || empty($_POST['nom_cargoE'])) {
        echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos']);
        return;
    }

    $id = intval($_POST['id_cargoE']);
    $nombre = trim($_POST['nom_cargoE']);

    try {
        $respuesta = ctrCargos::ctrEditarCargoAjax($id, $nombre);
        echo json_encode([
            'status' => $respuesta === "ok" ? "ok" : "error",
            'message' => $respuesta
        ]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    return;
}

class AjaxCargos
{

    public $idCargos;

public function ajaxEditarRoles()
{
    $item = "id_cargo"; // ← corregido
    $valor = $this->idCargos;

    $respuesta = ctrCargos::ctrVerCargo($item, $valor);

    echo json_encode($respuesta);
}



    public $idCargoE;

    public function ajaxEliminarRoles()
    {

        $item = "id_cargo";
        $valor = $this->idCargoE;

        $respuesta = ctrCargos::ctrEliminarCargo($item, $valor);
        echo json_encode($respuesta);
    }
}

//Editar Cargos

if (isset($_POST["idCargos"])) {

    $editar = new AjaxCargos();
    $editar->idCargos = $_POST["idCargos"];
    $editar->ajaxEditarRoles();
}

//Eliminar Cargo

if (isset($_POST["idCargoE"])) {

    $eliminar = new AjaxCargos();
    $eliminar->idCargoE = $_POST["idCargoE"];
    $eliminar->ajaxEliminarRoles();
}
