<?php
include("../php/conexion.php");

// Consultar datos con JOIN a provincias
$query = "
  SELECT c.id_compania, c.nombre, c.Edad, c.Fecha, c.VIP, 
         c.Direccion, c.Telefono, c.Ciudad_origen, p.nombre
  FROM compania c
  LEFT JOIN provincia p ON c.id_provincia = p.id_provincia
  ORDER BY c.id_compania ASC
";
$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estado de Reservas</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 bg-gradient-to-b from-sky-800 to-sky-600 text-white flex flex-col justify-between">
      <div>
        <div class="flex items-center gap-2 px-6 py-4 border-b border-sky-500">
          <i class="fa-solid fa-calendar-check text-2xl text-amber-300"></i>
          <h1 class="text-xl font-bold">Panel Usuario</h1>
        </div>

        <nav class="mt-6 space-y-2">
          <a href="panel_usuario.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
            <i class="fa-solid fa-house"></i><span>Inicio</span>
          </a>
          <a href="provincias.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
            <i class="fa-solid fa-map-location-dot"></i><span>Provincias</span>
          </a>
          <a href="reservas.php" class="flex items-center gap-3 px-6 py-3 bg-sky-700 rounded-r-full transition">
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
    <h1 class="text-3xl font-bold text-gray-800 mb-8">📊 Estado de Reservas</h1>

    <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
      <table class="min-w-full border border-gray-200">
        <thead class="bg-sky-700 text-white">
          <tr>
            <th class="py-3 px-4 text-left">#</th>
            <th class="py-3 px-4 text-left">Nombre</th>
            <th class="py-3 px-4 text-left">Edad</th>
            <th class="py-3 px-4 text-left">Fecha</th>
            <th class="py-3 px-4 text-left">VIP</th>
            <th class="py-3 px-4 text-left">Dirección</th>
            <th class="py-3 px-4 text-left">Teléfono</th>
            <th class="py-3 px-4 text-left">Ciudad Origen</th>
            <th class="py-3 px-4 text-left">Provincia</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php while ($fila = $resultado->fetch_assoc()) { ?>
            <tr class="hover:bg-gray-50">
              <td class="py-3 px-4"><?= $fila['id_compania'] ?></td>
              <td class="py-3 px-4"><?= htmlspecialchars($fila['nombre']) ?></td>
              <td class="py-3 px-4"><?= $fila['Edad'] ?></td>
              <td class="py-3 px-4"><?= $fila['Fecha'] ?></td>
              <td class="py-3 px-4">
                <?php if ($fila['VIP'] == 1): ?>
                  <span class="bg-yellow-400 text-white px-2 py-1 rounded-md text-sm">VIP</span>
                <?php else: ?>
                  <span class="bg-gray-300 text-gray-800 px-2 py-1 rounded-md text-sm">Normal</span>
                <?php endif; ?>
              </td>
              <td class="py-3 px-4"><?= htmlspecialchars($fila['Direccion']) ?></td>
              <td class="py-3 px-4"><?= htmlspecialchars($fila['Telefono']) ?></td>
              <td class="py-3 px-4"><?= htmlspecialchars($fila['Ciudad_origen']) ?></td>
              <td class="py-3 px-4"><?= htmlspecialchars($fila['nombre_provincia'] ?? '—') ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
