<?php
session_start();
include('../php/conexion.php');

// Selecciona todas las columnas de provincia y ordénalas por el campo "nombre" si existe,
// si no, usa la segunda columna disponible para ordenar.
$orderBy = 'nombre';
$colsRes = $conexion->query("SHOW COLUMNS FROM provincia");
$columns = [];
if ($colsRes) {
    while ($c = $colsRes->fetch_assoc()) {
        $columns[] = $c['Field'];
    }
    // si no existe 'nombre' intenta usar la segunda columna como orden
    if (!in_array('nombre', $columns) && isset($columns[1])) {
        $orderBy = $columns[1];
    } elseif (!in_array('nombre', $columns)) {
        $orderBy = $columns[0];
    }
}

// Antes: SELECT * FROM provincia ORDER BY `...`
// Reemplazar la consulta por:
$sql = "SELECT id_provincia AS id, nombre FROM provincia ORDER BY `$orderBy`";
$stmt = $conexion->prepare($sql);
$provincias = [];
if ($stmt) {
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res) {
        // obtener nombres de campos para mapear id/nombre de forma segura
        $fieldsMeta = $res->fetch_fields();
        $firstField = $fieldsMeta[0]->name ?? null;
        // buscar un campo de nombre común
        $nameField = null;
        foreach (['nombre', 'provincia', 'nombre_provincia', 'descripcion'] as $nf) {
            if (in_array($nf, array_column($fieldsMeta, 'name'))) {
                $nameField = $nf;
                break;
            }
        }
        // si no hay campo "nombre" usar el segundo campo si existe
        if (!$nameField && isset($fieldsMeta[1])) {
            $nameField = $fieldsMeta[1]->name;
        }
        while ($row = $res->fetch_assoc()) {
            $id = $firstField ? $row[$firstField] : null;
            $nombre = $nameField ? $row[$nameField] : reset($row);
            $provincias[] = [
                'id' => $id,
                'nombre' => htmlspecialchars($nombre),
                'raw' => $row
            ];
        }
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Destinos | Sol & Mar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- estilos para flip card -->
    <style>
        .flip-card { perspective: 1200px; width: 100%; }
        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.6s;
            transform-style: preserve-3d;
            -webkit-transform-style: preserve-3d;
            box-sizing: border-box;
        }

        /* activar flip con hover o con la clase .is-flipped (para click/touch) */
        .flip-card:hover .flip-card-inner,
        .flip-card:focus-within .flip-card-inner,
        .flip-card.is-flipped .flip-card-inner {
            transform: rotateY(180deg);
            -webkit-transform: rotateY(180deg);
        }

        .flip-card-front,
        .flip-card-back {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            border-radius: .5rem;
            overflow: hidden;
            background: white;
            box-sizing: border-box;
            padding: 1rem;
            display: flex;
            flex-direction: column;
        }

        /* La espalda se rota 180° para que al rotar el contenedor quede legible (no invertida) */
        .flip-card-back {
            transform: rotateY(180deg);
            -webkit-transform: rotateY(180deg);
        }

        /* tamaño mínimo para que la tarjeta tenga dimensión */
        .flip-card { min-height: 320px; display: block; }
        .flip-thumb { height: 9rem; overflow: hidden; flex-shrink: 0; border-radius: .375rem; }
        .flip-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
    </style>
</head>
<body class="bg-slate-100 font-sans">
    <div class="max-w-6xl mx-auto p-6">
        <header class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-amber-800">Destinos / Provincias</h1>
            <a href="/agencia-1/viajes/invitado/panel_invitado.php" class="text-sky-600 hover:underline">Volver al panel</a>
        </header>

        <!-- Tarjeta descriptiva encima del grid -->
        <div class="mb-6">
            <div class="bg-white p-6 rounded-lg shadow flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-compass-drafting text-3xl text-sky-500"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-gray-800">Explora nuestras provincias</h2>
                    <p class="text-gray-600 mt-2">Descubre los mejores destinos, actividades y paquetes disponibles. Filtra por provincia y reserva tu viaje con facilidad.</p>
                </div>
                <div class="text-right">
                    <span class="text-amber-700 font-bold text-lg"><?= count($provincias) ?> disponibles</span>
                    <div class="text-sm text-gray-500">Paquetes y excursiones</div>
                </div>
            </div>
        </div>

        <?php if (empty($provincias)): ?>
            <div class="bg-white p-6 rounded shadow text-gray-600">
                No hay destinos/provincias disponibles por ahora.
            </div>
        <?php else: ?>
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($provincias as $p): 
                    // buscar campo de descripción en los datos crudos
                    $desc = '';
                    foreach (['descripcion','detalle','info','descripcion_larga','nota'] as $f) {
                        if (isset($p['raw'][$f]) && trim($p['raw'][$f]) !== '') {
                            $desc = htmlspecialchars($p['raw'][$f]);
                            break;
                        }
                    }
                    if ($desc === '') $desc = 'No hay descripción disponible.';
                    // imagen: si hay algún campo imagen en raw úsalo, si no placeholder
                    $img = null;
                    foreach (['imagen','imagenes','foto','fotos'] as $fi) {
                        if (!empty($p['raw'][$fi])) { $img = $p['raw'][$fi]; break; }
                    }
                    if ($img) {
                        $local = __DIR__ . '/../uploads/' . $img;
                        $imgSrc = file_exists($local) ? '/agencia-1/viajes/uploads/' . rawurlencode($img) : $img;
                    } else {
                        $imgSrc = 'https://via.placeholder.com/600x400?text=Sin+imagen';
                    }
                ?>
                <!-- tarjeta que gira al pasar el cursor -->
                <article class="flip-card bg-transparent rounded-lg shadow">
                    <div class="flip-card-inner">
                        <!-- frente -->
                        <div class="flip-card-front p-4 flex flex-col h-full">
                            <div class="flip-thumb rounded-md mb-3">
                                <img src="<?= $imgSrc ?>" alt="<?= $p['nombre'] ?>">
                            </div>
                            <h2 class="text-xl font-semibold text-gray-800"><?= $p['nombre'] ?></h2>
                            <p class="text-sm text-gray-500 mt-2 flex-1">
                                <?= strlen(strip_tags($desc)) > 120 ? substr(strip_tags($desc), 0, 117) . '...' : strip_tags($desc) ?>
                            </p>
                        </div>

                        <!-- reverso -->
                        <div class="flip-card-back flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-amber-800 mb-2"><?= $p['nombre'] ?></h3>
                                <div class="text-sm text-gray-700 mb-4" style="max-height:220px; overflow:auto;">
                                    <?= nl2br($desc) ?>
                                </div>
                            </div>

                            <!-- botones visibles en la cara trasera -->
                            <div class="mt-4 flex gap-2">
                                <a href="/agencia-1/viajes/invitado/detalle_destino.php?id=<?= urlencode($p['id']) ?>" class="flex-1 text-center px-3 py-2 bg-sky-600 text-white rounded hover:bg-sky-700">
                                    Más detalles
                                </a>
                                <a href="/agencia-1/viajes/invitado/reservar.php?provincia=<?= urlencode($p['id']) ?>" class="flex-1 text-center px-3 py-2 border border-sky-600 text-sky-600 rounded hover:bg-sky-50">
                                    Reservar
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>
