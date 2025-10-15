<?php
include('../php/conexion.php');

// Consultas reales
$totalUsuarios = $conexion->query("SELECT COUNT(*) AS total FROM cuenta_usuario")->fetch_assoc()['total'];
$totalAdmins = $conexion->query("SELECT COUNT(*) AS total FROM cuenta_usuario WHERE id_rol = 1")->fetch_assoc()['total'];
$ultimoUsuario = $conexion->query("SELECT nombre_usuario FROM cuenta_usuario ORDER BY id_usuario DESC LIMIT 1")->fetch_assoc()['nombre_usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel del Administrador</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans">

  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-sky-800 to-sky-600 text-white flex flex-col justify-between">
      <div>
        <div class="flex items-center gap-2 px-6 py-4 border-b border-sky-500">
          <i class="fa-solid fa-leaf text-2xl text-amber-300"></i>
          <h1 class="text-xl font-bold">Panel Admin</h1>
        </div>
        <nav class="mt-6 space-y-2">
          <a href="index_admi.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
            <i class="fa-solid fa-gauge"></i><span>Dashboard</span>
          </a>
          <a href="usuarios.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
            <i class="fa-solid fa-users"></i><span>Usuarios</span>
          </a>
          <a href="agregar_usuario.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
            <i class="fa-solid fa-database"></i><span>Registros</span>
          </a>
          <a href="estadisticas.html" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
            <i class="fa-solid fa-chart-line"></i><span>Estadísticas</span>
          </a>
          <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
            <i class="fa-solid fa-gear"></i><span>Configuración</span>
          </a>
        </nav>
      </div>
      <div class="border-t border-sky-500 px-6 py-4">
        <a href="../index.html" class="flex items-center gap-2 text-amber-300 hover:text-white transition">
          <i class="fa-solid fa-right-from-bracket"></i> <span>Cerrar sesión</span>
        </a>
      </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-8">
      <header class="mb-8">
        <h1 class="text-3xl font-bold text-sky-800">Bienvenido, Administrador</h1>
        <p class="text-slate-600 mt-1">Panel de control conectado a MySQL</p>
      </header>

      <!-- Dashboard -->
      <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white shadow-md rounded-2xl p-6 text-center hover:shadow-lg transition">
          <i class="fa-solid fa-users text-sky-700 text-3xl mb-2"></i>
          <h3 class="text-lg font-semibold text-sky-800">Usuarios registrados</h3>
          <p class="text-3xl font-bold text-amber-500 mt-2"><?= $totalUsuarios ?></p>
        </div>

        <div class="bg-white shadow-md rounded-2xl p-6 text-center hover:shadow-lg transition">
          <i class="fa-solid fa-user-shield text-sky-700 text-3xl mb-2"></i>
          <h3 class="text-lg font-semibold text-sky-800">Administradores</h3>
          <p class="text-3xl font-bold text-amber-500 mt-2"><?= $totalAdmins ?></p>
        </div>

        <div class="bg-white shadow-md rounded-2xl p-6 text-center hover:shadow-lg transition">
          <i class="fa-solid fa-user-plus text-sky-700 text-3xl mb-2"></i>
          <h3 class="text-lg font-semibold text-sky-800">Último usuario registrado</h3>
          <p class="text-xl font-bold text-slate-700 mt-2"><?= htmlspecialchars($ultimoUsuario) ?></p>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
