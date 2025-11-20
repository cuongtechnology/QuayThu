<?php
require_once __DIR__ . '/../../config/database.php';

/**
 * Service for fetching and managing lottery data
 */
class LotteryService {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Fetch lottery data from external sources
     * Using web scraping as fallback since public APIs are limited
     */
    public function fetchLotteryData($region, $date = null) {
        if ($date === null) {
            $date = date('Y-m-d');
        }

        // Try to fetch from local database first
        $cached = $this->getLotteryResult($region, $date);
        if ($cached) {
            return $cached;
        }

        // Fetch fresh data (implement scraping or API call)
        $data = $this->scrapeData($region, $date);
        
        if ($data) {
            $this->saveLotteryResult($data);
            return $data;
        }

        return null;
    }

    /**
     * Scrape data from minhngoc.net.vn (most reliable source)
     */
    private function scrapeData($region, $date) {
        // Format date for URL
        $dateObj = new DateTime($date);
        $formattedDate = $dateObj->format('d-m-Y');
        
        // Build URL based on region
        $urls = [
            'XSMB' => "https://www.minhngoc.net.vn/xo-so-mien-bac/xsmb-{$formattedDate}.html",
            'XSMT' => "https://www.minhngoc.net.vn/xo-so-mien-trung/xsmt-{$formattedDate}.html",
            'XSMN' => "https://www.minhngoc.net.vn/xo-so-mien-nam/xsmn-{$formattedDate}.html",
        ];

        if (!isset($urls[$region])) {
            return null;
        }

        // For demo purposes, return mock data
        // In production, implement actual web scraping with curl or file_get_contents
        return $this->getMockData($region, $date);
    }

    /**
     * Get mock data for testing (replace with actual scraping)
     */
    private function getMockData($region, $date) {
        $dayOfWeek = date('l', strtotime($date));
        $daysVN = [
            'Monday' => 'Thứ hai',
            'Tuesday' => 'Thứ ba',
            'Wednesday' => 'Thứ tư',
            'Thursday' => 'Thứ năm',
            'Friday' => 'Thứ sáu',
            'Saturday' => 'Thứ bảy',
            'Sunday' => 'Chủ nhật',
        ];

        if ($region === 'XSMB') {
            return [
                'region' => 'XSMB',
                'province' => null,
                'draw_date' => $date,
                'draw_day' => $daysVN[$dayOfWeek],
                'special' => '46433',
                'first' => '89650',
                'second' => '21573,12383',
                'third' => '02926,67478,72732,69126,88536,18119',
                'fourth' => '7983,1901,9341,6705',
                'fifth' => '3521,0032,0545,9949,1065,4450',
                'sixth' => '046,737,274',
                'seventh' => '59,07,93,31',
                'eighth' => null,
            ];
        } elseif ($region === 'XSMT') {
            return [
                'region' => 'XSMT',
                'province' => 'Thừa Thiên Huế',
                'draw_date' => $date,
                'draw_day' => $daysVN[$dayOfWeek],
                'special' => '429338',
                'first' => '71541',
                'second' => '83451',
                'third' => '84597,30578',
                'fourth' => '87579,49092,70573,92880,27024,94755,68151',
                'fifth' => '4840',
                'sixth' => '6862,0287,9886',
                'seventh' => '106',
                'eighth' => '75',
            ];
        } else { // XSMN
            return [
                'region' => 'XSMN',
                'province' => 'TP. HCM',
                'draw_date' => $date,
                'draw_day' => $daysVN[$dayOfWeek],
                'special' => '510623',
                'first' => '57261',
                'second' => '81962',
                'third' => '67488,08570',
                'fourth' => '22229,53032,32580,97366,22614,72444,28767',
                'fifth' => '0537',
                'sixth' => '3340,7307,9790',
                'seventh' => '608',
                'eighth' => '72',
            ];
        }
    }

