<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');
include "conexion.php";

error_reporting(0);
ini_set('display_errors', 0);

// ====== Totales ======
$totalUsuarios = $conexion->query("SELECT COUNT(*) AS total FROM cuenta_usuario")->fetch_assoc()['total'] ?? 0;
$totalRegistros = $totalUsuarios;
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
$queryRoles = "
  SELECT 
    r.nombre_rol AS categoria, 
    COUNT(cu.id_usuario) AS cantidad
  FROM cuenta_usuario cu
  INNER JOIN rol r ON cu.id_rol = r.id_rol
  GROUP BY r.nombre_rol
";

$result2 = $conexion->query($queryRoles);

if ($result2 && $result2->num_rows > 0) {
  while ($row2 = $result2->fetch_assoc()) {
    $registrosPorCategoria[] = [
      "categoria" => $row2['categoria'],
      "cantidad" => (int)$row2['cantidad']
    ];
  }
} else {
  // Si no hay datos, muestra un mensaje amigable
  $registrosPorCategoria[] = ["categoria" => "Sin datos", "cantidad" => 0];
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
