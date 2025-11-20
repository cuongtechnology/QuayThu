<?php
/**
 * Helper functions for lottery draw time logic
 */
class DrawTimeHelper {
    
    /**
     * Get draw times for each region (GMT+7)
     */
    public static function getDrawTimes() {
        return [
            'XSMN' => '16:15',
            'XSMT' => '17:15',
            'XSMB' => '18:15',
        ];
    }
    
    /**
     * Check if draw has happened for a region today
     * 
     * @param string $region Region code (XSMB, XSMT, XSMN)
     * @return bool True if draw time has passed
     */
    public static function hasDrawnToday($region) {
        $drawTimes = self::getDrawTimes();
        
        if (!isset($drawTimes[$region])) {
            return false;
        }
        
        $now = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $drawTime = DateTime::createFromFormat('Y-m-d H:i', date('Y-m-d') . ' ' . $drawTimes[$region], new DateTimeZone('Asia/Ho_Chi_Minh'));
        
        return $now >= $drawTime;
    }
    
    /**
     * Get countdown to next draw
     * 
     * @param string $region Region code (XSMB, XSMT, XSMN)
     * @return array Countdown info with hours, minutes, seconds
     */
    public static function getCountdown($region) {
        $drawTimes = self::getDrawTimes();
        
        if (!isset($drawTimes[$region])) {
            return null;
        }
        
        $now = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $today = $now->format('Y-m-d');
        
        $drawTime = DateTime::createFromFormat('Y-m-d H:i', $today . ' ' . $drawTimes[$region], new DateTimeZone('Asia/Ho_Chi_Minh'));
        
        // If draw time has passed today, countdown to tomorrow
        if ($now >= $drawTime) {
            $drawTime->modify('+1 day');
        }
        
        $diff = $drawTime->getTimestamp() - $now->getTimestamp();
        
        if ($diff < 0) {
            $diff = 0;
        }
        
        $hours = floor($diff / 3600);
        $minutes = floor(($diff % 3600) / 60);
        $seconds = $diff % 60;
        
        return [
            'region' => $region,
            'draw_time' => $drawTimes[$region],
            'draw_date' => $drawTime->format('d/m/Y'),
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds,
            'total_seconds' => $diff,
            'has_drawn' => false,
        ];
    }
    
    /**
     * Get appropriate date to display results for
     * If draw hasn't happened today, show yesterday's results
     * 
     * @param string $region Region code
     * @return string Date in Y-m-d format
     */
    public static function getResultDate($region) {
        if (self::hasDrawnToday($region)) {
            return date('Y-m-d');
        } else {
            return date('Y-m-d', strtotime('-1 day'));
        }
    }
    
    /**
     * Get status message for a region
     * 
     * @param string $region Region code
     * @return array Status info
     */
    public static function getDrawStatus($region) {
        if (self::hasDrawnToday($region)) {
            return [
                'status' => 'completed',
                'message' => 'Đã quay xong',
                'date' => date('Y-m-d'),
                'date_display' => date('d/m/Y'),
            ];
        } else {
            $countdown = self::getCountdown($region);
            return [
                'status' => 'waiting',
                'message' => 'Đang chờ quay',
                'countdown' => $countdown,
                'date' => date('Y-m-d', strtotime('-1 day')),
                'date_display' => date('d/m/Y', strtotime('-1 day')),
            ];
        }
    }
    
    /**
     * Format countdown for display
     * 
     * @param array $countdown Countdown array
     * @return string Formatted countdown string
     */
    public static function formatCountdown($countdown) {
        if (!$countdown) {
            return '';
        }
        
        $parts = [];
        
        if ($countdown['hours'] > 0) {
            $parts[] = sprintf('%02d giờ', $countdown['hours']);
        }
        
        if ($countdown['minutes'] > 0 || $countdown['hours'] > 0) {
            $parts[] = sprintf('%02d phút', $countdown['minutes']);
        }
        
        $parts[] = sprintf('%02d giây', $countdown['seconds']);
        
        return implode(' ', $parts);
    }
}
