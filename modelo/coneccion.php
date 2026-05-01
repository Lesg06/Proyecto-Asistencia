<?php

class conexion
{
	static public function conectar()
	{
		$link = new PDO("mysql:host=localhost;dbname=sistema_asistencia", "root", "");

		$link->exec("set names utf8mb4");

		return $link;
	}
}
