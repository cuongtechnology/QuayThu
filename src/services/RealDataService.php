<?php
require_once __DIR__ . '/../../config/database.php';

/**
 * Service for fetching real lottery data from external sources
 */
class RealDataService {
    private $db;
    
    // API endpoints for real data
    private $apiEndpoints = [
        // Option 1: Scrape from official sources
        'minhngoc' => 'https://www.minhngoc.net.vn/xo-so-truc-tiep/',
        
        // Option 2: Use public APIs if available
        'backup_api' => 'https://api.example.com/lottery/',
    ];

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Fetch real lottery data from minhngoc.net.vn
     */
    public function fetchRealData($region, $date) {
        // Format date
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

        $url = $urls[$region];
        
        // Try to fetch data
        try {
            $html = $this->fetchUrl($url);
            
            if ($html) {
                $data = $this->parseHtml($html, $region, $date);
                
                if ($data) {
                    // Save to database
                    $this->saveToDatabase($data);
                    return $data;
                }
            }
        } catch (Exception $e) {
            error_log("Error fetching real data: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Fetch URL content
     */
    private function fetchUrl($url) {
        // Use cURL for better control
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200 && $html) {
            return $html;
        }

        return null;
    }

    /**
     * Parse HTML to extract lottery numbers
     * This is a simplified parser - needs to be customized based on actual HTML structure
     */
    private function parseHtml($html, $region, $date) {
        // Use DOMDocument to parse HTML
        $dom = new DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        
        // This is where you would implement the actual parsing logic
        // Based on the HTML structure of minhngoc.net.vn
        
        // For now, return null to indicate parsing not implemented
        // You would need to inspect the HTML and write specific parsing logic
        
        return null;
    }

    /**
     * Save data to database
     */
    private function saveToDatabase($data) {
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
     * Fetch from alternative API (if available)
     */
    public function fetchFromApi($region, $date) {
        // Example: If you have access to a JSON API
        $apiUrl = "https://api.example.com/lottery/{$region}/{$date}";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200 && $response) {
            $data = json_decode($response, true);
            
            if ($data && isset($data['results'])) {
                // Process and save to database
                $this->saveToDatabase($data['results']);
                return $data['results'];
            }
        }

        return null;
    }

    /**
     * Manual data entry helper (for testing or when API is not available)
     */
    public function manualEntry($region, $date, $prizes) {
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

        $data = array_merge([
            'region' => $region,
            'province' => null,
            'draw_date' => $date,
            'draw_day' => $daysVN[$dayOfWeek],
        ], $prizes);

        return $this->saveToDatabase($data);
    }

    /**
     * Seed sample data for testing (based on mock data from LotteryService)
     */
    public function seedSampleData() {
        $dates = [];
        $today = new DateTime();
        
        // Generate data for last 30 days
        for ($i = 0; $i < 30; $i++) {
            $date = clone $today;
            $date->modify("-{$i} days");
            $dates[] = $date->format('Y-m-d');
        }

        foreach ($dates as $date) {
            // XSMB
            $this->generateRandomResult('XSMB', $date);
            
            // XSMT
            $this->generateRandomResult('XSMT', $date);
            
            // XSMN
            $this->generateRandomResult('XSMN', $date);
        }

        return true;
    }

    /**
     * Generate random lottery result for seeding
     */
    private function generateRandomResult($region, $date) {
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

        $provinces = [
            'XSMT' => ['Thừa Thiên Huế', 'Phú Yên', 'Đắk Lắk', 'Quảng Nam'],
            'XSMN' => ['TP. HCM', 'Đồng Tháp', 'Cà Mau', 'Bến Tre'],
        ];

        if ($region === 'XSMB') {
            $data = [
                'region' => 'XSMB',
                'province' => null,
                'draw_date' => $date,
                'draw_day' => $daysVN[$dayOfWeek],
                'special' => $this->randomNumber(5),
                'first' => $this->randomNumber(5),
                'second' => $this->randomNumber(5) . ',' . $this->randomNumber(5),
                'third' => implode(',', [$this->randomNumber(5), $this->randomNumber(5), $this->randomNumber(5), $this->randomNumber(5), $this->randomNumber(5), $this->randomNumber(5)]),
                'fourth' => implode(',', [$this->randomNumber(4), $this->randomNumber(4), $this->randomNumber(4), $this->randomNumber(4)]),
                'fifth' => implode(',', [$this->randomNumber(4), $this->randomNumber(4), $this->randomNumber(4), $this->randomNumber(4), $this->randomNumber(4), $this->randomNumber(4)]),
                'sixth' => implode(',', [$this->randomNumber(3), $this->randomNumber(3), $this->randomNumber(3)]),
                'seventh' => implode(',', [$this->randomNumber(2), $this->randomNumber(2), $this->randomNumber(2), $this->randomNumber(2)]),
                'eighth' => null,
            ];
        } else {
            $provinceList = $provinces[$region];
            $data = [
                'region' => $region,
                'province' => $provinceList[array_rand($provinceList)],
                'draw_date' => $date,
                'draw_day' => $daysVN[$dayOfWeek],
                'special' => $this->randomNumber(6),
                'first' => $this->randomNumber(5),
                'second' => $this->randomNumber(5),
                'third' => $this->randomNumber(5) . ',' . $this->randomNumber(5),
                'fourth' => implode(',', [$this->randomNumber(4), $this->randomNumber(4), $this->randomNumber(4), $this->randomNumber(4), $this->randomNumber(4), $this->randomNumber(4), $this->randomNumber(4)]),
                'fifth' => $this->randomNumber(4),
                'sixth' => implode(',', [$this->randomNumber(3), $this->randomNumber(3), $this->randomNumber(3)]),
                'seventh' => $this->randomNumber(3),
                'eighth' => $this->randomNumber(2),
            ];
        }

        return $this->saveToDatabase($data);
    }

    /**
     * Generate random number with specific digits
     */
    private function randomNumber($digits) {
        $min = pow(10, $digits - 1);
        $max = pow(10, $digits) - 1;
        return str_pad(rand($min, $max), $digits, '0', STR_PAD_LEFT);
    }
}
