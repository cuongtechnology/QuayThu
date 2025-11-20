<?php
/**
 * Configuration file for Xổ Số VN Application
 */

define('DB_PATH', __DIR__ . '/../database/xoso.db');
define('BASE_URL', '/');
define('TIMEZONE', 'Asia/Ho_Chi_Minh');
define('SITE_NAME', 'Xổ Số VN');

// Set timezone
date_default_timezone_set(TIMEZONE);

// API Configuration
define('API_ENDPOINTS', [
    'XSMB' => 'https://xoso.me/xsmb.json',  // Fallback to web scraping if needed
    'XSMT' => 'https://xoso.me/xsmt.json',
    'XSMN' => 'https://xoso.me/xsmn.json',
]);

// Update schedule (in Vietnamese time)
define('UPDATE_SCHEDULE', [
    'XSMN' => '16:15',
    'XSMT' => '17:15', 
    'XSMB' => '18:15',
]);

// Region configuration
define('REGIONS', [
    'XSMB' => [
        'name' => 'Miền Bắc',
        'provinces' => ['Hà Nội'],
    ],
    'XSMT' => [
        'name' => 'Miền Trung',
        'provinces' => ['Thừa Thiên Huế', 'Phú Yên', 'Đắk Lắk', 'Quảng Nam', 'Đà Nẵng', 'Khánh Hòa', 'Bình Định', 'Quảng Trị', 'Quảng Bình', 'Gia Lai', 'Ninh Thuận', 'Đắk Nông', 'Quảng Ngãi', 'Kon Tum'],
    ],
    'XSMN' => [
        'name' => 'Miền Nam',
        'provinces' => ['TP. HCM', 'Đồng Tháp', 'Cà Mau', 'Bến Tre', 'Vũng Tàu', 'Bạc Liêu', 'Đồng Nai', 'Cần Thơ', 'Sóc Trăng', 'Tây Ninh', 'An Giang', 'Bình Thuận', 'Vĩnh Long', 'Bình Dương', 'Trà Vinh', 'Long An', 'Hậu Giang', 'Bình Phước', 'Tiền Giang', 'Kiên Giang', 'Đà Lạt'],
    ],
]);

// Prize structure for XSMB
define('XSMB_PRIZES', [
    'special' => ['name' => 'Đặc Biệt', 'count' => 1, 'digits' => 5],
    'first' => ['name' => 'Giải Nhất', 'count' => 1, 'digits' => 5],
    'second' => ['name' => 'Giải Nhì', 'count' => 2, 'digits' => 5],
    'third' => ['name' => 'Giải Ba', 'count' => 6, 'digits' => 5],
    'fourth' => ['name' => 'Giải Tư', 'count' => 4, 'digits' => 4],
    'fifth' => ['name' => 'Giải Năm', 'count' => 6, 'digits' => 4],
    'sixth' => ['name' => 'Giải Sáu', 'count' => 3, 'digits' => 3],
    'seventh' => ['name' => 'Giải Bảy', 'count' => 4, 'digits' => 2],
]);

// Prize structure for XSMT and XSMN
define('XSMT_XSMN_PRIZES', [
    'special' => ['name' => 'Đặc Biệt', 'count' => 1, 'digits' => 6],
    'first' => ['name' => 'Giải Nhất', 'count' => 1, 'digits' => 5],
    'second' => ['name' => 'Giải Nhì', 'count' => 1, 'digits' => 5],
    'third' => ['name' => 'Giải Ba', 'count' => 2, 'digits' => 5],
    'fourth' => ['name' => 'Giải Tư', 'count' => 7, 'digits' => 4],
    'fifth' => ['name' => 'Giải Năm', 'count' => 1, 'digits' => 4],
    'sixth' => ['name' => 'Giải Sáu', 'count' => 3, 'digits' => 3],
    'seventh' => ['name' => 'Giải Bảy', 'count' => 1, 'digits' => 2],
    'eighth' => ['name' => 'Giải Tám', 'count' => 1, 'digits' => 2],
]);

// Cache settings
define('CACHE_DURATION', 300); // 5 minutes in seconds

return [
    'db_path' => DB_PATH,
    'base_url' => BASE_URL,
    'timezone' => TIMEZONE,
];
