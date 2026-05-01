<?php
require_once "../modelo/RespaldoModel.php";
class RespaldoController
{
    public static function ctrMostrarRespaldos()
    {
        $respuesta = RespaldoModel::mdlObtenerTodos();
        return $respuesta;
    }

    public static function ctrRestaurarRespaldo($id)
    {
        $respaldo = RespaldoModel::mdlObtenerPorId($id);

        if (!$respaldo) {
            return ['status' => 'error', 'message' => 'Respaldo no encontrado.'];
        }

        $archivo = __DIR__ . '/../respaldo2/backups/' . $respaldo['nombre'];
        if (!file_exists($archivo)) {
            return ['status' => 'error', 'message' => 'Archivo .sql no encontrado.'];
        }

      try {
    $conexion = new PDO("mysql:host=localhost;dbname=sistema_asistencia", "root", "");
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = file_get_contents($archivo);
    $sql = "SET FOREIGN_KEY_CHECKS=0;\n" . $sql . "\nSET FOREIGN_KEY_CHECKS=1;";
    $conexion->exec($sql);

    return ['status' => 'success', 'message' => 'Base de datos restaurada correctamente.'];
} catch (PDOException $e) {
    return ['status' => 'error', 'message' => 'Error: ' . $e->getMessage()];
}

    }
}
