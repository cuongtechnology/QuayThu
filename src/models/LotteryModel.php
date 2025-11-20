<?php
require_once __DIR__ . '/../../config/database.php';

/**
 * Model for Lottery data operations
 */
class LotteryModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Get today's results for all regions
     */
    public function getTodayResults() {
        $today = date('Y-m-d');
        $sql = "SELECT * FROM lottery_results WHERE draw_date = ? ORDER BY region";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$today]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get results by date range
     */
    public function getResultsByDateRange($region, $startDate, $endDate) {
        $sql = "SELECT * FROM lottery_results 
                WHERE region = ? AND draw_date BETWEEN ? AND ? 
                ORDER BY draw_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$region, $startDate, $endDate]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Check if number appears in result
     */
    public function checkNumber($number, $result) {
        $allNumbers = [];
        $prizes = ['special', 'first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth'];
        
        foreach ($prizes as $prize) {
            if (isset($result[$prize]) && $result[$prize]) {
                $prizeNumbers = explode(',', $result[$prize]);
                foreach ($prizeNumbers as $num) {
                    $allNumbers[] = trim($num);
                }
            }
        }

        // Check exact match and last 2,3,4 digits
        $number = str_pad($number, 2, '0', STR_PAD_LEFT);
        $matches = [];

        foreach ($allNumbers as $num) {
            $len = strlen($number);
            if (substr($num, -$len) === $number) {
                $matches[] = [
                    'number' => $num,
                    'match_type' => $len . ' số',
                ];
            }
        }

        return $matches;
    }
}
