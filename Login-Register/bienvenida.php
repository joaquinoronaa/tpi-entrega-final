<?php

    session_start();

    if(!isset($_SESSION['usuario'])){
        echo '
            <script>
                alert("porfavor debes iniciar sesion");
                window.location = "index.php";
            </script>
        ';
        session_destroy();
        die();
    }


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
            background-color: #005792;
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
            background-color: #005792;
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
    <h1>Instituto San Francisco de Asís</h1>
    <h3>Boletín de Calificaciones</h3>
</header>

<div class="container">
    <div class="student-info">
        <div><strong>Alumno:</strong> Juan Pérez</div>
        <div><strong>Curso:</strong> 3º A</div>
        <div><strong>Año Académico:</strong> 2024</div>
        <div><strong>Orientación:</strong> Bachillerato</div>
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
            <tr>
                <td>Matemáticas</td>
                <td>8</td>
                <td>7.5</td>
                <td>8</td>
                <td>7</td>
                <td>8.5</td>
                <td>7.8</td>
                <td>8</td>
            </tr>
            <tr>
                <td>Lengua</td>
                <td>7</td>
                <td>6.5</td>
                <td>7</td>
                <td>6</td>
                <td>7</td>
                <td>6.8</td>
                <td>7</td>
            </tr>
            <tr>
                <td>Ciencias</td>
                <td>9</td>
                <td>8.5</td>
                <td>9</td>
                <td>8.5</td>
                <td>9</td>
                <td>8.8</td>
                <td>9</td>
            </tr>
        </tbody>
    </table>

    <a href="php/cerrar_sesion.php">Cerrar sesión</a>
</div>

<footer>
    &copy; 2024 Instituto San Francisco de Asís | Todos los derechos reservados.
</footer>

</body>
</html>

