<?php
require_once __DIR__ . '/../services/LotteryService.php';
require_once __DIR__ . '/../models/LotteryModel.php';

/**
 * Controller for checking lottery tickets (Dò vé số)
 */
class CheckTicketController {
    private $lotteryService;
    private $lotteryModel;

    public function __construct() {
        $this->lotteryService = new LotteryService();
        $this->lotteryModel = new LotteryModel();
    }

    /**
     * Check a single ticket number against results
     */
    public function check($number, $region, $date = null) {
        if ($date === null) {
            $date = date('Y-m-d');
        }

        // Validate number format
        if (!is_numeric($number) || strlen($number) < 2) {
            return [
                'success' => false,
                'error' => 'Số vé không hợp lệ. Vui lòng nhập ít nhất 2 chữ số.',
            ];
        }

        // Get result for the date
        $result = $this->lotteryService->getLotteryResult($region, $date);
        
        if (!$result) {
            return [
                'success' => false,
                'error' => 'Không tìm thấy kết quả cho ngày này.',
            ];
        }

        // Check number
        $matches = $this->lotteryModel->checkNumber($number, $result);

        return [
            'success' => true,
            'number' => $number,
            'region' => $region,
            'date' => $date,
            'result' => $result,
            'matches' => $matches,
            'has_won' => count($matches) > 0,
        ];
    }

    /**
     * Check multiple numbers at once
     */
    public function checkMultiple($numbers, $region, $date = null) {
        if ($date === null) {
            $date = date('Y-m-d');
        }

        $results = [];
        
        foreach ($numbers as $number) {
            $checkResult = $this->check($number, $region, $date);
            $results[] = $checkResult;
        }

        return [
            'success' => true,
            'region' => $region,
            'date' => $date,
            'total_numbers' => count($numbers),
            'total_winners' => count(array_filter($results, function($r) {
                return isset($r['has_won']) && $r['has_won'];
            })),
            'results' => $results,
        ];
    }

    /**
     * Get prize information for a winning number
     */
    public function getPrizeInfo($number, $region, $date = null) {
        $checkResult = $this->check($number, $region, $date);
        
        if (!$checkResult['success'] || !$checkResult['has_won']) {
            return null;
        }

        $prizes = $this->analyzePrizes($checkResult['matches'], $region);

        return [
            'number' => $number,
            'region' => $region,
            'date' => $date,
            'prizes' => $prizes,
            'total_amount' => array_sum(array_column($prizes, 'amount')),
        ];
    }

    /**
     * Analyze which prizes were won
     */
    private function analyzePrizes($matches, $region) {
        $prizeStructure = $region === 'XSMB' ? XSMB_PRIZES : XSMT_XSMN_PRIZES;
        
        // Prize amounts (example values in VND)
        $prizeAmounts = [
            'special' => 2000000000,  // 2 tỷ
            'first' => 75000000,      // 75 triệu
            'second' => 15000000,     // 15 triệu
            'third' => 10000000,      // 10 triệu
            'fourth' => 3000000,      // 3 triệu
            'fifth' => 1000000,       // 1 triệu
            'sixth' => 400000,        // 400k
            'seventh' => 200000,      // 200k
            'eighth' => 100000,       // 100k
        ];

        $prizes = [];
        
        foreach ($matches as $match) {
            $matchNumber = $match['number'];
            
            // Determine which prize level
            foreach ($prizeStructure as $key => $info) {
                $digits = $info['digits'];
                
                if (strlen($matchNumber) === $digits) {
                    $prizes[] = [
                        'prize_name' => $info['name'],
                        'prize_level' => $key,
                        'number' => $matchNumber,
                        'amount' => $prizeAmounts[$key] ?? 0,
                    ];
                    break;
                }
            }
        }

        return $prizes;
    }

    /**
     * Check ticket against multiple dates
     */
    public function checkDateRange($number, $region, $startDate, $endDate) {
        $current = new DateTime($startDate);
        $end = new DateTime($endDate);
        $results = [];

        while ($current <= $end) {
            $date = $current->format('Y-m-d');
            $checkResult = $this->check($number, $region, $date);
            
            if ($checkResult['success'] && $checkResult['has_won']) {
                $results[] = $checkResult;
            }
            
            $current->modify('+1 day');
        }

        return [
            'success' => true,
            'number' => $number,
            'region' => $region,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_wins' => count($results),
            'results' => $results,
        ];
    }
}
