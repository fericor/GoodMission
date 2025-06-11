<?php

    include_once 'control/db.php';
    include_once 'control/csrf.php';

    check_csrf();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 1) {
            $user = $res->fetch_assoc();
            if (password_verify($password, $user['password'])) {

                session_start();

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nombre']  = $user['nombre'];

                header("Location: index.php");

            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Correo no encontrado.";
        }
    }
?>

<?php 
    // if (!isset($_SESSION['user_id'])) header("Location: login.php");
    $TITLE_PAG = "GoodMission - Login"; 
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
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Iniciar sesión</h2>
    <form method="post" class="space-y-4">
        <?= csrf_token() ?>
        <div>
            <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Email" required />
        </div>
        <div>
            <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contraseña" required />
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200"> Entrar </button>
        <p class="text-center text-sm text-gray-600 mt-4">
            ¿No tienes cuenta? <a href="register.php" class="text-blue-600 hover:underline">Regístrate aquí</a>
        </p>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
