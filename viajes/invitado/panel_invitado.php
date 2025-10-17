<?php
// invitado/panel_invitado.php (Ubicado en la carpeta invitado/)
session_start();

include('../php/conexion.php'); 

// La página es pública, pero se personaliza si hay sesión.
// Usar las mismas claves de sesión que en login.php
$nombre_invitado = isset($_SESSION['nombre_usuario']) ? htmlspecialchars($_SESSION['nombre_usuario']) : "Visitante";
$es_invitado_logueado = isset($_SESSION['id_rol']) && $_SESSION['id_rol'] == 3;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Invitado | Sol & Mar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-gradient-to-b from-amber-600 to-amber-500 text-white flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-2 px-6 py-4 border-b border-amber-400">
                    <i class="fa-solid fa-leaf text-2xl text-sky-800"></i>
                    <h1 class="text-xl font-bold">Sol & Mar</h1>
                </div>
                <nav class="mt-6 space-y-2">
                    <a href="panel_invitado.php" class="flex items-center gap-3 px-6 py-3 bg-amber-700 transition">
                        <i class="fa-solid fa-house"></i><span>Inicio</span>
                    </a>
                    <a href="destinos.php" class="flex items-center gap-3 px-6 py-3 hover:bg-amber-700 transition">
                        <i class="fa-solid fa-plane-departure"></i><span>Ver Paquetes</span>
                    </a>
                    <?php if (!$es_invitado_logueado): ?>
                    <!-- ruta absoluta para evitar Not Found -->
                    <a href="/agencia-1/viajes/inicio_registro.html" class="flex items-center gap-3 px-6 py-3 hover:bg-amber-700 transition">
                        <i class="fa-solid fa-user-plus"></i><span>Iniciar Sesión</span>
                    </a>
                    <?php else: ?>
                    <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-amber-700 transition">
                        <i class="fa-solid fa-gem"></i><span>Mi Cuenta</span>
                    </a>
                    <?php endif; ?>
                </nav>
            </div>
            <div class="border-t border-amber-400 px-6 py-4">
                <?php if (isset($_SESSION['nombre_usuario'])): ?>
                    <a href="/agencia-1/viajes/php/cerrar_sesion.php" class="flex items-center gap-2 text-sky-800 hover:text-white transition">
                        <i class="fa-solid fa-right-from-bracket"></i> <span>Cerrar sesión</span>
                    </a>
                <?php endif; ?>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-amber-800">Bienvenido, <?= $nombre_invitado ?></h1>
                <p class="text-slate-600 mt-1">Explora nuestros destinos y comienza tu próxima aventura.</p>
            </header>

            <section class="p-8 bg-white rounded-xl shadow-lg border-l-4 border-sky-500">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">La agencia Sol & Mar te da la bienvenida</h2>
                <p class="text-gray-600 mb-4">
                    Estamos listos para planificar el viaje de tus sueños. Utiliza el menú lateral para ver nuestros paquetes.
                </p>
                <a href="destinos.php" class="inline-block px-6 py-2 rounded-full bg-sky-600 hover:bg-sky-700 text-white font-semibold transition shadow-md">
                    <i class="fa-solid fa-plane-departure mr-2"></i> Explorar Destinos
                </a>
            </section>
        </main>
    </div>
</body>
</html>