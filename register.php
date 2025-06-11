<?php
    include_once 'control/db.php';
    include_once 'control/csrf.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre   = $_POST['nombre'];
        $email    = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (nombre, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $email, $password);

        if ($stmt->execute()) {
            header("Location: login.php");
        } else {
            echo "Error al registrar: " . $conn->error;
        }
    }

    $TITLE_PAG = "GoodMission - Registro"; 
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
            <!-- Perfil (Dropdown) -->
            <div class="relative">
                <a href="index.php" class="flex items-center space-x-1 focus:outline-none">
                    <svg class="w-6 h-6 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                    </svg>
                </a>
            </div>
        </div>
        </div>
    </div>
</header>

<?php include 'includes/header.php'; ?>

<div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Registro</h2>
    <form method="post" class="space-y-4">
        <div>
            <input 
                type="text" 
                name="nombre" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Nombre completo" 
                required
            >
        </div>
        <div>
            <input 
                type="email" 
                name="email" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Correo electrónico" 
                required
            >
        </div>
        <div>
            <input 
                type="password" 
                name="password" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Contraseña" 
                required
            >
        </div>
        <div class="flex items-center">
            <input 
                type="checkbox" 
                id="terms" 
                name="terms" 
                class="mr-2 rounded text-blue-600 focus:ring-blue-500"
                required
            >
            <label for="terms" class="text-sm text-gray-600">
                Acepto los términos y condiciones
            </label>
        </div>
        <button 
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200"
        >
            Registrarse
        </button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
