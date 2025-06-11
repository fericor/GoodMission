<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detalle del Evento</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-xl mt-10">
    <!-- Imagen del evento -->
    <div class="rounded-xl overflow-hidden">
      <img src="https://source.unsplash.com/800x400/?concert,event" alt="Imagen del Evento" class="w-full object-cover">
    </div>

    <!-- Título y acciones -->
    <div class="flex justify-between items-center mt-4">
      <h1 class="text-3xl font-bold">Festival de Música Urbana</h1>
      <div class="flex space-x-4">
        <!-- Botón de gustar -->
        <button id="likeBtn" class="text-gray-500 hover:text-red-500 transition">
          ❤️ <span id="likeCount">12</span>
        </button>
        <!-- Botón de participar -->
        <button id="participateBtn" class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">
          Participar
        </button>
      </div>
    </div>

    <!-- Información del evento -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <p class="text-lg"><strong>Fecha:</strong> 22 de Junio de 2025</p>
        <p class="text-lg"><strong>Hora:</strong> 19:00</p>
        <p class="text-lg"><strong>Lugar:</strong> Parque del Retiro, Madrid</p>
      </div>
      <div>
        <p class="text-lg"><strong>Precio:</strong> <span class="text-green-600 font-semibold">Gratis</span></p>
        <p class="text-lg"><strong>Organiza:</strong> Cultura Madrid</p>
        <p class="text-lg"><strong>Categoría:</strong> Música, Festival</p>
      </div>
    </div>

    <!-- Descripción -->
    <div class="mt-6">
      <h2 class="text-xl font-semibold mb-2">Descripción del evento</h2>
      <p class="text-gray-700 leading-relaxed">
        Únete a una noche llena de música, comida, y diversión. Disfruta de los mejores artistas urbanos nacionales e internacionales. Ideal para pasar con amigos o familia.
      </p>
    </div>

    <!-- Número de participantes -->
    <div class="mt-6 border-t pt-4 text-sm text-gray-500" id="participantsSection">
      <span>Participantes: <span id="participantCount">87</span></span>
    </div>
  </div>

  <script>
    const likeBtn = document.getElementById("likeBtn");
    const likeCount = document.getElementById("likeCount");
    const participateBtn = document.getElementById("participateBtn");
    const participantCount = document.getElementById("participantCount");

    let liked = false;
    let participating = false;

    likeBtn.addEventListener("click", () => {
      liked = !liked;
      likeBtn.classList.toggle("text-red-500", liked);
      likeCount.textContent = liked ? parseInt(likeCount.textContent) + 1 : parseInt(likeCount.textContent) - 1;
    });

    participateBtn.addEventListener("click", () => {
      participating = !participating;
      participateBtn.textContent = participating ? "Cancelar participación" : "Participar";
      participantCount.textContent = participating ? parseInt(participantCount.textContent) + 1 : parseInt(participantCount.textContent) - 1;
    });
  </script>

</body>
</html>
