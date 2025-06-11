<?php
    session_start();
    include '../../control/db.php';

    $categoria  = $_POST['categoria'] ?? '*';
    $busqueda   = $_POST['busqueda'] ?? '';
    $pagina     = max(1, intval($_POST['pagina'] ?? 1));
    $por_pagina = 5;
    $offset     = ($pagina - 1) * $por_pagina;

    // Consulta base
    $sql    = "SELECT * FROM retos WHERE 1";
    $params = [];
    $types  = '';

    // Filtro por categoría
    if ($categoria != "*") {
        $sql .= " AND categoria = ?";
        $params[] = $categoria;
        $types .= 's';
    }

    // Filtro por texto (título o ubicación)
    if (!empty($busqueda)) {
        $sql .= " AND (titulo LIKE ? OR ubicacion LIKE ?)";
        $busqueda_wildcard = "%" . $busqueda . "%";
        $params[] = $busqueda_wildcard;
        $params[] = $busqueda_wildcard;
        $types .= 'ss';
    }

    // Contar total
    $stmt = $conn->prepare($sql);
    if ($types) $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $total = $stmt->get_result()->num_rows;

    // Añadir límite para paginación
    $sql .= " ORDER BY fecha_limite ASC LIMIT ? OFFSET ?";
    $params[] = $por_pagina;
    $params[] = $offset;
    $types .= 'ii';

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    $html = '';
    while ($reto = $result->fetch_assoc()) {
        // Para cada reto:
        $HTML_BOTON          = '';
        $estrellasHTML       = '';
        $idReto              = $reto['id'];
        $valoracion_total    = $reto['valoracion_total'];
        $valoracion_cantidad = $reto['valoracion_cantidad'];
        $media               = $valoracion_cantidad > 0 ? round($valoracion_total / $valoracion_cantidad, 1) : 0;

        // Inscritos
        $inscritosQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM inscripciones WHERE id_reto = $idReto");
        $inscritos      = mysqli_fetch_assoc($inscritosQuery)['total'];

        // Comprobar si el usuario está inscrito
        $id_usuario = $_SESSION['user_id'] ?? 0;
        $yaInscrito = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM inscripciones WHERE id_reto=$idReto AND id_usuario=$id_usuario")) > 0;

        // Botón para participar si hay cupo
        if ($yaInscrito) {
            $HTML_BOTON .= "<form method='POST' action='modulos/retos/apuntarse_retos.php' class='m-0'>";
            $HTML_BOTON .= "<input type='hidden' name='id_reto' value='$idReto'>";
            $HTML_BOTON .= '<button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-sm font-medium flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg> Cancelar </button>';
            $HTML_BOTON .= "</form>";
        } else if ($inscritos < $reto['max_participantes']) {
            $HTML_BOTON .= "<form method='POST' action='modulos/retos/apuntarse_retos.php' class='m-0'>";
            $HTML_BOTON .= "<input type='hidden' name='id_reto' value='$idReto'>";
            $HTML_BOTON .= '<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm font-medium flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg> Apuntarme </button>';
            $HTML_BOTON .= "</form>";
        } else {
            $HTML_BOTON = '<div class="flex justify-end">
                            <strong class="-me-[2px] -mb-[2px] inline-flex items-center gap-1 rounded-ss-xl rounded-ee-xl bg-green-600 px-3 py-1.5 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>

                                <span class="text-[10px] font-medium sm:text-xs">Solved!</span>
                            </strong>
                        </div>';
        }


        $media = ($valoracion_cantidad > 0) ? round($valoracion_total / $valoracion_cantidad, 1) : 0;

        $estrellasHTML .= '<!-- Valoración con estrellas -->';
        $estrellasHTML .= '<div class="flex items-center mb-4">';
        $estrellasHTML .= '<div class="flex mr-2">';

        $estrellasHTML .= '<!-- Estrellas llenas -->';
        for ($i = 1; $i <= 5; $i++) {
            $color = $i <= round($media) ? 'text-yellow-400' : 'text-gray-300';

            $estrellasHTML .= '<svg data-valor="' . $i . '" data-reto="' . $idReto . '" onclick="app.handleStarClick(this)" class="w-4 h-4 ' . $color . '" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
        }
        
        $estrellasHTML .= '</div>';
        $estrellasHTML .= '<span class="text-sm text-gray-600">' . number_format($media, 1) . ' ('.$valoracion_total.' valoraciones)</span>';
        $estrellasHTML .= '</div>';

        $html .= '<div data-categoria="'.htmlspecialchars($reto['categoria']).'" class="max-w bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <!-- Imagen con icono de "me gusta" -->
                    <div class="relative">
                        <img class="w-full h-48 object-cover" src="uploads/'.htmlspecialchars($reto['imagen']).'" alt="'.htmlspecialchars($reto['titulo']).'">
                        <!-- Corazón "me gusta" -->
                        <button class="absolute top-3 right-3 p-2 bg-white bg-opacity-80 rounded-full hover:bg-opacity-100 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 hover:text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Contenido de la card -->
                    <div class="p-5">
                        <!-- Título y fecha -->
                        <div class="mb-3">
                            <h3 class="text-xl font-bold text-gray-800">'.htmlspecialchars($reto['titulo']).'</h3>
                            <p class="text-sm text-gray-500 mt-1">'.date('d M Y', strtotime($reto['fecha_limite'])).' • '.date('H:i', strtotime($reto['fecha_limite'])).'h</p>
                        </div>

                        <!-- Ubicación -->
                        <div class="flex items-center text-gray-600 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-sm">'.htmlspecialchars($reto['direccion']).', '.htmlspecialchars($reto['ubicacion']).'</span>
                        </div>

                        '.$estrellasHTML.'

                        <!-- Botones de acción -->
                        <div class="flex justify-between">
                            <button class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-200 text-sm font-medium"> Más información </button>
                            '.$HTML_BOTON.'
                        </div>
                    </div>
                </div>';

        // echo '<a href="detalle_reto.php?id='.$reto['id'].'" class="block rounded-lg shadow-xs shadow-indigo-100 bg-white mb-4 hover:shadow-lg transition-shadow duration-300 ease-in-out"> 
        /*$html .= '<div data-categoria="'.htmlspecialchars($reto['categoria']).'" class="reto-card block rounded-lg shadow-xs shadow-indigo-100 bg-white mb-4 hover:shadow-lg transition-shadow duration-300 ease-in-out"> 
                <img alt="" src="uploads/'.htmlspecialchars($reto['imagen']).'" class="h-56 w-full rounded-md object-cover" />

                <div class="mt-2">
                    <dl>
                        <div class="pl-4 pr-4">
                            <dd class="text-lg text-gray-900">'.htmlspecialchars($reto['recompensa']).''.htmlspecialchars($reto['tipo']).'</dd>
                        </div>

                        <div class="pl-4 pr-4">
                            <dd class="font-medium">'.htmlspecialchars($reto['titulo']).'</dd>
                        </div>

                        '.$estrellasHTML.'
                    </dl>

                    <div class="bg-blue-50 mt-2 mb-2 p-2 flex items-center gap-4 text-xs">
                        <div class="flex-1 flex items-center gap-1">
                            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z" clip-rule="evenodd"/>
                            </svg>

                            <div class="mt-1.5 mt-0">
                                <p class="font-medium">'.$inscritos.'/'.$reto['max_participantes'].' inscritos</p>
                            </div>
                        </div>

                        <div class="flex-1 flex items-center gap-1">
                            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M18 5.05h1a2 2 0 0 1 2 2v2H3v-2a2 2 0 0 1 2-2h1v-1a1 1 0 1 1 2 0v1h3v-1a1 1 0 1 1 2 0v1h3v-1a1 1 0 1 1 2 0v1Zm-15 6v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-8H3ZM11 18a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1a1 1 0 1 0-2 0v1h-1a1 1 0 1 0 0 2h1v1Z" clip-rule="evenodd"/>
                            </svg>

                            <div class="mt-1.5 mt-0">
                                <p class="font-medium">Hasta el <span class="font-medium">'.date('d M', strtotime($reto['fecha_limite'])).'</span></p>
                            </div>
                        </div>

                        <div class="flex-1 flex items-center gap-1">
                            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z" clip-rule="evenodd"/>
                            </svg>

                            <div class="mt-1.5 mt-0">
                                <p class="font-medium">Organizado por <span class="font-medium">'.htmlspecialchars($reto['organizador']).'</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                '.$HTML_BOTON.'
            </div>';*/

        
    }

    if ($html === '') {
        $html = '<p class="text-gray-500 text-sm">No se encontraron retos.</p>';
    }

    $ultima_pagina = ($offset + $por_pagina) >= $total;

    echo json_encode([
        'html' => $html,
        'ultima' => $ultima_pagina
    ]);
