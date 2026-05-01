<?php
require_once "../controlador/empleados.controlador.php";
require_once "../modelo/empleados.modelo.php";

// ✅ NUEVO: Editar empleado completo con validación y manejo de errores
if (isset($_POST['opcion']) && $_POST['opcion'] === 'editarEmpleado') {

    // Activar modo estricto para depuración (opcional, quitar en producción)
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    error_reporting(E_ALL);

    header('Content-Type: application/json'); // ← Fuerza el tipo de respuesta JSON

    $camposEsperados = [
        "id_empleado", "nombre", "apellido", "ci", "cargo",
        "telefono", "direccion", "fecha_ingreso", "anio_servicio", "correo"
    ];

    foreach ($camposEsperados as $campo) {
        if (!isset($_POST[$campo])) {
            echo json_encode([
                "status" => "error",
                "message" => "Falta el campo: $campo"
            ]);
            return;
        }
    }

    $datos = [
        "id_empleado" => $_POST["id_empleado"],
        "nombre" => $_POST["nombre"],
        "apellido" => $_POST["apellido"],
        "ci" => $_POST["ci"],
        "cargo" => $_POST["cargo"],
        "telefono" => $_POST["telefono"],
        "direccion" => $_POST["direccion"],
        "fecha_ingreso" => $_POST["fecha_ingreso"],
        "anio_servicio" => $_POST["anio_servicio"],
        "correo" => $_POST["correo"]
    ];

    try {
        $respuesta = ctrEmpleados::ctrEditarEmpleado2($datos);
        echo json_encode([
            "status" => $respuesta === "ok" ? "ok" : "error",
            "message" => $respuesta
        ]);
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Excepción: " . $e->getMessage()
        ]);
    }

    return;
}

class AjaxEmpleados
{
    public $idEmpleado;
    public $elimina;

    // Para edición
    public function ajaxEditarEmpleado()
    {
        $item = "id_empleado";
        $valor = $this->idEmpleado;
        $respuesta = ctrEmpleados::ctrMostrarEmpleados1($item, $valor);
        echo json_encode($respuesta);
    }

    // Para solo visualizar (puede ser el mismo método, pero lo separamos por claridad)
    public function ajaxVerEmpleado()
    {
        $item = "id_empleado";
        $valor = $this->idEmpleado;
        $respuesta = ctrEmpleados::ctrMostrarEmpleados1($item, $valor);
        echo json_encode($respuesta);
    }

    public function ajasxEliminarEmpleado()
    {
        $valor = $this->elimina;
        $respuesta = ctrEmpleados::ctrEliminarEmpleados($valor);
        echo json_encode($respuesta);
    }
}

// 🔍 Obtener empleado por ID para edición o visualización
if (isset($_POST["idEmpleado"]) && !isset($_POST['solo_ver'])) {
    $editar = new AjaxEmpleados();
    $editar->idEmpleado = $_POST["idEmpleado"];
    $editar->ajaxEditarEmpleado();
}

// 👁️ Ver empleado completo
if (isset($_POST["verEmpleado"])) {
    $ver = new AjaxEmpleados();
    $ver->idEmpleado = $_POST["verEmpleado"];
    $respuesta = ctrEmpleados::ctrVerEmpleado($ver->idEmpleado);
    echo json_encode($respuesta);
}


// 🗑️ Eliminar empleado
if (isset($_POST["idEmpleadoE"])) {
    $eliminar = new AjaxEmpleados();
    $eliminar->elimina = $_POST["idEmpleadoE"];
    $eliminar->ajasxEliminarEmpleado();
}
