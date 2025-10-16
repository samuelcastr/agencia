<?php
include("../php/conexion.php");
$resultado = $conexion->query("SELECT * FROM cuenta_usuario ORDER BY id_usuario ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Usuarios</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/a2e0e6a46d.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="flex bg-gray-100 min-h-screen text-gray-900">

  <!-- 🧭 Menú lateral -->
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
          <a href="configuraciones.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
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

  <!-- 🧠 Contenido principal -->
  <main class="flex-1 p-8 overflow-y-auto">
    <div class="bg-white rounded-xl shadow-lg p-6">
      <h1 class="text-2xl font-bold mb-6 text-center text-blue-700">👥 Gestión de Usuarios</h1>

      <div class="flex justify-end mb-4">
        <a href="agregar_usuario.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">+ Agregar Usuario</a>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
          <thead class="bg-blue-700 text-white">
            <tr>
              <th class="py-3 px-4 text-left">ID</th>
              <th class="py-3 px-4 text-left">Nombre</th>
              <th class="py-3 px-4 text-left">Correo</th>
              <th class="py-3 px-4 text-left">Rol</th>
              <th class="py-3 px-4 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php while($fila = $resultado->fetch_assoc()) { ?>
            <tr class="hover:bg-gray-50">
              <td class="py-3 px-4"><?= $fila['id_usuario'] ?></td>
              <td class="py-3 px-4"><?= htmlspecialchars($fila['nombre_usuario']) ?></td>
              <td class="py-3 px-4"><?= htmlspecialchars($fila['correo']) ?></td>
              <td class="py-3 px-4">
                <?php
                  // Mostrar rol en texto legible
                  switch ($fila['id_rol']) {
                    case 1: echo "Administrador"; break;
                    case 2: echo "Usuario"; break;
                    case 3: echo "Invitado"; break;
                    default: echo "Desconocido";
                  }
                ?>
              </td>
              <td class="py-3 px-4 text-center space-x-2">
                <a href="editar_usuario.php?id=<?= $fila['id_usuario'] ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md">Editar</a>
                <a href="eliminar_usuario.php?id=<?= $fila['id_usuario'] ?>" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md" onclick="return confirm('¿Deseas eliminar este usuario?')">Eliminar</a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

</body>
</html>

