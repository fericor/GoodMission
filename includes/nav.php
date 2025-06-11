<?php
    $ID_USER     = $_SESSION['user_id'] ?? 0;
    $NOMBRE_USER = $_SESSION['nombre'] ?? 'Usuario';

    // Contar notificaciones no leídas
    $noti_count = 0;
    if ($ID_USER > 0) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM notificaciones WHERE id_usuario = ? AND leida = 0");
        $stmt->bind_param("i", $ID_USER);
        $stmt->execute();
        $stmt->bind_result($noti_count);
        $stmt->fetch();
        $stmt->close();
    }
?>


<!-- Menú Superior - App -->
<header class="sticky top-0 z-50 bg-white shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
        <!-- Logo y nombre de la app -->
        <div class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white font-bold">GM</div>
            <span class="text-lg font-semibold text-gray-800">GoodMission</span>
        </div>
        
        <!-- Iconos de navegación -->
        <div class="flex items-center space-x-4">
            <?php if($ID_USER != 0) : ?>
            <!-- Notificaciones -->
            <button id="noti-btn" class="p-1 rounded-full text-gray-600 hover:text-gray-800 hover:bg-gray-100 relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <?php if ($noti_count > 0): ?>
                    <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                <?php endif; ?>
            </button>
            
            <!-- Mensajes -->
            <button class="p-1 rounded-full text-gray-600 hover:text-gray-800 hover:bg-gray-100 relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-blue-500"></span>
            </button>
            <?php endif; ?>

            <!-- Dropdown -->
            <div id="noti-dropdown" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                <div class="p-3 border-b text-sm font-semibold text-gray-700">Notificaciones</div>
                <div id="noti-list" class="max-h-80 overflow-y-auto divide-y text-sm text-gray-600">
                    <!-- Aquí se cargan por AJAX -->
                    <div class="p-3 text-center text-gray-400">Cargando...</div>
                </div>
            </div>
            
            <!-- Perfil (Dropdown) -->
            <div class="relative">
                <button class="flex items-center space-x-1 focus:outline-none" data-dropdown-toggle>
                    <div class="w-8 h-8 rounded-full bg-gray-300 overflow-hidden">
                        <img src="assets/images/user_<?=$ID_USER?>.png" alt="Perfil" class="w-full h-full object-cover" style="width: 32px; height: 32px;">
                    </div>
                    <span class="hidden md:inline-block text-sm font-medium text-gray-700"><?=$NOMBRE_USER?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Menú desplegable (animado y oculto por defecto) -->
                <div id="dropdown-menu" class="origin-top-right absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 transition transform scale-95 opacity-0 invisible duration-200">
                    <?php if($ID_USER == 0) : ?>
                        <a href="login.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Iniciar sesión</a>
                        <a href="register.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Registrate</a>
                    <?php else: ?>
                        <a href="perfil.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mi perfil</a>
                        <a href="configuracion.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Configuración</a>
                        <div class="border-t border-gray-200"></div>
                        <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar sesión</a>
                    <?php endif; ?>
                </div>
                
            </div>
        </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.querySelector('[data-dropdown-toggle]');
        const dropdownMenu = document.getElementById('dropdown-menu');

        toggleBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('invisible');
            dropdownMenu.classList.toggle('opacity-0');
            dropdownMenu.classList.toggle('scale-95');
        });

        // Cierra el menú al hacer clic fuera
        document.addEventListener('click', function (e) {
            if (!dropdownMenu.classList.contains('invisible') && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('invisible', 'opacity-0', 'scale-95');
            }
        });
    });
</script>