<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/controllers/HomeController.php';
require_once __DIR__ . '/../src/controllers/HistoryController.php';
require_once __DIR__ . '/../src/controllers/CheckTicketController.php';
require_once __DIR__ . '/../src/controllers/PredictionController.php';
require_once __DIR__ . '/../src/controllers/DreamController.php';

// Handle routing
$action = $_GET['action'] ?? 'home';
$region = $_GET['region'] ?? 'XSMB';
$date = $_GET['date'] ?? null;

switch ($action) {
    // Home page
    case 'home':
        $controller = new HomeController();
        $data = $controller->index();
        require_once __DIR__ . '/../src/views/home.php';
        break;
    
    // Lottery results
    case 'results':
        $controller = new HomeController();
        $data = $controller->getResults($region, $date);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    
    // Statistics
    case 'statistics':
        $controller = new HomeController();
        $periodDays = $_GET['period'] ?? 30;
        $data = $controller->getStatistics($region, $periodDays);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    
    // Random number generation (Quay thử) - Full page
    case 'quay_thu':
        $data = ['region' => $region];
        require_once __DIR__ . '/../src/views/quay_thu.php';
        break;
    
    // Random number generation (Quay thử) - API
    case 'generate':
        $controller = new HomeController();
        $data = $controller->generateRandomNumbers($region);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    
    // Seed sample data
    case 'seed_data':
        require_once __DIR__ . '/../src/services/RealDataService.php';
        $realDataService = new RealDataService();
        $realDataService->seedSampleData();
        echo json_encode(['success' => true, 'message' => 'Sample data seeded successfully!']);
        exit;
    
    // History page
    case 'history':
        $controller = new HistoryController();
        $days = $_GET['days'] ?? 30;
        $data = $controller->index($region, $days);
        require_once __DIR__ . '/../src/views/history.php';
        break;
    
    // Search history by date range
    case 'history_search':
        $controller = new HistoryController();
        $startDate = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $_GET['end_date'] ?? date('Y-m-d');
        $data = $controller->search($region, $startDate, $endDate);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    
    // Check ticket (Dò vé số)
    case 'check_ticket':
        $controller = new CheckTicketController();
        $number = $_GET['number'] ?? null;
        
        if ($number) {
            $data = $controller->check($number, $region, $date);
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data = ['page' => 'check_ticket'];
            require_once __DIR__ . '/../src/views/check_ticket.php';
        }
        exit;
    
    // Check multiple tickets
    case 'check_multiple':
        $controller = new CheckTicketController();
        $numbers = $_POST['numbers'] ?? [];
        $data = $controller->checkMultiple($numbers, $region, $date);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    
    // Prediction page (Soi cầu)
    case 'prediction':
        $controller = new PredictionController();
        $analysisType = $_GET['type'] ?? 'balanced';
        $data = $controller->getPredictions($region, $analysisType);
        require_once __DIR__ . '/../src/views/prediction.php';
        break;
    
    // Get lucky numbers
    case 'lucky_numbers':
        $controller = new PredictionController();
        $count = $_GET['count'] ?? 5;
        $data = $controller->getLuckyNumbers($region, $count);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    
    // Get bạch thủ
    case 'bach_thu':
        $controller = new PredictionController();
        $data = $controller->getBachThu($region);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    
    // Statistics detail page
    case 'statistics_detail':
        $controller = new HomeController();
        $periodDays = $_GET['period'] ?? 30;
        $data = $controller->getStatistics($region, $periodDays);
        require_once __DIR__ . '/../src/views/statistics.php';
        break;
    
    // Sổ mơ (Dream interpretation) - Main page
    case 'so_mo':
        $data = ['page' => 'so_mo'];
        require_once __DIR__ . '/../src/views/so_mo.php';
        break;
    
    // Sổ mơ - Search dreams
    case 'so_mo_search':
        $controller = new DreamController();
        $keyword = $_GET['keyword'] ?? '';
        $data = $controller->searchDream($keyword);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    
    // Sổ mơ - Get all dreams
    case 'so_mo_all':
        $controller = new DreamController();
        $data = $controller->getDreamsByCategory();
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    
    // Sổ mơ - Get dreams by category
    case 'so_mo_category':
        $controller = new DreamController();
        $category = $_GET['category'] ?? null;
        $data = $controller->getDreamsByCategory($category);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    
    // Sổ mơ - Random suggestions
    case 'so_mo_random':
        $controller = new DreamController();
        $count = $_GET['count'] ?? 5;
        $data = $controller->getRandomSuggestions($count);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    
    // Sổ mơ - Interpret complex dream
    case 'so_mo_interpret':
        $controller = new DreamController();
        $dreamText = $_POST['dream_text'] ?? $_GET['dream_text'] ?? '';
        $data = $controller->interpretDream($dreamText);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    
    // Get countdown for a region
    case 'countdown':
        require_once __DIR__ . '/../src/helpers/DrawTimeHelper.php';
        $region = $_GET['region'] ?? 'XSMB';
        $countdown = DrawTimeHelper::getCountdown($region);
        header('Content-Type: application/json');
        echo json_encode($countdown);
        exit;
    
    // Get draw status for all regions
    case 'draw_status':
        require_once __DIR__ . '/../src/helpers/DrawTimeHelper.php';
        $status = [
            'XSMB' => DrawTimeHelper::getDrawStatus('XSMB'),
            'XSMT' => DrawTimeHelper::getDrawStatus('XSMT'),
            'XSMN' => DrawTimeHelper::getDrawStatus('XSMN'),
        ];
        header('Content-Type: application/json');
        echo json_encode($status);
        exit;
    
    default:
        $controller = new HomeController();
        $data = $controller->index();
        require_once __DIR__ . '/../src/views/home.php';
        break;
}
