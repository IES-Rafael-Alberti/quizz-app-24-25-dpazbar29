<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../src/controllers/QuizController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /quizzapp/views/auth/login.php");
    exit();
}

$quizController = new QuizController($conn);
$quizzes = $quizController->getQuizzes();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quiz List</title>
        <link rel="stylesheet" href="/public/css/styles.css">
    </head>
    <body>
        <h1>Quizs disponibles</h1>
        <ul>
            <?php foreach ($quizzes as $quiz): ?>
                <li>
                    <a href="/views/quiz/take.php?quiz_id=<?php echo $quiz['quiz_id']; ?>">
                        <?php echo htmlspecialchars($quiz['title']); ?>
                    </a>
                    - <?php echo htmlspecialchars($quiz['description']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="/views/auth/logout.php">Desconectarse</a>
        <a href="/quizzApp/views/admin/add_quiz.php">Añadir Nuevo Cuestionario</a>
    </body>
</html>
