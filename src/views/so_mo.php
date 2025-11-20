<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sổ Mơ - Giải Mã Giấc Mơ | <?= SITE_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
        
        .dream-card {
            transition: all 0.3s ease;
        }
        
        .dream-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .number-badge {
            transition: all 0.2s ease;
        }
        
        .number-badge:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
        
        .category-tab {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .category-tab:hover {
            transform: translateY(-2px);
        }
        
        .category-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 via-white to-blue-50 min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-700 text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="?action=home" class="text-2xl">🏠</a>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold">🌙 Sổ Mơ</h1>
                        <p class="text-sm text-purple-200">Giải Mã Giấc Mơ - Tìm Số May Mắn</p>
                    </div>
                </div>
                <a href="?action=home" class="text-white hover:text-purple-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-6 max-w-6xl">
        <!-- Search Section -->
        <div class="mb-8 fade-in-up">
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">🔮 Tìm Kiếm Giấc Mơ</h2>
                    <p class="text-gray-600">Nhập từ khóa hoặc mô tả giấc mơ của bạn</p>
                </div>
                
                <!-- Search Input -->
                <div class="relative mb-4">
                    <input 
                        type="text" 
                        id="searchInput" 
                        placeholder="Ví dụ: con rắn, tiền bạc, mưa, bay..." 
                        class="search-input w-full px-6 py-4 text-lg border-2 border-purple-200 rounded-xl focus:outline-none focus:border-purple-500 transition-all"
                        autocomplete="off"
                    >
                    <button 
                        id="searchBtn"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all font-semibold"
                    >
                        Tìm Kiếm
                    </button>
                </div>
                
                <!-- Quick Search Tags -->
                <div class="flex flex-wrap gap-2 justify-center">
                    <span class="text-sm text-gray-500">Tìm nhanh:</span>
                    <button class="quick-search px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm hover:bg-purple-200 transition-colors" data-keyword="con rắn">🐍 con rắn</button>
                    <button class="quick-search px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm hover:bg-purple-200 transition-colors" data-keyword="tiền bạc">💰 tiền bạc</button>
                    <button class="quick-search px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm hover:bg-purple-200 transition-colors" data-keyword="mưa">🌧️ mưa</button>
                    <button class="quick-search px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm hover:bg-purple-200 transition-colors" data-keyword="may mắn">🍀 may mắn</button>
                    <button class="quick-search px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm hover:bg-purple-200 transition-colors" data-keyword="bay">✈️ bay</button>
                </div>
            </div>
        </div>

        <!-- Search Results -->
        <div id="searchResults" class="mb-8 hidden"></div>

        <!-- Category Browser -->
        <div class="fade-in-up">
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 text-center">📚 Danh Mục Giấc Mơ</h2>
                
                <!-- Category Tabs -->
                <div class="flex flex-wrap gap-2 mb-6 justify-center">
                    <button class="category-tab active px-4 py-2 bg-gray-100 rounded-lg font-semibold text-gray-700" data-category="all">
                        🌟 Tất Cả
                    </button>
                    <button class="category-tab px-4 py-2 bg-gray-100 rounded-lg font-semibold text-gray-700" data-category="animals">
                        🐾 Động Vật
                    </button>
                    <button class="category-tab px-4 py-2 bg-gray-100 rounded-lg font-semibold text-gray-700" data-category="objects">
                        🎁 Đồ Vật
                    </button>
                    <button class="category-tab px-4 py-2 bg-gray-100 rounded-lg font-semibold text-gray-700" data-category="people">
                        👥 Con Người
                    </button>
                    <button class="category-tab px-4 py-2 bg-gray-100 rounded-lg font-semibold text-gray-700" data-category="actions">
                        🎬 Hành Động
                    </button>
                    <button class="category-tab px-4 py-2 bg-gray-100 rounded-lg font-semibold text-gray-700" data-category="emotions">
                        ❤️ Cảm Xúc
                    </button>
                    <button class="category-tab px-4 py-2 bg-gray-100 rounded-lg font-semibold text-gray-700" data-category="nature">
                        🌿 Thiên Nhiên
                    </button>
                    <button class="category-tab px-4 py-2 bg-gray-100 rounded-lg font-semibold text-gray-700" data-category="lucky_numbers">
                        🍀 Số May Mắn
                    </button>
                </div>

                <!-- Category Content -->
                <div id="categoryContent" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Will be populated by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Random Suggestions -->
        <div class="mt-8 text-center fade-in-up">
            <button 
                id="randomBtn"
                class="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-8 py-4 rounded-xl text-lg font-bold hover:from-pink-600 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-105"
            >
                🎲 Gợi Ý Ngẫu Nhiên
            </button>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400">
                💡 <strong>Lưu ý:</strong> Sổ mơ chỉ mang tính chất tham khảo và giải trí. 
                Chơi có trách nhiệm! 🙏
            </p>
            <p class="text-gray-500 text-sm mt-2">
                © 2024 <?= SITE_NAME ?>. Tất cả quyền được bảo lưu.
            </p>
        </div>
    </footer>

    <script>
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');
        const searchResults = document.getElementById('searchResults');
        const categoryContent = document.getElementById('categoryContent');
        const randomBtn = document.getElementById('randomBtn');

        // Quick search buttons
        document.querySelectorAll('.quick-search').forEach(btn => {
            btn.addEventListener('click', () => {
                const keyword = btn.getAttribute('data-keyword');
                searchInput.value = keyword;
                performSearch(keyword);
            });
        });

        // Search button click
        searchBtn.addEventListener('click', () => {
            const keyword = searchInput.value.trim();
            if (keyword) {
                performSearch(keyword);
            }
        });

        // Enter key press
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                const keyword = searchInput.value.trim();
                if (keyword) {
                    performSearch(keyword);
                }
            }
        });

        // Perform search
        async function performSearch(keyword) {
            try {
                const response = await fetch(`?action=so_mo_search&keyword=${encodeURIComponent(keyword)}`);
                const data = await response.json();
                displaySearchResults(data);
            } catch (error) {
                console.error('Search error:', error);
                searchResults.innerHTML = `
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                        <p class="text-red-700">❌ Có lỗi xảy ra khi tìm kiếm. Vui lòng thử lại!</p>
                    </div>
                `;
                searchResults.classList.remove('hidden');
            }
        }

        // Display search results
        function displaySearchResults(data) {
            if (data.total_results === 0) {
                searchResults.innerHTML = `
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg shadow-lg fade-in-up">
                        <div class="flex items-center mb-2">
                            <span class="text-3xl mr-3">🔍</span>
                            <h3 class="text-xl font-bold text-yellow-800">Không Tìm Thấy Kết Quả</h3>
                        </div>
                        <p class="text-yellow-700">Không tìm thấy giấc mơ cho từ khóa "<strong>${data.keyword}</strong>"</p>
                        <p class="text-yellow-600 text-sm mt-2">💡 Thử tìm với từ khóa khác hoặc chọn danh mục bên dưới.</p>
                    </div>
                `;
            } else {
                let html = `
                    <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 fade-in-up">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">
                            🔍 Kết Quả Tìm Kiếm: "${data.keyword}"
                        </h3>
                        <p class="text-gray-600 mb-6">Tìm thấy ${data.total_results} kết quả</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                `;

                data.results.forEach(result => {
                    html += createDreamCard(result.dream, result.numbers, result.category);
                });

                html += `
                        </div>
                    </div>
                `;
                searchResults.innerHTML = html;
            }
            searchResults.classList.remove('hidden');
            searchResults.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        // Create dream card HTML
        function createDreamCard(dream, numbers, category) {
            const numbersHtml = numbers.slice(0, 10).map(num => 
                `<span class="number-badge inline-block bg-gradient-to-r from-blue-500 to-purple-600 text-white px-3 py-1 rounded-lg font-bold text-sm m-1">${num}</span>`
            ).join('');

            return `
                <div class="dream-card bg-gradient-to-br from-purple-50 to-blue-50 p-4 rounded-xl border-2 border-purple-200">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-lg font-bold text-gray-800">${dream}</h4>
                        <span class="text-xs bg-purple-200 text-purple-800 px-2 py-1 rounded-full">${category}</span>
                    </div>
                    <div class="flex flex-wrap">
                        ${numbersHtml}
                    </div>
                </div>
            `;
        }

        // Category tabs
        document.querySelectorAll('.category-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Update active state
                document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                const category = tab.getAttribute('data-category');
                loadCategory(category);
            });
        });

        // Load category
        async function loadCategory(category) {
            try {
                const url = category === 'all' 
                    ? '?action=so_mo_all' 
                    : `?action=so_mo_category&category=${category}`;
                
                const response = await fetch(url);
                const data = await response.json();
                displayCategory(data, category);
            } catch (error) {
                console.error('Category load error:', error);
                categoryContent.innerHTML = `
                    <div class="col-span-full text-center text-red-500">
                        ❌ Có lỗi xảy ra khi tải dữ liệu
                    </div>
                `;
            }
        }

        // Display category
        function displayCategory(data, category) {
            let html = '';
            
            if (category === 'all') {
                // Display all categories
                for (const [cat, dreams] of Object.entries(data.all_dreams)) {
                    for (const [dream, numbers] of Object.entries(dreams)) {
                        html += createDreamCard(dream, numbers, getCategoryName(cat));
                    }
                }
            } else {
                // Display single category
                for (const [dream, numbers] of Object.entries(data.dreams)) {
                    html += createDreamCard(dream, numbers, data.category);
                }
            }

            categoryContent.innerHTML = html;
        }

        // Get category name
        function getCategoryName(category) {
            const names = {
                'animals': 'Động Vật',
                'objects': 'Đồ Vật',
                'people': 'Con Người',
                'actions': 'Hành Động',
                'emotions': 'Cảm Xúc',
                'nature': 'Thiên Nhiên',
                'lucky_numbers': 'Số May Mắn'
            };
            return names[category] || category;
        }

        // Random suggestions
        randomBtn.addEventListener('click', async () => {
            try {
                const response = await fetch('?action=so_mo_random&count=6');
                const data = await response.json();
                
                let html = `
                    <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 mt-8 fade-in-up">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                            🎲 Gợi Ý Ngẫu Nhiên
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                `;

                data.forEach(item => {
                    html += createDreamCard(item.dream, item.numbers, item.category);
                });

                html += `
                        </div>
                    </div>
                `;

                // Insert or replace random section
                const existingRandom = document.querySelector('#randomSuggestions');
                if (existingRandom) {
                    existingRandom.remove();
                }
                
                const randomSection = document.createElement('div');
                randomSection.id = 'randomSuggestions';
                randomSection.innerHTML = html;
                randomBtn.parentElement.appendChild(randomSection);
                
                randomSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } catch (error) {
                console.error('Random suggestion error:', error);
            }
        });

        // Load default category on page load
        document.addEventListener('DOMContentLoaded', () => {
            loadCategory('all');
        });
    </script>
</body>
</html>
