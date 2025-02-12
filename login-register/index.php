<?php

    session_start();

    if(isset($_SESSION['usuario'])){
        header("location: boletin.php");
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Register</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    
    <main>

        <div class="contenedor_todo">

            <!-- Caja trasera con Login y Registro -->
            <div class="caja__trasera">
                <div class="caja_trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn_iniciar-sesion">Iniciar sesión</button>
                </div>

                <div class="caja_trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas ver tus notas</p>
                    <button id="btn_registrarse">Registrarse</button>
                </div>
            </div> 

            <!-- Formulario de Login y Registro -->
            <div class="contenedor_login-register">

                <form action="php/login_usuario_be.php" method="POST" class="formulario_login">
                    <h2>Iniciar sesión</h2>
                    <input type="text" placeholder="Correo Electrónico" name="correo">
                    <input type="password" placeholder="Contraseña" name="contraseña">
                    <button>Entrar</button>
                </form>

                <form action="php/registro_usuario_be.php" method="POST" class="formulario_register">
                    <h2>Registrarse</h2>
                    <input type="text" placeholder="Nombre Completo" name="nombre_completo">
                    <input type="text" placeholder="Correo Electrónico" name="correo">
                    <input type="text" placeholder="DNI" name="dni">
                    <input type="password" placeholder="Contraseña" name="contraseña">
                    <button>Registrarse</button>
                </form>
            </div>
        </div>
    </main>

        <footer>
            <div class="footer">
                <img src="assets\imagenes\logoempresa.png" class="logoempresa">
                <p> © 2024 Todos los derechos reservados</p>
             </div>
        </footer>

    <script src="assets/js/script.js"></script>
</body>
</html>
