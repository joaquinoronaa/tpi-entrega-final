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
    <title>Boletín - Colegio Guevara</title>
    <link rel="stylesheet" href="assets/css/boletin.css">
</head>
<body>
    <header>
        <h1>Boletín de Calificaciones</h1>
        <p>Bienvenido, <span id="nombre-usuario"></span></p>
    </header>

    <section id="barra-datos">
        <p><strong>Curso:</strong> <span id="curso"></span></p>
        <p><strong>Año Académico:</strong> <span id="anio-academico"></span></p>
        <p><strong>Orientación:</strong> <span id="orientacion"></span></p>
    </section>
    
    <section id="notas">
        <h2>Notas del Estudiante</h2>
        <table>
            <thead>
                <tr>
                    <th>Asignatura</th>
                    <th>1er Cuatrimestre</th>
                    <th>2do Cuatrimestre</th>
                    <th>Calificación Final</th>
                </tr>
            </thead>
            <tbody id="tabla-notas">
            </tbody>
        </table>

        <a href="php/cerrar_sesion.php">Cerrar sesión</a>
    </section>

    <footer>
        <p>&copy; 2024 Colegio Guevara</p>
    </footer>

</body>
</html>
