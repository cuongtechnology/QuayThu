<?php
require_once __DIR__ . '/../services/LotteryService.php';

/**
 * Controller for lottery history and lookup
 */
class HistoryController {
    private $lotteryService;

    public function __construct() {
        $this->lotteryService = new LotteryService();
    }

    /**
     * Display history page
     */
    public function index($region = 'XSMB', $days = 30) {
        $results = $this->lotteryService->getRecentResults($region, $days);
        
        return [
            'region' => $region,
            'days' => $days,
            'results' => $results,
        ];
    }

    /**
     * Search results by date range
     */
    public function search($region, $startDate, $endDate) {
        $sql = "SELECT * FROM lottery_results 
                WHERE region = ? 
                AND draw_date BETWEEN ? AND ?
                ORDER BY draw_date DESC";
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute([$region, $startDate, $endDate]);
        
        return [
            'region' => $region,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'results' => $stmt->fetchAll(PDO::FETCH_ASSOC),
        ];
    }

    /**
     * Get results by specific date
     */
    public function getByDate($date, $region = null) {
        $sql = "SELECT * FROM lottery_results WHERE draw_date = ?";
        $params = [$date];
        
        if ($region) {
            $sql .= " AND region = ?";
            $params[] = $region;
        }
        
        $sql .= " ORDER BY region";
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        
        return [
            'date' => $date,
            'region' => $region,
            'results' => $stmt->fetchAll(PDO::FETCH_ASSOC),
        ];
    }

    /**
     * Get results by province (for XSMT and XSMN)
     */
    public function getByProvince($province, $limit = 30) {
        $sql = "SELECT * FROM lottery_results 
                WHERE province = ?
                ORDER BY draw_date DESC
                LIMIT ?";
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute([$province, $limit]);
        
        return [
            'province' => $province,
            'results' => $stmt->fetchAll(PDO::FETCH_ASSOC),
        ];
    }
}
