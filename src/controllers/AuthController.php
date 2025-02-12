<?php
requiere_once __DIR__ . '/../services/AuthService.php';

class AuthController {
    private $authService;

    public function __construct($conn) {
        $this->authService = new AuthService($conn);
    }

    public function register($username, $password) {
        return $this->authService->register($username, $password);
    }

    public function login($username, $password) {
        return $this->authService->login($username, $password);
    }

    public function logout() {
        $this->authService->logout();
    }
}