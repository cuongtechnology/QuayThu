<?php
/**
 * Controller for dream interpretation and number suggestions (Sổ mơ)
 */
class DreamController {
    private $dreamData;

    public function __construct() {
        // Load dream data
        $jsonPath = __DIR__ . '/../data/so_mo.json';
        if (file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            $this->dreamData = json_decode($json, true);
        } else {
            $this->dreamData = [];
        }
    }

    /**
     * Search dreams and return number suggestions
     */
    public function searchDream($keyword) {
        $keyword = $this->toLower(trim($keyword));
        $results = [];

        foreach ($this->dreamData as $category => $items) {
            foreach ($items as $dream => $numbers) {
                if (strpos($this->toLower($dream), $keyword) !== false) {
                    $results[] = [
                        'category' => $this->getCategoryName($category),
                        'dream' => $dream,
                        'numbers' => $numbers,
                        'relevance' => $this->calculateRelevance($dream, $keyword),
                    ];
                }
            }
        }

        // Sort by relevance
        usort($results, function($a, $b) {
            return $b['relevance'] - $a['relevance'];
        });

        return [
            'keyword' => $keyword,
            'total_results' => count($results),
            'results' => $results,
        ];
    }

    /**
     * Get all dreams by category
     */
    public function getDreamsByCategory($category = null) {
        if ($category && isset($this->dreamData[$category])) {
            return [
                'category' => $this->getCategoryName($category),
                'dreams' => $this->dreamData[$category],
            ];
        }

        return [
            'categories' => array_keys($this->dreamData),
            'all_dreams' => $this->dreamData,
        ];
    }

    /**
     * Get random dream suggestions
     */
    public function getRandomSuggestions($count = 5) {
        $allDreams = [];
        
        foreach ($this->dreamData as $category => $items) {
            foreach ($items as $dream => $numbers) {
                $allDreams[] = [
                    'category' => $this->getCategoryName($category),
                    'dream' => $dream,
                    'numbers' => $numbers,
                ];
            }
        }

        shuffle($allDreams);
        return array_slice($allDreams, 0, $count);
    }

    /**
     * Calculate relevance score
     */
    private function calculateRelevance($dream, $keyword) {
        $dream = $this->toLower($dream);
        $keyword = $this->toLower($keyword);

        // Exact match
        if ($dream === $keyword) {
            return 100;
        }

        // Starts with keyword
        if (strpos($dream, $keyword) === 0) {
            return 80;
        }

        // Contains keyword
        if (strpos($dream, $keyword) !== false) {
            return 60;
        }

        // Similar words
        $dreamWords = explode(' ', $dream);
        $keywordWords = explode(' ', $keyword);
        
        $matchCount = 0;
        foreach ($keywordWords as $kw) {
            foreach ($dreamWords as $dw) {
                if (strpos($dw, $kw) !== false || strpos($kw, $dw) !== false) {
                    $matchCount++;
                }
            }
        }

        return $matchCount * 20;
    }

    /**
     * Convert string to lowercase (with fallback for non-mbstring environments)
     */
    private function toLower($str) {
        if (function_exists('mb_strtolower')) {
            return mb_strtolower($str, 'UTF-8');
        }
        return strtolower($str);
    }

    /**
     * Get string length (with fallback for non-mbstring environments)
     */
    private function strLen($str) {
        if (function_exists('mb_strlen')) {
            return mb_strlen($str, 'UTF-8');
        }
        return strlen($str);
    }

    /**
     * Get category name in Vietnamese
     */
    private function getCategoryName($category) {
        $names = [
            'animals' => 'Động Vật',
            'objects' => 'Đồ Vật',
            'people' => 'Con Người',
            'actions' => 'Hành Động',
            'emotions' => 'Cảm Xúc',
            'nature' => 'Thiên Nhiên',
            'lucky_numbers' => 'Số May Mắn',
        ];

        return $names[$category] ?? ucfirst($category);
    }

    /**
     * Get popular dreams
     */
    public function getPopularDreams() {
        return [
            'animals' => ['con rắn', 'con ngựa', 'con chó', 'con mèo'],
            'objects' => ['tiền bạc', 'vàng', 'nhà cửa'],
            'people' => ['bố mẹ', 'con cái', 'người yêu'],
            'actions' => ['đi làm', 'ăn uống', 'đi chơi'],
            'lucky_numbers' => ['may mắn', 'tài lộc', 'thành công'],
        ];
    }

    /**
     * Interpret complex dream (multiple keywords)
     */
    public function interpretDream($dreamText) {
        // Simple keyword extraction
        $keywords = explode(' ', $this->toLower($dreamText));
        $keywords = array_filter($keywords, function($word) {
            return $this->strLen($word) > 2; // Filter out short words
        });

        $allNumbers = [];
        $interpretations = [];

        foreach ($keywords as $keyword) {
            $result = $this->searchDream($keyword);
            if ($result['total_results'] > 0) {
                $topResult = $result['results'][0];
                $interpretations[] = $topResult;
                $allNumbers = array_merge($allNumbers, $topResult['numbers']);
            }
        }

        // Get unique and most common numbers
        $numberCounts = array_count_values($allNumbers);
        arsort($numberCounts);
        $suggestedNumbers = array_slice(array_keys($numberCounts), 0, 10);

        return [
            'dream_text' => $dreamText,
            'keywords_found' => count($interpretations),
            'interpretations' => $interpretations,
            'suggested_numbers' => $suggestedNumbers,
            'top_numbers' => array_slice($suggestedNumbers, 0, 5),
        ];
    }
}
