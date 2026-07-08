<?php

class DashboardController {
    
    public function index() {
        session_start();
        
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . URL_BASE . 'index.php?url=login');
            exit;
        }

        require_once '../app/views/dashboard.php';
    }
}