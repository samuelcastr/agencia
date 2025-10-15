document.addEventListener("DOMContentLoaded", async () => {
  try {
    // Llamada al backend (PHP) para obtener estadísticas desde MySQL
    const response = await fetch("../php/obtener_estadisticas.php");
    const data = await response.json();

    // Mostrar totales
    document.getElementById("totalUsuarios").textContent = data.totalUsuarios;
    document.getElementById("totalRegistros").textContent = data.totalRegistros;
    document.getElementById("promedioDiario").textContent = data.promedioDiario;

    // ===== Gráfica 1: Usuarios por mes =====
    new Chart(document.getElementById("usuariosChart"), {
      type: "line",
      data: {
        labels: data.usuariosPorMes.map(i => i.mes),
        datasets: [{
          label: "Usuarios",
          data: data.usuariosPorMes.map(i => i.cantidad),
          borderColor: "#0ea5e9",
          backgroundColor: "rgba(14,165,233,0.2)",
          tension: 0.4,
          fill: true
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } }
      }
    });

    // ===== Gráfica 2: Registros por categoría =====
    new Chart(document.getElementById("registrosChart"), {
      type: "bar",
      data: {
        labels: data.registrosPorCategoria.map(i => i.categoria),
        datasets: [{
          label: "Registros",
          data: data.registrosPorCategoria.map(i => i.cantidad),
          backgroundColor: ["#10b981", "#3b82f6", "#facc15", "#ef4444", "#8b5cf6"]
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } }
      }
    });

  } catch (error) {
    console.error("Error al cargar estadísticas:", error);
  }
});
