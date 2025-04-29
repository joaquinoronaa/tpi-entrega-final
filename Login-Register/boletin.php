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
    <link rel="stylesheet" href="boletin.css">
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

    <script>
        const usuario = JSON.parse(localStorage.getItem('usuario'));
        if (!usuario) {
            window.location.href = 'index.html';
        }

        document.getElementById('nombre-usuario').textContent = usuario.nombre;

        document.getElementById('curso').textContent = "3ro A";  // Ejemplo de curso
        document.getElementById('anio-academico').textContent = "2024";  // Año académico
        document.getElementById('orientacion').textContent = "Bachiller";  // Orientación 

        // Notas de ejemplo
        const notas = [
            { asignatura: "Matemáticas", primerCuatrimestre: 8.5, segundoCuatrimestre: 7.5, calificacionFinal: 8.0 },
            { asignatura: "Lengua", primerCuatrimestre: 7.0, segundoCuatrimestre: 6.5, calificacionFinal: 6.8 },
            { asignatura: "Ciencias", primerCuatrimestre: 9.2, segundoCuatrimestre: 8.7, calificacionFinal: 9.0 }
        ];

        const tbody = document.getElementById('tabla-notas');
        notas.forEach(nota => {
            const row = document.createElement("tr");
            const tdAsignatura = document.createElement("td");
            tdAsignatura.textContent = nota.asignatura;
            const tdPrimerCuatrimestre = document.createElement("td");
            tdPrimerCuatrimestre.textContent = nota.primerCuatrimestre;
            const tdSegundoCuatrimestre = document.createElement("td");
            tdSegundoCuatrimestre.textContent = nota.segundoCuatrimestre;
            const tdCalificacionFinal = document.createElement("td");
            tdCalificacionFinal.textContent = nota.calificacionFinal;

            row.appendChild(tdAsignatura);
            row.appendChild(tdPrimerCuatrimestre);
            row.appendChild(tdSegundoCuatrimestre);
            row.appendChild(tdCalificacionFinal);
            tbody.appendChild(row);
        });
    </script>
</body>
</html>
