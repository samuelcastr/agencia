<?php
session_start();
include('../php/conexion.php');

if (!isset($_SESSION['correo'])) {
    header("Location: ../index.php");
    exit;
}

$correo = $_SESSION['correo'];
$query = "SELECT nombre_usuario, correo FROM cuenta_usuario WHERE correo = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil | Sol & Mar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-amber-600 to-amber-500 text-white flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-2 px-6 py-4 border-b border-amber-400">
                <i class="fa-solid fa-leaf text-2xl text-sky-800"></i>
                <h1 class="text-xl font-bold">Sol & Mar</h1>
            </div>
            <nav class="mt-6 space-y-2">
                <a href="panel_invitado.php" class="flex items-center gap-3 px-6 py-3 hover:bg-amber-700 transition">
                    <i class="fa-solid fa-house"></i><span>Inicio</span>
                </a>
                <a href="destinos.php" class="flex items-center gap-3 px-6 py-3 hover:bg-amber-700 transition">
                    <i class="fa-solid fa-plane-departure"></i><span>Ver Paquetes</span>
                </a>
                <a href="reservas_invitado.php" class="flex items-center gap-3 px-6 py-3 hover:bg-amber-700 transition">
                    <i class="fa-solid fa-book"></i><span>Mis Reservas</span>
                </a>
                <a href="perfil_invitado.php" class="flex items-center gap-3 px-6 py-3 bg-amber-700 transition">
                    <i class="fa-solid fa-user"></i><span>Mi Perfil</span>
                </a>
            </nav>
        </div>
        <div class="border-t border-amber-400 px-6 py-4">
            <a href="../index.html" class="flex items-center gap-2 text-amber-300 hover:text-white transition">
                <i class="fa-solid fa-right-from-bracket"></i> <span>Cerrar sesión</span>
            </a>
        </div>
    </aside>

    <!-- Contenido principal -->
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold text-amber-800 mb-6">Mi Perfil</h1>

        <div class="bg-white p-8 rounded-xl shadow-lg max-w-lg border-l-4 border-emerald-500">
            <div class="mb-6">
                <p class="text-gray-600">Nombre:</p>
                <p class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($usuario['nombre_usuario']); ?></p>
            </div>
            <div class="mb-6">
                <p class="text-gray-600">Correo electrónico:</p>
                <p class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($usuario['correo']); ?></p>
            </div>
            <div class="flex gap-4 mt-8">
                <a href="panel_invitado.php" class="bg-amber-600 hover:bg-amber-700 text-white py-2 px-5 rounded-full transition shadow-md">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Volver
                </a>
                <a href="../index.html" class="bg-red-500 hover:bg-red-600 text-white py-2 px-5 rounded-full transition shadow-md">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Cerrar sesión
                </a>
            </div>
        </div>
    </main>
</div>
</body>
</html>
