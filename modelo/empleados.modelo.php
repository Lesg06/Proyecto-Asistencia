<?php

require_once "coneccion.php";

class mdlEmpleados
{

	static public function mdlSesionEmpleados($tabla, $item, $valor)
	{

		$stmt = conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item =:$item");

		$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetch();
		$stmt->close();
		$stmt = null;
	}

	static public function mdlEliminarEmpleado($tabla, $valor)
	{
		$stmt = conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_empleado =:ID");

		$stmt->bindParam(":ID", $valor, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "ok";
		} else {
			echo "error";
		}

		$stmt->close();
		$stmt = null;
	}

	static public function mdlEditarEmpleado($tabla, $datos)
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
static public function mdlEditarEmpleado2($tabla, $datos) {
    try {
        $sql = "UPDATE $tabla SET 
            nombre = :nombre, 
            apellido = :apellido, 
            ci = :ci, 
            cargo = :cargo, 
            num_tlf = :num_tlf, 
            direccion = :direccion, 
            fecha_ingreso = :fecha_ingreso, 
            anio_servicio = :anio_servicio, 
            correo = :correo 
            WHERE id_empleado = :id_empleado";

        $stmt = conexion::conectar()->prepare($sql);

        $parametros = [
            ':nombre' => $datos["nombre"],
            ':apellido' => $datos["apellido"],
            ':ci' => $datos["ci"],
            ':cargo' => $datos["cargo"],
            ':num_tlf' => $datos["telefono"],
            ':direccion' => $datos["direccion"],
            ':fecha_ingreso' => $datos["fecha_ingreso"],
            ':anio_servicio' => $datos["anio_servicio"], // ← cambiado
            ':correo' => $datos["correo"],
            ':id_empleado' => $datos["id_empleado"]
        ];

        return $stmt->execute($parametros) ? "ok" : "error";

    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

static public function mdlVerEmpleado($tabla, $id_empleado)
{
    try {
        $stmt = conexion::conectar()->prepare("
            SELECT 
                e.*,
                c.nombre AS nombre_cargo
            FROM $tabla e
            LEFT JOIN cargo c ON e.cargo = c.id_cargo
            WHERE e.id_empleado = :id_empleado
            LIMIT 1
        ");

        $stmt->bindParam(":id_empleado", $id_empleado, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return ["error" => $e->getMessage()];
    }
}



static public function mdlMostrarEmpleado1($tabla, $item, $valor)
{
    $stmt = conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

    $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


	static public function mdlMostrarEmpleado2()
	{

		$stmt = conexion::conectar()->prepare("
	SELECT 
		asistencia.id_asistencia,
		asistencia.entrada,
		asistencia.salida,
		empleado.nombre AS nombre_empleado,
		empleado.apellido AS apellido_empleado,
		empleado.ci,
		cargo.nombre AS nom_cargo
	FROM asistencia
	INNER JOIN empleado ON asistencia.id_empleado = empleado.id_empleado
	INNER JOIN cargo ON empleado.cargo = cargo.id_cargo
	ORDER BY asistencia.id_asistencia DESC
");


		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	static public function mdlMostrarEmpleados($tabla)
	{

		$stmt = conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id_empleado DESC");

		$stmt->execute();

		return $stmt->fetchAll();
	}

static public function mdlguardarEmpleado($tabla, $datos)
{
    $stmt = conexion::conectar()->prepare("INSERT INTO $tabla (
        nombre, 
        apellido, 
        ci, 
        cargo, 
        num_tlf, 
        direccion, 
        fecha_ingreso, 
        anio_servicio, 
        correo
    ) VALUES (
        :NOMBRE, 
        :APELLIDO, 
        :CI, 
        :CARGO, 
        :TELEFONO, 
        :DIRECCION, 
        :FECHA_INGRESO, 
        :ANIO_SERVICIO, 
        :CORREO
    )");

    $stmt->bindParam(":NOMBRE", $datos['nom_empleado'], PDO::PARAM_STR);
    $stmt->bindParam(":APELLIDO", $datos['ape_empleado'], PDO::PARAM_STR);
    $stmt->bindParam(":CI", $datos['ci_empleado'], PDO::PARAM_STR);
    $stmt->bindParam(":CARGO", $datos['cargo_empleado'], PDO::PARAM_INT);
    $stmt->bindParam(":TELEFONO", $datos['telefono'], PDO::PARAM_STR);
    $stmt->bindParam(":DIRECCION", $datos['direccion'], PDO::PARAM_STR);
    $stmt->bindParam(":FECHA_INGRESO", $datos['fecha_ingreso'], PDO::PARAM_STR);
    $stmt->bindParam(":ANIO_SERVICIO", $datos['anio_servicio'], PDO::PARAM_INT);
    $stmt->bindParam(":CORREO", $datos['correo'], PDO::PARAM_STR);

    if ($stmt->execute()) {
        return "ok";
    } else {
        return "error";
    }

    $stmt->close();
    $stmt = null;
}

}
