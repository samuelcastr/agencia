<?php
include("../php/conexion.php");

$id_reserva = $_GET["id_reserva"] ?? null; // <-- cambiamos el nombre del parámetro
if ($id_reserva) {
    $stmt = $conexion->prepare("DELETE FROM reservas WHERE id_reserva = ?");
    $stmt->bind_param("i", $id_reserva);
    $stmt->execute();
}

header("Location: reservas.php");
exit;
?>