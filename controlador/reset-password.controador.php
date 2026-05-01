<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vistas/PHPMailer/src/Exception.php';
require 'vistas/PHPMailer/src/PHPMailer.php';
require 'vistas/PHPMailer/src/SMTP.php';

class ctrResetPassword
{

    public function ctrResetPassword()
    {
        if (isset($_POST['reset-password'])) {
            $tabla = "usuarios";
            $item = "usuario";
            $valor = $_POST['reset-password'];

            $respuesta = mdlUsuarios::mdlSesionUsuarios($tabla, $item, $valor);


            if ($respuesta['usuario'] == $_POST['reset-password']) {

                $passwordNuevo = uniqid();
                $password = crypt($passwordNuevo, '$5$rounds=5000$usesomesillystringforsalt$');

                $datos = array(
                    "idE" => $respuesta['id'],
                    "passE" => $password,
                );

                if ($respuesta['email'] != null) {

                    $mail = new PHPMailer; // Crear una instancia de PHPMailer

                    //$mail->SMTPDebug = 1; // Habilitar debug (solo en desarrollo)
                    $mail->isSMTP(); // Establecer como envío SMTP
                    $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
                    $mail->Port = 587; // Puerto SMTP
                    $mail->SMTPSecure = 'tls'; // Tipo de seguridad (tls o ssl)
                    $mail->SMTPAuth = true; // Habilitar autenticación SMTP
                    $mail->Username = 'sarmientoxluis1@gmail.com'; // Nombre de usuario SMTP
                    $mail->Password = 'hxdo mvjm dfnz djmo'; // Contraseña SMTP e2fb1e929d075a2c6d6276153624ed39-7c5e3295-7dd6cf72

                    $mail->setFrom('sarmientoxluis1@gmail.com', 'Sistema de asistencias'); // Remitente
                    $mail->addAddress($respuesta['email'], $respuesta['usuario']); // Destinatario

                    $mail->isHTML(true);
                    $mail->Subject = 'Nueva Clave de Acceso Sistema de Asistencias'; // Asunto
                    $mail->Body =  'Se ha creado una nueva calve de acceso para el susario ' . $_POST['reset-password'] . '  es: <b>' . $passwordNuevo . '</b>'; // Cuerpo del mensaje
                    $mail->AltBody = 'Cuerpo de texto plano para correos que no soportan HTML'; // Versión de texto plano

                    if ($mail->send()) {
                        // echo '<br>La contraseña <b>' . $passwordNuevo . '</b> Se ha sido enviado a ' . $respuesta['email'];
                    }

                    $tabla = "usuarios";
                    $respuesta2 = mdlUsuarios::mdlEditarPassword($tabla, $datos);


                    if ($respuesta2 == 'ok') {
                        echo '<script> Swal.fire({
							icon: "success",
							title: "Se envío un correo electronico con la contrasea nueva",
							showConfirmButton: false,
							timer: 10000
						}); </script>';
                    }
                } else {
                    echo '<script> Swal.fire({
						icon: "error",
						title: "El usuario no tiene correo electronico pongase en contacto con el administrador",
						showConfirmButton: false,
						timer: 2000
					}); </script>';
                }
            } else {
                echo '<script> Swal.fire({
						icon: "error",
						title: "El usuario no existe",
						showConfirmButton: false,
						timer: 2000
					}); </script>';
            }
        }
    }
}
