<?php

class ctrUsuarios
{


static public function ctrIngresoUsusrio()
{
	if (isset($_POST['log_user'])) {

		$cifrarPass = crypt($_POST['log_pass'], '$5$rounds=5000$usesomesillystringforsalt$');

		$tabla = "usuarios";
		$item = "usuario";
		$valor = $_POST['log_user'];

		$respuesta = mdlUsuarios::mdlSesionUsuarios($tabla, $item, $valor);

		if ($respuesta && $respuesta['usuario'] == $_POST['log_user'] && $respuesta['password'] == $cifrarPass) {

			$_SESSION['validarSesion'] = "ok";
			$_SESSION['id'] = $respuesta['id'];
			$_SESSION['usuario'] = $respuesta['usuario'];
			$_SESSION['password'] = $respuesta['password'];
			$_SESSION['nombre'] = $respuesta['nombre'];
			$_SESSION['apellido'] = $respuesta['apellido'];
			$_SESSION['foto'] = $respuesta['foto'];
			$_SESSION['rol'] = $respuesta['rol'];
			$_SESSION['idBackend'] = $respuesta['id'];
			$_SESSION['email'] = $respuesta['email'];

				$rol = ctrRoles::ctrMostrarRoles("id_roles", $respuesta['rol']);
				$_SESSION['nom_rol'] = $rol['nom_rol'] ?? '';
			echo '<script> window.location = "home"; </script>';

		} else {
			echo '<div class="alert alert-danger mt-3 small">Error: Usuario y/o contraseña incorrecta</div>';
		}
	}
}
	static public function ctrEliminarUsuarios($id, $rutafoto)
	{

		unlink("../" . $rutafoto);

		$tabla = "usuarios";
		$respuesta = mdlUsuarios::mdlEliminarUsuarios($tabla, $id);

		return $respuesta;
	}

	static public function ctrMostrarUsuarios1($item, $valor)
	{
		$tabla = "usuarios";

		$respuesta = mdlUsuarios::mdlMostrarUsuarios1($tabla, $item, $valor);

		return $respuesta;
	}

	static public function ctrMostrarUsuarios()
	{
		$tabla = "usuarios";

		$repuesta = mdlUsuarios::mdlMostrarUsuarios($tabla);

		return $repuesta;
	}

