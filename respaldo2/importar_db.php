<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_asistencia";

if (isset($_FILES['archivo_sql']) && $_FILES['archivo_sql']['error'] === UPLOAD_ERR_OK) {
    $archivo_tmp = $_FILES['archivo_sql']['tmp_name'];
    $nombre_archivo = $_FILES['archivo_sql']['name'];

    if (pathinfo($nombre_archivo, PATHINFO_EXTENSION) !== 'sql') {
        exit("<p style='color:red;'>❌ El archivo debe tener extensión .sql</p>");
    }

    $contenido = file_get_contents($archivo_tmp);
    $consultas = explode(";\n", $contenido);

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        exit("Error de conexión: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");
    $errores = [];
    $consultas_ejecutadas = 0;

    // 🔴 DESACTIVA restricción de claves foráneas
    $conn->query("SET FOREIGN_KEY_CHECKS=0;");

    foreach ($consultas as $sql) {
        $sql = trim($sql);
        if (!empty($sql)) {
            if ($conn->query($sql) === true) {
                $consultas_ejecutadas++;
            } else {
                $errores[] = $conn->error;
            }
        }
    }

    // ✅ REACTIVA claves foráneas
    $conn->query("SET FOREIGN_KEY_CHECKS=1;");
    $conn->close();

    if (empty($errores)) {
        echo "<script>
            alert('✅ Base de datos importada correctamente. Consultas ejecutadas: $consultas_ejecutadas');
            window.location.href = '../respaldo';
        </script>";
    } else {
        echo "<p style='color:red;'>❌ Ocurrieron errores:</p><ul>";
        foreach ($errores as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
    }
} else {
    echo "<p style='color:red;'>❌ No se seleccionó un archivo válido.</p>";
}
