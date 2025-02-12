<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

$quiz_id = $_GET['quiz_id'] ?? null;
$score = $_GET['score'] ?? null;
$total = $_GET['total'] ?? null;

if (!$quiz_id || !$score || !$total) {
    echo "Invalid results data.";
    exit();
}

// Get average score and attempts
$stmt = $conn->prepare("SELECT AVG(score/total_questions*100) as avg_score, COUNT(*) as attempts FROM quiz_results WHERE quiz_id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <h1>Quiz Results</h1>
    <p>Your score: <?php echo $score; ?> / <?php echo $total; ?> (<?php echo number_format(($score / $total) * 100, 2); ?>%)</p>
    <p>Average score for this quiz: <?php echo number_format($result['avg_score'], 2); ?>%</p>
    <p>Total attempts: <?php echo $result['attempts']; ?></p>
    <a href="/views/quiz/list.php">Back to Quiz List</a>
</body>
</html>
