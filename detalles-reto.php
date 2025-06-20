<?php include_once 'control/db.php'; ?>
<?php include_once 'control/csrf.php'; ?>

<?php 
    $ID_RETO   = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $TITLE_PAG = "GoodMission - Detalles del Reto"; 

    // Preparar y ejecutar consulta
    $stmt = $conn->prepare("SELECT * FROM retos WHERE id = ?");
    $stmt->bind_param("i", $ID_RETO);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($reto = $result->fetch_assoc()) {
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

?>

<?php include_once 'includes/nav.php'; ?>
<?php include_once 'includes/header.php'; ?>

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-xl mt-10">
    
        <!-- Imagen del evento -->
        <div class="rounded-xl overflow-hidden">
            <img src="uploads/<?=htmlspecialchars($reto['imagen'])?>" alt="<?=htmlspecialchars($reto['titulo'])?>" class="w-full object-cover">
        </div>

        <!-- Título y botones -->
        <div class="flex justify-between items-center mt-4">
            <h1 class="text-3xl font-bold"><?=htmlspecialchars($reto['titulo'])?></h1>
            <div class="flex space-x-4">
                <button id="likeBtn" class="text-gray-500 hover:text-red-500 transition">
                ❤️ <span id="likeCount"><?=$valoracion_cantidad?></span>
                </button>
                <?=$HTML_BOTON?>
            </div>
        </div>

        <!-- Información -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-lg"><strong>Fecha:</strong> <?=date('d M Y', strtotime($reto['fecha_limite']))?></p>
                <p class="text-lg"><strong>Hora:</strong> <?=date('H:i', strtotime($reto['fecha_limite']))?></p>
                <p class="text-lg"><strong>Lugar:</strong> <?=htmlspecialchars($reto['direccion'])?>, <?=htmlspecialchars($reto['ubicacion'])?></p>
                <p class="text-lg"><strong>Precio:</strong> <span class="text-green-600 font-semibold"><?=htmlspecialchars($reto['recompensa'])?> <?=htmlspecialchars($reto['tipo'])?></span></p>
            </div>
            <div>
                <p class="text-lg"><strong>Organiza:</strong> <?=htmlspecialchars($reto['organizador'])?></p>
                <p class="text-lg"><strong>Categoría:</strong> <?=htmlspecialchars($reto['categoria'])?></p>

                <!-- Valoración -->
                <div class="mt-4">
                    <strong>Valoración:</strong>
                    <?= $estrellasHTML ?>
                </div>
            </div>
        </div>

        <!-- Descripción -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold mb-2">Descripción del evento</h2>
            <p class="text-gray-700 leading-relaxed">
                <?=htmlspecialchars($reto['descripcion'])?>
            </p>
        </div>

        <!-- Mapa (Ubicación) -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-2">Ubicación</h2>
            <div class="aspect-w-16 aspect-h-9">
                <iframe class="w-full h-64 rounded-xl border"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3036.2992991773556!2d-3.682746384605812!3d40.41536397936562!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd422628d5403b4d%3A0xf37b956e10f816e!2sParque%20del%20Retiro!5e0!3m2!1ses!2ses!4v1689105404742"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <!-- Participantes -->
        <div class="mt-6 border-t pt-4 text-sm text-gray-500">
            Participantes: <span id="participantCount"><?=$inscritos?></span>
        </div>
    </div>

    <?php
        } else {
            echo "<p>Reto no encontrado.</p>";
        }
    ?>


    <!-- Script JS -->
    <script>
        const likeBtn = document.getElementById("likeBtn");
        const likeCount = document.getElementById("likeCount");
        const participateBtn = document.getElementById("participateBtn");
        const participantCount = document.getElementById("participantCount");
        const stars = document.querySelectorAll(".star");

        let liked = false;
        let participating = false;
        let currentRating = 0;

        likeBtn.addEventListener("click", () => {
        liked = !liked;
        likeBtn.classList.toggle("text-red-500", liked);
        likeCount.textContent = liked
            ? parseInt(likeCount.textContent) + 1
            : parseInt(likeCount.textContent) - 1;
        });

        participateBtn.addEventListener("click", () => {
        participating = !participating;
        participateBtn.textContent = participating ? "Cancelar participación" : "Participar";
        participantCount.textContent = participating
            ? parseInt(participantCount.textContent) + 1
            : parseInt(participantCount.textContent) - 1;
        });

        stars.forEach(star => {
        star.addEventListener("click", () => {
            currentRating = parseInt(star.getAttribute("data-value"));
            updateStars(currentRating);
            // Aquí podrías hacer un fetch/ajax para guardar la valoración
            console.log("Valoración:", currentRating);
        });
        });

        function updateStars(rating) {
        stars.forEach(star => {
            const val = parseInt(star.getAttribute("data-value"));
            star.classList.toggle("selected", val <= rating);
        });
        }
    </script>
<?php include_once 'includes/menu.php'; ?>
<?php include_once 'includes/footer.php'; ?>