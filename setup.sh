#!/bin/bash

echo "🎂 Setting up Birthday Wisher Project..."

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Installing PHP..."
    sudo apt update
    sudo apt install php php-mysql php-pgsql php-curl -y
fi

# Check if MySQL is installed
if ! command -v mysql &> /dev/null; then
    echo "❌ MySQL is not installed."
    echo "Do you want to install MySQL? (y/n)"
    read -r install_mysql
    if [[ $install_mysql == "y" ]]; then
        sudo apt install mysql-server -y
        sudo mysql_secure_installation
    else
        echo "⚠️  Using SQLite as fallback database"
        echo "You can install MySQL later with: sudo apt install mysql-server"
    fi
fi

# Check if PostgreSQL is installed (for Render compatibility testing)
if ! command -v psql &> /dev/null; then
    echo "ℹ️  PostgreSQL not installed (optional for local testing)"
fi

# Create database
echo "📦 Creating database..."
if command -v mysql &> /dev/null; then
    sudo mysql -e "CREATE DATABASE IF NOT EXISTS birthday_wishes;"
    sudo mysql -e "CREATE USER IF NOT EXISTS 'birthday_user'@'localhost' IDENTIFIED BY 'birthday_pass';"
    sudo mysql -e "GRANT ALL PRIVILEGES ON birthday_wishes.* TO 'birthday_user'@'localhost';"
    sudo mysql -e "FLUSH PRIVILEGES;"
    sudo mysql birthday_wishes < database.sql
    echo "✅ MySQL database created successfully!"
else
    echo "⚠️  MySQL not found. Using SQLite instead."
    # Create SQLite database
    sqlite3 birthday_wishes.db < database.sqlite
    echo "✅ SQLite database created successfully!"
fi

# Create .env file for local development
echo "📝 Creating .env file..."
cat > .env << EOL
# Database configuration
DB_TYPE=mysql
DB_HOST=localhost
DB_NAME=birthday_wishes
DB_USER=birthday_user
DB_PASS=birthday_pass

# Render will use DATABASE_URL automatically
EOL

# Set permissions
chmod 755 *.php
chmod 644 *.css *.js

echo "✅ Setup complete!"
echo ""
echo "🚀 To start the application:"
echo "   php -S localhost:8000"
echo ""
echo "📱 Then visit: http://localhost:8000"
echo ""
echo "🎉 Happy Birthday Wishing!"