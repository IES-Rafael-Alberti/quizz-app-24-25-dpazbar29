<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/controllers/QuizController.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['quiz_id'])) {
    header("Location: /login.php");
    exit();
}

$quizController = new QuizController($conn);
$quiz_id = $_POST['quiz_id'];
$questions = $quizController->getQuizQuestions($quiz_id);

$score = 0;
$total_questions = count($questions);

foreach ($questions as $question) {
    $user_answer = $_POST['q' . $question['question_id']] ?? '';
    if ($user_answer === $question['correct_option']) {
        $score++;
    }
}

// Save the result
$stmt = $conn->prepare("INSERT INTO quiz_results (user_id, quiz_id, score, total_questions) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiii", $_SESSION['user_id'], $quiz_id, $score, $total_questions);
$stmt->execute();

// Redirect to results page
header("Location: /views/quiz/results.php?quiz_id=$quiz_id&score=$score&total=$total_questions");
exit();
