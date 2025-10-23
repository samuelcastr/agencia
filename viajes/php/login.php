<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = trim($_POST['correo'] ?? '');
    $clave = $_POST['clave'] ?? '';

    $stmt = $conexion->prepare("SELECT id_usuario, nombre_usuario, contraseña, id_rol FROM cuenta_usuario WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows === 1) {
        $user = $res->fetch_assoc();

        if (password_verify($clave, $user['contraseña'])) {
            // ===== Guardamos datos en sesión =====
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nombre_usuario'] = $user['nombre_usuario'];
            $_SESSION['correo'] = $correo;
            $_SESSION['id_rol'] = $user['id_rol'];

            // ===== PASO CLAVE: enviar los valores al entorno MySQL =====
           $conexion->query("
            INSERT INTO sesion_actual (id_usuario, nombre_usuario, id_rol)
            VALUES ({$_SESSION['id_usuario']}, '{$_SESSION['nombre_usuario']}', {$_SESSION['id_rol']})
            ON DUPLICATE KEY UPDATE
            nombre_usuario = VALUES(nombre_usuario),
            id_rol = VALUES(id_rol),
            fecha = NOW();
            ");

            // ===== Redirección según rol =====
            switch ($user['id_rol']) {
                case 1:
                    header("Location: ../admi/index_admi.php");
                    break;
                case 2:
                    header("Location: ../usuario/panel_usuario.php");
                    break;
                case 3:
                    header("Location: ../invitado/panel_invitado.php");
                    break;
                default:
                    echo "<script>alert('Rol no válido'); window.history.back();</script>";
                    exit;
            }
            exit;
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Usuario no encontrado'); window.history.back();</script>";
        exit;
    }
}
?>
