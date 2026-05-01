<?php

class ctrEstadistica
{

    static public function ctrMostrarEstadistica($valor)
    {

        $tabla = "asistencia";

        $repuesta = mdlEstadistica::mdlEstadistias($tabla, $valor);

        return $repuesta;
    }
}
