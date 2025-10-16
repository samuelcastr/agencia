<?php
session_start();
include("../php/conexion.php");

// Verificar si hay sesión activa
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../index.html");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener datos del usuario actual
$stmt = $conexion->prepare("SELECT nombre_usuario, correo FROM cuenta_usuario WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

// Actualizar contraseña
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $clave_actual = $_POST['clave_actual'] ?? '';
    $clave_nueva = $_POST['clave_nueva'] ?? '';
    $confirmar_clave = $_POST['confirmar_clave'] ?? '';

    // Verificar contraseña actual
    $stmt = $conexion->prepare("SELECT contraseña FROM cuenta_usuario WHERE id_usuario = ?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if (password_verify($clave_actual, $res['contraseña'])) {
        if ($clave_nueva === $confirmar_clave) {
            $hash = password_hash($clave_nueva, PASSWORD_DEFAULT);
            $update = $conexion->prepare("UPDATE cuenta_usuario SET contraseña = ? WHERE id_usuario = ?");
            $update->bind_param("si", $hash, $id_usuario);
            $update->execute();
            $mensaje = "✅ Contraseña actualizada correctamente.";
            $tipo = "exito";
        } else {
            $mensaje = "⚠️ Las contraseñas nuevas no coinciden.";
            $tipo = "error";
        }
    } else {
        $mensaje = "❌ La contraseña actual no es correcta.";
        $tipo = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configuración del Usuario</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 bg-gradient-to-b from-sky-800 to-sky-600 text-white flex flex-col justify-between">
    <div>
      <div class="flex items-center gap-2 px-6 py-4 border-b border-sky-500">
        <i class="fa-solid fa-user-cog text-2xl text-amber-300"></i>
        <h1 class="text-xl font-bold">Panel Usuario</h1>
      </div>

      <nav class="mt-6 space-y-2">
        <a href="panel_usuario.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
          <i class="fa-solid fa-house"></i><span>Inicio</span>
        </a>
        <a href="provincias.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
          <i class="fa-solid fa-map-location-dot"></i><span>Provincias</span>
        </a>
        <a href="reservas.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
          <i class="fa-solid fa-calendar-check"></i><span>Reservas</span>
        </a>
        <a href="configuracion_usuario.php" class="flex items-center gap-3 px-6 py-3 bg-sky-700 rounded-r-full transition">
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
    <h1 class="text-3xl font-bold text-gray-800 mb-8">⚙️ Configuración del Usuario</h1>

    <?php if (isset($mensaje)): ?>
      <div class="mb-6 p-4 rounded-lg text-white <?= $tipo === 'exito' ? 'bg-green-600' : 'bg-red-600' ?>">
        <?= htmlspecialchars($mensaje) ?>
      </div>
    <?php endif; ?>

    <div class="bg-white shadow-lg rounded-2xl p-8 max-w-lg mx-auto">
      <h2 class="text-xl font-semibold mb-6 text-sky-700 text-center">Actualizar Contraseña</h2>

      <form method="POST" class="space-y-5">
        <div>
          <label class="block text-gray-700 font-medium mb-2">Nombre</label>
          <input type="text" value="<?= htmlspecialchars($usuario['nombre_usuario']) ?>" disabled class="w-full border rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed">
        </div>

        <div>
          <label class="block text-gray-700 font-medium mb-2">Correo</label>
          <input type="email" value="<?= htmlspecialchars($usuario['correo']) ?>" disabled class="w-full border rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed">
        </div>

        <div>
          <label class="block text-gray-700 font-medium mb-2">Contraseña actual</label>
          <input type="password" name="clave_actual" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500">
        </div>

        <div>
          <label class="block text-gray-700 font-medium mb-2">Nueva contraseña</label>
          <input type="password" name="clave_nueva" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500">
        </div>

        <div>
          <label class="block text-gray-700 font-medium mb-2">Confirmar nueva contraseña</label>
          <input type="password" name="confirmar_clave" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500">
        </div>

        <button type="submit" class="w-full bg-sky-700 hover:bg-sky-800 text-white font-semibold py-2 rounded-lg transition">
          <i class="fa-solid fa-key mr-2"></i>Actualizar Contraseña
        </button>
      </form>
    </div>
  </main>
</body>
</html>
