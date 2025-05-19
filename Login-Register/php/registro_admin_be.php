<?php
include('conexion_be.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'registrar') {
    $nombre_completo = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $DNI = $_POST['DNI'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    // Solo para alumnos
    $curso = isset($_POST['curso']) ? $_POST['curso'] : '';
    $orientacion = isset($_POST['orientacion']) ? $_POST['orientacion'] : '';

    // Verificar si el correo ya existe
    $verificar_correo = mysqli_query($conexion, "
        SELECT correo FROM usuarios WHERE correo = '$correo'
        UNION
        SELECT correo FROM alumnos WHERE correo = '$correo'
    ");
    if (mysqli_num_rows($verificar_correo) > 0) {
        echo '<script>
                alert("Este correo ya está registrado, intenta con otro diferente.");
                window.location = "panel_admin.php";
              </script>';
        exit();
    }

    // Verificar si el DNI ya existe
    $verificar_DNI = mysqli_query($conexion, "
        SELECT DNI FROM usuarios WHERE DNI = '$DNI'
        UNION
        SELECT DNI FROM alumnos WHERE DNI = '$DNI'
    ");
    if (mysqli_num_rows($verificar_DNI) > 0) {
        echo '<script>
                alert("Este DNI ya está registrado, intenta con uno diferente.");
                window.location = "panel_admin.php";
              </script>';
        exit();
    }

    // Insertar según el rol
    if ($rol == 1) {
        $query = "INSERT INTO usuarios (nombre_completo, correo, DNI, contraseña, id_rol)
                  VALUES ('$nombre_completo', '$correo', '$DNI', '$contraseña', 1)";
    } else {
        $query = "INSERT INTO alumnos (nombre_completo, correo, DNI, curso, orientacion)
                  VALUES ('$nombre_completo', '$correo', '$DNI', '$curso', '$orientacion')";
    }

    if (mysqli_query($conexion, $query)) {
        echo '<script>
                alert("Usuario registrado exitosamente.");
                window.location = "panel_admin.php";
              </script>';
        exit();
    } else {
        echo '<script>
                alert("Error al registrar usuario: ' . mysqli_error($conexion) . '");
                window.location = "panel_admin.php";
              </script>';
    }

    mysqli_close($conexion);
}
?>
