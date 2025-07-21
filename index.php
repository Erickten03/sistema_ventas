<?php
session_start();
if (!empty($_SESSION['active'])) {
    header('location: src/');
} else {
    if (!empty($_POST)) {
        $alert = '';
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = '<div class="alert alert-danger" role="alert">Ingrese su usuario y su clave</div>';
        } else {
            require_once "conexion.php";
            $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
            $clave = md5(mysqli_real_escape_string($conexion, $_POST['clave']));
            $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario = '$user' AND clave = '$clave' AND estado = 1");
            mysqli_close($conexion);
            $resultado = mysqli_num_rows($query);
            if ($resultado > 0) {
                $dato = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $dato['idusuario'];
                $_SESSION['nombre'] = $dato['nombre'];
                $_SESSION['user'] = $dato['usuario'];
                header('location: src/');
            } else {
                $alert = '<div class="alert alert-danger text-center" role="alert">Usuario o Contraseña Incorrecta</div>';
                session_destroy();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-container {
            background: #ffffff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.25);
            max-width: 400px;
            width: 100%;
        }
        .login-container img {
            width: 80px;
            margin-bottom: 10px;
        }
        .login-title {
            margin-bottom: 1.5rem;
            color: #2c5364;
        }
        .form-control:focus {
            border-color: #2c5364;
            box-shadow: none;
        }
        .btn-login {
            background-color: #2c5364;
            color: #fff;
        }
        .btn-login:hover {
            background-color: #1b2e38;
        }
    </style>
</head>
<body>
    <div class="login-container text-center">
        <img src="assets/img/mi_logo.png" alt="Logo">
        <h4 class="login-title">Iniciar Sesión</h4>
        <form method="POST">
            <div class="mb-3 text-start">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingrese usuario" required>
            </div>
            <div class="mb-3 text-start">
                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="clave" name="clave" placeholder="Ingrese contraseña" required>
            </div>
            <?php echo isset($alert) ? $alert : ''; ?>
            <button type="submit" class="btn btn-login w-100 mt-3">Ingresar</button>
        </form>
    </div>
</body>
</html>