    /**
     * Save lottery result to database
     */
    public function saveLotteryResult($data) {
        $sql = "INSERT OR REPLACE INTO lottery_results 
                (region, province, draw_date, draw_day, special, first, second, third, fourth, fifth, sixth, seventh, eighth, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, datetime('now'))";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['region'],
            $data['province'] ?? null,
            $data['draw_date'],
            $data['draw_day'],
            $data['special'],
            $data['first'],
            $data['second'],
            $data['third'],
            $data['fourth'],
            $data['fifth'],
            $data['sixth'],
            $data['seventh'],
            $data['eighth'] ?? null,
        ]);
    }

    /**
     * Get lottery result from database
     */
    public function getLotteryResult($region, $date, $province = null) {
        $sql = "SELECT * FROM lottery_results WHERE region = ? AND draw_date = ?";
        $params = [$region, $date];
        
        if ($province) {
            $sql .= " AND province = ?";
            $params[] = $province;
        }
        
        $sql .= " LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get recent lottery results
     */
    public function getRecentResults($region, $limit = 30) {
        $sql = "SELECT * FROM lottery_results WHERE region = ? ORDER BY draw_date DESC LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$region, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all numbers from a result
     */
    public function extractNumbers($result) {
        $numbers = [];
        $prizes = ['special', 'first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh'];
        
        if (isset($result['eighth']) && $result['eighth']) {
            $prizes[] = 'eighth';
        }

        foreach ($prizes as $prize) {
            if (isset($result[$prize]) && $result[$prize]) {
                $prizeNumbers = explode(',', $result[$prize]);
                foreach ($prizeNumbers as $num) {
                    $num = trim($num);
                    if ($num) {
                        // Extract last 2 digits for statistics
                        $twoDigit = substr($num, -2);
                        $numbers[] = $twoDigit;
                    }
                }
            }
        }

        return $numbers;
    }

    /**
     * Calculate statistics for a region
     */
    public function calculateStatistics($region, $periodDays = 30) {
        $results = $this->getRecentResults($region, $periodDays);
        
        $frequency = [];
        $lastAppeared = [];
        
        foreach ($results as $index => $result) {
            $numbers = $this->extractNumbers($result);
            $date = $result['draw_date'];
            
            foreach ($numbers as $num) {
                if (!isset($frequency[$num])) {
                    $frequency[$num] = 0;
                    $lastAppeared[$num] = $date;
                }
                $frequency[$num]++;
                
                // Keep the most recent appearance
                if (strtotime($date) > strtotime($lastAppeared[$num])) {
                    $lastAppeared[$num] = $date;
                }
            }
        }

        // Calculate days since last appearance
        $today = date('Y-m-d');
        $stats = [];
        
        foreach ($frequency as $num => $count) {
            $daysSince = floor((strtotime($today) - strtotime($lastAppeared[$num])) / 86400);
            $stats[$num] = [
                'number' => $num,
                'frequency' => $count,
                'last_appeared' => $lastAppeared[$num],
                'days_since_last' => $daysSince,
            ];
        }

        // Save to database
        $this->saveStatistics($region, $stats, $periodDays);

        return $stats;
    }

    /**
     * Save statistics to database
     */
    private function saveStatistics($region, $stats, $periodDays) {
        foreach ($stats as $stat) {
            $sql = "INSERT OR REPLACE INTO statistics 
                    (region, number, frequency, last_appeared, days_since_last, period_days, updated_at)
                    VALUES (?, ?, ?, ?, ?, ?, datetime('now'))";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $region,
                $stat['number'],
                $stat['frequency'],
                $stat['last_appeared'],
                $stat['days_since_last'],
                $periodDays,
            ]);
        }
    }

    /**
     * Get hot numbers (most frequent)
     */
    public function getHotNumbers($region, $limit = 10, $periodDays = 30) {
        $sql = "SELECT * FROM statistics 
                WHERE region = ? AND period_days = ? 
                ORDER BY frequency DESC, number ASC 
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$region, $periodDays, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get cold numbers (least frequent / gan)
     */
    public function getColdNumbers($region, $limit = 10, $periodDays = 30) {
        $sql = "SELECT * FROM statistics 
                WHERE region = ? AND period_days = ? 
                ORDER BY days_since_last DESC, frequency ASC 
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$region, $periodDays, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Generate head/tail statistics
     */
    public function generateHeadTailStats($result) {
        $numbers = $this->extractNumbers($result);
        
        $headStats = array_fill(0, 10, []);
        $tailStats = array_fill(0, 10, []);

        foreach ($numbers as $num) {
            $num = str_pad($num, 2, '0', STR_PAD_LEFT);
            $head = (int)substr($num, 0, 1);
            $tail = (int)substr($num, 1, 1);
            
            $headStats[$head][] = $num;
            $tailStats[$tail][] = $num;
        }

        return [
            'head' => $headStats,
            'tail' => $tailStats,
        ];
    }
}
