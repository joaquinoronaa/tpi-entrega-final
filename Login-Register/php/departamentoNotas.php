<?php
session_start();
include 'conexion_be.php';

// Verificar si el usuario ha iniciado sesión y es admin
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

$correo = $_SESSION['usuario'];
$query = "SELECT id_rol FROM usuarios WHERE correo = '$correo'";
$result = mysqli_query($conexion, $query);
$row = mysqli_fetch_assoc($result);

if (!$row || !in_array((int)$row['id_rol'], [1, 3])) {
    echo "Acceso denegado. Esta página es solo para administradores o profesores.";
    exit();
}

// Insertar o actualizar nota si se envió el formulario
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $DNI = mysqli_real_escape_string($conexion, $_POST['DNI']);
    $asignatura = mysqli_real_escape_string($conexion, $_POST['asignatura']);
    $nota = floatval($_POST['nota']);
    $instancia = $_POST['instancia'];
    $campo = '';

    // Determinar qué campo actualizar
    switch ($instancia) {
        case 'Primer Parcial':
            $campo = 'parcial1';
            break;
        case 'Segundo Parcial':
            $campo = 'parcial2';
            break;
        case 'Primer Cuatrimestre':
            $campo = 'cuatrimestre1';
            break;
        case 'Tercer Parcial':
            $campo = 'parcial3';
            break;
        case 'Cuarto Parcial':
            $campo = 'parcial4';
            break;
        case 'Segundo Cuatrimestre':
            $campo = 'cuatrimestre2';
            break;
        case 'Final':
            $campo = 'final';
            break;
        default:
            $mensaje = "❌ Instancia no válida.";
            exit();
    }

    // Buscar ID del alumno por DNI
    $consulta_id = "SELECT id FROM alumnos WHERE DNI = '$DNI'";
    $resultado_id = mysqli_query($conexion, $consulta_id);

    if ($fila = mysqli_fetch_assoc($resultado_id)) {
        $id_alumno = $fila['id'];
    
        // Verificar si ya existe una fila para ese alumno y asignatura
        $check = "SELECT * FROM notas WHERE id_alumno = '$id_alumno' AND asignatura = '$asignatura'";
        $result = mysqli_query($conexion, $check);
    
        if (mysqli_num_rows($result) > 0) {
            // Ya existe → actualizamos la nota correspondiente
            $update = "UPDATE notas SET $campo = $nota, fecha = NOW() WHERE id_alumno = '$id_alumno' AND asignatura = '$asignatura'";
            if (mysqli_query($conexion, $update)) {
                $mensaje = "✅ Nota actualizada correctamente.";
            } else {
                $mensaje = "❌ Error al actualizar la nota.";
            }
        } else {
            // No existe → insertamos nueva fila
            $insert = "INSERT INTO notas (id_alumno, asignatura, $campo, fecha) VALUES ('$id_alumno', '$asignatura', $nota, NOW())";
            if (mysqli_query($conexion, $insert)) {
                $mensaje = "✅ Nota cargada correctamente.";
            } else {
                $mensaje = "❌ Error al cargar la nota.";
            }
        }
    } else {
        $mensaje = "❌ No se encontró ningún alumno con ese DNI.";
    }
    
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Departamento de Notas</title>
    <a href="cerrar_sesion.php"><button type="button">Cerrar Sesión</button></a>

    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f4f4; }
        h1 { color: #333; }
        form { background: #fff; padding: 20px; border-radius: 5px; margin-bottom: 30px; }
        label { display: block; margin-top: 10px; }
        input, select { padding: 8px; width: 100%; margin-top: 5px; }
        button { margin-top: 15px; padding: 10px 20px; background-color:rgb(204, 46, 46); border: none; border-radius: 50px; color: white; cursor: pointer; }
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
        <label for="DNI">DNI del Alumno:</label>
        <input type="text" name="DNI" required>

        <label for="asignatura">Materia:</label>
        <input type="text" name="asignatura" required>
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
    <a href="panel_admin.php"><button type="button">Volver al Panel de Administrador</button></a>


    <h2>🗂 Últimas Notas Cargadas</h2>
    <table>
        <thead>
        <tr>
            <th>DNI Alumno</th>
            <th>Nombre</th>
            <th>Año</th>
            <th>Materia</th>
            <th>Instancia</th>
            <th>Nota</th>
            <th>Fecha</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $notas = mysqli_query($conexion, "
            SELECT 
                a.DNI AS dni_alumno,
                a.nombre_completo,
                a.curso,
                n.asignatura,
                CASE 
                    WHEN n.parcial1 IS NOT NULL THEN 'Primer Parcial'
                    WHEN n.parcial2 IS NOT NULL THEN 'Segundo Parcial'
                    WHEN n.parcial3 IS NOT NULL THEN 'Tercer Parcial'
                    WHEN n.parcial4 IS NOT NULL THEN 'Cuarto Parcial'
                    WHEN n.cuatrimestre1 IS NOT NULL THEN 'Primer Cuatrimestre'
                    WHEN n.cuatrimestre2 IS NOT NULL THEN 'Segundo Cuatrimestre'
                    WHEN n.final IS NOT NULL THEN 'Final'
                    ELSE 'N/A'
                END AS instancia,
                COALESCE(n.parcial1, n.parcial2, n.parcial3, n.parcial4, n.cuatrimestre1, n.cuatrimestre2, n.final) AS nota,
                n.fecha
            FROM notas n
            INNER JOIN alumnos a ON n.id_alumno = a.id
            ORDER BY n.fecha DESC
            LIMIT 10
        ");
        
        while ($fila = mysqli_fetch_assoc($notas)) {
            echo "<tr>
                    <td>{$fila['dni_alumno']}</td>
                    <td>{$fila['nombre_completo']}</td>
                    <td>{$fila['curso']}</td>
                    <td>{$fila['asignatura']}</td>
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
