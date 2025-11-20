<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kết quả xổ số trực tiếp 3 miền Bắc Trung Nam - XSMB, XSMT, XSMN nhanh và chính xác nhất">
    <title>Xổ Số VN - Kết Quả XSMB, XSMT, XSMN Hôm Nay</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af',
                        secondary: '#7c3aed',
                        danger: '#dc2626',
                        success: '#16a34a',
                    }
                }
            }
        }
    </script>
    
    <!-- Custom Styles -->
    <style>
        .lottery-number {
            @apply font-bold text-lg text-red-600;
        }
        .prize-row {
            @apply border-b border-gray-200 hover:bg-gray-50 transition-colors;
        }
        .stat-card {
            @apply bg-gradient-to-br from-blue-500 to-purple-600 text-white rounded-lg shadow-lg p-4;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"></path>
                    </svg>
                    <h1 class="text-xl md:text-2xl font-bold">Xổ Số VN</h1>
                </div>
                <div class="text-right">
                    <div class="text-xs md:text-sm opacity-90">
                        <?php 
                        $dayNames = ['Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy'];
                        echo $dayNames[date('w')] . ', ' . date('d/m/Y'); 
                        ?>
                    </div>
                    <div class="text-xs opacity-75">Cập nhật: <?php echo date('H:i'); ?></div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6 max-w-6xl">
        
        <!-- Region Tabs -->
        <div class="mb-6">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="flex border-b">
                    <button onclick="showRegion('XSMB')" id="tab-XSMB" class="flex-1 px-4 py-3 text-center font-semibold transition-colors border-b-2 border-blue-600 text-blue-600 bg-blue-50">
                        XSMB
                    </button>
                    <button onclick="showRegion('XSMT')" id="tab-XSMT" class="flex-1 px-4 py-3 text-center font-semibold transition-colors text-gray-600 hover:bg-gray-50">
                        XSMT
                    </button>
                    <button onclick="showRegion('XSMN')" id="tab-XSMN" class="flex-1 px-4 py-3 text-center font-semibold transition-colors text-gray-600 hover:bg-gray-50">
                        XSMN
                    </button>
                </div>
            </div>
        </div>

        <!-- XSMB Results -->
        <div id="region-XSMB" class="region-content">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-3">
                    <h2 class="text-lg md:text-xl font-bold">Kết Quả Xổ Số Miền Bắc - XSMB</h2>
                    <p class="text-sm opacity-90"><?php echo $data['xsmb']['draw_day'] ?? ''; ?> - <?php echo date('d/m/Y', strtotime($data['today'])); ?></p>
                </div>
                
                <?php if ($data['xsmb']): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <tbody>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700 w-32">Đặc Biệt</td>
                                <td class="px-4 py-3">
                                    <span class="text-2xl md:text-3xl font-bold text-red-600 tracking-wider">
                                        <?php echo $data['xsmb']['special']; ?>
                                    </span>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Nhất</td>
                                <td class="px-4 py-3">
                                    <span class="lottery-number text-xl md:text-2xl"><?php echo $data['xsmb']['first']; ?></span>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Nhì</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $data['xsmb']['second']) as $num): ?>
                                            <span class="lottery-number"><?php echo trim($num); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Ba</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $data['xsmb']['third']) as $num): ?>
                                            <span class="lottery-number"><?php echo trim($num); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Tư</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $data['xsmb']['fourth']) as $num): ?>
                                            <span class="lottery-number"><?php echo trim($num); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Năm</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $data['xsmb']['fifth']) as $num): ?>
                                            <span class="lottery-number"><?php echo trim($num); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Sáu</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $data['xsmb']['sixth']) as $num): ?>
                                            <span class="lottery-number"><?php echo trim($num); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Bảy</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $data['xsmb']['seventh']) as $num): ?>
                                            <span class="lottery-number"><?php echo trim($num); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="p-8 text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p>Chưa có kết quả. Vui lòng quay lại sau.</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Head/Tail Statistics -->
            <?php if ($data['headTailStats']): ?>
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <!-- Head Stats -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-3">
                        <h3 class="font-bold">📊 Bảng Đầu</h3>
                    </div>
                    <div class="p-4">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2 font-semibold">Đầu</th>
                                    <th class="text-left py-2 font-semibold">Đuôi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['headTailStats']['head'] as $digit => $numbers): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-2 font-bold text-blue-600"><?php echo $digit; ?></td>
                                    <td class="py-2">
                                        <?php echo $numbers ? implode(', ', array_unique($numbers)) : '-'; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tail Stats -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white px-4 py-3">
                        <h3 class="font-bold">📊 Bảng Đuôi</h3>
                    </div>
                    <div class="p-4">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2 font-semibold">Đuôi</th>
                                    <th class="text-left py-2 font-semibold">Đầu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['headTailStats']['tail'] as $digit => $numbers): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-2 font-bold text-purple-600"><?php echo $digit; ?></td>
                                    <td class="py-2">
                                        <?php echo $numbers ? implode(', ', array_unique($numbers)) : '-'; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Statistics Cards -->
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <!-- Hot Numbers -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 py-3">
                        <h3 class="font-bold">🔥 Top 10 Số Nóng</h3>
                        <p class="text-xs opacity-90">Xuất hiện nhiều nhất (30 kỳ)</p>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                            <?php foreach ($data['hotNumbers'] as $index => $stat): ?>
                            <div class="flex items-center justify-between p-2 rounded hover:bg-orange-50">
                                <div class="flex items-center space-x-3">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-600 font-bold text-sm">
                                        <?php echo $index + 1; ?>
                                    </span>
                                    <span class="text-2xl font-bold text-red-600"><?php echo $stat['number']; ?></span>
                                </div>
                                <span class="text-sm font-semibold text-gray-600">
                                    <?php echo $stat['frequency']; ?> lần
                                </span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Cold Numbers -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white px-4 py-3">
                        <h3 class="font-bold">❄️ Top 10 Lô Gan</h3>
                        <p class="text-xs opacity-90">Lâu chưa về nhất (30 kỳ)</p>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                            <?php foreach ($data['coldNumbers'] as $index => $stat): ?>
                            <div class="flex items-center justify-between p-2 rounded hover:bg-blue-50">
                                <div class="flex items-center space-x-3">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold text-sm">
                                        <?php echo $index + 1; ?>
                                    </span>
                                    <span class="text-2xl font-bold text-blue-600"><?php echo $stat['number']; ?></span>
                                </div>
                                <span class="text-sm font-semibold text-gray-600">
                                    <?php echo $stat['days_since_last']; ?> kỳ
                                </span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- XSMT Results -->
        <div id="region-XSMT" class="region-content hidden">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-3">
                    <h2 class="text-lg md:text-xl font-bold">Kết Quả Xổ Số Miền Trung - XSMT</h2>
                    <p class="text-sm opacity-90"><?php echo $data['xsmt']['draw_day'] ?? ''; ?> - <?php echo date('d/m/Y', strtotime($data['today'])); ?></p>
                </div>
                
                <?php if ($data['xsmt']): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <tbody>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700 w-32">Tỉnh</td>
                                <td class="px-4 py-3">
                                    <span class="font-bold text-green-600"><?php echo $data['xsmt']['province']; ?></span>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Tám</td>
                                <td class="px-4 py-3">
                                    <span class="lottery-number"><?php echo $data['xsmt']['eighth']; ?></span>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Bảy</td>
                                <td class="px-4 py-3">
                                    <span class="lottery-number"><?php echo $data['xsmt']['seventh']; ?></span>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Sáu</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $data['xsmt']['sixth']) as $num): ?>
                                            <span class="lottery-number"><?php echo trim($num); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Năm</td>
                                <td class="px-4 py-3">
                                    <span class="lottery-number"><?php echo $data['xsmt']['fifth']; ?></span>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Tư</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $data['xsmt']['fourth']) as $num): ?>
                                            <span class="lottery-number"><?php echo trim($num); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Ba</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $data['xsmt']['third']) as $num): ?>
                                            <span class="lottery-number"><?php echo trim($num); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Nhì</td>
                                <td class="px-4 py-3">
                                    <span class="lottery-number text-xl md:text-2xl"><?php echo $data['xsmt']['second']; ?></span>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Nhất</td>
                                <td class="px-4 py-3">
                                    <span class="lottery-number text-xl md:text-2xl"><?php echo $data['xsmt']['first']; ?></span>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Đặc Biệt</td>
                                <td class="px-4 py-3">
                                    <span class="text-2xl md:text-3xl font-bold text-red-600 tracking-wider">
                                        <?php echo $data['xsmt']['special']; ?>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="p-8 text-center text-gray-500">
                    <p>Chưa có kết quả. Vui lòng quay lại sau.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- XSMN Results -->
        <div id="region-XSMN" class="region-content hidden">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white px-4 py-3">
                    <h2 class="text-lg md:text-xl font-bold">Kết Quả Xổ Số Miền Nam - XSMN</h2>
                    <p class="text-sm opacity-90"><?php echo $data['xsmn']['draw_day'] ?? ''; ?> - <?php echo date('d/m/Y', strtotime($data['today'])); ?></p>
                </div>
                
                <?php if ($data['xsmn']): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <tbody>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700 w-32">Tỉnh</td>
                                <td class="px-4 py-3">
                                    <span class="font-bold text-orange-600"><?php echo $data['xsmn']['province']; ?></span>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Tám</td>
                                <td class="px-4 py-3">
                                    <span class="lottery-number"><?php echo $data['xsmn']['eighth']; ?></span>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Bảy</td>
                                <td class="px-4 py-3">
                                    <span class="lottery-number"><?php echo $data['xsmn']['seventh']; ?></span>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Sáu</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $data['xsmn']['sixth']) as $num): ?>
                                            <span class="lottery-number"><?php echo trim($num); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Năm</td>
                                <td class="px-4 py-3">
                                    <span class="lottery-number"><?php echo $data['xsmn']['fifth']; ?></span>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Tư</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $data['xsmn']['fourth']) as $num): ?>
                                            <span class="lottery-number"><?php echo trim($num); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Ba</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $data['xsmn']['third']) as $num): ?>
                                            <span class="lottery-number"><?php echo trim($num); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Nhì</td>
                                <td class="px-4 py-3">
                                    <span class="lottery-number text-xl md:text-2xl"><?php echo $data['xsmn']['second']; ?></span>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Giải Nhất</td>
                                <td class="px-4 py-3">
                                    <span class="lottery-number text-xl md:text-2xl"><?php echo $data['xsmn']['first']; ?></span>
                                </td>
                            </tr>
                            <tr class="prize-row">
                                <td class="px-4 py-3 font-semibold text-gray-700">Đặc Biệt</td>
                                <td class="px-4 py-3">
                                    <span class="text-2xl md:text-3xl font-bold text-red-600 tracking-wider">
                                        <?php echo $data['xsmn']['special']; ?>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="p-8 text-center text-gray-500">
                    <p>Chưa có kết quả. Vui lòng quay lại sau.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quay Thử Feature -->
        <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg shadow-lg p-6 text-white mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-xl font-bold mb-1">🎲 Quay Thử</h3>
                    <p class="text-sm opacity-90">Tạo số ngẫu nhiên để dự đoán</p>
                </div>
                <button onclick="generateRandom()" class="bg-white text-purple-600 px-6 py-2 rounded-lg font-semibold hover:bg-purple-50 transition-colors shadow-md">
                    Quay Ngay
                </button>
            </div>
            <div id="random-result" class="hidden mt-4 bg-white bg-opacity-20 rounded-lg p-4 backdrop-blur">
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2" id="random-special"></div>
                    <div class="text-sm opacity-90">Đặc biệt</div>
                </div>
            </div>
        </div>

        <!-- Important Notice -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-yellow-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h4 class="font-bold text-yellow-800 mb-1">Lưu ý quan trọng</h4>
                    <p class="text-sm text-yellow-700">
                        ✓ Kết quả cập nhật nhanh & chính xác | <strong>XSMN</strong>: 16h15 | <strong>XSMT</strong>: 17h15 | <strong>XSMB</strong>: 18h15
                    </p>
                    <p class="text-sm text-yellow-700 mt-1">
                        ⚠️ Thông tin tham khảo - Kết quả chính thức do công ty xổ số công bố
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12 py-6">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm opacity-75">© 2025 Xổ Số VN. Kết quả chỉ mang tính chất tham khảo.</p>
            <p class="text-xs opacity-50 mt-2">Made with ❤️ using PHP, SQLite3 & TailwindCSS</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        function showRegion(region) {
            // Hide all regions
            document.querySelectorAll('.region-content').forEach(el => {
                el.classList.add('hidden');
            });
            
            // Remove active state from all tabs
            document.querySelectorAll('[id^="tab-"]').forEach(tab => {
                tab.classList.remove('border-blue-600', 'text-blue-600', 'bg-blue-50');
                tab.classList.add('text-gray-600');
            });
            
            // Show selected region
            document.getElementById('region-' + region).classList.remove('hidden');
            
            // Activate selected tab
            const activeTab = document.getElementById('tab-' + region);
            activeTab.classList.add('border-blue-600', 'text-blue-600', 'bg-blue-50');
            activeTab.classList.remove('text-gray-600');
        }

        async function generateRandom() {
            const region = document.querySelector('[id^="tab-"][class*="border-blue-600"]').id.replace('tab-', '');
            
            try {
                const response = await fetch(`?action=generate&region=${region}`);
                const data = await response.json();
                
                if (data && data.prizes) {
                    document.getElementById('random-special').textContent = data.prizes.special;
                    document.getElementById('random-result').classList.remove('hidden');
                    
                    // Show animation
                    const resultEl = document.getElementById('random-result');
                    resultEl.style.animation = 'none';
                    setTimeout(() => {
                        resultEl.style.animation = 'pulse 0.5s ease-in-out';
                    }, 10);
                }
            } catch (error) {
                console.error('Error generating random numbers:', error);
            }
        }

        // Auto-refresh every 5 minutes
        setInterval(() => {
            location.reload();
        }, 300000);
    </script>
</body>
</html>
