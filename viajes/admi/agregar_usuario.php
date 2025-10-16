<?php
include("../php/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    $rol = $_POST['rol'];

    // Encriptar la contraseña
    $clave_hash = password_hash($clave, PASSWORD_DEFAULT);

    // Insertar en la base de datos
    $sql = "INSERT INTO cuenta_usuario (nombre_usuario, contraseña, correo, id_rol)
            VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssi", $nombre_usuario, $clave_hash, $correo, $rol);

    if ($stmt->execute()) {
        echo "<script>
                alert('✅ Usuario registrado correctamente');
                window.location.href='usuarios.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Error al registrar el usuario');
                window.history.back();
              </script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Usuario</title>
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
  <main class="flex-1 p-8">
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-xl p-8">
      <h1 class="text-2xl font-bold text-center text-blue-700 mb-6">➕ Agregar Usuario</h1>

      <form method="POST" class="space-y-5">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre de usuario</label>
          <input type="text" name="nombre_usuario" required placeholder="Ingrese nombre" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400">
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Correo</label>
          <input type="email" name="correo" required placeholder="correo@ejemplo.com" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400">
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Contraseña</label>
          <input type="password" name="clave" required placeholder="Ingrese una contraseña" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400">
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Rol</label>
          <select name="rol" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400">
            <option value="">Seleccionar rol...</option>
            <option value="1">Administrador</option>
            <option value="2">Usuario</option>
            <option value="3">Invitado</option>
          </select>
        </div>

        <div class="flex justify-between mt-6">
          <a href="usuarios.php" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Cancelar</a>
          <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold">Registrar</button>
        </div>
      </form>
    </div>
  </main>

</body>
</html>
