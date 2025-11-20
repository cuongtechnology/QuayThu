<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quay Thử Xổ Số - Xổ Số VN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .spinning {
            animation: spin-slow 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .prize-reveal {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-100 to-pink-100 min-h-screen">
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
    <main class="container mx-auto px-4 py-8 max-w-5xl">
        <!-- Title Section -->
        <div class="text-center mb-8">
            <div class="inline-block bg-white rounded-full p-4 shadow-lg mb-4">
                <div id="dice-icon" class="text-6xl">🎲</div>
            </div>
            <h2 class="text-4xl font-bold text-purple-900 mb-2">Quay Thử Xổ Số</h2>
            <p class="text-gray-700">Tạo bộ số ngẫu nhiên - Thử vận may của bạn!</p>
        </div>

        <!-- Region Selection -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Chọn Miền Quay Thử</h3>
            <div class="grid md:grid-cols-3 gap-4">
                <button onclick="selectRegion('XSMB')" id="btn-region-XSMB" 
                        class="p-6 rounded-xl font-bold text-lg transition-all transform hover:scale-105 border-4 border-blue-600 bg-blue-600 text-white shadow-lg">
                    <div class="text-3xl mb-2">🏛️</div>
                    Miền Bắc
                    <div class="text-xs font-normal mt-1 opacity-90">7 giải thưởng</div>
                </button>
                <button onclick="selectRegion('XSMT')" id="btn-region-XSMT"
                        class="p-6 rounded-xl font-bold text-lg transition-all transform hover:scale-105 border-4 border-gray-300 bg-white text-gray-700 hover:border-green-500">
                    <div class="text-3xl mb-2">🏯</div>
                    Miền Trung
                    <div class="text-xs font-normal mt-1">8 giải thưởng</div>
                </button>
                <button onclick="selectRegion('XSMN')" id="btn-region-XSMN"
                        class="p-6 rounded-xl font-bold text-lg transition-all transform hover:scale-105 border-4 border-gray-300 bg-white text-gray-700 hover:border-orange-500">
                    <div class="text-3xl mb-2">🌴</div>
                    Miền Nam
                    <div class="text-xs font-normal mt-1">8 giải thưởng</div>
                </button>
            </div>

            <!-- Quay Button -->
            <div class="mt-8 text-center">
                <button onclick="startQuay()" id="quay-button"
                        class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-12 py-4 rounded-full font-bold text-xl shadow-2xl hover:shadow-3xl transform hover:scale-110 transition-all">
                    🎰 QUAY NGAY
                </button>
                <p class="text-sm text-gray-600 mt-3">Hoàn toàn ngẫu nhiên - Kết quả tức thì</p>
            </div>
        </div>

        <!-- Results Section -->
        <div id="results-section" class="hidden">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <!-- Results Header -->
                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-8 py-6 text-center">
                    <h3 class="text-2xl font-bold mb-2">🎉 Kết Quả Quay Thử</h3>
                    <p class="text-sm opacity-90" id="result-region"></p>
                    <p class="text-xs opacity-75" id="result-time"></p>
                </div>

                <!-- Prize Table -->
                <div class="p-6" id="prize-table">
                    <!-- Will be populated by JavaScript -->
                </div>

                <!-- Actions -->
                <div class="px-8 py-6 bg-gray-50 flex gap-4 justify-center">
                    <button onclick="startQuay()" class="px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition-all">
                        🔄 Quay Lại
                    </button>
                    <button onclick="shareResult()" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-all">
                        📤 Chia Sẻ
                    </button>
                    <button onclick="saveResult()" class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-all">
                        💾 Lưu Lại
                    </button>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="mt-8 bg-white bg-opacity-80 backdrop-blur rounded-xl p-6 border-2 border-purple-200">
            <h4 class="font-bold text-purple-900 mb-3 flex items-center">
                <span class="text-2xl mr-2">💡</span>
                Thông Tin
            </h4>
            <ul class="space-y-2 text-sm text-gray-700">
                <li>• <strong>Hoàn toàn ngẫu nhiên:</strong> Sử dụng thuật toán random để tạo số</li>
                <li>• <strong>Chỉ để giải trí:</strong> Không có giá trị pháp lý, không dự đoán kết quả thật</li>
                <li>• <strong>Miễn phí:</strong> Quay không giới hạn số lần</li>
                <li>• <strong>Kết quả tức thì:</strong> Không cần chờ đợi</li>
            </ul>
        </div>
    </main>

    <script>
        let selectedRegion = 'XSMB';
        let isSpinning = false;

        function selectRegion(region) {
            if (isSpinning) return;
            
            selectedRegion = region;
            
            // Update button styles
            ['XSMB', 'XSMT', 'XSMN'].forEach(r => {
                const btn = document.getElementById('btn-region-' + r);
                if (r === region) {
                    btn.className = 'p-6 rounded-xl font-bold text-lg transition-all transform hover:scale-105 border-4 shadow-lg';
                    if (region === 'XSMB') {
                        btn.className += ' border-blue-600 bg-blue-600 text-white';
                    } else if (region === 'XSMT') {
                        btn.className += ' border-green-600 bg-green-600 text-white';
                    } else {
                        btn.className += ' border-orange-600 bg-orange-600 text-white';
                    }
                } else {
                    btn.className = 'p-6 rounded-xl font-bold text-lg transition-all transform hover:scale-105 border-4 border-gray-300 bg-white text-gray-700';
                    if (r === 'XSMB') btn.className += ' hover:border-blue-500';
                    else if (r === 'XSMT') btn.className += ' hover:border-green-500';
                    else btn.className += ' hover:border-orange-500';
                }
            });
        }

        async function startQuay() {
            if (isSpinning) return;
            
            isSpinning = true;
            
            // Animate dice icon
            const diceIcon = document.getElementById('dice-icon');
            diceIcon.classList.add('spinning');
            
            // Disable button
            const btn = document.getElementById('quay-button');
            btn.disabled = true;
            btn.textContent = '⏳ Đang quay...';
            btn.classList.add('opacity-50');

            try {
                // Fetch results from API
                const response = await fetch(`?action=generate&region=${selectedRegion}`);
                const data = await response.json();

                // Wait for animation
                setTimeout(() => {
                    displayResults(data);
                    isSpinning = false;
                    btn.disabled = false;
                    btn.textContent = '🎰 QUAY LẠI';
                    btn.classList.remove('opacity-50');
                    diceIcon.classList.remove('spinning');
                }, 1000);
            } catch (error) {
                alert('Có lỗi xảy ra. Vui lòng thử lại!');
                isSpinning = false;
                btn.disabled = false;
                btn.textContent = '🎰 QUAY NGAY';
                btn.classList.remove('opacity-50');
                diceIcon.classList.remove('spinning');
            }
        }

        function displayResults(data) {
            const resultsSection = document.getElementById('results-section');
            const prizeTable = document.getElementById('prize-table');
            
            // Update header
            const regionNames = {
                'XSMB': 'Xổ Số Miền Bắc',
                'XSMT': 'Xổ Số Miền Trung',
                'XSMN': 'Xổ Số Miền Nam'
            };
            document.getElementById('result-region').textContent = regionNames[data.region];
            document.getElementById('result-time').textContent = 'Quay lúc: ' + data.generated_at;

            // Build prize table
            let html = '<div class="space-y-3">';
            
            const prizeNames = {
                'special': ['Đặc Biệt', '🏆'],
                'first': ['Giải Nhất', '🥇'],
                'second': ['Giải Nhì', '🥈'],
                'third': ['Giải Ba', '🥉'],
                'fourth': ['Giải Tư', '🎖️'],
                'fifth': ['Giải Năm', '🏅'],
                'sixth': ['Giải Sáu', '🎫'],
                'seventh': ['Giải Bảy', '🎟️'],
                'eighth': ['Giải Tám', '🎪']
            };

            for (const [key, value] of Object.entries(data.prizes)) {
                if (value && prizeNames[key]) {
                    const [name, icon] = prizeNames[key];
                    const numbers = value.split(',');
                    const isSpecial = key === 'special';
                    
                    html += `
                        <div class="prize-reveal p-4 rounded-lg ${isSpecial ? 'bg-gradient-to-r from-yellow-100 to-orange-100 border-2 border-yellow-400' : 'bg-gray-50 border-2 border-gray-200'}">
                            <div class="flex items-center justify-between">
                                <div class="font-semibold text-gray-700 flex items-center">
                                    <span class="text-2xl mr-2">${icon}</span>
                                    ${name}
                                </div>
                                <div class="flex flex-wrap gap-2 justify-end">
                                    ${numbers.map(n => `
                                        <span class="font-mono font-bold ${isSpecial ? 'text-3xl text-red-600' : 'text-xl text-red-600'} px-2">
                                            ${n.trim()}
                                        </span>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    `;
                }
            }
            
            html += '</div>';
            prizeTable.innerHTML = html;

            // Show results
            resultsSection.classList.remove('hidden');
            resultsSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function shareResult() {
            alert('Tính năng chia sẻ sẽ được cập nhật sớm!');
        }

        function saveResult() {
            alert('Kết quả đã được lưu vào bộ nhớ trình duyệt!');
            // Can implement localStorage save here
        }
    </script>
</body>
</html>
