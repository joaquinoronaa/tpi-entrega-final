<?php

    session_start();

    if(isset($_SESSION['usuario'])){
        header("location: bienvenida.php");
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

        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse">Regístrarse</button>
                </div>
            </div>
            <!--Formulario de Login y registro-->
            <div class="contenedor__login-register">
                <!--Login-->
                <form action="php/login_usuario_be.php" method="POST" class="formulario__login">
                    <h2>Iniciar Sesión</h2>
                    <input type="text" placeholder="Correo Electronico" name="correo">
                    <input type="password" placeholder="Contraseña" name="contraseña">
                    <button>Entrar</button>
                </form>
                <!--Register-->
                <form action="php/registro_usuario_be.php" method="POST" class="formulario__register">
                    <h2>Regístrarse</h2>
                    <input type="text" placeholder="Nombre completo" name="nombre_completo">
                    <input type="text" placeholder="Correo Electronico" name="correo">
                    <input type="text" placeholder="DNI" name="DNI">
                    <input type="password" placeholder="Contraseña" name="contraseña">
                    <select name="curso" required>
                        <option value="">Seleccione un curso</option>
                        <option value="1°">1° Año</option>
                        <option value="2°">2° Año</option>
                        <option value="3°">3° Año</option>
                        <option value="4°">4° Año</option>
                        <option value="5°">5° Año</option>
                        <option value="6°">6° Año</option>
                        <option value="7°">7° Año</option>
                    </select>
                    <select name="orientacion" required>
                        <option value="">Seleccione una orientación</option>
                        <option value="Bachiller">Bachiller</option>
                        <option value="Técnica">Técnica</option>
                    </select>
                    <button>Regístrarse</button>
                </form>
             </div>
        </div>
    </main>

    <script src="assets/js/script.js"></script>
</body>
</html>