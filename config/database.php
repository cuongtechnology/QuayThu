<?php
require_once __DIR__ . '/config.php';

/**
 * Database initialization and schema creation
 */
class Database {
    private static $instance = null;
    private $db;

    private function __construct() {
        try {
            // Create database directory if it doesn't exist
            $dbDir = dirname(DB_PATH);
            if (!is_dir($dbDir)) {
                mkdir($dbDir, 0755, true);
            }

            // Open SQLite database
            $this->db = new PDO('sqlite:' . DB_PATH);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Initialize schema
            $this->initSchema();
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->db;
    }

    private function initSchema() {
        $sql = "
        -- Table for storing lottery results
        CREATE TABLE IF NOT EXISTS lottery_results (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            region TEXT NOT NULL,
            province TEXT,
            draw_date DATE NOT NULL,
            draw_day TEXT,
            special TEXT,
            first TEXT,
            second TEXT,
            third TEXT,
            fourth TEXT,
            fifth TEXT,
            sixth TEXT,
            seventh TEXT,
            eighth TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE(region, province, draw_date)
        );

        -- Table for storing statistics
        CREATE TABLE IF NOT EXISTS statistics (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            region TEXT NOT NULL,
            number TEXT NOT NULL,
            frequency INTEGER DEFAULT 0,
            last_appeared DATE,
            days_since_last INTEGER DEFAULT 0,
            period_days INTEGER DEFAULT 30,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE(region, number, period_days)
        );

        -- Table for head/tail analysis
        CREATE TABLE IF NOT EXISTS head_tail_stats (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            region TEXT NOT NULL,
            draw_date DATE NOT NULL,
            head_digit INTEGER NOT NULL,
            tail_digit INTEGER NOT NULL,
            numbers TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE(region, draw_date, head_digit, tail_digit)
        );

        -- Create indexes for better performance
        CREATE INDEX IF NOT EXISTS idx_lottery_region_date ON lottery_results(region, draw_date DESC);
        CREATE INDEX IF NOT EXISTS idx_lottery_date ON lottery_results(draw_date DESC);
        CREATE INDEX IF NOT EXISTS idx_statistics_region ON statistics(region, frequency DESC);
        CREATE INDEX IF NOT EXISTS idx_statistics_last_appeared ON statistics(region, days_since_last DESC);
        CREATE INDEX IF NOT EXISTS idx_head_tail_region_date ON head_tail_stats(region, draw_date DESC);
        ";

        $this->db->exec($sql);
    }

    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function lastInsertId() {
        return $this->db->lastInsertId();
    }
}
