<?php
include("../php/conexion.php");

$id = $_GET["id"] ?? null;
if (!$id) {
    header("Location: reservas.php");
    exit;
}

// Provincias para el select
$provincias = $conexion->query("SELECT id_provincia, nombre FROM provincia");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = trim($_POST["correo"]);
    $telefono = trim($_POST["telefono"]);
    $fecha_viaje = $_POST["fecha_viaje"];
    $personas = $_POST["personas"];
    $comentarios = trim($_POST["comentarios"]);
    $id_provincia = $_POST["id_provincia"];

    $stmt = $conexion->prepare("UPDATE reservas SET correo=?, telefono=?, fecha_viaje=?, personas=?, comentarios=?, id_provincia=? WHERE id_usuario=?");
    $stmt->bind_param("sssisis", $correo, $telefono, $fecha_viaje, $personas, $comentarios, $id_provincia, $id);
    $stmt->execute();

    header("Location: reservas.php");
    exit;
}

// Obtener reserva actual
$res = $conexion->prepare("SELECT * FROM reservas WHERE id_usuario=?");
$res->bind_param("i", $id);
$res->execute();
$reserva = $res->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Reserva</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

  <div class="bg-white shadow-lg rounded-2xl p-8 w-[28rem]">
    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Editar Reserva</h1>

    <form method="POST" class="space-y-4">
      <input type="email" name="correo" value="<?= htmlspecialchars($reserva['correo']) ?>" required class="w-full px-4 py-2 border rounded-md">
      <input type="text" name="telefono" value="<?= htmlspecialchars($reserva['telefono']) ?>" required class="w-full px-4 py-2 border rounded-md">
      <input type="date" name="fecha_viaje" value="<?= htmlspecialchars($reserva['fecha_viaje']) ?>" required class="w-full px-4 py-2 border rounded-md">
      <input type="number" name="personas" value="<?= htmlspecialchars($reserva['personas']) ?>" class="w-full px-4 py-2 border rounded-md">
      <textarea name="comentarios" class="w-full px-4 py-2 border rounded-md"><?= htmlspecialchars($reserva['comentarios']) ?></textarea>

      <select name="id_provincia" class="w-full px-4 py-2 border rounded-md" required>
        <?php while ($p = $provincias->fetch_assoc()) { ?>
          <option value="<?= $p['id_provincia'] ?>" <?= $p['id_provincia'] == $reserva['id_provincia'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($p['nombre']) ?>
          </option>
        <?php } ?>
      </select>

      <div class="flex justify-between mt-4">
        <a href="reservas.php" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md">Cancelar</a>
        <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Actualizar</button>
      </div>
    </form>
  </div>

</body>
</html>
