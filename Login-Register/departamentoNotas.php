<?php
session_start();
include '../Login-register/conexion_be.php';

// Verificar si el usuario ha iniciado sesión y es admin
if (!isset($_SESSION['usuario'])) {
    header("Location: ../Login-register/index.php");
    exit();
}

$correo = $_SESSION['usuario'];
$query = "SELECT rol FROM usuarios WHERE correo = '$correo'";
$result = mysqli_query($conexion, $query);
$row = mysqli_fetch_assoc($result);

if (!$row || $row['rol'] !== 'admin') {
    echo "Acceso denegado. Esta página es solo para administradores.";
    exit();
}

// Insertar nota si se envió el formulario
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dni = mysqli_real_escape_string($conexion, $_POST['dni_alumno']);
    $materia = mysqli_real_escape_string($conexion, $_POST['materia']);
    $instancia = mysqli_real_escape_string($conexion, $_POST['instancia']);
    $nota = floatval($_POST['nota']);

    $insert = "INSERT INTO notas (dni_alumno, materia, instancia, nota) VALUES ('$dni', '$materia', '$instancia', $nota)";
    if (mysqli_query($conexion, $insert)) {
        $mensaje = "✅ Nota cargada correctamente.";
    } else {
        $mensaje = "❌ Error al cargar la nota.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Departamento de Notas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f4f4; }
        h1 { color: #333; }
        form { background: #fff; padding: 20px; border-radius: 5px; margin-bottom: 30px; }
        label { display: block; margin-top: 10px; }
        input, select { padding: 8px; width: 100%; margin-top: 5px; }
        button { margin-top: 15px; padding: 10px 20px; background-color: #4CAF50; border: none; color: white; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ddd; padding: 10px; }
        th { background-color: #eee; }
        .mensaje { margin-top: 10px; color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h1>📚 Cargar Notas al Boletín</h1>

    <?php if ($mensaje): ?>
        <p class="mensaje"><?= $mensaje ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="dni_alumno">DNI del Alumno:</label>
        <input type="text" name="dni_alumno" required>

        <label for="materia">Materia:</label>
        <input type="text" name="materia" required>

        <label for="instancia">Instancia (Parcial/Cuatrimestre):</label>
        <select name="instancia" required>
            <option value="">-- Seleccionar Instancia --</option>
            <option value="Primer Parcial">Primer Parcial</option>
            <option value="Segundo Parcial">Segundo Parcial</option>
            <option value="Primer Cuatrimestre">Primer Cuatrimestre</option>
            <option value="Segundo Cuatrimestre">Segundo Cuatrimestre</option>
            <option value="Final">Final</option>
        </select>

        <label for="nota">Nota:</label>
        <input type="number" name="nota" step="0.01" min="0" max="10" required>

        <button type="submit">Cargar Nota</button>
    </form>

    <h2>🗂 Últimas Notas Cargadas</h2>
    <table>
        <thead>
            <tr>
                <th>DNI Alumno</th>
                <th>Materia</th>
                <th>Instancia</th>
                <th>Nota</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $notas = mysqli_query($conexion, "SELECT * FROM notas ORDER BY fecha DESC LIMIT 10");
            while ($fila = mysqli_fetch_assoc($notas)) {
                echo "<tr>
                        <td>{$fila['dni_alumno']}</td>
                        <td>{$fila['materia']}</td>
                        <td>{$fila['instancia']}</td>
                        <td>{$fila['nota']}</td>
                        <td>{$fila['fecha']}</td>
                      </tr>";
            }
        ?>
        </tbody>
    </table>
</body>
</html>
