<?php

class ctrCargos
{

    static public function ctrEliminarCargo($item, $valor)
    {

        $tabla = "cargo";

        $respuesta = mdlCargos::mdlEliminarCargo($tabla, $valor);

        return $respuesta;
    }

    static public function ctrMostrarCargos($item, $valor)
    {

        $tabla = "cargo";

        $repuesta = mdlCargos::mdlMostrarCargos($tabla, $item, $valor);

        return $repuesta;
    }
    

    static public function ctrMostrarCargos2()
    {

        $tabla = "cargo";

        $repuesta = mdlCargos::mdlMostrarCargos2($tabla);

        return $repuesta;
    }
static public function ctrEditarCargoAjax($id, $nombre)
{
    $tabla = "cargo";
    return mdlCargos::mdlEditarCargo($tabla, $nombre, $id);
}

    static public function ctrGuardarCargo()
    {

        if (isset($_POST['nom_cargo'])) {

            $nomCarg = $_POST['nom_cargo'];

            $tabla = "cargo";

            $respuesta = mdlCargos::mdlGuardarCargo($tabla, $nomCarg);

            if ($respuesta = "ok") {
                echo '<script>
                        swal.fire({
                            icon:"success",
                            title:"¡CORRECTO¡",
                            text: "El cargo ha sido guardado correctamente",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"

                        }).then(function(result){

                            if(result.value){
                                //history.back();
                                window.location = "cargos";
                                }
                            });
                    </script>';
            } else {
                echo "<div class='alert alert-danger mt-3 small'>Edición fallida</div>";
            }
        }
    }

    static public function ctrVerCargo($item, $valor)
    {

        $tabla = "cargo";

        $respuesta = mdlCargos::mdlVerCargo($tabla, $item, $valor);

        return $respuesta;
    }

    static public function ctrEditarCargo()
    {

        if (isset($_POST['nom_cargoE'])) {

            $nomRolE = $_POST['nom_cargoE'];

            $idRol = $_POST['id_cargoE'];

            $tabla = "cargo";

            $respuesta = mdlCargos::mdlEditarCargo($tabla, $nomRolE, $idRol);

            if ($respuesta = "ok") {
                echo '<script>
                        swal.fire({
                            icon:"success",
                            title:"¡CORRECTO¡",
                            text: "El cargo ha sido actualizado correctamente",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"

                        }).then(function(result){

                            if(result.value){
                                //history.back();
                                window.location = "cargo";
                                }
                            });
                    </script>';
            } else {
                echo "<div class='alert alert-danger mt-3 small'>Edición fallida</div>";
            }
        }
    }
}
