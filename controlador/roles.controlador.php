<?php

class ctrRoles{

    static public function ctrEliminarRoles($item, $valor){

        $tabla = "roles";

        $respuesta = mdlRoles::mdlEliminarRoles($tabla, $valor);

        return $respuesta;
    }

    static public function ctrMostrarRoles($item, $valor){

        $tabla = "roles";

        $repuesta = mdlRoles::mdlMostrarRoles($tabla, $item, $valor);

        return $repuesta;

    }

    static public function ctrMostrarRoles2(){

        $tabla = "roles";

        $repuesta = mdlRoles::mdlMostrarRoles2($tabla);

        return $repuesta;

    }

    static public function ctrGuardarRol(){

        if(isset($_POST['nom_rol'])){

            $nomRol = $_POST['nom_rol'];

            $tabla = "roles";

            $respuesta = mdlRoles::mdlGuardarRoles($tabla,$nomRol);

            if($respuesta = "ok"){
                echo '<script>
                        swal.fire({
                            icon:"success",
                            title:"¡CORRECTO¡",
                            text: "el Rol ha sido Guardado correctamente",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"

                        }).then(function(result){

                            if(result.value){
                                //history.back();
                                window.location = "roles";
                                }
                            });
                    </script>';
            }else{
                echo "<div class='alert alert-danger mt-3 small'>Edición fallida</div>";
            }

        }
    }

    static public function ctrVerRoles($item, $valor){

        $tabla = "roles";

        $respuesta = mdlRoles::mdlVerRoles($tabla, $item, $valor);

        return $respuesta;

    }

    static public function ctrEditarRol(){

        if(isset($_POST['nom_rolE'])){

            $nomRolE = $_POST['nom_rolE'];

            $idRol = $_POST['id_rolE'];

            $tabla = "roles";

            $respuesta = mdlRoles::mdlEditarRoles($tabla,$nomRolE,$idRol);

            if($respuesta = "ok"){
                echo '<script>
                        swal.fire({
                            icon:"success",
                            title:"¡CORRECTO¡",
                            text: "el Rol ha sido Actualizado correctamente",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"

                        }).then(function(result){

                            if(result.value){
                                //history.back();
                                window.location = "roles";
                                }
                            });
                    </script>';
            }else{
                echo "<div class='alert alert-danger mt-3 small'>Edición fallida</div>";
            }

        }

    }
}

?>