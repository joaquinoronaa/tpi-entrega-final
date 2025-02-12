<?php

    include 'conexion_be.php';

    $nombre_completo = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $dni = $_POST['dni'];
    $contraseña = $_POST['contraseña'];
    $contraseña = hash('sha512', $contraseña);

    $query = "INSERT INTO usuarios(nombre_completo, correo, dni, contraseña) 
              VALUES('$nombre_completo', '$correo', '$dni', '$contraseña')";

    //Verificar que el correo no se repita en la base de datos
    $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo= '$correo' ");
    
    if(mysqli_num_rows($verificar_correo) > 0){
        echo '
            <script>
                alert("Este correo ya esta en uso");
                window.location = "../index.php";
            </script>
        ';
        exit();
    }

    //Verificar que el DNI no se repita en la base de datos
    $verificar_dni = mysqli_query($conexion, "SELECT * FROM usuarios WHERE dni= '$dni' ");
    
    if(mysqli_num_rows($verificar_dni) > 0){
        echo '
            <script>
                alert("Este dni ya esta en uso");
                window.location = "../index.php";
            </script>
        ';
        exit();
    }

    $ejecutar = mysqli_query($conexion, $query);


    if ($ejecutar){
        echo '
            <script>
                alert("Usuario almacenado exitosamente");
                window.location = "../index.php";
            </script>
        ';
    }else{
        echo '
            <script>
                alert("Intentalo de nuevo, Usuario no almacenado");
                window.location = "../index.php";
            </script>
        ';
    }

    mysqli_close($conexion);


?>