<?php

require_once "coneccion.php";

class mdlCargos
{

    static public function mdlEliminarCargo($tabla, $valor)
    {

        $stmt = conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_cargo = :id");

        $stmt->bindParam(":id", $valor, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            echo "error";
        }

        $stmt->close();

        $stmt = null;
    }


    static public function mdlMostrarCargos($tabla, $item, $valor)
    {

        $stmt = conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item =:$item");

        $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch();
    }

    static public function mdlMostrarCargos2($tabla)
    {

        $stmt = conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $tabla.id_cargo DESC");

        $stmt->execute();

        return $stmt->fetchAll();
    }
    

    static public function mdlGuardarCargo($tabla, $nomCarg)
    {

        $stmt = conexion::conectar()->prepare("INSERT INTO $tabla(nombre) VALUES(:NOM_CARG)");

        $stmt->bindParam(":NOM_CARG", $nomCarg, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            echo 'error';
        }

        $stmt->close();

        $stmt = null;
    }

    static public function mdlVerCargo($tabla, $item, $valor)
    {

        $stmt = conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:IDE");

        $stmt->bindParam(":IDE", $valor, PDO::PARAM_INT);


        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            echo "error";
        }

        $stmt->close();
        $stmt = null;
    }

static public function mdlEditarCargo($tabla, $nomRolE, $id)
{
    $stmt = conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nom WHERE id_cargo = :id");

    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":nom", $nomRolE, PDO::PARAM_STR);

    if ($stmt->execute()) {
        return "ok";
    } else {
        return "error";
    }

    $stmt->close();
    $stmt = null;
}

}
