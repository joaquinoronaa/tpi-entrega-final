<?php
    session_start();
    include(__DIR__ . '/conexion_be.php');

    if (!isset($_SESSION['rol']) || (int)$_SESSION['rol'] !== 1) {
        header("Location: index.php");
        exit();
    }

    $mensaje = "";

    if (isset($_POST['accion']) && $_POST['accion'] == 'registrar') {
        $nombre_completo = $_POST['nombre_completo'];
        $correo = $_POST['correo'];
        $DNI = $_POST['DNI'];
        $contraseña = $_POST['contraseña'];
        $rol = $_POST['rol'];

        $query = "INSERT INTO usuarios (nombre_completo, correo, DNI, contraseña, id_rol) 
                  VALUES ('$nombre_completo', '$correo', '$DNI', '$contraseña', '$rol')";
        mysqli_query($conexion, $query);
        $mensaje = "Usuario registrado correctamente.";
    }

    if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
        $id = $_POST['id'];
        $origen = $_POST['origen'];

        if ($origen === 'usuarios') {
            mysqli_query($conexion, "DELETE FROM usuarios WHERE id = $id");
        } elseif ($origen === 'alumnos') {
            mysqli_query($conexion, "DELETE FROM alumnos WHERE id = $id");
        }
        $mensaje = "Usuario eliminado correctamente.";
    }

    if (isset($_POST['accion']) && $_POST['accion'] == 'editar') {
        $id = $_POST['id'];
        $nombre_completo = $_POST['nombre_completo'];
        $correo = $_POST['correo'];
        $DNI = $_POST['DNI'];
        $rol = $_POST['rol'];

        $query = "UPDATE usuarios 
                  SET nombre_completo = '$nombre_completo', correo = '$correo', dni = '$DNI', id_rol = '$rol'
                  WHERE id = $id";
        mysqli_query($conexion, $query);
        $mensaje = "Usuario actualizado correctamente.";
    }

    $usuarios = mysqli_query($conexion, "
        SELECT id, nombre_completo, correo, DNI, id_rol, 'usuarios' as origen FROM usuarios
        UNION
        SELECT id, nombre_completo, correo, DNI, 2 as id_rol, 'alumnos' as origen FROM alumnos
    ");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../assets/css/adminpanel.css">
    <style>
        #extraUsuarios {
            display: none;
            transition: all 0.3s ease;
        }
        #toggleButton {
            margin: 10px 0;
            padding: 8px 16px;
            font-weight: bold;
            cursor: pointer;
        }
        .mensaje {
            padding: 10px;
            background-color:rgb(129, 187, 142);
            color: #155724;
            border: 1px solid #c3e6cb;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .action-buttons button {
            margin: 2px 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="top-bar-buttons">
            <a href="departamentoNotas.php"><button class="nav-btn" type="button">Ir al Departamento de Notas</button></a>
            <a href="cerrar_sesion.php"><button class="nav-btn" type="button">Cerrar Sesión</button></a>
        </div>
    </div>

    <h2>Panel de Administración de Usuarios</h2>

    <?php if ($mensaje): ?>
        <div class="mensaje"><?= $mensaje ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Correo</th>
                <th>DNI</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $contador = 0;
            while($row = mysqli_fetch_assoc($usuarios)):
                $contador++;
                if ($contador == 3) {
                    echo '</tbody><tbody id="extraUsuarios">';
                }
            ?>
            <tr>
                <form method="POST">
                    <td><?= $row['id'] ?></td>
                    <td><input type="text" name="nombre_completo" value="<?= $row['nombre_completo'] ?>" required></td>
                    <td><input type="email" name="correo" value="<?= $row['correo'] ?>" required></td>
                    <td><input type="text" name="DNI" value="<?= $row['DNI'] ?>" required></td>
                    <td>
                        <select name="rol" required>
                            <option value="2" <?= $row['id_rol'] == 2 ? 'selected' : '' ?>>Alumno</option>
                            <option value="1" <?= $row['id_rol'] == 1 ? 'selected' : '' ?>>Administrador</option>
                            <option value="3" <?= $row['id_rol'] == 3 ? 'selected' : '' ?>>Profesor</option>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="origen" value="<?= $row['origen'] ?>">
                        <div class="action-buttons">
                            <button type="submit" name="accion" value="editar">Guardar</button>
                            <button type="submit" name="accion" value="eliminar" onclick="return confirm('¿Seguro que quieres eliminar este usuario?');">Eliminar</button>
                        </div>
                    </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <button id="toggleButton">Mostrar más usuarios ▼</button>

    <script>
        const toggleBtn = document.getElementById("toggleButton");
        const extraUsuarios = document.getElementById("extraUsuarios");

        toggleBtn.addEventListener("click", () => {
            const visible = extraUsuarios.style.display === "table-row-group";
            extraUsuarios.style.display = visible ? "none" : "table-row-group";
            toggleBtn.textContent = visible ? "Mostrar más usuarios ▼" : "Ocultar usuarios ▲";
        });
    </script>

    <h3>Registrar Nuevo Usuario</h3>
    <form action="" method="POST">
        <input type="hidden" name="accion" value="registrar">
        <label>Nombre Completo</label>
        <input type="text" name="nombre_completo" placeholder="Nombre completo" required>

        <label>Correo</label>
        <input type="email" name="correo" placeholder="Correo electrónico" required>

        <label>DNI</label>
        <input type="text" name="DNI" placeholder="DNI" required>

        <label>Contraseña</label>
        <input type="password" name="contraseña" placeholder="Contraseña" required>

        <label>Rol</label>
        <select name="rol" required>
            <option value="2">Alumno</option>
            <option value="1">Administrador</option>
            <option value="3">Profesor</option>
        </select>

        <button type="submit">Registrar Usuario</button>
    </form>
</body>
</html>