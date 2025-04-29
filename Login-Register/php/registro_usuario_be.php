<?php

    include 'conexion_be.php';

    $nombre_completo = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $DNI = $_POST['DNI'];
    $contraseña = $_POST['contraseña'];
    $rol = 2;

    $query = "INSERT INTO usuarios(nombre_completo, correo, DNI, contraseña, id_rol) 
              VALUES('$nombre_completo', '$correo', '$DNI', '$contraseña', '$rol')";

    //verificar que el correo no se repita en database
    $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo'");

    if(mysqli_num_rows($verificar_correo) > 0){
        echo '
            <script>
                alert("Este correo ya esta registrado, intenta con otro diferente");
                window.location = "../index.php";
            </script>
        ';
        exit();
    }

    $verificar_DNI = mysqli_query($conexion, "SELECT * FROM usuarios WHERE DNI='$DNI'");

    if(mysqli_num_rows($verificar_DNI) > 0){
        echo '
            <script>
                alert("Si tu DNI ya esta registrado, ingresa con tu cuenta");
                window.location = "../index.php";
            </script>
        ';
        exit();
    }

    $ejecutar = mysqli_query($conexion, $query);

    if($ejecutar){
        echo '
            <script>
                alert("usuario almacenado exitosamente");
                window.location = "../index.php";
            </script>
        ';
    }else{
        echo '
            <script>
                alert("Intentelo de nuevo, Usuario no almacenado");
                window.location = "../index.php";
            </script>
        ';
    }

    mysqli_close($conexion);
?>