<?php
session_start();
include("../php/conexion.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../index.html");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$nombre_invitado = htmlspecialchars($_SESSION['nombre_usuario']);
$es_invitado_logueado = isset($_SESSION['id_rol']) && $_SESSION['id_rol'] == 3;

// Obtener reservas del usuario actual
$stmt = $conexion->prepare("
    SELECT r.id_reserva, r.fecha_viaje, r.personas, r.comentarios, r.fecha_creacion, p.nombre AS provincia
    FROM reservas r
    LEFT JOIN provincia p ON r.id_provincia = p.id_provincia
    WHERE r.id_usuario = ?
    ORDER BY r.fecha_creacion DESC
");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$reservas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mis Reservas | Sol & Mar</title>
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
                    <a href="panel_invitado.php" class="flex items-center gap-3 px-6 py-3 bg-amber-700 transition">
                        <i class="fa-solid fa-house"></i><span>Inicio</span>
                    </a>
                    <a href="destinos.php" class="flex items-center gap-3 px-6 py-3 hover:bg-amber-700 transition">
                        <i class="fa-solid fa-plane-departure"></i><span>Ver Paquetes</span>
                    </a>
                    <a href="reservas_invitado.php" class="flex items-center gap-3 px-6 py-3 hover:bg-amber-700 transition">
                        <i class="fa-solid fa-book"></i><span>Mis Reservas</span>
                    </a>
                    <!-- Nueva opción: Mi Perfil -->
                    <a href="perfil_invitado.php" class="flex items-center gap-3 px-6 py-3 hover:bg-amber-700 transition">
                        <i class="fa-solid fa-user"></i><span>Mi Perfil</span>
                    </a>

                    <?php if (!$es_invitado_logueado): ?>
                    <a href="/agencia/viajes/panel_invitado.php" class="flex items-center gap-3 px-6 py-3 hover:bg-amber-700 transition">
                        <i class="fa-solid fa-user-plus"></i><span>Iniciar Sesión</span>
                    </a>
                    <?php endif; ?>
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
      <header class="mb-8">
        <h1 class="text-3xl font-bold text-amber-800">Mis Reservas</h1>
        <p class="text-slate-600 mt-1">Aquí puedes consultar todas tus reservas realizadas.</p>
      </header>

      <section class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-sky-500">
        <?php if ($reservas->num_rows > 0): ?>
          <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
              <thead class="bg-amber-600 text-white">
                <tr>
                  <th class="py-3 px-4 text-left">#</th>
                  <th class="py-3 px-4 text-left">Provincia</th>
                  <th class="py-3 px-4 text-left">Fecha del Viaje</th>
                  <th class="py-3 px-4 text-left">Personas</th>
                  <th class="py-3 px-4 text-left">Comentarios</th>
                  <th class="py-3 px-4 text-left">Fecha de Reserva</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <?php $n = 1; while ($fila = $reservas->fetch_assoc()): ?>
                  <tr class="hover:bg-gray-50 transition">
                    <td class="py-3 px-4"><?= $n++ ?></td>
                    <td class="py-3 px-4"><?= htmlspecialchars($fila['provincia']) ?></td>
                    <td class="py-3 px-4"><?= htmlspecialchars($fila['fecha_viaje']) ?></td>
                    <td class="py-3 px-4"><?= htmlspecialchars($fila['personas']) ?></td>
                    <td class="py-3 px-4"><?= htmlspecialchars($fila['comentarios'] ?: '—') ?></td>
                    <td class="py-3 px-4 text-gray-500"><?= htmlspecialchars($fila['fecha_creacion']) ?></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <p class="text-gray-600 text-center py-6">Aún no tienes reservas registradas.</p>
        <?php endif; ?>
      </section>
    </main>
  </div>
</body>
</html>
