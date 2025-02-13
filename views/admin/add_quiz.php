<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../src/controllers/QuizController.php';

// Verifica si el usuario es un administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /quizzApp/views/auth/login.php");
    exit();
}

$quizController = new QuizController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $questions = $_POST['questions'] ?? [];

    if (!empty($title) && !empty($description) && !empty($questions)) {
        $quiz_id = $quizController->createQuiz($title, $description);
        if ($quiz_id) {
            foreach ($questions as $question) {
                $quizController->addQuestion(
                    $quiz_id,
                    $question['text'],
                    $question['option_a'],
                    $question['option_b'],
                    $question['option_c'],
                    $question['option_d'],
                    $question['correct_option']
                );
            }
            $success = "Cuestionario creado exitosamente.";
        } else {
            $error = "Error al crear el cuestionario.";
        }
    } else {
        $error = "Por favor, complete todos los campos requeridos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Cuestionario</title>
    <link rel="stylesheet" href="/quizzApp/public/css/styles.css">
</head>
<body>
    <h1>Añadir Nuevo Cuestionario</h1>
    
    <?php if (isset($success)): ?>
        <p class="success"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post" id="quizForm">
        <div>
            <label for="title">Título del Cuestionario:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="description">Descripción:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        
        <div id="questions">
            <!-- Las preguntas se añadirán aquí dinámicamente -->
        </div>
        
        <button type="button" id="addQuestion">Añadir Pregunta</button>
        <button type="submit">Guardar Cuestionario</button>
    </form>

    <script>
    let questionCount = 0;

    document.getElementById('addQuestion').addEventListener('click', function() {
        questionCount++;
        const questionDiv = document.createElement('div');
        questionDiv.className = 'question';
        questionDiv.innerHTML = `
            <h3>Pregunta ${questionCount}</h3>
            <input type="text" name="questions[${questionCount}][text]" placeholder="Texto de la pregunta" required>
            <input type="text" name="questions[${questionCount}][option_a]" placeholder="Opción A" required>
            <input type="text" name="questions[${questionCount}][option_b]" placeholder="Opción B" required>
            <input type="text" name="questions[${questionCount}][option_c]" placeholder="Opción C" required>
            <input type="text" name="questions[${questionCount}][option_d]" placeholder="Opción D" required>
            <select name="questions[${questionCount}][correct_option]" required>
                <option value="">Seleccione la respuesta correcta</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        `;
        document.getElementById('questions').appendChild(questionDiv);
    });
    </script>
</body>
</html>
