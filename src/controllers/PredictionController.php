<?php
require_once __DIR__ . '/../services/LotteryService.php';

/**
 * Controller for lottery prediction and analysis (Soi cầu)
 */
class PredictionController {
    private $lotteryService;

    public function __construct() {
        $this->lotteryService = new LotteryService();
    }

    /**
     * Get prediction suggestions based on statistics
     */
    public function getPredictions($region, $analysisType = 'balanced') {
        $hotNumbers = $this->lotteryService->getHotNumbers($region, 20, 30);
        $coldNumbers = $this->lotteryService->getColdNumbers($region, 20, 30);
        
        $predictions = [];

        switch ($analysisType) {
            case 'hot':
                // Focus on hot numbers
                $predictions = $this->predictFromHot($hotNumbers);
                break;
            
            case 'cold':
                // Focus on cold numbers (gan strategy)
                $predictions = $this->predictFromCold($coldNumbers);
                break;
            
            case 'balanced':
            default:
                // Mix of hot and cold
                $predictions = $this->predictBalanced($hotNumbers, $coldNumbers);
                break;
        }

        return [
            'region' => $region,
            'analysis_type' => $analysisType,
            'predictions' => $predictions,
            'hot_numbers' => array_slice($hotNumbers, 0, 10),
            'cold_numbers' => array_slice($coldNumbers, 0, 10),
            'generated_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * Predict based on hot numbers
     */
    private function predictFromHot($hotNumbers) {
        $predictions = [];
        
        // Top hot numbers with high confidence
        foreach (array_slice($hotNumbers, 0, 5) as $stat) {
            $predictions[] = [
                'number' => $stat['number'],
                'confidence' => 'Cao',
                'reason' => "Xuất hiện {$stat['frequency']} lần trong 30 kỳ",
                'strategy' => 'Theo số nóng',
            ];
        }

        // Combinations of hot digits
        $hotDigits = array_map(function($stat) {
            return str_split($stat['number']);
        }, array_slice($hotNumbers, 0, 5));

        // Generate combinations
        for ($i = 0; $i < 3; $i++) {
            $combo = $this->generateCombination($hotDigits);
            if ($combo && !in_array($combo, array_column($predictions, 'number'))) {
                $predictions[] = [
                    'number' => $combo,
                    'confidence' => 'Trung bình',
                    'reason' => 'Kết hợp các chữ số nóng',
                    'strategy' => 'Tổ hợp số nóng',
                ];
            }
        }

        return $predictions;
    }

    /**
     * Predict based on cold numbers (gan)
     */
    private function predictFromCold($coldNumbers) {
        $predictions = [];
        
        // Top cold numbers (most overdue)
        foreach (array_slice($coldNumbers, 0, 5) as $stat) {
            $predictions[] = [
                'number' => $stat['number'],
                'confidence' => 'Trung bình',
                'reason' => "Chưa về {$stat['days_since_last']} kỳ",
                'strategy' => 'Đánh lô gan',
            ];
        }

        return $predictions;
    }

    /**
     * Balanced prediction strategy
     */
    private function predictBalanced($hotNumbers, $coldNumbers) {
        $predictions = [];
        
        // Mix hot and cold
        $hotPicks = array_slice($hotNumbers, 0, 3);
        $coldPicks = array_slice($coldNumbers, 0, 2);

        foreach ($hotPicks as $stat) {
            $predictions[] = [
                'number' => $stat['number'],
                'confidence' => 'Cao',
                'reason' => "Số nóng: {$stat['frequency']} lần",
                'strategy' => 'Cân bằng',
            ];
        }

        foreach ($coldPicks as $stat) {
            $predictions[] = [
                'number' => $stat['number'],
                'confidence' => 'Trung bình',
                'reason' => "Lô gan: {$stat['days_since_last']} kỳ",
                'strategy' => 'Cân bằng',
            ];
        }

        // Pattern-based predictions
        $patterns = $this->analyzePatterns($hotNumbers);
        foreach (array_slice($patterns, 0, 3) as $pattern) {
            $predictions[] = $pattern;
        }

        return $predictions;
    }

    /**
     * Analyze number patterns
     */
    private function analyzePatterns($numbers) {
        $patterns = [];
        
        // Analyze head patterns
        $heads = [];
        foreach ($numbers as $stat) {
            $head = (int)substr($stat['number'], 0, 1);
            if (!isset($heads[$head])) {
                $heads[$head] = 0;
            }
            $heads[$head] += $stat['frequency'];
        }

        arsort($heads);
        $topHead = key($heads);

        // Suggest numbers starting with top head
        for ($i = 0; $i < 3; $i++) {
            $tail = rand(0, 9);
            $number = str_pad($topHead . $tail, 2, '0', STR_PAD_LEFT);
            $patterns[] = [
                'number' => $number,
                'confidence' => 'Thấp',
                'reason' => "Đầu {$topHead} xuất hiện nhiều",
                'strategy' => 'Phân tích đầu số',
            ];
        }

        return $patterns;
    }

    /**
     * Generate combination from digit arrays
     */
    private function generateCombination($digitArrays) {
        if (empty($digitArrays)) {
            return null;
        }

        $d1 = $digitArrays[rand(0, count($digitArrays) - 1)];
        $d2 = $digitArrays[rand(0, count($digitArrays) - 1)];

        return $d1[rand(0, 1)] . $d2[rand(0, 1)];
    }

    /**
     * Get lucky numbers for the day
     */
    public function getLuckyNumbers($region, $count = 5) {
        $predictions = $this->getPredictions($region, 'balanced');
        
        return [
            'region' => $region,
            'date' => date('Y-m-d'),
            'lucky_numbers' => array_slice($predictions['predictions'], 0, $count),
        ];
    }

    /**
     * Analyze frequency by day of week
     */
    public function analyzeByDayOfWeek($region) {
        $sql = "SELECT draw_day, COUNT(*) as count 
                FROM lottery_results 
                WHERE region = ?
                GROUP BY draw_day
                ORDER BY count DESC";
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute([$region]);
        
        return [
            'region' => $region,
            'day_analysis' => $stmt->fetchAll(PDO::FETCH_ASSOC),
        ];
    }

    /**
     * Get bạch thủ (single best pick)
     */
    public function getBachThu($region) {
        $predictions = $this->getPredictions($region, 'hot');
        $topPrediction = $predictions['predictions'][0] ?? null;

        return [
            'region' => $region,
            'bach_thu' => $topPrediction,
            'date' => date('Y-m-d'),
            'note' => 'Bạch thủ là số được dự đoán có khả năng cao nhất',
        ];
    }

    /**
     * Get song thủ (top 2 picks)
     */
    public function getSongThu($region) {
        $predictions = $this->getPredictions($region, 'balanced');
        $topTwo = array_slice($predictions['predictions'], 0, 2);

        return [
            'region' => $region,
            'song_thu' => $topTwo,
            'date' => date('Y-m-d'),
            'note' => 'Song thủ là 2 số được dự đoán hàng đầu',
        ];
    }

    /**
     * Get bộ số (number set)
     */
    public function getBoSo($region, $count = 10) {
        $predictions = $this->getPredictions($region, 'balanced');
        
        return [
            'region' => $region,
            'bo_so' => array_slice($predictions['predictions'], 0, $count),
            'date' => date('Y-m-d'),
            'total' => $count,
        ];
    }
}