	static public function ctrEditaruarios()
{
	if (isset($_POST['ed_idPerfil'])) {
		$tabla = "usuarios";
$item = "usuario";
$valor = $_POST['ed_nom_user'];
$usuarioExistente = mdlUsuarios::mdlSesionUsuarios($tabla, $item, $valor);

// Validar que el nombre de usuario no pertenezca a otro ID
if ($usuarioExistente && $usuarioExistente['id'] != $_POST['ed_idPerfil']) {
	echo '<script>
		swal.fire({
			icon: "error",
			title: "¡Usuario duplicado!",
			text: "El nombre de usuario ya está en uso por otro usuario.",
			confirmButtonText: "Cerrar"
		});
	</script>';
	return;
}


		$ruta = $_POST['fotoActualE']; // Por defecto, conserva la actual

if (!empty($_FILES['ed_subirImgUsuario']['tmp_name'])) {
    list($ancho, $alto) = getimagesize($_FILES['ed_subirImgUsuario']['tmp_name']);
    $nuevoAncho = 480;
    $nuevoAlto = 382;
    $directorio = "vistas/imagenes/usuarios";
    $aleatorio = mt_rand(100, 999);

    if (!empty($_POST['fotoActualE']) && file_exists($_POST['fotoActualE'])) {
        unlink($_POST['fotoActualE']);
    }

    $mimeType = mime_content_type($_FILES['ed_subirImgUsuario']['tmp_name']);
    echo "<script>console.log('Tipo MIME detectado: $mimeType');</script>";

    if (in_array($mimeType, ["image/jpeg", "image/jpg", "image/pjpeg"])) {
        $ruta = $directorio . "/" . $aleatorio . ".jpg";
        $origen = @imagecreatefromjpeg($_FILES['ed_subirImgUsuario']['tmp_name']);

        if (!$origen) {
            echo '<script>
                swal.fire({
                    icon: "error",
                    title: "¡Error!",
                    text: "No se pudo procesar la imagen JPG. Asegúrate de que esté en buen estado.",
                    confirmButtonText: "Cerrar"
                });
            </script>';
            return;
        }

        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
        imagejpeg($destino, $ruta);
    } elseif ($mimeType == "image/png") {
        $ruta = $directorio . "/" . $aleatorio . ".png";
        $origen = @imagecreatefrompng($_FILES['ed_subirImgUsuario']['tmp_name']);

        if (!$origen) {
            echo '<script>
                swal.fire({
                    icon: "error",
                    title: "¡Error!",
                    text: "No se pudo procesar la imagen PNG.",
                    confirmButtonText: "Cerrar"
                });
            </script>';
            return;
        }

        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        imagealphablending($destino, false);
        imagesavealpha($destino, true);
        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
        imagepng($destino, $ruta);
    } else {
        echo '<script>
            swal.fire({
                icon:"error",
                title:"¡CORREGIR!",
                text: "Solo se permiten imágenes en formato JPG o PNG",
                confirmButtonText: "Cerrar"
            });
        </script>';
        return;
    }

    // Verificar si se guardó correctamente
    if (!file_exists($ruta)) {
        echo '<script>
            swal.fire({
                icon: "error",
                title: "¡Error al guardar!",
                text: "No se pudo guardar la imagen en el servidor.",
                confirmButtonText: "Cerrar"
            });
        </script>';
        return;
    }
}


		// Procesar contraseña (si se cambia)
		if (!empty($_POST['ed_pass_user'])) {
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
			"img" => $ruta
		);

		$tabla = "usuarios";
		$respuesta = mdlUsuarios::mdlEditarUsuarios($tabla, $datos);

		if ($respuesta == "ok") {
			echo '<script>
				swal.fire({
					icon: "success",
					title: "¡CORRECTO!",
					text: "El usuario ha sido editado correctamente",
					showConfirmButton: true,
					confirmButtonText: "Cerrar"
				}).then(function(result){
					if(result.value){
						window.location = "usuarios";
					}
				});
			</script>';
		} else {
			echo "<div class='alert alert-danger mt-3 small'>Edición fallida</div>";
		}
	}
}
static public function ctrEditarPerfilPropio()
{
    if (isset($_POST['ed_idPerfil'])) {

        $tabla = "usuarios";

        // Verifica si el usuario ya existe y no es otro con el mismo nombre
        $item = "usuario";
        $valor = $_POST['ed_nom_user'];
        $usuarioExistente = mdlUsuarios::mdlSesionUsuarios($tabla, $item, $valor);

        if ($usuarioExistente && $usuarioExistente['id'] != $_POST['ed_idPerfil']) {
            echo '<script>
                swal.fire({
                    icon: "error",
                    title: "¡Usuario duplicado!",
                    text: "El nombre de usuario ya está en uso.",
                    confirmButtonText: "Cerrar"
                });
            </script>';
            return;
        }

        $ruta = $_POST['fotoActualE'];

        if (!empty($_FILES['ed_subirImgUsuario']['tmp_name'])) {
    list($ancho, $alto) = getimagesize($_FILES['ed_subirImgUsuario']['tmp_name']);
    $nuevoAncho = 480;
    $nuevoAlto = 382;
    $directorio = "vistas/imagenes/usuarios";
    $aleatorio = mt_rand(100, 999);

    if (!empty($_POST['fotoActualE']) && file_exists($_POST['fotoActualE'])) {
        unlink($_POST['fotoActualE']);
    }

    $mimeType = mime_content_type($_FILES['ed_subirImgUsuario']['tmp_name']);
    echo "<script>console.log('Tipo MIME detectado: $mimeType');</script>";

    if (in_array($mimeType, ["image/jpeg", "image/jpg", "image/pjpeg"])) {
        $ruta = $directorio . "/" . $aleatorio . ".jpg";
        $origen = @imagecreatefromjpeg($_FILES['ed_subirImgUsuario']['tmp_name']);

        if (!$origen) {
            echo '<script>
                swal.fire({
                    icon: "error",
                    title: "¡Error!",
                    text: "No se pudo procesar la imagen JPG. Asegúrate de que esté en buen estado.",
                    confirmButtonText: "Cerrar"
                });
            </script>';
            return;
        }

        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
        imagejpeg($destino, $ruta);
    } elseif ($mimeType == "image/png") {
        $ruta = $directorio . "/" . $aleatorio . ".png";
        $origen = @imagecreatefrompng($_FILES['ed_subirImgUsuario']['tmp_name']);

        if (!$origen) {
            echo '<script>
                swal.fire({
                    icon: "error",
                    title: "¡Error!",
                    text: "No se pudo procesar la imagen PNG.",
                    confirmButtonText: "Cerrar"
                });
            </script>';
            return;
        }

        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        imagealphablending($destino, false);
        imagesavealpha($destino, true);
        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
        imagepng($destino, $ruta);
    } else {
        echo '<script>
            swal.fire({
                icon:"error",
                title:"¡CORREGIR!",
                text: "Solo se permiten imágenes en formato JPG o PNG",
                confirmButtonText: "Cerrar"
            });
        </script>';
        return;
    }

    // Verificar si se guardó correctamente
    if (!file_exists($ruta)) {
        echo '<script>
            swal.fire({
                icon: "error",
                title: "¡Error al guardar!",
                text: "No se pudo guardar la imagen en el servidor.",
                confirmButtonText: "Cerrar"
            });
        </script>';
        return;
    }
}


        // Contraseña
        if (!empty($_POST['ed_pass_user'])) {
            $password = crypt($_POST['ed_pass_user'], '$5$rounds=5000$usesomesillystringforsalt$');
        } else {
            $password = $_SESSION['password']; // usar la que está en sesión si no cambia
        }

        $datos = array(
            "idE" => $_POST["ed_idPerfil"],
            "nom_usuarioE" => $_POST["ed_nom_usuario"],
            "ape_usuarioE" => $_POST["ed_ape_usuario"],
            "nom_userE" => $_POST["ed_nom_user"],
            "passE" => $password,
            "rol_userE" => $_POST["ed_rol_user"], // aunque no se permite cambiar, se mantiene
            "img" => $ruta
        );

        $respuesta = mdlUsuarios::mdlEditarUsuarios($tabla, $datos);

        if ($respuesta == "ok") {
            // Actualizar sesión
            $_SESSION['nombre'] = $_POST["ed_nom_usuario"];
            $_SESSION['apellido'] = $_POST["ed_ape_usuario"];
            $_SESSION['usuario'] = $_POST["ed_nom_user"];
            $_SESSION['password'] = $password;
            $_SESSION['foto'] = $ruta;
            $_SESSION['email'] = $_POST["ed_email_usuario"];

            echo '<script>
                swal.fire({
                    icon: "success",
                    title: "Perfil actualizado",
                    text: "Tus cambios fueron guardados correctamente.",
                    confirmButtonText: "Cerrar"
                }).then((result) => {
                    if (result.value) {
                        window.location = "perfil";
                    }
                });
            </script>';
        } else {
            echo '<div class="alert alert-danger mt-3 small">No se pudo actualizar el perfil</div>';
        }
    }
}



static public function ctrGuardarusuarios()
{
	if (isset($_POST['cr_nom_usuario'])) {

		// Verificar si el usuario ya existe
		$tabla = "usuarios";
		$item = "usuario";
		$valor = $_POST['cr_nom_user'];
		$usuarioExistente = mdlUsuarios::mdlSesionUsuarios($tabla, $item, $valor);

		if ($usuarioExistente) {
			echo '<script>
				swal.fire({
					icon: "error",
					title: "¡Usuario duplicado!",
					text: "El nombre de usuario ya está registrado. Por favor, elige otro.",
					confirmButtonText: "Cerrar"
				});
			</script>';
			return;
		}

        


		if (!empty($_FILES['cr_subirImgUsuario']['tmp_name'])) {

			list($ancho, $alto) = getimagesize($_FILES['cr_subirImgUsuario']['tmp_name']);
			$nuevoAncho = 480;
			$nuevoAlto = 382;
			$directorio = "vistas/imagenes/usuarios";

			$aleatorio = mt_rand(100, 999);

			if ($_FILES['cr_subirImgUsuario']['type'] == "image/jpeg") {
				$ruta = $directorio . "/" . $aleatorio . ".jpg";
				$origen = imagecreatefromjpeg($_FILES['cr_subirImgUsuario']['tmp_name']);
				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
				imagejpeg($destino, $ruta);
			} elseif ($_FILES['cr_subirImgUsuario']['type'] == "image/png") {
				$ruta = $directorio . "/" . $aleatorio . ".png";
				$origen = imagecreatefrompng($_FILES['cr_subirImgUsuario']['tmp_name']);
				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
				imagealphablending($destino, false);
				imagesavealpha($destino, true);
				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
				imagepng($destino, $ruta);
			} else {
				echo '<script>
						swal.fire({
							icon:"error",
							title:"¡CORREGIR¡",
							text: "No se permiten formatos diferentes a JPG y/o PNG",
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

		$cifrarPassword = crypt($_POST['cr_pass_user'], '$5$rounds=5000$usesomesillystringforsalt$');

		$datos = array(
			'nom_usuario' => $_POST['cr_nom_usuario'],
			'ape_usuario' => $_POST['cr_ape_usuario'],
			'nom_user' => $_POST['cr_nom_user'],
			'pass_user' => $cifrarPassword,
			'rol_user' => $_POST['cr_rol_user'],
			'foto' => $ruta
		);

		$tabla = "usuarios";
		$respuesta = mdlUsuarios::mdlguardarUsuarios($tabla, $datos);

		if ($respuesta == 'ok') {
			echo '<script> 
					swal.fire({
						icon: "success",
						title: "¡CORRECTO!",
						text: "El usuario ha sido creado correctamente",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){
						if(result.value){
							window.location = "usuarios";
						}
					});
				</script>';
		} else {
			echo '<div class="alert alert-danger mt-3 small">Registro fallido</div>';
		}
	}
}

}
