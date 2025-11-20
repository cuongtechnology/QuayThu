<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê Chi Tiết - Xổ Số VN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-gradient-to-r from-orange-600 to-red-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center space-x-3">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"></path>
                    </svg>
                    <h1 class="text-xl md:text-2xl font-bold">Xổ Số VN</h1>
                </a>
                <a href="/" class="text-sm hover:underline">← Trang chủ</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Page Title -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-2">
                📊 Thống Kê Chi Tiết
            </h2>
            <p class="text-gray-600">Phân tích tần suất xuất hiện, lô gan và các số liệu quan trọng</p>
        </div>

        <!-- Region & Period Selection -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Region -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Chọn miền</label>
                    <div class="flex gap-2">
                        <button onclick="changeRegion('XSMB')" class="flex-1 px-4 py-2 rounded-lg font-semibold bg-blue-600 text-white">XSMB</button>
                        <button onclick="changeRegion('XSMT')" class="flex-1 px-4 py-2 rounded-lg font-semibold bg-gray-200 text-gray-700">XSMT</button>
                        <button onclick="changeRegion('XSMN')" class="flex-1 px-4 py-2 rounded-lg font-semibold bg-gray-200 text-gray-700">XSMN</button>
                    </div>
                </div>

                <!-- Period -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Thời gian thống kê</label>
                    <select onchange="changePeriod(this.value)" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:outline-none">
                        <option value="7">7 ngày gần nhất</option>
                        <option value="30" selected>30 ngày gần nhất</option>
                        <option value="60">60 ngày gần nhất</option>
                        <option value="90">90 ngày gần nhất</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <!-- Hot Numbers -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-4">
                    <h3 class="text-xl font-bold flex items-center">
                        🔥 Top 20 Số Nóng
                        <span class="ml-auto text-sm opacity-90">(<?php echo $data['periodDays']; ?> kỳ)</span>
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <?php foreach ($data['hotNumbers'] as $index => $stat): ?>
                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-orange-50 border-2 border-gray-100">
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-600 font-bold text-sm">
                                    #<?php echo $index + 1; ?>
                                </span>
                                <span class="text-3xl font-bold text-red-600"><?php echo $stat['number']; ?></span>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-gray-700"><?php echo $stat['frequency']; ?> lần</div>
                                <div class="text-xs text-gray-500">Cuối: <?php echo date('d/m/Y', strtotime($stat['last_appeared'])); ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Cold Numbers (Lô Gan) -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white px-6 py-4">
                    <h3 class="text-xl font-bold flex items-center">
                        ❄️ Top 20 Lô Gan
                        <span class="ml-auto text-sm opacity-90">(<?php echo $data['periodDays']; ?> kỳ)</span>
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <?php foreach ($data['coldNumbers'] as $index => $stat): ?>
                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-blue-50 border-2 border-gray-100">
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold text-sm">
                                    #<?php echo $index + 1; ?>
                                </span>
                                <span class="text-3xl font-bold text-blue-600"><?php echo $stat['number']; ?></span>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-gray-700"><?php echo $stat['days_since_last']; ?> kỳ</div>
                                <div class="text-xs text-gray-500">
                                    <?php if ($stat['frequency'] > 0): ?>
                                        Xuất hiện: <?php echo $stat['frequency']; ?> lần
                                    <?php else: ?>
                                        Chưa về lần nào
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Numbers Statistics Table -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-4">
                <h3 class="text-xl font-bold">📋 Bảng Thống Kê Toàn Bộ (00-99)</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Số</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Tần Suất</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Lần Cuối</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Số Kỳ Chưa Về</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Sort stats by number
                        $allStats = $data['stats'];
                        ksort($allStats);
                        
                        foreach ($allStats as $num => $stat): 
                            // Determine status
                            $status = '';
                            $statusColor = '';
                            if ($stat['frequency'] >= 5) {
                                $status = '🔥 Nóng';
                                $statusColor = 'text-red-600';
                            } elseif ($stat['days_since_last'] > 10) {
                                $status = '❄️ Gan';
                                $statusColor = 'text-blue-600';
                            } else {
                                $status = '➖ Bình thường';
                                $statusColor = 'text-gray-600';
                            }
                        ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <span class="text-2xl font-bold text-purple-600"><?php echo str_pad($num, 2, '0', STR_PAD_LEFT); ?></span>
                            </td>
                            <td class="px-4 py-3 text-center font-semibold"><?php echo $stat['frequency']; ?></td>
                            <td class="px-4 py-3 text-center text-sm text-gray-600">
                                <?php echo $stat['last_appeared'] ? date('d/m/Y', strtotime($stat['last_appeared'])) : 'N/A'; ?>
                            </td>
                            <td class="px-4 py-3 text-center font-bold text-lg"><?php echo $stat['days_since_last']; ?></td>
                            <td class="px-4 py-3 text-center font-semibold <?php echo $statusColor; ?>"><?php echo $status; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Legend -->
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
            <h4 class="font-bold text-blue-900 mb-3">📖 Chú Thích</h4>
            <div class="grid md:grid-cols-3 gap-4 text-sm text-blue-800">
                <div>
                    <strong>🔥 Số Nóng:</strong> Xuất hiện ≥ 5 lần trong kỳ thống kê
                </div>
                <div>
                    <strong>❄️ Lô Gan:</strong> Chưa về > 10 kỳ
                </div>
                <div>
                    <strong>➖ Bình thường:</strong> Các trường hợp còn lại
                </div>
            </div>
        </div>
    </main>

    <script>
        function changeRegion(region) {
            const period = new URLSearchParams(window.location.search).get('period') || '30';
            window.location.href = `?action=statistics_detail&region=${region}&period=${period}`;
        }

        function changePeriod(period) {
            const region = new URLSearchParams(window.location.search).get('region') || 'XSMB';
            window.location.href = `?action=statistics_detail&region=${region}&period=${period}`;
        }
    </script>
</body>
</html>
