<?php

require_once "coneccion.php";

class mdlUsuarios
{

	static public function mdlSesionUsuarios($tabla, $item, $valor)
	{
		$stmt = conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item =:$item");
		$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch();
	}

	static public function mdlEliminarUsuarios($tabla, $id)
	{
		$stmt = conexion::conectar()->prepare("DELETE FROM $tabla WHERE id =:id");
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}

	static public function mdlEditarPassword($tabla, $datos)
	{
		$stmt = conexion::conectar()->prepare("UPDATE $tabla SET password=:PASSER_E WHERE id=:IDE");
		$stmt->bindParam(":IDE", $datos['idE'], PDO::PARAM_INT);
		$stmt->bindParam(":PASSER_E", $datos['passE'], PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}

	static public function mdlEditarUsuarios($tabla, $datos)
	{
		$stmt = conexion::conectar()->prepare("
			UPDATE $tabla 
			SET usuario = :NOMUSER_E,
				password = :PASSER_E,
				nombre = :NOM_E,
				apellido = :APE_E,
				foto = :IMG_E,
				rol = :ROL_E 
			WHERE id = :IDE
		");

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
			return "error";
		}
	}

	static public function mdlMostrarUsuarios1($tabla, $item, $valor)
	{
		$stmt = conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item =:$item");
		$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch();
	}

	static public function mdlMostrarUsuarios($tabla)
	{
		$stmt = conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $tabla.`id` DESC");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function mdlguardarUsuarios($tabla, $datos)
	{
		$stmt = conexion::conectar()->prepare("
			INSERT INTO $tabla(usuario, password, nombre, apellido, foto, rol)
			VALUES (:USUARIO, :PASS, :NOMBRE, :APELLIDO, :FOTO, :ROL)
		");

		$stmt->bindParam(":NOMBRE", $datos['nom_usuario'], PDO::PARAM_STR);
		$stmt->bindParam(":APELLIDO", $datos['ape_usuario'], PDO::PARAM_STR);
		$stmt->bindParam(":USUARIO", $datos['nom_user'], PDO::PARAM_STR);
		$stmt->bindParam(":PASS", $datos['pass_user'], PDO::PARAM_STR);
		$stmt->bindParam(":ROL", $datos['rol_user'], PDO::PARAM_INT);
		$stmt->bindParam(":FOTO", $datos['foto'], PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}
}
