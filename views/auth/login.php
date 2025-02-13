<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../src/controllers/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController = new AuthController($conn);
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($authController->login($username, $password)) {
        header("Location: /quizzapp/views/quiz/list.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="/public/css/quiz.css">
    </head>
    <body>
        <h1>Inicio de Sesión</h1>
        
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?> </p>
        <?php endif; ?>
        
        <form method="post">
            <div>
                <label for="username">Nombre de usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>

        <p>No tienes cuenta? <a href="/views/auth/register.php">Registrate aquí</a></p>
    </body>
</html>