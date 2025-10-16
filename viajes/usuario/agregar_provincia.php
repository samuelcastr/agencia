<?php
include("../php/conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"]);

    if (!empty($nombre)) {
        $stmt = $conexion->prepare("INSERT INTO provincia (nombre) VALUES (?)");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();

        header("Location: provincias.php");
        exit;
    } else {
        $error = "El nombre no puede estar vacío.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Provincia</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

  <div class="bg-white shadow-lg rounded-2xl p-8 w-96">
    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Agregar Provincia</h1>

    <?php if (!empty($error)) echo "<p class='text-red-500 mb-3'>$error</p>"; ?>

    <form method="POST" class="space-y-4">
      <input type="text" name="nombre" placeholder="Nombre de la provincia"
        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-sky-300" required>

      <div class="flex justify-between">
        <a href="provincias.php" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md">Cancelar</a>
        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">Guardar</button>
      </div>
    </form>
  </div>

</body>
</html>
