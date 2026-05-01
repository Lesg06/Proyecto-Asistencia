<?php

require_once "coneccion.php";

class mdlAsistencias
{
    static public function mdlEliminarAsistencias($tabla, $id)
    {
        $stmt = conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_asistencia =:id");

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            echo "error";
        }

        $stmt->close();
        $stmt = null;
    }

    static public function mdlEditarAsistencias($tabla, $datos)
    {

        $stmt = conexion::conectar()->prepare("UPDATE $tabla SET usuario=:NOMUSER_E , password=:PASSER_E , nombre=:NOM_E , apellido=:APE_E , foto=:IMG_E , rol=:ROL_E WHERE id=:IDE");

        $stmt->bindParam(":IDE", $datos['idE'], PDO::PARAM_INT);
        $stmt->bindParam(":NOM_E", $datos['nom_usuarioE'], PDO::PARAM_STR);
        $stmt->bindParam(":APE_E", $datos['ape_usuarioE'], PDO::PARAM_STR);
        $stmt->bindParam(":NOMUSER_E", $datos['nom_userE'], PDO::PARAM_STR);
        $stmt->bindParam(":PASSER_E", $datos['passE'], PDO::PARAM_STR);
        $stmt->bindParam(":ROL_E", $datos['rol_userE'], PDO::PARAM_INT);
        $stmt->bindParam(":IMG_E", $datos['img'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            echo "error";
        }

        $stmt->close();
        $stmt = null;
    }

    static public function mdlMostrarAsistencias1($tabla, $item, $valor)
    {

        $stmt = conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item =:$item");

        $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch();
    }

    static public function mdlMostrarAsistencias($tabla)
    {

        $stmt = conexion::conectar()->prepare("SELECT * FROM $tabla");

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt->close();

        $stmt = null;
    }

    static public function mdlVerAsistencias($tabla, $item, $valor)
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

    static public function mdlguardarAsistencias($tabla, $datos)
    {
        $stmt = conexion::conectar()->prepare("INSERT INTO $tabla(usuario, password, nombre, apellido, foto, rol) VALUES (:USUARIO, :PASS, :NOMBRE, :APELLIDO, :FOTO, :ROL)");

        $stmt->bindParam(":NOMBRE", $datos['nom_usuario'], PDO::PARAM_STR);
        $stmt->bindParam(":APELLIDO", $datos['ape_usuario'], PDO::PARAM_STR);
        $stmt->bindParam(":USUARIO", $datos['nom_user'], PDO::PARAM_STR);
        $stmt->bindParam(":PASS", $datos['pass_user'], PDO::PARAM_STR);
        $stmt->bindParam(":ROL", $datos['rol_user'], PDO::PARAM_INT);
        $stmt->bindParam(":FOTO", $datos['foto'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            echo 'error';
        }

        $stmt->close();

        $stmt = null;
    }
}
