<?php
include 'includes/db.php';

$query = "
SELECT 
    u.id, 
    u.nombre, 
    COUNT(i.id_reto) AS total_retos, 
    AVG(i.valoracion) AS promedio_valoracion
FROM users u
JOIN inscripciones i ON u.id = i.id_usuario
WHERE i.valoracion IS NOT NULL
GROUP BY u.id
ORDER BY total_retos DESC, promedio_valoracion DESC
LIMIT 20
";

$result = mysqli_query($conn, $query);
?>

<h2 class="mb-4">🏆 Ranking de Usuarios</h2>

<table class="table table-hover table-striped rounded shadow-sm">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Retos completados</th>
            <th>Valoración promedio</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $pos = 1;
        while ($fila = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>$pos</td>";
            echo "<td>".htmlspecialchars($fila['nombre'])."</td>";
            echo "<td>{$fila['total_retos']}</td>";
            echo "<td>" . number_format($fila['promedio_valoracion'], 2) . " ⭐</td>";
            echo "</tr>";
            $pos++;
        }
        ?>
    </tbody>
</table>
