<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soi Cầu - Dự Đoán Xổ Số VN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg">
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
            <h2 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                🔮 Soi Cầu & Dự Đoán
            </h2>
            <p class="text-gray-600">Phân tích thống kê và đưa ra các con số may mắn cho bạn</p>
        </div>

        <!-- Region & Strategy Selection -->
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

                <!-- Strategy -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Phương pháp phân tích</label>
                    <select onchange="changeStrategy(this.value)" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:outline-none">
                        <option value="balanced">Cân bằng (Hot + Cold)</option>
                        <option value="hot">Theo số nóng</option>
                        <option value="cold">Đánh lô gan</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Predictions -->
        <div class="grid md:grid-cols-3 gap-6 mb-6">
            <!-- Bạch Thủ -->
            <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">👑 Bạch Thủ</h3>
                    <div class="bg-white bg-opacity-20 rounded-full px-3 py-1 text-xs font-semibold">
                        Top 1
                    </div>
                </div>
                <?php if (!empty($data['predictions'])): ?>
                    <div class="bg-white bg-opacity-20 rounded-lg p-4 mb-3">
                        <div class="text-5xl font-bold text-center"><?php echo $data['predictions'][0]['number']; ?></div>
                    </div>
                    <div class="text-sm">
                        <div class="flex items-center mb-1">
                            <span class="font-semibold">Độ tin cậy:</span>
                            <span class="ml-auto"><?php echo $data['predictions'][0]['confidence']; ?></span>
                        </div>
                        <div class="text-xs opacity-90"><?php echo $data['predictions'][0]['reason']; ?></div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Song Thủ -->
            <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">🎯 Song Thủ</h3>
                    <div class="bg-white bg-opacity-20 rounded-full px-3 py-1 text-xs font-semibold">
                        Top 2
                    </div>
                </div>
                <?php if (!empty($data['predictions']) && count($data['predictions']) >= 2): ?>
                    <div class="space-y-3">
                        <?php for ($i = 0; $i < 2; $i++): ?>
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <div class="text-3xl font-bold text-center"><?php echo $data['predictions'][$i]['number']; ?></div>
                                <div class="text-xs text-center mt-1 opacity-90"><?php echo $data['predictions'][$i]['confidence']; ?></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Bộ Số -->
            <div class="bg-gradient-to-br from-green-500 to-teal-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">📋 Bộ Số</h3>
                    <div class="bg-white bg-opacity-20 rounded-full px-3 py-1 text-xs font-semibold">
                        Top 5
                    </div>
                </div>
                <?php if (!empty($data['predictions'])): ?>
                    <div class="grid grid-cols-3 gap-2">
                        <?php foreach (array_slice($data['predictions'], 0, 5) as $pred): ?>
                            <div class="bg-white bg-opacity-20 rounded-lg p-2 text-center">
                                <div class="text-xl font-bold"><?php echo $pred['number']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-3 text-xs opacity-90 text-center">
                        Chọn một trong các số trên để chơi
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- All Predictions Table -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-4">
                <h3 class="text-xl font-bold">📊 Chi Tiết Dự Đoán</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Số</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Độ Tin Cậy</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Lý Do</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Chiến Lược</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['predictions'] as $index => $pred): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <span class="text-2xl font-bold text-purple-600"><?php echo $pred['number']; ?></span>
                            </td>
                            <td class="px-4 py-3">
                                <?php
                                $confidenceColor = '';
                                switch($pred['confidence']) {
                                    case 'Cao': $confidenceColor = 'bg-green-100 text-green-700 border-green-300'; break;
                                    case 'Trung bình': $confidenceColor = 'bg-yellow-100 text-yellow-700 border-yellow-300'; break;
                                    default: $confidenceColor = 'bg-gray-100 text-gray-700 border-gray-300';
                                }
                                ?>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold border-2 <?php echo $confidenceColor; ?>">
                                    <?php echo $pred['confidence']; ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-700"><?php echo $pred['reason']; ?></td>
                            <td class="px-4 py-3 text-gray-600 text-sm"><?php echo $pred['strategy']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Reference Statistics -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Hot Numbers -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-3">
                    <h4 class="font-bold">🔥 Số Nóng (Tham khảo)</h4>
                </div>
                <div class="p-4">
                    <div class="space-y-2">
                        <?php foreach (array_slice($data['hot_numbers'], 0, 5) as $stat): ?>
                        <div class="flex items-center justify-between p-2 rounded hover:bg-orange-50">
                            <span class="text-xl font-bold text-red-600"><?php echo $stat['number']; ?></span>
                            <span class="text-sm text-gray-600"><?php echo $stat['frequency']; ?> lần</span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Cold Numbers -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white px-6 py-3">
                    <h4 class="font-bold">❄️ Lô Gan (Tham khảo)</h4>
                </div>
                <div class="p-4">
                    <div class="space-y-2">
                        <?php foreach (array_slice($data['cold_numbers'], 0, 5) as $stat): ?>
                        <div class="flex items-center justify-between p-2 rounded hover:bg-blue-50">
                            <span class="text-xl font-bold text-blue-600"><?php echo $stat['number']; ?></span>
                            <span class="text-sm text-gray-600"><?php echo $stat['days_since_last']; ?> kỳ</span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Disclaimer -->
        <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg">
            <h4 class="font-bold text-yellow-800 mb-2">⚠️ Lưu ý quan trọng</h4>
            <ul class="space-y-1 text-sm text-yellow-700">
                <li>• Các dự đoán trên chỉ mang tính chất tham khảo, dựa trên phân tích thống kê</li>
                <li>• Không có phương pháp nào đảm bảo 100% chính xác trong xổ số</li>
                <li>• Chỉ chơi với số tiền bạn có thể chấp nhận mất</li>
                <li>• Xổ số chỉ nên coi là trò giải trí, không phải nguồn thu nhập chính</li>
            </ul>
        </div>
    </main>

    <script>
        function changeRegion(region) {
            window.location.href = `?action=prediction&region=${region}`;
        }

        function changeStrategy(type) {
            const region = new URLSearchParams(window.location.search).get('region') || 'XSMB';
            window.location.href = `?action=prediction&region=${region}&type=${type}`;
        }
    </script>
</body>
</html>
