<?php
require_once __DIR__ . '/../services/QuizService.php';

class QuizController {
    private $quizService;

    public function __construct($conn) {
        $this->quizService = new QuizService($conn);
    }

    public function createQuiz($title, $description) {
        return $this->quizService->createQuiz($title, $description);
    }

    public function addQuestion($quiz_id, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option) {
        return $this->quizService->addQuestion($quiz_id, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option);
    }

    public function getQuizzes() {
        return $this->quizService->getQuizzes();
    }

    public function getQuizQuestions($quiz_id) {
        return $this->quizService->getQuizQuestions($quiz_id);
    }
}
