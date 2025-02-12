<?php
require_once __DIR__ . '/../../config/database.php';

class QuizService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createQuiz($title, $description) {
        $stmt = $this->conn->prepare("INSERT INTO quizzes (title, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $description);
        return $stmt->execute();
    }

    public function addQuestion($quiz_id, $qustion_text, $option_a, $option_b, $option_c, $option_d, $correct_option) {
        $stmt = $this->conn->prepare("INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $quiz_id, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option);
        return $stmt->execute();
    }

    public function getQuizzes() {
        $result = $this->conn->query("SELECT * FROM quizzes");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getQuizQuestions($quiz_id) {
        $stmt = $this->conn->prepare("SELECT * FROM questions WHERE quiz_id = ?");
        $stmt->bind_param("i", $quiz_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}