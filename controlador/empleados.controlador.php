<?php

class ctrEmpleados
{

	static public function ctrIngresoEmpleado()
	{

		if (isset($_POST['log_user'])) {
			$cifrarPass = crypt($_POST['log_pass'], '$5$rounds=5000$usesomesillystringforsalt$');

			$tabla = "usuarios";
			$item = "usuario";
			$valor = $_POST['log_user'];

			$respuesta = mdlEmpleados::mdlSesionEmpleados($tabla, $item, $valor);

			if ($respuesta['usuario'] == $_POST['log_user'] && $respuesta['password'] == $cifrarPass) {

				$_SESSION['validarSesion'] = "ok";
				$_SESSION['idBackend'] = $respuesta['id'];

				echo '<script> window.location = "home"; </script>';
			} else {
				echo '<div class="alert alert-danger mt-3 small">Error: Usuasio y/o contraseña incorrecta</div>';
			}
		}
	}

	static public function ctrEliminarEmpleados($valor)
	{
		$tabla = "empleado";
		$respuesta = mdlEmpleados::mdlEliminarEmpleado($tabla, $valor);

		return $respuesta;
	}

public static function ctrMostrarEmpleados1($item, $valor)
{
    $tabla = "empleado";
    $respuesta = mdlEmpleados::mdlMostrarEmpleado1($tabla, $item, $valor);
    return $respuesta;
}


	static public function ctrMostrarEmpleados2()
	{
		$respuesta = mdlEmpleados::mdlMostrarEmpleado2();

		return $respuesta;
	}

	static public function ctrMostrarEmpleados()
	{
		$tabla = "empleado";

		$repuesta = mdlEmpleados::mdlMostrarEmpleados($tabla);

		return $repuesta;
	}
	static public function ctrVerEmpleado($id_empleado)
{
    $tabla = "empleado";
    return mdlEmpleados::mdlVerEmpleado($tabla, $id_empleado);
}

	static public function ctrEditarEmpleados()
	{

		if (isset($_POST['ed_idPerfil'])) {
			if (isset($_FILES['ed_subirImgUsuario']['tmp_name']) && !empty($_FILES['ed_subirImgUsuario']['tmp_name'])) {
				list($ancho, $alto) = getimagesize($_FILES['ed_subirImgUsuario']['tmp_name']);
				$nuevoAncho = 480;
				$nuevoAlto = 382;

				/* Directorio donde se guardará la foto de los usuarios*/
				$directorio = "vistas/imagenes/usuarios";

				/* Elimina la foto vieja del servidor */
				if (isset($_POST['fotoActualE'])) {

					unlink($_POST['fotoActualE']);
				}

				if ($_FILES['ed_subirImgUsuario']['type'] == "image/jpeg") {

					$aleatorio = mt_rand(100, 999);

					$ruta = $directorio . "/" . $aleatorio . ".jpg";

					$origen = imagecreatefromjpeg($_FILES['ed_subirImgUsuario']['tmp_name']);

					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta);
				} elseif ($_FILES['ed_subirImgUsuario']['type'] == "image/png") {

					$aleatorio = mt_rand(100, 999);

					$ruta = $directorio . "/" . $aleatorio . ".png";

					$origen = imagecreatefrompng($_FILES['ed_subirImgUsuario']['tmp_name']);

					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagealphablending($destino, FALSE);

					imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $ruta);
				} else {
					echo '<script>
						swal.fire({
								icon:"error",
								title:"¡CORREGIR¡",
								text: "¿no se permiten formatos diferentes a JPG y/o PNG",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then(function(result){
								if(result.value){
									history.back();
								}
								});
					</script>';
					return;
				}
			}

			/* Comprueba si hay cambio de foto */

			if ($ruta != "") {
				$r = $ruta;
			} else {
				$r = $_POST['fotoActualE'];
			}

			/*Compueba si hay cambio de contraseña */
			if ($_POST['ed_pass_user'] != "") {
				$password = crypt($_POST['ed_pass_user'], '$5$rounds=5000$usesomesillystringforsalt$');
			} else {
				$password = $_POST['pass_useractual'];
			}

			$datos = array(
				"idE" => $_POST["ed_idPerfil"],
				"nom_usuarioE" => $_POST["ed_nom_usuario"],
				"ape_usuarioE" => $_POST["ed_ape_usuario"],
				"nom_userE" => $_POST["ed_nom_user"],
				"passE" => $password,
				"rol_userE" => $_POST["ed_rol_user"],
				"img" => $r
			);

			$tabla = "usuarios";

			$respuesta = mdlEmpleados::mdlEditarEmpleado($tabla, $datos);

			if ($respuesta = "ok") {
				echo '<script>
							swal.fire({
								icon:"success",
								title:"¡CORRECTO¡",
								text: "el ususario ha sido editado correctamente",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"

							}).then(function(result){

								if(result.value){
									//history.back();
									window.location = "usuarios";
									}
								});
						</script>';
			} else {
				echo "<div class='alert alert-danger mt-3 small'>Edición fallida</div>";
			}
		}
	}
static public function ctrEditarEmpleado2($datos) {
    $tabla = "empleado"; // ✔️ nombre correcto de la tabla
    return mdlEmpleados::mdlEditarEmpleado2($tabla, $datos);
}



	static public function ctrGuardarEmpleado()
{
    if (isset($_POST['nom_empleado'])) {

        $datos = array(
            'nom_empleado'     => $_POST['nom_empleado'],
            'ape_empleado'     => $_POST['ape_empleado'],
            'cargo_empleado'   => $_POST['cargo_empleado'],
            'ci_empleado'      => $_POST['ci_empleado'],
            'telefono'         => $_POST['telefono'] ?? null,
            'direccion'        => $_POST['direccion'] ?? null,
            'fecha_ingreso'    => $_POST['fecha_ingreso'] ?? null,
            'anio_servicio'    => $_POST['anio_servicio'] ?? null,
            'correo'           => $_POST['correo'] ?? null
        );

        $tabla = "empleado";

        $respuesta = mdlEmpleados::mdlguardarEmpleado($tabla, $datos);

        if ($respuesta == 'ok') {
            echo '<script> 
                Swal.fire({
                    icon: "success",
                    title: "¡CORRECTO!",
                    text: "El empleado ha sido creado correctamente",
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if(result.value){
                        history.back();
                    }
                });
            </script>';
        } else {
            echo '<div class="alert alert-danger mt-3 small">Registro fallido</div>';
        }
    }
}

}
