<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];

    // Buscar usuario por correo
    $sql = "SELECT * FROM cuenta_usuario WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verificar contraseña
        if (password_verify($clave, $usuario['contraseña'])) {
            $_SESSION['nombre'] = $usuario['nombre_usuario'];
            $_SESSION['rol'] = $usuario['id_rol'];

            // Redirigir según rol
            switch ($usuario['id_rol']) {
                case 1:
                    header("Location: ../admi/index_admi.php");
                    break;
                case 2:
                    header("Location: ../usuario/index.php");
                    break;
                case 3:
                    header("Location: ../invitado/index.php");
                    break;
                default:
                    header("Location: ../../inicio_registro.html");
            }
            exit;
        } else {
            echo "<script>
                    alert('⚠️ Contraseña incorrecta.');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('⚠️ No existe una cuenta con ese correo.');
                window.history.back();
              </script>";
    }

    $stmt->close();
    $conexion->close();
}
?>
