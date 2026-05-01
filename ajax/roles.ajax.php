<?php
require_once "../controlador/roles.controlador.php";
require_once "../modelo/roles.modelo.php";

class AjaxRoles{

    public $idRoles;

    public function ajaxEditarRoles(){

        $item = "id_roles";
        $valor = $this->idRoles;

        $respuesta = ctrRoles::ctrVerRoles($item, $valor);

        echo json_encode($respuesta);
       
    }


    public $idRolE;

    public function ajaxEliminarRoles(){

        $item = "id_roles";
        $valor = $this->idRolE;

        $respuesta = ctrRoles::ctrEliminarRoles($item, $valor);

        echo json_encode($respuesta);
       
    }
    

}

//Editar roles

if(isset($_POST["idRoles"])){

    $editar = new AjaxRoles();
    $editar->idRoles = $_POST["idRoles"];
    $editar->ajaxEditarRoles();
}

//Eliminar Rol

if(isset($_POST["idRolE"])){

    $eliminar = new AjaxRoles();
    $eliminar->idRolE = $_POST["idRolE"];
    $eliminar->ajaxEliminarRoles();
}

?>