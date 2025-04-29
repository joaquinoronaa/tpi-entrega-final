<?php
session_start();
include 'Login-register/conexion_be.php';

// Verificar que solo el admin pueda acceder
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Registrar un nuevo usuario
if (isset($_POST['accion']) && $_POST['accion'] == 'registrar') {
    $nombre_completo = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $dni = $_POST['dni'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    $query = "INSERT INTO usuarios (nombre_completo, correo, dni, contraseña, rol) 
              VALUES ('$nombre_completo', '$correo', '$dni', '$contraseña', '$rol')";
    mysqli_query($conexion, $query);
}

// Eliminar usuario
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    mysqli_query($conexion, "DELETE FROM usuarios WHERE id = $id");
}

// Editar usuario
if (isset($_POST['accion']) && $_POST['accion'] == 'editar') {
    $id = $_POST['id'];
    $nombre_completo = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $dni = $_POST['dni'];
    $rol = $_POST['rol'];

    $query = "UPDATE usuarios 
              SET nombre_completo = '$nombre_completo', correo = '$correo', dni = '$dni', rol = '$rol'
              WHERE id = $id";
    mysqli_query($conexion, $query);
}

// Obtener todos los usuarios
$usuarios = mysqli_query($conexion, "SELECT * FROM usuarios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; padding: 20px; }
        table { width: 100%; background: white; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: left; }
        h2 { text-align: center; }
        form { background: white; padding: 20px; margin-top: 20px; border-radius: 10px; }
        input, select, button { width: 100%; padding: 10px; margin-bottom: 10px; }
        .acciones a { margin-right: 10px; }
        button { background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>

<h2>Panel de Administración de Usuarios</h2>

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
    <?php while($row = mysqli_fetch_assoc($usuarios)): ?>
        <tr>
            <form method="POST">
                <td><?= $row['id'] ?></td>
                <td><input type="text" name="nombre_completo" value="<?= $row['nombre_completo'] ?>" required></td>
                <td><input type="email" name="correo" value="<?= $row['correo'] ?>" required></td>
                <td><input type="text" name="dni" value="<?= $row['dni'] ?>" required></td>
                <td>
                    <select name="rol" required>
                        <option value="alumno" <?= $row['rol'] == 'alumno' ? 'selected' : '' ?>>Alumno</option>
                        <option value="admin" <?= $row['rol'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
                    </select>
                </td>
                <td class="acciones">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="accion" value="editar">
                    <button type="submit">Guardar</button>
                    <a href="?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Seguro que quieres eliminar este usuario?');">Eliminar</a>
                </td>
            </form>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<h3>Registrar Nuevo Usuario</h3>
<form method="POST">
    <input type="hidden" name="accion" value="registrar">
    <label>Nombre Completo</label>
    <input type="text" name="nombre_completo" required>

    <label>Correo</label>
    <input type="email" name="correo" required>

    <label>DNI</label>
    <input type="text" name="dni" required>

    <label>Contraseña</label>
    <input type="password" name="contraseña" required>

    <label>Rol</label>
    <select name="rol" required>
        <option value="alumno">Alumno</option>
        <option value="admin">Administrador</option>
    </select>

    <button type="submit">Registrar Usuario</button>
</form>

</body>
</html>
