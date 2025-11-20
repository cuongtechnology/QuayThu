# 🎲 Xổ Số VN - Vietnam Lottery Web Application

A modern, mobile-first web application for displaying Vietnamese lottery results (XSMB, XSMT, XSMN) built with PHP, SQLite3, and TailwindCSS.

## ✨ Features

### 🎯 Core Features
- **Real-time Lottery Results**: Display results for all 3 regions (North, Central, South)
- **Mobile-First Design**: Optimized for mobile devices with responsive layout
- **Statistics & Analytics**:
  - 🔥 Hot Numbers (most frequent)
  - ❄️ Cold Numbers (least frequent / gan)
  - 📊 Head/Tail Analysis
  - 📈 Frequency Statistics (30-day period)
- **Random Number Generator**: "Quay Thử" feature for prediction simulation
- **Historical Data**: Store and retrieve past lottery results
- **Fast Performance**: SQLite3 database with optimized queries

### 🎨 Design Features
- Modern gradient UI with TailwindCSS
- Smooth transitions and hover effects
- Responsive tables for all screen sizes
- Color-coded results by region
- Auto-refresh every 5 minutes

## 🏗️ Technology Stack

- **Backend**: PHP 7.4+
- **Database**: SQLite3
- **Frontend**: TailwindCSS 3.x (CDN)
- **Architecture**: MVC Pattern
  - Models: Data operations
  - Controllers: Business logic
  - Views: Presentation layer
  - Services: External data fetching

## 📁 Project Structure

```
webapp/
├── config/
│   ├── config.php          # Main configuration
│   └── database.php        # Database setup & connection
├── database/
│   └── xoso.db             # SQLite database (auto-created)
├── public/
│   ├── index.php           # Entry point & routing
│   └── .htaccess           # URL rewriting rules
├── src/
│   ├── controllers/
│   │   └── HomeController.php
│   ├── models/
│   │   └── LotteryModel.php
│   ├── services/
│   │   └── LotteryService.php
│   └── views/
│       └── home.php        # Main view template
└── assets/                 # Static assets (CSS, JS, images)
```

## 🚀 Installation

### Prerequisites
- PHP 7.4 or higher
- SQLite3 extension enabled
- Apache/Nginx web server
- mod_rewrite enabled (for Apache)

### Setup Steps

1. **Clone or download the project**
```bash
cd /path/to/webroot
git clone <repository-url> xoso-vn
cd xoso-vn
```

2. **Set permissions**
```bash
chmod -R 755 .
chmod -R 777 database/
```

3. **Configure web server**

**For Apache:**
- Ensure `public/` is your document root
- Enable mod_rewrite
- The `.htaccess` file is already configured

**For Nginx:**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/xoso-vn/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

4. **Initialize database**
```bash
php -r "require 'config/database.php'; Database::getInstance();"
```

5. **Access the application**
Open your browser and navigate to: `http://localhost` or your configured domain

## 🎮 Usage

### Main Page
- View today's lottery results for all regions
- Switch between XSMB, XSMT, XSMN tabs
- See statistics and hot/cold numbers
- Use "Quay Thử" to generate random numbers

### API Endpoints

**Get results for specific region and date:**
```
GET /?action=results&region=XSMB&date=2025-11-20
```

**Get statistics:**
```
GET /?action=statistics&region=XSMB&period=30
```

**Generate random numbers:**
```
GET /?action=generate&region=XSMB
```

## 📊 Database Schema

### lottery_results
Stores lottery draw results
- `region`: XSMB, XSMT, or XSMN
- `province`: Province name (for XSMT/XSMN)
- `draw_date`: Date of the draw
- `special` to `eighth`: Prize numbers

### statistics
Stores frequency statistics
- `region`: Region code
- `number`: 2-digit number
- `frequency`: Appearance count
- `last_appeared`: Last appearance date
- `days_since_last`: Days since last appearance

### head_tail_stats
Stores head/tail analysis data

## 🔧 Configuration

Edit `config/config.php` to customize:

- **Database path**: `DB_PATH`
- **Timezone**: Default is `Asia/Ho_Chi_Minh`
- **Update schedule**: Times when results are published
- **Cache duration**: How long to cache results
- **API endpoints**: External data sources

## 🎨 Customization

### Changing Colors
Modify the TailwindCSS configuration in `src/views/home.php`:
```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: '#1e40af',    // Change this
                secondary: '#7c3aed',  // Change this
                // ...
            }
        }
    }
}
```

### Adding New Regions
1. Update `REGIONS` constant in `config/config.php`
2. Add prize structure in config
3. Create corresponding views

## 📈 Performance Tips

1. **Enable caching**: Results are cached for 5 minutes by default
2. **Database optimization**: Indexes are created automatically
3. **Asset optimization**: Enable gzip compression (already in .htaccess)
4. **CDN**: Consider hosting TailwindCSS locally for production

## 🔒 Security Considerations

- SQLite database is stored outside public directory
- Prepared statements prevent SQL injection
- XSS protection headers enabled
- Input validation on all user inputs
- CSRF tokens recommended for forms (implement if needed)

## 🐛 Troubleshooting

**Database not created:**
```bash
# Check SQLite3 is installed
php -m | grep sqlite3

# Create database directory manually
mkdir -p database
chmod 777 database
```

**Permission errors:**
```bash
# Fix permissions
chmod -R 755 .
chmod -R 777 database/
```

**URL rewriting not working:**
- Ensure mod_rewrite is enabled (Apache)
- Check .htaccess file exists in public/
- Verify AllowOverride is set to All

## 📱 Mobile Optimization

- Responsive breakpoints: `sm:`, `md:`, `lg:`, `xl:`
- Touch-friendly buttons and links
- Optimized table scrolling
- Readable font sizes on small screens

## 🔮 Future Enhancements

- [ ] Real web scraping implementation
- [ ] Push notifications for new results
- [ ] User accounts and saved numbers
- [ ] Advanced prediction algorithms
- [ ] Multi-language support
- [ ] Dark mode
- [ ] Progressive Web App (PWA)
- [ ] Social sharing features

## 📄 License

This project is open source and available for educational purposes.

## ⚠️ Disclaimer

This application is for informational purposes only. Official lottery results are published by the respective lottery companies. Always verify results with official sources.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📞 Support

For issues and questions, please open an issue on the repository.

---

**Made with ❤️ in Vietnam**
