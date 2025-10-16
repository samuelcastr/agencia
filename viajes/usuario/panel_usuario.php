<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Usuario</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="flex bg-gray-100 min-h-screen text-gray-900">

  <!-- 🧭 Sidebar -->
  <aside class="w-64 bg-gradient-to-b from-sky-800 to-sky-600 text-white flex flex-col justify-between">
    <div>
      <div class="flex items-center gap-2 px-6 py-4 border-b border-sky-500">
        <i class="fa-solid fa-leaf text-2xl text-amber-300"></i>
        <h1 class="text-xl font-bold">Panel Usuario</h1>
      </div>
      <nav class="mt-6 space-y-2">
        <a href="panel_usuario.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
          <i class="fa-solid fa-gauge"></i><span>Inicio</span>
        </a>
        <a href="provincias.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
          <i class="fa-solid fa-map-location-dot"></i><span>Provincias</span>
        </a>
        <a href="reservas.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
          <i class="fa-solid fa-calendar-check"></i><span>Reservas</span>
        </a>
        <a href="config_usuario.php" class="flex items-center gap-3 px-6 py-3 hover:bg-sky-700 transition">
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
  <main class="flex-1 p-10 overflow-y-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Bienvenido al Panel de Usuario</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- Card Provincias -->
      <div class="bg-white p-6 rounded-2xl shadow-md text-center hover:shadow-lg transition">
        <i class="fa-solid fa-map-location-dot text-sky-600 text-4xl mb-3"></i>
        <h2 class="text-xl font-semibold mb-2">Gestión de Provincias</h2>
        <p class="text-gray-600 mb-4">Crea, edita o elimina provincias para asignarlas a las reservas de los clientes.</p>
        <a href="provincias.php" class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-lg inline-block">Ir a Provincias</a>
      </div>

      <!-- Card Reservas -->
      <div class="bg-white p-6 rounded-2xl shadow-md text-center hover:shadow-lg transition">
        <i class="fa-solid fa-calendar-check text-green-600 text-4xl mb-3"></i>
        <h2 class="text-xl font-semibold mb-2">Estado de Reservas</h2>
        <p class="text-gray-600 mb-4">Consulta las reservas hechas por los clientes invitados y su estado actual.</p>
        <a href="reservas.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg inline-block">Ver Reservas</a>
      </div>

      <!-- Card Configuración -->
      <div class="bg-white p-6 rounded-2xl shadow-md text-center hover:shadow-lg transition">
        <i class="fa-solid fa-gear text-yellow-500 text-4xl mb-3"></i>
        <h2 class="text-xl font-semibold mb-2">Configuración</h2>
        <p class="text-gray-600 mb-4">Actualiza tu información personal o cambia tu contraseña.</p>
        <a href="config_usuario.php" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg inline-block">Ir a Configuración</a>
      </div>
    </div>
  </main>

</body>
</html>
