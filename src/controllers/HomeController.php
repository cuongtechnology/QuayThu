<?php
require_once __DIR__ . '/../services/LotteryService.php';
require_once __DIR__ . '/../models/LotteryModel.php';
require_once __DIR__ . '/../helpers/DrawTimeHelper.php';

/**
 * Home page controller
 */
class HomeController {
    private $lotteryService;
    private $lotteryModel;

    public function __construct() {
        $this->lotteryService = new LotteryService();
        $this->lotteryModel = new LotteryModel();
    }

    /**
     * Display home page with today's results
     */
    public function index() {
        // Get appropriate dates based on draw times
        $xsmbDate = DrawTimeHelper::getResultDate('XSMB');
        $xsmtDate = DrawTimeHelper::getResultDate('XSMT');
        $xsmnDate = DrawTimeHelper::getResultDate('XSMN');
        
        // Get draw status for each region
        $xsmbStatus = DrawTimeHelper::getDrawStatus('XSMB');
        $xsmtStatus = DrawTimeHelper::getDrawStatus('XSMT');
        $xsmnStatus = DrawTimeHelper::getDrawStatus('XSMN');
        
        // Fetch results for appropriate dates
        $xsmb = $this->lotteryService->fetchLotteryData('XSMB', $xsmbDate);
        $xsmt = $this->lotteryService->fetchLotteryData('XSMT', $xsmtDate);
        $xsmn = $this->lotteryService->fetchLotteryData('XSMN', $xsmnDate);

        // Calculate statistics
        $xsmbStats = $this->lotteryService->calculateStatistics('XSMB', 30);
        
        // Get hot and cold numbers
        $hotNumbers = $this->lotteryService->getHotNumbers('XSMB', 10, 30);
        $coldNumbers = $this->lotteryService->getColdNumbers('XSMB', 10, 30);

        // Generate head/tail stats for today
        $headTailStats = null;
        if ($xsmb) {
            $headTailStats = $this->lotteryService->generateHeadTailStats($xsmb);
        }

        return [
            'today' => date('Y-m-d'),
            'xsmb' => $xsmb,
            'xsmt' => $xsmt,
            'xsmn' => $xsmn,
            'xsmb_status' => $xsmbStatus,
            'xsmt_status' => $xsmtStatus,
            'xsmn_status' => $xsmnStatus,
            'hotNumbers' => $hotNumbers,
            'coldNumbers' => $coldNumbers,
            'headTailStats' => $headTailStats,
        ];
    }

    /**
     * Get results for specific region and date
     */
    public function getResults($region, $date = null) {
        if ($date === null) {
            $date = date('Y-m-d');
        }

        $result = $this->lotteryService->fetchLotteryData($region, $date);
        
        if ($result) {
            $headTailStats = $this->lotteryService->generateHeadTailStats($result);
            return [
                'result' => $result,
                'headTailStats' => $headTailStats,
            ];
        }

        return null;
    }

    /**
     * Get statistics for a region
     */
    public function getStatistics($region, $periodDays = 30) {
        $stats = $this->lotteryService->calculateStatistics($region, $periodDays);
        $hotNumbers = $this->lotteryService->getHotNumbers($region, 10, $periodDays);
        $coldNumbers = $this->lotteryService->getColdNumbers($region, 10, $periodDays);

        return [
            'region' => $region,
            'periodDays' => $periodDays,
            'stats' => $stats,
            'hotNumbers' => $hotNumbers,
            'coldNumbers' => $coldNumbers,
        ];
    }

    /**
     * Generate random lottery numbers (Quay thử)
     */
    public function generateRandomNumbers($region) {
        $prizes = [];
        
        if ($region === 'XSMB') {
            $structure = XSMB_PRIZES;
        } else {
            $structure = XSMT_XSMN_PRIZES;
        }

        foreach ($structure as $key => $prize) {
            $count = $prize['count'];
            $digits = $prize['digits'];
            $numbers = [];

            for ($i = 0; $i < $count; $i++) {
                $min = pow(10, $digits - 1);
                $max = pow(10, $digits) - 1;
                $numbers[] = str_pad(rand($min, $max), $digits, '0', STR_PAD_LEFT);
            }

            $prizes[$key] = implode(',', $numbers);
        }

        return [
            'region' => $region,
            'generated_at' => date('Y-m-d H:i:s'),
            'prizes' => $prizes,
        ];
    }
}
