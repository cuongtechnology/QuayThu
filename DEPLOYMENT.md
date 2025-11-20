# 🚀 Deployment Guide - Xổ Số VN

## Quick Start with PHP Built-in Server

For development and testing purposes:

```bash
cd /home/user/webapp/public
php -S 0.0.0.0:8080
```

Then access: `http://localhost:8080`

## Production Deployment

### Option 1: Apache with mod_php (Recommended)

1. **Configure Apache Virtual Host**

```apache
<VirtualHost *:80>
    ServerName xoso.yourdomain.com
    DocumentRoot /var/www/xoso-vn/public
    
    <Directory /var/www/xoso-vn/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    # Security headers
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-XSS-Protection "1; mode=block"
    
    # Enable compression
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
    
    ErrorLog ${APACHE_LOG_DIR}/xoso-error.log
    CustomLog ${APACHE_LOG_DIR}/xoso-access.log combined
</VirtualHost>
```

2. **Enable required Apache modules**

```bash
sudo a2enmod rewrite headers deflate expires
sudo systemctl restart apache2
```

3. **Set permissions**

```bash
cd /var/www/xoso-vn
sudo chown -R www-data:www-data .
sudo chmod -R 755 .
sudo chmod -R 777 database/
```

### Option 2: Nginx with PHP-FPM

1. **Configure Nginx**

```nginx
server {
    listen 80;
    server_name xoso.yourdomain.com;
    root /var/www/xoso-vn/public;
    index index.php index.html;
    
    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    
    # Gzip compression
    gzip on;
    gzip_types text/plain text/css text/xml text/javascript application/javascript application/json;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    # Deny access to sensitive files
    location ~ /\. {
        deny all;
    }
    
    location ~ /database/ {
        deny all;
    }
    
    access_log /var/log/nginx/xoso-access.log;
    error_log /var/log/nginx/xoso-error.log;
}
```

2. **Enable site and restart Nginx**

```bash
sudo ln -s /etc/nginx/sites-available/xoso /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### Option 3: Docker Deployment

Create `Dockerfile`:

```dockerfile
FROM php:8.2-apache

# Install SQLite3
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Enable Apache modules
RUN a2enmod rewrite headers deflate expires

# Copy application files
COPY . /var/www/html/
COPY public/.htaccess /var/www/html/.htaccess

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && mkdir -p /var/www/html/database \
    && chmod 777 /var/www/html/database

# Configure Apache DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80

CMD ["apache2-foreground"]
```

Create `docker-compose.yml`:

```yaml
version: '3.8'

services:
  xoso-vn:
    build: .
    ports:
      - "8080:80"
    volumes:
      - ./database:/var/www/html/database
    restart: unless-stopped
    environment:
      - TZ=Asia/Ho_Chi_Minh
```

Build and run:

```bash
docker-compose up -d
```

## SSL/HTTPS Setup

### Using Let's Encrypt (Certbot)

```bash
sudo apt-get install certbot python3-certbot-apache
sudo certbot --apache -d xoso.yourdomain.com
```

For Nginx:

```bash
sudo apt-get install certbot python3-certbot-nginx
sudo certbot --nginx -d xoso.yourdomain.com
```

## Performance Optimization

### 1. Enable OPcache

Edit `/etc/php/8.2/apache2/php.ini` (or `/etc/php/8.2/fpm/php.ini` for Nginx):

```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
```

### 2. PHP-FPM Optimization

Edit `/etc/php/8.2/fpm/pool.d/www.conf`:

```ini
pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35
```

### 3. Database Optimization

SQLite is already optimized with indexes. For high traffic:

```bash
# Vacuum database periodically
sqlite3 database/xoso.db "VACUUM;"

# Analyze for query optimization
sqlite3 database/xoso.db "ANALYZE;"
```

### 4. Caching Strategy

Consider implementing Redis or Memcached:

```bash
sudo apt-get install redis-server php-redis
```

## Monitoring

### 1. Setup Error Logging

Edit `php.ini`:

```ini
error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT
log_errors = On
error_log = /var/log/php/error.log
```

### 2. Application Monitoring

Monitor key files:

```bash
# Watch error logs
tail -f /var/log/apache2/xoso-error.log

# Monitor database size
watch -n 60 'du -h database/xoso.db'
```

## Backup Strategy

### Automated Backup Script

Create `/usr/local/bin/backup-xoso.sh`:

```bash
#!/bin/bash

BACKUP_DIR="/var/backups/xoso"
DB_PATH="/var/www/xoso-vn/database/xoso.db"
DATE=$(date +%Y%m%d_%H%M%S)

mkdir -p $BACKUP_DIR

# Backup database
sqlite3 $DB_PATH ".backup '$BACKUP_DIR/xoso_$DATE.db'"

# Compress
gzip $BACKUP_DIR/xoso_$DATE.db

# Remove old backups (keep last 30 days)
find $BACKUP_DIR -name "*.gz" -mtime +30 -delete

echo "Backup completed: xoso_$DATE.db.gz"
```

Make executable and add to cron:

```bash
sudo chmod +x /usr/local/bin/backup-xoso.sh
sudo crontab -e

# Add this line for daily backup at 2 AM
0 2 * * * /usr/local/bin/backup-xoso.sh
```

## Security Checklist

- [ ] Change database file permissions to 600 in production
- [ ] Disable directory listing (already in .htaccess)
- [ ] Keep PHP updated
- [ ] Use HTTPS (SSL certificate)
- [ ] Implement rate limiting for API endpoints
- [ ] Regular security audits
- [ ] Database backups
- [ ] Monitor error logs
- [ ] Use environment variables for sensitive config
- [ ] Implement CSRF protection for forms

## Troubleshooting

### Issue: White screen / 500 Error

```bash
# Check PHP error log
tail -f /var/log/apache2/error.log

# Check file permissions
ls -la /var/www/xoso-vn/

# Verify PHP extensions
php -m | grep sqlite
```

### Issue: Database locked

```bash
# Check for locks
lsof database/xoso.db

# If needed, kill process and restart
```

### Issue: Slow performance

```bash
# Check server resources
htop

# Optimize database
sqlite3 database/xoso.db "VACUUM;"
sqlite3 database/xoso.db "ANALYZE;"

# Enable OPcache (see above)
```

## Updating the Application

```bash
cd /var/www/xoso-vn
git pull origin main
sudo systemctl restart apache2  # or nginx
```

## Current Deployment Status

✅ **Application is running at:**

**Development Server:** https://8080-i03vojmqiw7mq22cnmw38-2b54fc91.sandbox.novita.ai

This is a temporary development URL. For production, follow the deployment steps above.

## Support

For issues or questions:
- Check logs first
- Review documentation
- Open an issue on repository

---

**Last Updated:** 2025-11-20
