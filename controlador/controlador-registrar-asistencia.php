<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include "modelo/conexion.php";
    date_default_timezone_set("America/Caracas");

    if (!empty($_POST["btnentrada"])) {

        if (!empty($_POST["txtci"])) {
            $ci = $_POST["txtci"];

            $consulta = $conexion->query("SELECT COUNT(*) AS total FROM empleado WHERE ci='$ci'");
            $id = $conexion->query("SELECT id_empleado FROM empleado WHERE ci='$ci'");

            if ($consulta->fetch_object()->total > 0) {
                $id_empleado = $id->fetch_object()->id_empleado;

                // Verificar si ya hay entrada hoy sin salida
                $verificar = $conexion->query("
                    SELECT COUNT(*) AS total FROM asistencia 
                    WHERE id_empleado = $id_empleado 
                    AND DATE(entrada) = CURDATE() 
                    AND salida = '0000-00-00 00:00:00'
                ");

                if ($verificar->fetch_object()->total == 0) {
                    $fecha = date("Y-m-d H:i:s");
                    $sql = $conexion->query("INSERT INTO asistencia(id_empleado, entrada) VALUES($id_empleado, '$fecha')");

                    if ($sql == true) {
                        echo "<script>
                            Swal.fire({ icon: 'success', title: 'CORRECTO', showConfirmButton: false, timer: 1500 });
                        </script>";
                    } else {
                        echo "<script>
                            Swal.fire({ icon: 'error', title: 'Error al registrar ENTRADA', showConfirmButton: false, timer: 1500 });
                        </script>";
                    }
                } else {
                    echo "<script>
                        Swal.fire({ icon: 'info', title: 'Ya registraste tu entrada hoy.', showConfirmButton: false, timer: 2000 });
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({ icon: 'error', title: 'La cédula ingresada no existe', showConfirmButton: false, timer: 1500 });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({ icon: 'error', title: 'Ingrese la cédula', showConfirmButton: false, timer: 1500 });
            </script>";
        }
    }

    // -------- SALIDA --------
    if (!empty($_POST["btnsalida"])) {
        if (!empty($_POST["txtci"])) {
            $ci = $_POST["txtci"];
            $consulta = $conexion->query("SELECT COUNT(*) AS total FROM empleado WHERE ci='$ci'");
            $id = $conexion->query("SELECT id_empleado FROM empleado WHERE ci='$ci'");

            if ($consulta->fetch_object()->total > 0) {
                $fecha = date("Y-m-d H:i:s");
                $id_empleado = $id->fetch_object()->id_empleado;
                $busqueda = $conexion->query("SELECT id_asistencia FROM asistencia WHERE id_empleado=$id_empleado ORDER BY id_asistencia DESC LIMIT 1");
                $id_asistencia = $busqueda->fetch_object()->id_asistencia;

                $sql = $conexion->query("UPDATE asistencia SET salida='$fecha' WHERE id_asistencia=$id_asistencia");

                if ($sql == true) {
                    echo "<script>
                        Swal.fire({ icon: 'success', title: 'Adiós, vuelve pronto!!', showConfirmButton: false, timer: 1500 });
                    </script>";
                } else {
                    echo "<script>
                        Swal.fire({ icon: 'error', title: 'Error al registrar SALIDA', showConfirmButton: false, timer: 1500 });
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({ icon: 'error', title: 'La cédula ingresada no existe', showConfirmButton: false, timer: 1500 });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({ icon: 'error', title: 'Ingrese la cédula', showConfirmButton: false, timer: 1500 });
            </script>";
        }
    }

    // Evita reenvío duplicado al recargar
    echo "<script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>";
}
?>
