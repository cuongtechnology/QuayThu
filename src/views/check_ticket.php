<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dò Vé Số - Xổ Số VN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg">
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
    <main class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Title -->
            <div class="bg-gradient-to-r from-green-500 to-blue-500 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">🎫 Dò Vé Số</h2>
                <p class="text-sm opacity-90 mt-1">Kiểm tra vé số của bạn nhanh chóng và chính xác</p>
            </div>

            <!-- Check Form -->
            <div class="p-6">
                <!-- Region Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Chọn miền</label>
                    <div class="flex gap-3">
                        <button onclick="selectRegion('XSMB')" id="btn-XSMB" class="flex-1 px-4 py-3 rounded-lg font-semibold transition-all border-2 border-blue-600 bg-blue-600 text-white">
                            XSMB
                        </button>
                        <button onclick="selectRegion('XSMT')" id="btn-XSMT" class="flex-1 px-4 py-3 rounded-lg font-semibold transition-all border-2 border-gray-300 text-gray-700 hover:border-green-500">
                            XSMT
                        </button>
                        <button onclick="selectRegion('XSMN')" id="btn-XSMN" class="flex-1 px-4 py-3 rounded-lg font-semibold transition-all border-2 border-gray-300 text-gray-700 hover:border-orange-500">
                            XSMN
                        </button>
                    </div>
                </div>

                <!-- Date Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ngày quay số</label>
                    <input type="date" id="check-date" value="<?php echo date('Y-m-d'); ?>" 
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none">
                </div>

                <!-- Number Input -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nhập số cần dò</label>
                    <input type="text" id="ticket-number" placeholder="Ví dụ: 123, 45, 6789" 
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none text-xl font-mono"
                           maxlength="10">
                    <p class="text-sm text-gray-500 mt-2">💡 Nhập ít nhất 2 chữ số cuối của vé</p>
                </div>

                <!-- Check Button -->
                <button onclick="checkTicket()" 
                        class="w-full bg-gradient-to-r from-green-500 to-blue-500 text-white px-6 py-4 rounded-lg font-bold text-lg hover:shadow-lg transition-all">
                    🔍 Kiểm Tra Ngay
                </button>

                <!-- Multiple Numbers Section -->
                <div class="mt-6 pt-6 border-t">
                    <button onclick="toggleMultipleCheck()" class="text-blue-600 hover:underline font-semibold">
                        📋 Dò nhiều số cùng lúc
                    </button>
                    
                    <div id="multiple-check-section" class="hidden mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nhập các số cần dò (mỗi số một dòng)</label>
                        <textarea id="multiple-numbers" rows="6" placeholder="12&#10;34&#10;56&#10;78"
                                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none font-mono"></textarea>
                        <button onclick="checkMultipleTickets()" 
                                class="w-full mt-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white px-6 py-3 rounded-lg font-bold hover:shadow-lg transition-all">
                            🔍 Kiểm Tra Tất Cả
                        </button>
                    </div>
                </div>
            </div>

            <!-- Result Section -->
            <div id="result-section" class="hidden px-6 pb-6">
                <div class="bg-gray-50 rounded-lg p-6 border-2 border-gray-200">
                    <div id="result-content"></div>
                </div>
            </div>
        </div>

        <!-- How to use -->
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
            <h3 class="font-bold text-blue-900 mb-3">📖 Hướng dẫn sử dụng</h3>
            <ul class="space-y-2 text-sm text-blue-800">
                <li>✓ <strong>Bước 1:</strong> Chọn miền (Bắc/Trung/Nam) tương ứng với vé của bạn</li>
                <li>✓ <strong>Bước 2:</strong> Chọn ngày quay số</li>
                <li>✓ <strong>Bước 3:</strong> Nhập số cần dò (ít nhất 2 chữ số cuối)</li>
                <li>✓ <strong>Bước 4:</strong> Nhấn "Kiểm Tra Ngay" để xem kết quả</li>
                <li>💡 <strong>Mẹo:</strong> Bạn có thể dò nhiều số cùng lúc để tiết kiệm thời gian!</li>
            </ul>
        </div>
    </main>

    <script>
        let selectedRegion = 'XSMB';

        function selectRegion(region) {
            selectedRegion = region;
            
            // Update button styles
            ['XSMB', 'XSMT', 'XSMN'].forEach(r => {
                const btn = document.getElementById('btn-' + r);
                if (r === region) {
                    btn.className = 'flex-1 px-4 py-3 rounded-lg font-semibold transition-all border-2 ';
                    if (region === 'XSMB') btn.className += 'border-blue-600 bg-blue-600 text-white';
                    else if (region === 'XSMT') btn.className += 'border-green-600 bg-green-600 text-white';
                    else btn.className += 'border-orange-600 bg-orange-600 text-white';
                } else {
                    btn.className = 'flex-1 px-4 py-3 rounded-lg font-semibold transition-all border-2 border-gray-300 text-gray-700 hover:border-gray-400';
                }
            });
        }

        function toggleMultipleCheck() {
            const section = document.getElementById('multiple-check-section');
            section.classList.toggle('hidden');
        }

        async function checkTicket() {
            const number = document.getElementById('ticket-number').value.trim();
            const date = document.getElementById('check-date').value;

            if (!number) {
                alert('Vui lòng nhập số cần dò!');
                return;
            }

            try {
                const response = await fetch(`?action=check_ticket&number=${number}&region=${selectedRegion}&date=${date}`);
                const data = await response.json();

                displayResult(data);
            } catch (error) {
                alert('Có lỗi xảy ra. Vui lòng thử lại!');
            }
        }

        function displayResult(data) {
            const resultSection = document.getElementById('result-section');
            const resultContent = document.getElementById('result-content');

            if (!data.success) {
                resultContent.innerHTML = `
                    <div class="text-center text-red-600">
                        <p class="font-bold text-lg">❌ ${data.error}</p>
                    </div>
                `;
                resultSection.classList.remove('hidden');
                return;
            }

            if (data.has_won) {
                let matchesHtml = '';
                data.matches.forEach(match => {
                    matchesHtml += `
                        <div class="bg-green-100 border-2 border-green-500 rounded-lg p-4 mb-3">
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-green-700">${match.number}</span>
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    ${match.match_type}
                                </span>
                            </div>
                        </div>
                    `;
                });

                resultContent.innerHTML = `
                    <div class="text-center mb-4">
                        <div class="text-6xl mb-2">🎉</div>
                        <h3 class="text-2xl font-bold text-green-600 mb-2">CHÚC MỪNG!</h3>
                        <p class="text-gray-700">Số <strong class="text-xl">${data.number}</strong> trúng thưởng!</p>
                    </div>
                    <div class="mt-4">
                        <h4 class="font-bold text-gray-700 mb-3">Các số trúng:</h4>
                        ${matchesHtml}
                    </div>
                `;
            } else {
                resultContent.innerHTML = `
                    <div class="text-center">
                        <div class="text-6xl mb-2">😢</div>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Rất tiếc!</h3>
                        <p class="text-gray-600">Số <strong class="text-xl">${data.number}</strong> không trúng thưởng.</p>
                        <p class="text-sm text-gray-500 mt-3">Chúc bạn may mắn lần sau!</p>
                    </div>
                `;
            }

            resultSection.classList.remove('hidden');
            resultSection.scrollIntoView({ behavior: 'smooth' });
        }

        async function checkMultipleTickets() {
            const numbersText = document.getElementById('multiple-numbers').value.trim();
            const date = document.getElementById('check-date').value;

            if (!numbersText) {
                alert('Vui lòng nhập các số cần dò!');
                return;
            }

            const numbers = numbersText.split('\n').map(n => n.trim()).filter(n => n);

            try {
                const formData = new FormData();
                formData.append('numbers', JSON.stringify(numbers));

                const response = await fetch(`?action=check_multiple&region=${selectedRegion}&date=${date}`, {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                displayMultipleResults(data);
            } catch (error) {
                alert('Có lỗi xảy ra. Vui lòng thử lại!');
            }
        }

        function displayMultipleResults(data) {
            const resultSection = document.getElementById('result-section');
            const resultContent = document.getElementById('result-content');

            let resultsHtml = `
                <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                    <h3 class="font-bold text-lg mb-2">Tổng kết</h3>
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div>
                            <div class="text-3xl font-bold text-blue-600">${data.total_numbers}</div>
                            <div class="text-sm text-gray-600">Tổng số kiểm tra</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-green-600">${data.total_winners}</div>
                            <div class="text-sm text-gray-600">Số trúng thưởng</div>
                        </div>
                    </div>
                </div>
                <div class="space-y-3">
            `;

            data.results.forEach(result => {
                if (result.success) {
                    const statusClass = result.has_won ? 'bg-green-100 border-green-500 text-green-700' : 'bg-gray-100 border-gray-300 text-gray-600';
                    const icon = result.has_won ? '✓' : '✗';
                    
                    resultsHtml += `
                        <div class="border-2 ${statusClass} rounded-lg p-3 flex items-center justify-between">
                            <span class="font-mono text-lg font-bold">${result.number}</span>
                            <span class="font-bold">${icon} ${result.has_won ? 'Trúng' : 'Không trúng'}</span>
                        </div>
                    `;
                }
            });

            resultsHtml += '</div>';
            resultContent.innerHTML = resultsHtml;
            resultSection.classList.remove('hidden');
            resultSection.scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>
