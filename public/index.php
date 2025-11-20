<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/controllers/HomeController.php';

$controller = new HomeController();

// Handle routing
$action = $_GET['action'] ?? 'home';
$region = $_GET['region'] ?? 'XSMB';
$date = $_GET['date'] ?? null;

switch ($action) {
    case 'results':
        $data = $controller->getResults($region, $date);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    
    case 'statistics':
        $periodDays = $_GET['period'] ?? 30;
        $data = $controller->getStatistics($region, $periodDays);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    
    case 'generate':
        $data = $controller->generateRandomNumbers($region);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    
    case 'home':
    default:
        $data = $controller->index();
        require_once __DIR__ . '/../src/views/home.php';
        break;
}
