<?php
session_start();
include('../php/conexion.php');

// aceptar destino/provincia tanto por GET como por POST
$id_destino = $_REQUEST['destino'] ?? $_REQUEST['provincia'] ?? null;
if (!$id_destino) {
    echo "<script>alert('No se indicó el destino.'); window.history.back();</script>";
    exit;
}

// Prefill si hay sesión
$id_usuario = isset($_SESSION['id_usuario']) ? (int)$_SESSION['id_usuario'] : 0;
$prefill_nombre = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : '';
$prefill_correo = isset($_SESSION['correo']) ? $_SESSION['correo'] : '';

// Procesar envío
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $fecha_viaje = trim($_POST['fecha_viaje'] ?? '');
    $personas = (int)($_POST['personas'] ?? 1);
    $comentarios = trim($_POST['comentarios'] ?? '');
    $id_destino = $_REQUEST['destino'] ?? $_REQUEST['provincia'] ?? $id_destino;

    // Validaciones básicas
    if ($nombre === '' || $correo === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Completa nombre y un correo válido.'); window.history.back();</script>";
        exit;
    }
    if ($personas < 1) $personas = 1;

    $sql = "INSERT INTO reservas (id_usuario, id_provincia, nombre, correo, telefono, fecha_viaje, personas, comentarios, fecha_creacion)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        echo "<script>alert('Error al preparar la reserva.'); window.history.back();</script>";
        exit;
    }

    // tipos: id_usuario (i), id_destino (i), nombre (s), correo (s), telefono (s), fecha_viaje (s), personas (i), comentarios (s)
    $types = "iissssis";
    $stmt->bind_param($types,
        $id_usuario,
        $id_destino,
        $nombre,
        $correo,
        $telefono,
        $fecha_viaje,
        $personas,
        $comentarios
    );

    if ($stmt->execute()) {
        echo "<script>
                alert('✅ Reserva registrada. Nos contactaremos contigo pronto.');
                window.location.href = '/agencia/viajes/invitado/panel_invitado.php'; 
              </script>";
        $stmt->close();
        $conexion->close();
        exit;
    } else {
        echo "<script>alert('❌ Error al guardar la reserva. Intenta nuevamente.'); window.history.back();</script>";
        $stmt->close();
        $conexion->close();
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Reservar — Sol & Mar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans">
    <div class="max-w-3xl mx-auto p-6">
        <a href="/agencia/viajes/invitado/detalle_destino.php?id=<?= htmlspecialchars($id_destino) ?>" class="text-sky-600 hover:underline mb-4 inline-block">← Volver</a>

        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-amber-800 mb-4">Reservar destino</h1>
            <form method="post" novalidate>
                <input type="hidden" name="destino" value="<?= htmlspecialchars($id_destino) ?>">

                <label class="block mb-3">
                    <span class="text-sm font-medium text-gray-700">Nombre</span>
                    <input name="nombre" required class="mt-1 block w-full rounded border-gray-200 shadow-sm" value="<?= htmlspecialchars($prefill_nombre) ?>">
                </label>

                <label class="block mb-3">
                    <span class="text-sm font-medium text-gray-700">Correo</span>
                    <input name="correo" type="email" required class="mt-1 block w-full rounded border-gray-200 shadow-sm" value="<?= htmlspecialchars($prefill_correo) ?>">
                </label>

                <label class="block mb-3">
                    <span class="text-sm font-medium text-gray-700">Teléfono</span>
                    <input name="telefono" class="mt-1 block w-full rounded border-gray-200 shadow-sm" placeholder="Opcional">
                </label>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Fecha del viaje</span>
                        <input name="fecha_viaje" type="date" class="mt-1 block w-full rounded border-gray-200 shadow-sm">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700">Personas</span>
                        <input name="personas" type="number" min="1" value="1" class="mt-1 block w-full rounded border-gray-200 shadow-sm">
                    </label>
                </div>

                <label class="block mb-4">
                    <span class="text-sm font-medium text-gray-700">Comentarios</span>
                    <textarea name="comentarios" rows="4" class="mt-1 block w-full rounded border-gray-200 shadow-sm" placeholder="Requisitos, preferencia de fechas, etc."></textarea>
                </label>

                <div class="flex items-center gap-3">
                    <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700">Enviar reserva</button>
                    <a href="/agencia/viajes/invitado/panel_invitado.php" class="text-sm text-gray-600 hover:underline">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>