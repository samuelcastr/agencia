<?php
include("../php/conexion.php");

// Obtener provincias de la base de datos
$resultado = $conexion->query("SELECT * FROM provincia ORDER BY id_provincia ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Provincias</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 bg-gradient-to-b from-sky-800 to-sky-600 text-white flex flex-col justify-between">
      <div>
        <div class="flex items-center gap-2 px-6 py-4 border-b border-sky-500">
          <i class="fa-solid fa-earth-americas text-2xl text-amber-300"></i>
          <h1 class="text-xl font-bold">Panel Usuario</h1>
        </div>

        <nav class="mt-6 space-y-2">
          <a href="panel_usuario.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
            <i class="fa-solid fa-house"></i><span>Inicio</span>
          </a>
          <a href="provincias.php" class="flex items-center gap-3 px-6 py-3 bg-sky-700 rounded-r-full transition">
            <i class="fa-solid fa-map-location-dot"></i><span>Provincias</span>
          </a>
          <a href="reservas.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
            <i class="fa-solid fa-calendar-check"></i><span>Reservas</span>
          </a>
          <a href="configuracion_usuario.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
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

  <!-- Contenido principal -->
  <main class="flex-1 p-10 overflow-y-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">🌍 Gestión de Provincias</h1>

    <div class="flex justify-end mb-4">
      <a href="agregar_provincia.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
        + Agregar Provincia
      </a>
    </div>

    <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
      <table class="min-w-full border border-gray-200">
        <thead class="bg-sky-700 text-white">
          <tr>
            <th class="py-3 px-4 text-left">Nombre</th>
            <th class="py-3 px-4 text-center">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php while($fila = $resultado->fetch_assoc()) { ?>
            <tr class="hover:bg-gray-50">
              <td class="py-3 px-4"><?= htmlspecialchars($fila['nombre']) ?></td>
              <td class="py-3 px-4 text-center space-x-2">
                <a href="editar_provincia.php?id=<?= $fila['id_provincia'] ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md">Editar</a>
                <a href="eliminar_provincia.php?id=<?= $fila['id_provincia'] ?>" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md" onclick="return confirm('¿Deseas eliminar esta provincia?')">Eliminar</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
