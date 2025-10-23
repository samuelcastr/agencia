<?php
include '../php/conexion.php'; // ajusta la ruta si tu archivo está en /usuario/

// Obtener lista de provincias
$provincias = $conexion->query("SELECT id_provincia, nombre FROM provincia");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $telefono = trim($_POST["telefono"]);
    $fecha_viaje = $_POST["fecha_viaje"];
    $personas = $_POST["personas"];
    $comentarios = trim($_POST["comentarios"]);
    $id_provincia = $_POST["id_provincia"];

    // Buscar el ID del usuario por nombre_usuario y correo
    $buscar_usuario = $conexion->prepare("SELECT id_usuario FROM cuenta_usuario WHERE nombre_usuario = ? AND correo = ?");
    $buscar_usuario->bind_param("ss", $nombre, $correo);
    $buscar_usuario->execute();
    $resultado = $buscar_usuario->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        $id_usuario = $usuario['id_usuario'];

        // ✅ Ahora guardamos también nombre y correo dentro de reservas
        $stmt = $conexion->prepare("
            INSERT INTO reservas 
            (id_usuario, nombre, correo, telefono, fecha_viaje, personas, comentarios, id_provincia, fecha_creacion)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param("issssisi", $id_usuario, $nombre, $correo, $telefono, $fecha_viaje, $personas, $comentarios, $id_provincia);
        $stmt->execute();

        header("Location: reservas.php");
        exit;
    } else {
        $error = "❌ No se encontró un usuario con ese nombre y correo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Reserva</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

  <div class="bg-white shadow-lg rounded-2xl p-8 w-[28rem]">
    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Agregar Reserva</h1>

    <?php if (!empty($error)) echo "<p class='text-red-500 mb-3'>$error</p>"; ?>

    <form method="POST" class="space-y-4">
      <input type="text" name="nombre" placeholder="Nombre del usuario" required class="w-full px-4 py-2 border rounded-md">
      <input type="email" name="correo" placeholder="Correo del usuario" required class="w-full px-4 py-2 border rounded-md">
      <input type="text" name="telefono" placeholder="Teléfono" required class="w-full px-4 py-2 border rounded-md">
      <input type="date" name="fecha_viaje" required class="w-full px-4 py-2 border rounded-md">
      <input type="number" name="personas" placeholder="Número de Personas" class="w-full px-4 py-2 border rounded-md">
      <textarea name="comentarios" placeholder="Comentarios" class="w-full px-4 py-2 border rounded-md"></textarea>

      <select name="id_provincia" class="w-full px-4 py-2 border rounded-md" required>
        <option value="">Seleccionar provincia</option>
        <?php while ($p = $provincias->fetch_assoc()) { ?>
          <option value="<?= $p['id_provincia'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
        <?php } ?>
      </select>

      <div class="flex justify-between mt-4">
        <a href="reservas.php" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md">Cancelar</a>
        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">Guardar</button>
      </div>
    </form>
  </div>

</body>
</html>
