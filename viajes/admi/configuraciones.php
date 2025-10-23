<?php
session_start();
include("../php/conexion.php");

// Verificamos sesión activa
if (!isset($_SESSION['id_usuario'])) {
  header("Location: ../inicio_registro.html");
  exit;
}

$id_usuario = $_SESSION['id_usuario'];
$query = $conexion->query("SELECT * FROM cuenta_usuario WHERE id_usuario = $id_usuario");
$usuario = $query->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configuraciones - Panel de Administrador</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex">

  <!-- ===== Sidebar ===== -->
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
        <a href="configuraciones.php" class="flex items-center gap-3 px-6 py-3 bg-sky-700 rounded-md transition">
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

  <!-- ===== Main Content ===== -->
  <main class="flex-1 p-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Configuración de Cuenta</h1>

    <div class="max-w-lg mx-auto bg-white p-8 rounded-2xl shadow-md">
      <form action="../php/actualizar_configuracion.php" method="POST" class="space-y-6">

        <!-- Nombre -->
        <div>
          <label class="block font-semibold text-gray-700 mb-2">Nombre de usuario</label>
          <input type="text" name="nombre_usuario" value="<?= htmlspecialchars($usuario['nombre_usuario']) ?>"
                 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500" required>
        </div>

        <!-- Correo -->
        <div>
          <label class="block font-semibold text-gray-700 mb-2">Correo electrónico</label>
          <input type="email" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>"
                 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500" required>
        </div>

        <!-- Contraseña -->
        <div>
          <label class="block font-semibold text-gray-700 mb-2">Nueva contraseña</label>
          <input type="password" name="clave" placeholder="Deja en blanco si no deseas cambiarla"
                 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500">
        </div>

        <!-- Botón -->
        <div class="text-center">
          <button type="submit"
                  class="bg-gradient-to-r from-sky-700 to-sky-500 hover:from-sky-800 hover:to-sky-600 text-white font-semibold px-6 py-2 rounded-lg transition">
            Guardar cambios
          </button>
        </div>

      </form>
    </div>
  </main>

</body>
</html>
