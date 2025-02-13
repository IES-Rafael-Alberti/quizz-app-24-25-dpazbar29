<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../src/controllers/QuizController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

$quizController = new QuizController($conn);
$quiz_id = $_GET['quiz_id'] ?? null;

if (!$quiz_id) {
    echo "Quiz ID not provided.";
    exit();
}

$questions = $quizController->getQuizQuestions($quiz_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Quiz</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <h1>Take Quiz</h1>
    <form method="post" action="/process_quiz.php">
        <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
        <?php foreach ($questions as $index => $question): ?>
            <div class="question">
                <p><?php echo ($index + 1) . ". " . htmlspecialchars($question['question_text']); ?></p>
                <label><input type="radio" name="q<?php echo $question['question_id']; ?>" value="A"> <?php echo htmlspecialchars($question['option_a']); ?></label>
                <label><input type="radio" name="q<?php echo $question['question_id']; ?>" value="B"> <?php echo htmlspecialchars($question['option_b']); ?></label>
                <label><input type="radio" name="q<?php echo $question['question_id']; ?>" value="C"> <?php echo htmlspecialchars($question['option_c']); ?></label>
                <label><input type="radio" name="q<?php echo $question['question_id']; ?>" value="D"> <?php echo htmlspecialchars($question['option_d']); ?></label>
            </div>
        <?php endforeach; ?>
        <input type="submit" value="Submit Quiz">
    </form>
</body>
</html>
