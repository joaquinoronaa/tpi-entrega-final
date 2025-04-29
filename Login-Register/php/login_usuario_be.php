<?php
session_start();
include 'conexion_be.php';

// Recoger datos
$correo = trim($_POST['correo']);
$contrasena = trim($_POST['contrasena']);

// Consulta SOLO por correo y contraseña
$consulta = "SELECT * FROM usuarios WHERE correo='$correo' AND contraseña='$contrasena'";
$resultado = mysqli_query($conexion, $consulta);

// Verificar si existe usuario
if (mysqli_num_rows($resultado) > 0) {
    $usuario = mysqli_fetch_assoc($resultado);

    // Guardar datos en sesión
    $_SESSION['usuario'] = $usuario['correo'];
    $_SESSION['rol'] = $usuario['id_rol']; // Forzar número

    // Redireccionar según rol
    if ($_SESSION['rol'] === 1) {
        // Admin
        header("Location: ../panel_admin.php");
        exit();
    } else if ($_SESSION['rol'] === 2) {
        // Alumno
        header("Location: ../bienvenida.php");
        exit();
    } else {
        // Otro rol no permitido
        echo "<script>alert('Rol no permitido'); window.location='../index.php';</script>";
        exit;
    }
} else {
    // Usuario no encontrado
    echo "<script>alert('Usuario no encontrado'); window.location='../index.php';</script>";
    exit;
}
?>
