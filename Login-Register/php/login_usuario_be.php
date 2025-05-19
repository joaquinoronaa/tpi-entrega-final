<?php
session_start();
include 'conexion_be.php';

$correo = trim($_POST['correo']);
$contraseña = trim($_POST['contraseña']);

// Buscar en tabla usuarios (admins)
$consultaUsuario = "SELECT * FROM usuarios WHERE correo='$correo' AND contraseña='$contraseña'";
$resultadoUsuario = mysqli_query($conexion, $consultaUsuario);

if (mysqli_num_rows($resultadoUsuario) > 0) {
    $usuario = mysqli_fetch_assoc($resultadoUsuario);

    $_SESSION['usuario'] = $usuario['correo'];
    $_SESSION['rol'] = (int)$usuario['id_rol']; // 1 = admin
    $_SESSION['id'] = $usuario['id'];

    if ($_SESSION['rol'] === 1) {
        header("Location: panel_admin.php"); // Administrador
    } elseif ($_SESSION['rol'] === 3) {
        header("Location: departamentoNotas.php"); // Profesor
    }
    exit();
}

// Buscar en tabla alumnos
$consultaAlumno = "SELECT * FROM alumnos WHERE correo='$correo' AND contraseña='$contraseña'";
$resultadoAlumno = mysqli_query($conexion, $consultaAlumno);

if (mysqli_num_rows($resultadoAlumno) > 0) {
    $alumno = mysqli_fetch_assoc($resultadoAlumno);

    $_SESSION['usuario'] = $alumno['correo'];
    $_SESSION['rol'] = 2; // alumno
    $_SESSION['id'] = $alumno['id'];

    header("Location: ../BOLETIN.php");
    exit();
}

// Si no encontró nada
echo '
    <script>
        alert("Correo o contraseña incorrectos");
        window.location = "../index.php";
    </script>
';
session_destroy();
exit;
?>
