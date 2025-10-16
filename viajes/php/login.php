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
            // Inicio de sesión correcto
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nombre_usuario'] = $user['nombre_usuario'];
            $_SESSION['id_rol'] = $user['id_rol'];
            header("Location: ../admi/index_admi.php"); exit;
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
