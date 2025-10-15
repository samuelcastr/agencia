<?php
header('Content-Type: application/json; charset=utf-8');
include "conexion.php";

// Desactivar warnings
error_reporting(0);
ini_set('display_errors', 0);

// ====== Totales ======
$totalUsuarios = $conexion->query("SELECT COUNT(*) AS total FROM cuenta_usuario")->fetch_assoc()['total'] ?? 0;

// Como no existe una tabla 'registros', usamos la misma para este conteo
$totalRegistros = $totalUsuarios;

// Promedio diario (ejemplo simple)
$promedioDiario = round($totalRegistros / 30, 1);

// ====== Usuarios por mes ======
$usuariosPorMes = [];
$result = $conexion->query("
  SELECT 
    MONTH(fecha_creacion) AS mes, 
    COUNT(*) AS cantidad 
  FROM cuenta_usuario 
  GROUP BY mes
");
if ($result) {
  while ($row = $result->fetch_assoc()) {
    $usuariosPorMes[] = [
      "mes" => "Mes " . $row['mes'],
      "cantidad" => (int)$row['cantidad']
    ];
  }
}

// ====== Registros por rol ======
$registrosPorCategoria = [];
$result2 = $conexion->query("
  SELECT id_rol AS categoria, COUNT(*) AS cantidad 
  FROM cuenta_usuario 
  GROUP BY id_rol
");
if ($result2) {
  while ($row2 = $result2->fetch_assoc()) {
    // Traducir roles a nombres legibles
    $nombreRol = match($row2['categoria']) {
      1 => "Administrador",
      2 => "Usuario",
      3 => "Invitado",
      default => "Desconocido"
    };

    $registrosPorCategoria[] = [
      "categoria" => $nombreRol,
      "cantidad" => (int)$row2['cantidad']
    ];
  }
}

// ====== Respuesta JSON ======
echo json_encode([
  "totalUsuarios" => (int)$totalUsuarios,
  "totalRegistros" => (int)$totalRegistros,
  "promedioDiario" => (float)$promedioDiario,
  "usuariosPorMes" => $usuariosPorMes,
  "registrosPorCategoria" => $registrosPorCategoria
]);
?>
