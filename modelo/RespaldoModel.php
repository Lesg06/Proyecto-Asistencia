<?php
require_once "coneccion.php";

class RespaldoModel
{
    public static function mdlObtenerTodos()
    {
        $stmt = conexion::conectar()->prepare("SELECT * FROM respaldos ORDER BY fecha DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function mdlObtenerPorId($id)
    {
        $stmt = conexion::conectar()->prepare("SELECT * FROM respaldos WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
