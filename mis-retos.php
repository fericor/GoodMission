<?php 
    include_once 'control/db.php'; 
    include_once 'control/csrf.php';

    noLogin();

    $TITLE_PAG = "GoodMission - Mis retos inscritos";
?>

<?php include_once 'includes/nav.php'; ?>
<?php include_once 'includes/header.php'; ?>

<?php

    $id_usuario = $_SESSION['user_id'] ?? null;

    // Consulta retos donde está inscrito
    $query = "SELECT 
                    r.*, 
                    i.valoracion, 
                    i.fecha_inscripcion 
                FROM 
                    inscripciones i 
                    JOIN retos r ON i.id_reto = r.id 
                WHERE 
                    i.id_usuario = $id_usuario 
                ORDER BY r.fecha_limite ASC";

    $result = mysqli_query($conn, $query);
?>

<h2>Mis retos inscritos</h2>

<div class="row">
<?php while($reto = mysqli_fetch_assoc($result)) {
    $fecha_limite = strtotime($reto['fecha_limite']);
    $yaValorado = !is_null($reto['valoracion']);
    $hoy = strtotime(date('Y-m-d'));

    echo "<div class='col-12 mb-3'>";
    echo "<div class='md-card shadow-sm p-3'>";
    echo "<h5>{$reto['titulo']}</h5>";
    echo "<p><strong>Organiza:</strong> {$reto['organizador']}</p>";
    echo "<p><strong>Recompensa:</strong> {$reto['recompensa']} ({$reto['tipo']})</p>";
    echo "<p><strong>Límite:</strong> " . date('d M', $fecha_limite) . "</p>";

    // Mostrar valoración actual
    if ($yaValorado) {
        echo "<p><strong>Valoración:</strong> ";
        for ($i = 1; $i <= 5; $i++) {
            echo $i <= $reto['valoracion'] 
                ? "<i class='bi bi-star-fill text-warning'></i>" 
                : "<i class='bi bi-star text-warning'></i>";
        }
        echo "</p>";
    } elseif ($hoy > $fecha_limite) {
        // Mostrar formulario para valorar si el reto ha pasado
        echo "<form action='valoracion.php' method='POST'>";
        echo "<input type='hidden' name='id_reto' value='{$reto['id']}'>";
        echo "<label>Valorar este reto:</label><br>";
        for ($i = 1; $i <= 5; $i++) {
            echo "<label><input type='radio' name='valor' value='$i'> $i ⭐</label> ";
        }
        echo "<br><button type='submit' class='btn btn-sm btn-primary mt-2'>Enviar</button>";
        echo "</form>";
    } else {
        echo "<p class='text-muted'><em>Podrás valorar este reto una vez haya finalizado.</em></p>";
    }

    // Permitir retiro solo si no ha pasado la fecha límite
    if ($hoy < $fecha_limite) {
        echo "<form action='apuntarse.php' method='POST' class='mt-2'>";
        echo "<input type='hidden' name='id_reto' value='{$reto['id']}'>";
        echo "<input type='hidden' name='accion' value='retirar'>";
        echo "<button class='btn btn-outline-danger btn-sm'>Cancelar inscripción</button>";
        echo "</form>";
    }

    echo "</div></div>";
}
?>
<?php include 'includes/menu.php'; ?>
<?php include 'includes/footer.php'; ?>
