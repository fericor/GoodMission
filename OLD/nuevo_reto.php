<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $organizador = $_POST['organizador'];
    $tipo = $_POST['tipo'];
    $recompensa = $_POST['recompensa'];
    $fecha_limite = $_POST['fecha_limite'];

    $imagen = $_FILES['imagen']['name'];
    move_uploaded_file($_FILES['imagen']['tmp_name'], "uploads/$imagen");

    $stmt = $conn->prepare("INSERT INTO retos (titulo, descripcion, categoria, organizador, tipo, recompensa, fecha_limite, imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $titulo, $descripcion, $categoria, $organizador, $tipo, $recompensa, $fecha_limite, $imagen);
    $stmt->execute();

    header("Location: index.php");
}
?>

<?php include 'includes/header.php'; ?>
<div class="container mt-4">
    <h2>Nuevo Reto</h2>
    <form method="post" enctype="multipart/form-data">
        <input name="titulo" class="form-control mb-2" placeholder="Título" required>
        <textarea name="descripcion" class="form-control mb-2" placeholder="Descripción" required></textarea>
        <select name="categoria" class="form-control mb-2">
            <option value="Medioambiente">Medioambiente</option>
            <option value="Comunidad">Comunidad</option>
        </select>
        <input name="organizador" class="form-control mb-2" placeholder="Organizador" required>
        <select name="tipo" class="form-control mb-2">
            <option value="€">€</option>
            <option value="Curso">Curso</option>
            <option value="Banja">Banja</option>
        </select>
        <input name="recompensa" class="form-control mb-2" placeholder="Recompensa" required>
        <input type="date" name="fecha_limite" class="form-control mb-2" required>
        <input type="file" name="imagen" class="form-control mb-2" required>
        <button class="btn btn-success">Guardar</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
