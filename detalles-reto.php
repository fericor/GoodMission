<?php include_once 'control/db.php'; ?>
<?php include_once 'control/csrf.php'; ?>

<?php 
    // if (!isset($_SESSION['user_id'])) header("Location: login.php");
    $TITLE_PAG = "GoodMission - Inicio"; 
?>

<?php include_once 'includes/nav.php'; ?>
<?php include_once 'includes/header.php'; ?>

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-xl mt-10">
    
        <!-- Imagen del evento -->
        <div class="rounded-xl overflow-hidden">
        <img src="https://source.unsplash.com/800x400/?concert,event" alt="Imagen del Evento" class="w-full object-cover">
        </div>

        <!-- Título y botones -->
        <div class="flex justify-between items-center mt-4">
        <h1 class="text-3xl font-bold">Festival de Música Urbana</h1>
        <div class="flex space-x-4">
            <button id="likeBtn" class="text-gray-500 hover:text-red-500 transition">
            ❤️ <span id="likeCount">12</span>
            </button>
            <button id="participateBtn" class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">
            Participar
            </button>
        </div>
        </div>

        <!-- Información -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <p class="text-lg"><strong>Fecha:</strong> 22 de Junio de 2025</p>
            <p class="text-lg"><strong>Hora:</strong> 19:00</p>
            <p class="text-lg"><strong>Lugar:</strong> Parque del Retiro, Madrid</p>
            <p class="text-lg"><strong>Precio:</strong> <span class="text-green-600 font-semibold">Gratis</span></p>
        </div>
        <div>
            <p class="text-lg"><strong>Organiza:</strong> Cultura Madrid</p>
            <p class="text-lg"><strong>Categoría:</strong> Música, Festival</p>

            <!-- Valoración -->
            <div class="mt-4">
            <strong>Valoración:</strong>
            <div id="rating" class="flex space-x-1 mt-1">
                <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
            </div>
            </div>
        </div>
        </div>

        <!-- Descripción -->
        <div class="mt-6">
        <h2 class="text-xl font-semibold mb-2">Descripción del evento</h2>
        <p class="text-gray-700 leading-relaxed">
            Únete a una noche llena de música, comida y diversión. Disfruta de artistas urbanos reconocidos y emergentes. Evento al aire libre con zona de food trucks, actividades y mucho más.
        </p>
        </div>

        <!-- Mapa (Ubicación) -->
        <div class="mt-8">
        <h2 class="text-xl font-semibold mb-2">Ubicación</h2>
        <div class="aspect-w-16 aspect-h-9">
            <iframe 
            class="w-full h-64 rounded-xl border"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3036.2992991773556!2d-3.682746384605812!3d40.41536397936562!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd422628d5403b4d%3A0xf37b956e10f816e!2sParque%20del%20Retiro!5e0!3m2!1ses!2ses!4v1689105404742"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        </div>

        <!-- Participantes -->
        <div class="mt-6 border-t pt-4 text-sm text-gray-500">
        Participantes: <span id="participantCount">87</span>
        </div>
    </div>


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