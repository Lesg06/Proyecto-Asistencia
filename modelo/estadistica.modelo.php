<?php

require_once "coneccion.php";

class mdlEstadistica
{
    public static function mdlEstadistias($tabla, $valor)
    {
        $añoActual = date('Y');
        $mes = str_pad($valor, 2, "0", STR_PAD_LEFT);

        $stmt = conexion::conectar()->prepare("
            SELECT COUNT(*) 
            FROM $tabla 
            WHERE MONTH(entrada) = :mes AND YEAR(entrada) = :anio
        ");
        $stmt->bindParam(":mes", $mes, PDO::PARAM_INT);
        $stmt->bindParam(":anio", $añoActual, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch();
    }

    public static function contarEmpleados()
    {
        $stmt = conexion::conectar()->prepare("SELECT COUNT(*) FROM empleado");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public static function contarCargos()
    {
        $stmt = conexion::conectar()->prepare("SELECT COUNT(*) FROM cargo");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public static function contarEntradasHoy()
    {
        $hoy = date("Y-m-d");
        $stmt = conexion::conectar()->prepare("SELECT COUNT(*) FROM asistencia WHERE DATE(entrada) = ?");
        $stmt->execute([$hoy]);
        return $stmt->fetchColumn();
    }

    public static function contarSalidasHoy()
    {
        $hoy = date("Y-m-d");
        $stmt = conexion::conectar()->prepare("SELECT COUNT(*) FROM asistencia WHERE DATE(salida) = ?");
        $stmt->execute([$hoy]);
        return $stmt->fetchColumn();
    }
}
