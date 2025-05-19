<?php
session_start();

if (!isset($_SESSION['rol']) || (int)$_SESSION['rol'] !== 2) {
    header("location: index.php");
    session_destroy();
    die();
}

require_once "php/conexion_be.php"; // Asegúrate de tener este archivo con conexión a MySQL

$id_usuario = $_SESSION['id'];

// Obtener datos del alumno
$queryAlumno = "SELECT * FROM alumnos WHERE id = $id_usuario";
$resultAlumno = mysqli_query($conexion, $queryAlumno);
$alumno = mysqli_fetch_assoc($resultAlumno);

if (!$alumno) {
    echo "No se encontró información del alumno.";
    session_destroy();
    die();
}

// Obtener notas del alumno
$queryNotas = "SELECT * FROM notas WHERE id_alumno = " . $alumno['id'];
$resultNotas = mysqli_query($conexion, $queryNotas);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boletín de Calificaciones</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f4f8;
            margin: 0;
            padding: 0;
        }
        header {
            background-color:rgb(143, 35, 35);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .container {
            max-width: 1000px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .student-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .student-info div {
            margin-bottom: 10px;
            flex: 1 1 45%;
        }
        h2 {
            margin-top: 0;
            border-bottom: 2px solid #005792;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color:rgb(204, 43, 43);
            color: white;
        }
        footer {
            text-align: center;
            padding: 20px;
            background: #003f5c;
            color: white;
            margin-top: 30px;
        }
        .logout {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            color: #005792;
            text-decoration: none;
        }
        .logout:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <h1>Colegio Dr. Ernesto Guevara</h1>
    <h3>Boletín de Calificaciones</h3>
</header>

<div class="container">
    <div class="student-info">
        <div><strong>Alumno:</strong> <?= htmlspecialchars($alumno['nombre_completo']) ?></div>
        <div><strong>Curso:</strong> <?= htmlspecialchars($alumno['curso']) ?></div>
        <div><strong>Año Académico:</strong> <?= date("Y") ?></div>
        <div><strong>Orientación:</strong> <?= htmlspecialchars($alumno['orientacion']) ?></div>
    </div>

    <h2>Notas</h2>

    <table>
        <thead>
            <tr>
                <th>Asignatura</th>
                <th>Parcial 1</th>
                <th>Parcial 2</th>
                <th>1er Cuatrimestre</th>
                <th>Parcial 3</th>
                <th>Parcial 4</th>
                <th>2do Cuatrimestre</th>
                <th>Calificación Final</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($nota = mysqli_fetch_assoc($resultNotas)): ?>
            <tr>
                <td><?= htmlspecialchars($nota['asignatura']) ?></td>
                <td><?= $nota['parcial1'] ?></td>
                <td><?= $nota['parcial2'] ?></td>
                <td><?= $nota['cuatrimestre1'] ?></td>
                <td><?= $nota['parcial3'] ?></td>
                <td><?= $nota['parcial4'] ?></td>
                <td><?= $nota['cuatrimestre2'] ?></td>
                <td><?= $nota['final'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a class="logout" href="php/cerrar_sesion.php">Cerrar sesión</a>
</div>

<footer>
    &copy; <?= date("Y") ?> Colegio Dr. Ernesto Guevara | Todos los derechos reservados.
</footer>

</body>
</html>


