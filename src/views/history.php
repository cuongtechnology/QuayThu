<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Kết Quả - Xổ Số VN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg">
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
            <h2 class="text-3xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent mb-2">
                📅 Lịch Sử Kết Quả
            </h2>
            <p class="text-gray-600">Tra cứu kết quả xổ số các ngày trước</p>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Region -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Chọn miền</label>
                    <div class="flex gap-2">
                        <button onclick="changeRegion('XSMB')" id="region-XSMB" class="flex-1 px-4 py-2 rounded-lg font-semibold bg-blue-600 text-white">XSMB</button>
                        <button onclick="changeRegion('XSMT')" id="region-XSMT" class="flex-1 px-4 py-2 rounded-lg font-semibold bg-gray-200 text-gray-700">XSMT</button>
                        <button onclick="changeRegion('XSMN')" id="region-XSMN" class="flex-1 px-4 py-2 rounded-lg font-semibold bg-gray-200 text-gray-700">XSMN</button>
                    </div>
                </div>

                <!-- Days -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Số ngày</label>
                    <select onchange="changeDays(this.value)" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none">
                        <option value="7">7 ngày gần nhất</option>
                        <option value="30" selected>30 ngày gần nhất</option>
                        <option value="60">60 ngày gần nhất</option>
                        <option value="90">90 ngày gần nhất</option>
                    </select>
                </div>

                <!-- Quick Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Tra nhanh</label>
                    <input type="date" id="quick-date" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" onchange="quickDateSearch(this.value)">
                </div>
            </div>
        </div>

        <!-- Results List -->
        <div class="space-y-4">
            <?php if (empty($data['results'])): ?>
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="text-6xl mb-4">📭</div>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Chưa Có Dữ Liệu</h3>
                    <p class="text-gray-600">Không tìm thấy kết quả trong khoảng thời gian này</p>
                    <p class="text-sm text-gray-500 mt-2">Dữ liệu sẽ được cập nhật khi có kết quả mới</p>
                </div>
            <?php else: ?>
                <?php foreach ($data['results'] as $result): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-lg">
                                    <?php 
                                    $regionName = ['XSMB' => 'Miền Bắc', 'XSMT' => 'Miền Trung', 'XSMN' => 'Miền Nam'];
                                    echo $regionName[$result['region']];
                                    ?>
                                    <?php if ($result['province']): ?>
                                        - <?php echo $result['province']; ?>
                                    <?php endif; ?>
                                </h3>
                                <p class="text-sm opacity-90"><?php echo $result['draw_day']; ?> - <?php echo date('d/m/Y', strtotime($result['draw_date'])); ?></p>
                            </div>
                            <button onclick="toggleDetail('result-<?php echo $result['id']; ?>')" class="px-4 py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition-all text-sm font-semibold">
                                Chi tiết
                            </button>
                        </div>
                    </div>

                    <!-- Quick View -->
                    <div class="px-6 py-4 bg-gray-50">
                        <div class="flex items-center justify-center space-x-4">
                            <span class="text-sm text-gray-600">Đặc Biệt:</span>
                            <span class="text-3xl font-bold text-red-600"><?php echo $result['special']; ?></span>
                        </div>
                    </div>

                    <!-- Detailed View (Hidden by default) -->
                    <div id="result-<?php echo $result['id']; ?>" class="hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <tbody>
                                    <?php if ($result['eighth']): ?>
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-3 font-semibold text-gray-700 w-32">Giải Tám</td>
                                        <td class="px-6 py-3 font-mono text-red-600 font-bold"><?php echo $result['eighth']; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-3 font-semibold text-gray-700">Giải Bảy</td>
                                        <td class="px-6 py-3 font-mono text-red-600 font-bold"><?php echo $result['seventh']; ?></td>
                                    </tr>
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-3 font-semibold text-gray-700">Giải Sáu</td>
                                        <td class="px-6 py-3 font-mono text-red-600 font-bold"><?php echo $result['sixth']; ?></td>
                                    </tr>
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-3 font-semibold text-gray-700">Giải Năm</td>
                                        <td class="px-6 py-3 font-mono text-red-600 font-bold"><?php echo $result['fifth']; ?></td>
                                    </tr>
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-3 font-semibold text-gray-700">Giải Tư</td>
                                        <td class="px-6 py-3 font-mono text-red-600 font-bold"><?php echo $result['fourth']; ?></td>
                                    </tr>
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-3 font-semibold text-gray-700">Giải Ba</td>
                                        <td class="px-6 py-3 font-mono text-red-600 font-bold"><?php echo $result['third']; ?></td>
                                    </tr>
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-3 font-semibold text-gray-700">Giải Nhì</td>
                                        <td class="px-6 py-3 font-mono text-red-600 font-bold text-lg"><?php echo $result['second']; ?></td>
                                    </tr>
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-3 font-semibold text-gray-700">Giải Nhất</td>
                                        <td class="px-6 py-3 font-mono text-red-600 font-bold text-lg"><?php echo $result['first']; ?></td>
                                    </tr>
                                    <tr class="bg-yellow-50">
                                        <td class="px-6 py-4 font-semibold text-gray-700">Đặc Biệt</td>
                                        <td class="px-6 py-4 font-mono text-red-600 font-bold text-2xl"><?php echo $result['special']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
            <h4 class="font-bold text-blue-900 mb-2">💡 Mẹo Tra Cứu</h4>
            <ul class="space-y-1 text-sm text-blue-800">
                <li>• Sử dụng bộ lọc trên để tìm kết quả nhanh hơn</li>
                <li>• Nhấn "Chi tiết" để xem đầy đủ các giải thưởng</li>
                <li>• Chọn ngày cụ thể để tra cứu kết quả ngày đó</li>
                <li>• Dữ liệu được lưu trữ và cập nhật liên tục</li>
            </ul>
        </div>
    </main>

    <script>
        function changeRegion(region) {
            const days = new URLSearchParams(window.location.search).get('days') || '30';
            window.location.href = `?action=history&region=${region}&days=${days}`;
        }

        function changeDays(days) {
            const region = new URLSearchParams(window.location.search).get('region') || 'XSMB';
            window.location.href = `?action=history&region=${region}&days=${days}`;
        }

        function quickDateSearch(date) {
            if (date) {
                const region = new URLSearchParams(window.location.search).get('region') || 'XSMB';
                window.location.href = `?action=results&region=${region}&date=${date}`;
            }
        }

        function toggleDetail(id) {
            const element = document.getElementById(id);
            element.classList.toggle('hidden');
        }

        // Highlight current region
        const currentRegion = new URLSearchParams(window.location.search).get('region') || 'XSMB';
        document.querySelectorAll('[id^="region-"]').forEach(btn => {
            const region = btn.id.replace('region-', '');
            if (region === currentRegion) {
                btn.className = 'flex-1 px-4 py-2 rounded-lg font-semibold bg-blue-600 text-white';
            } else {
                btn.className = 'flex-1 px-4 py-2 rounded-lg font-semibold bg-gray-200 text-gray-700';
            }
        });
    </script>
</body>
</html>
