<?php

class ctrAsistencias
{
    static public function ctrEliminarAsistencias($id)
    {
        $tabla = "asistencia";
        $respuesta = mdlAsistencias::mdlEliminarAsistencias($tabla, $id);

        return $respuesta;
    }

    static public function ctrMostrarAsistencias1($item, $valor)
    {
        $tabla = "asistencia";

        $respuesta = mdlAsistencias::mdlMostrarAsistencias1($tabla, $item, $valor);

        return $respuesta;
    }

    static public function ctrMostrarAsistencias()
    {
        $tabla = "asistencia";

        $repuesta = mdlAsistencias::mdlMostrarAsistencias($tabla);

        return $repuesta;
    }

    static public function ctrVerAsistencia($item, $valor)
    {

        $tabla = "asistencia";

        $respuesta = mdlAsistencias::mdlVerAsistencias($tabla, $item, $valor);

        return $respuesta;
    }

    static public function ctrEditarAsistencias()
    {

        if (isset($_POST['ed_idPerfil'])) {

            $datos = array(
                "idE" => $_POST["ed_idPerfil"],
                "nom_usuarioE" => $_POST["ed_nom_usuario"],
                "ape_usuarioE" => $_POST["ed_ape_usuario"],
                "nom_userE" => $_POST["ed_nom_user"],
                "rol_userE" => $_POST["ed_rol_user"],
            );

            $tabla = "asistencia";

            $respuesta = mdlAsistencias::mdlEditarAsistencias($tabla, $datos);

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
									window.location = "asistencia";
									}
								});
						</script>';
            } else {
                echo "<div class='alert alert-danger mt-3 small'>Edición fallida</div>";
            }
        }
    }

    static public function ctrGuardarusAsistencias()
    {

        if (isset($_POST['nom_usuario'])) {

            $datos = array(
                'nom_usuario' => $_POST['nom_usuario'],
                'nom_user' => $_POST['nom_user'],
                'rol_user' => $_POST['rol_user'],
            );
            echo "</pre>";
            print_r($datos);
            echo "</pre>";

            $tabla = "asistencia";

            $respuesta = mdlAsistencias::mdlguardarAsistencias($tabla, $datos);

            if ($respuesta = 'ok') {
                echo '<script> 
							swal.fire({
								icon: "success",
								title: "¡CORRECTO¡",
								text: "El usuario ha sido creado correctamente",
								showConfirmButton: true,
								confirmButtonText: "cerrar"
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
