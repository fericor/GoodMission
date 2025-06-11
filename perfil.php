<?php 
    include_once 'control/db.php'; 
    include_once 'control/csrf.php';

    noLogin();

    $TITLE_PAG = "GoodMission - Mi perfil";
?>

<?php include_once 'includes/nav.php'; ?>
<?php include_once 'includes/header.php'; ?>

<?php

    $id_usuario = $_SESSION['user_id'] ?? null;

    // Obtener estadísticas
    $query = "
    SELECT 
        COUNT(*) AS total,
        SUM(CASE WHEN valoracion = 5 THEN 1 ELSE 0 END) AS cinco_estrellas
    FROM inscripciones
    WHERE id_usuario = $id_usuario AND valoracion IS NOT NULL";

    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    $retos_completados = $data['total'];
    $valoraciones_5 = $data['cinco_estrellas'];

    // Nivel
    if ($retos_completados >= 11) $nivel = "🧠 Leyenda";
    elseif ($retos_completados >= 6) $nivel = "🔥 Comprometido";
    elseif ($retos_completados >= 3) $nivel = "🚀 Activo";
    else $nivel = "🐣 Novato";

    // Insignias
    $insignias = [];

    if ($retos_completados >= 1) $insignias[] = "🎉 Primer paso";
    if ($retos_completados >= 5) $insignias[] = "💪 Constante";
    if ($retos_completados >= 10) $insignias[] = "🏅 Top Participante";
    if ($valoraciones_5 >= 5) $insignias[] = "⭐ Inspirador";

?>


    <div class="container mx-auto max-w-md p-4">
        <!-- Encabezado -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-4">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Laura</h1>
            
            <!-- Sección Mistones -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Mistones</h2>
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-green-500">+13</span>
                </div>
            </div>
            
            <!-- Sección Puntos -->
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-1">870</h2>
                <p class="text-gray-500 italic">interés: mensual</p>
            </div>
        </div>

        <!-- Divisor -->
        <div class="border-t border-gray-200 my-4"></div>

        <!-- Misiones diarias 1 -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-4">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Misiones diarias</h2>
            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-600">1/3</span>
            </div>
            
            <div class="bg-gray-200 rounded-full h-4 mb-4">
                <div class="bg-blue-500 h-4 rounded-full" style="width: 33%"></div>
            </div>
            
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-700">Nivel 5</h3>
                </div>
                <span class="text-lg font-bold text-green-500">+120 PTS</span>
            </div>
        </div>

        <!-- Misiones diarias 2 -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Misiones diarias</h2>
            <h3 class="text-lg font-bold text-purple-600 mb-2">POOGRESO</h3>
            
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-700">Level</h3>
                </div>
                <span class="text-lg font-bold text-green-500">+120P</span>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4 p-3">
    <h4 class="mb-2">🎖️ Nivel actual: <strong><?= $nivel ?></strong></h4>
    <p>Retos completados: <strong><?= $retos_completados ?></strong></p>

    <h5 class="mt-3">🏅 Insignias desbloqueadas:</h5>
    <?php if (count($insignias)) {
        echo "<ul class='list-group'>";
        foreach ($insignias as $i) {
            echo "<li class='list-group-item'>$i</li>";
        }
        echo "</ul>";
    } else {
        echo "<p class='text-muted'>Aún no has ganado ninguna insignia.</p>";
    } ?>



<?php include 'includes/menu.php'; ?>
<?php include 'includes/footer.php'; ?>