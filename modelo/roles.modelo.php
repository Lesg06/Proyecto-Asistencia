<?php

require_once "coneccion.php";

class mdlRoles
{

    static public function mdlEliminarRoles($tabla, $valor)
    {

        $stmt = conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_roles = :id");

        $stmt->bindParam(":id", $valor, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            echo "error";
        }

        $stmt - close();

        $stmt = null;
    }

    static public function mdlMostrarRoles($tabla, $item, $valor)
    {

        $stmt = conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item =:$item");

        $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch();
    }

    static public function mdlMostrarRoles2($tabla)
    {

        $stmt = conexion::conectar()->prepare("SELECT * FROM $tabla");

        $stmt->execute();

        return $stmt->fetchAll();
    }

    static public function mdlGuardarRoles($tabla, $nomRol)
    {

        $stmt = conexion::conectar()->prepare("INSERT INTO $tabla(nom_rol) VALUES(:NOM_ROL)");

        $stmt->bindParam(":NOM_ROL", $nomRol, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            echo 'error';
        }

        $stmt->close();

        $stmt = null;
    }

    static public function mdlVerRoles($tabla, $item, $valor)
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

    static public function mdlEditarRoles($tabla, $nomRolE, $idRol)
    {

        $stmt = conexion::conectar()->prepare("UPDATE $tabla SET nom_rol=:rol_nom WHERE id_roles = :id");

        $stmt->bindParam(":id", $idRol, PDO::PARAM_INT);
        $stmt->bindParam(":rol_nom", $nomRolE, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            echo "error";
        }

        $stmt - close();
        $stmt = null;
    }
}
