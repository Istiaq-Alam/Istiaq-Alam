#!/usr/bin/env bash

# ==============================================================================
# Ultimate Interactive Laravel Project Setup & Configuration Script
# ==============================================================================

set -e

# Text Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
CYAN='\033[0;36m'
BOLD='\033[1m'
NC='\033[0m' # No Color

CURRENT_DIR="$(pwd)"

echo -e "${CYAN}${BOLD}==============================================================${NC}"
echo -e "${CYAN}${BOLD}      Ultimate Interactive Laravel Project Generator          ${NC}"
echo -e "${CYAN}${BOLD}==============================================================${NC}"
echo -e "Working Directory: ${YELLOW}${CURRENT_DIR}${NC}\n"

# ------------------------------------------------------------------------------
# STEP 1: Environment & Dependency Checks
# ------------------------------------------------------------------------------
echo -e "${CYAN}${BOLD}[Step 1/6] Checking system requirements...${NC}"

if ! command -v php &>/dev/null; then
    echo -e "${RED}[ERROR] PHP is not installed or not in PATH.${NC}"
    exit 1
fi

if ! command -v composer &>/dev/null; then
    echo -e "${YELLOW}[WARN] Composer not found. Installing Composer globally...${NC}"
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    php -r "unlink('composer-setup.php');"
fi

# Detect system PHP version vs XAMPP PHP version if available
SYSTEM_PHP=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.'.'.PHP_RELEASE_VERSION;")
SYSTEM_PHP_MINOR=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")

echo -e "${GREEN}[OK]${NC} System PHP CLI Version: ${BOLD}${SYSTEM_PHP}${NC}"

# ------------------------------------------------------------------------------
# STEP 2: Interactive Environment Selection (XAMPP vs Native)
# ------------------------------------------------------------------------------
echo -e "\n${CYAN}${BOLD}[Step 2/6] Environment Architecture Selection${NC}"
echo -e "Select how you want to run and host your local development project:"
echo -e "  1) ${BOLD}XAMPP Stack${NC}      -> Uses XAMPP (/opt/lampp), locks to XAMPP PHP version, uses Laravel 12 (PHP 8.2+ compatible)"
echo -e "  2) ${BOLD}Native CLI Local${NC} -> Uses modern system PHP 8.4+, latest Laravel 13, and 'php artisan serve'"
read -r -p "Choose environment [1 or 2] [default: 2]: " ENV_CHOICE
ENV_CHOICE=${ENV_CHOICE:-2}

if [ "$ENV_CHOICE" = "1" ]; then
    ENV_MODE="xampp"
    if [ ! -f "/opt/lampp/lampp" ]; then
        echo -e "${RED}[ERROR] XAMPP is not found at /opt/lampp/lampp.${NC}"
        echo -e "Please install XAMPP first or select Option 2 for Native mode."
        exit 1
    fi
    # Detect XAMPP PHP version
    XAMPP_PHP=$(/opt/lampp/bin/php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.'.'.PHP_RELEASE_VERSION;")
    XAMPP_PHP_MINOR=$(/opt/lampp/bin/php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")
    
    # XAMPP bundles PHP 8.2 usually, so lock platform and force Laravel 12 to eliminate platform version clashes
    TARGET_PHP="$XAMPP_PHP"
    LARAVEL_PKG="laravel/laravel:^12.0"
    echo -e "${YELLOW}[INFO] XAMPP mode selected. Bound to PHP ${XAMPP_PHP} using Laravel 12 package.${NC}"
else
    ENV_MODE="native"
    TARGET_PHP="$SYSTEM_PHP"
    LARAVEL_PKG="laravel/laravel"
    echo -e "${YELLOW}[INFO] Native mode selected. Using system PHP ${SYSTEM_PHP} with Latest Laravel 13.${NC}"
fi

# ------------------------------------------------------------------------------
# STEP 3: Project & Database Settings
# ------------------------------------------------------------------------------
echo -e "\n${CYAN}${BOLD}[Step 3/6] Project & Database Details${NC}"

while [[ -z "$RAW_PROJECT_NAME" ]]; do
    read -r -p "Enter your Project / Webapp Name (e.g., test-app): " RAW_PROJECT_NAME
done

PROJECT_FOLDER=$(echo "$RAW_PROJECT_NAME" | tr '[:upper:]' '[:lower:]' | sed -E 's/[^a-z0-9]+/-/g' | sed -E 's/^-+|-+$//g')
DEFAULT_DB_NAME=$(echo "$PROJECT_FOLDER" | tr '-' '_')

if [ -d "${CURRENT_DIR}/${PROJECT_FOLDER}" ]; then
    echo -e "${RED}[ERROR] Folder '${CURRENT_DIR}/${PROJECT_FOLDER}' already exists!${NC}"
    exit 1
fi

# Database Connection Type
echo -e "\nSelect Database Connection:"
echo -e "  1) MySQL (Native Kali MySQL/MariaDB or XAMPP MySQL Engine)"
echo -e "  2) SQLite (Zero configuration local file database)"
read -r -p "Choose database type [1 or 2] [default: 1]: " DB_CHOICE
DB_CHOICE=${DB_CHOICE:-1}

if [ "$DB_CHOICE" = "2" ]; then
    DB_CONN="sqlite"
    MYSQL_ENGINE="none"
else
    DB_CONN="mysql"

    if [ "$ENV_MODE" = "xampp" ]; then
        DEFAULT_MYSQL_ENGINE="2"
    else
        DEFAULT_MYSQL_ENGINE="1"
    fi

    echo -e "\nSelect MySQL Engine:"
    echo -e "  1) ${BOLD}Native Kali Linux MySQL/MariaDB${NC} -> Uses system MySQL/MariaDB service + 'php artisan serve'"
    echo -e "  2) ${BOLD}XAMPP's MySQL Engine${NC}            -> Uses /opt/lampp MySQL + 'php artisan serve' (or XAMPP Apache)"
    read -r -p "Choose MySQL engine [1 or 2] [default: ${DEFAULT_MYSQL_ENGINE}]: " MYSQL_ENGINE_CHOICE
    MYSQL_ENGINE_CHOICE=${MYSQL_ENGINE_CHOICE:-$DEFAULT_MYSQL_ENGINE}

    if [ "$MYSQL_ENGINE_CHOICE" = "2" ]; then
        MYSQL_ENGINE="xampp_mysql"
        if [ ! -f "/opt/lampp/lampp" ]; then
            echo -e "${RED}[ERROR] XAMPP is not found at /opt/lampp/lampp.${NC}"
            echo -e "Please install XAMPP or select Option 1 for Native Kali MySQL/MariaDB."
            exit 1
        fi
    else
        MYSQL_ENGINE="native_mysql"
    fi

    read -r -p "Enter MySQL Database Name [default: ${DEFAULT_DB_NAME}]: " DB_NAME
    DB_NAME=${DB_NAME:-$DEFAULT_DB_NAME}

    read -r -p "Enter MySQL Host [default: 127.0.0.1]: " DB_HOST
    DB_HOST=${DB_HOST:-127.0.0.1}

    read -r -p "Enter MySQL Port [default: 3306]: " DB_PORT
    DB_PORT=${DB_PORT:-3306}

    read -r -p "Enter MySQL Username [default: root]: " DB_USER
    DB_USER=${DB_USER:-root}

    read -r -s -p "Enter MySQL Password (leave blank for empty/XAMPP default): " DB_PASS
    echo ""
fi

# Summary Display
echo -e "\n${YELLOW}${BOLD}==============================================================${NC}"
echo -e "${YELLOW}${BOLD}                     CONFIGURATION SUMMARY                    ${NC}"
echo -e "${YELLOW}${BOLD}==============================================================${NC}"
echo -e " Project Name   : ${RAW_PROJECT_NAME}"
echo -e " Folder Path    : ${CURRENT_DIR}/${PROJECT_FOLDER}"
echo -e " Architecture   : ${BOLD}${ENV_MODE^^}${NC} (PHP ${TARGET_PHP})"
echo -e " Laravel Pkg    : ${LARAVEL_PKG}"
echo -e " DB Connection  : ${DB_CONN}"
if [ "$DB_CONN" = "mysql" ]; then
echo -e " MySQL Engine   : $( [ "$MYSQL_ENGINE" = "xampp_mysql" ] && echo "XAMPP MySQL (/opt/lampp)" || echo "Native Kali MySQL/MariaDB" )"
echo -e " DB Host:Port   : ${DB_HOST}:${DB_PORT}"
echo -e " DB Name        : ${DB_NAME}"
echo -e " DB User        : ${DB_USER}"
fi
echo -e "${YELLOW}${BOLD}==============================================================${NC}\n"

read -r -p "Proceed with project generation? (y/n) [y]: " CONFIRM
CONFIRM=${CONFIRM:-y}
if [[ ! "$CONFIRM" =~ ^[Yy]$ ]]; then
    echo -e "${RED}Aborted by user.${NC}"
    exit 0
fi

# ------------------------------------------------------------------------------
# STEP 4: Start Services & Setup Database
# ------------------------------------------------------------------------------
if [ "$DB_CONN" = "mysql" ]; then
    echo -e "\n${CYAN}${BOLD}[Step 4/6] Initializing MySQL Database...${NC}"
    
    if [ "$MYSQL_ENGINE" = "xampp_mysql" ]; then
        # Stop native Kali MySQL/MariaDB if running so port 3306 is free for XAMPP MySQL
        if systemctl is-active --quiet mysql 2>/dev/null || systemctl is-active --quiet mariadb 2>/dev/null; then
            echo -e "${YELLOW}[INFO] Stopping native MySQL service to free port ${DB_PORT} for XAMPP MySQL...${NC}"
            sudo systemctl stop mysql 2>/dev/null || sudo systemctl stop mariadb 2>/dev/null || true
        fi

        if [ "$ENV_MODE" = "xampp" ]; then
            sudo /opt/lampp/lampp start
        else
            echo -e "${YELLOW}[INFO] Starting XAMPP MySQL Engine for 'php artisan serve'...${NC}"
            sudo /opt/lampp/lampp startmysql
        fi
        MYSQL_BIN="/opt/lampp/bin/mysql"

        if [ -z "$DB_PASS" ]; then
            "$MYSQL_BIN" -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
        else
            "$MYSQL_BIN" -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
        fi
    else
        # Native Kali Linux MySQL / MariaDB Engine
        if ! command -v mysql &>/dev/null; then
            echo -e "${YELLOW}[WARN] Native MySQL/MariaDB not found. Installing default-mysql-server...${NC}"
            sudo apt update && sudo apt install -y default-mysql-server
        fi

        # Stop XAMPP MySQL if running so port 3306 is free for Native Kali MySQL
        if [ -f "/opt/lampp/lampp" ]; then
            sudo /opt/lampp/lampp stopmysql >/dev/null 2>&1 || true
        fi

        echo -e "${YELLOW}[INFO] Starting Native Kali Linux MySQL/MariaDB service...${NC}"
        sudo systemctl start mysql 2>/dev/null || sudo systemctl start mariadb 2>/dev/null || sudo service mysql start

        MYSQL_BIN="mysql"

        # Create database & ensure TCP (127.0.0.1) access works for Laravel Artisan
        if [ -z "$DB_PASS" ]; then
            "$MYSQL_BIN" -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null || \
            sudo mysql -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; ALTER USER '${DB_USER}'@'localhost' IDENTIFIED VIA mysql_native_password USING PASSWORD(''); GRANT ALL PRIVILEGES ON *.* TO '${DB_USER}'@'127.0.0.1' IDENTIFIED BY '' WITH GRANT OPTION; FLUSH PRIVILEGES;"
        else
            "$MYSQL_BIN" -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null || \
            sudo mysql -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; ALTER USER '${DB_USER}'@'localhost' IDENTIFIED VIA mysql_native_password USING PASSWORD('${DB_PASS}'); GRANT ALL PRIVILEGES ON *.* TO '${DB_USER}'@'127.0.0.1' IDENTIFIED BY '${DB_PASS}' WITH GRANT OPTION; FLUSH PRIVILEGES;"
        fi
    fi

    echo -e "${GREEN}[OK]${NC} Database '${DB_NAME}' created successfully."
else
    echo -e "\n${CYAN}${BOLD}[Step 4/6] Skipping external database setup (SQLite selected).${NC}"
    if [ "$ENV_MODE" = "xampp" ]; then
        sudo /opt/lampp/lampp startapache
    fi
fi

# ------------------------------------------------------------------------------
# STEP 5: Generate Laravel Project & Platform Pinning
# ------------------------------------------------------------------------------
echo -e "\n${CYAN}${BOLD}[Step 5/6] Generating Laravel Project & Configuring Dependencies...${NC}"

# Ignore platform requirements during creation to prevent version mismatch blockers
composer create-project "$LARAVEL_PKG" "$PROJECT_FOLDER" --no-scripts --ignore-platform-reqs

cd "${CURRENT_DIR}/${PROJECT_FOLDER}"

# Explicitly lock platform PHP version to prevent Composer platform requirement errors
composer config platform.php "$TARGET_PHP"
rm -f composer.lock
composer update --with-all-dependencies --no-scripts

# ------------------------------------------------------------------------------
# STEP 6: Configure .env, Permissions, & Migrations
# ------------------------------------------------------------------------------
echo -e "\n${CYAN}${BOLD}[Step 6/6] Finalizing Environment & Running Migrations...${NC}"

cp -f .env.example .env

if [ "$ENV_MODE" = "xampp" ]; then
    APP_URL_VAL="http://localhost/${PROJECT_FOLDER}/public"
else
    APP_URL_VAL="http://127.0.0.1:8000"
fi

for ENV_FILE in .env .env.example; do
    sed -i "s|^APP_NAME=.*|APP_NAME=\"${RAW_PROJECT_NAME}\"|" "$ENV_FILE"
    sed -i "s|^APP_URL=.*|APP_URL=${APP_URL_VAL}|" "$ENV_FILE"
    
    if [ "$DB_CONN" = "sqlite" ]; then
        sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=sqlite|" "$ENV_FILE"
        sed -i "s|^#* *DB_HOST=.*|#DB_HOST=127.0.0.1|" "$ENV_FILE"
        sed -i "s|^#* *DB_PORT=.*|#DB_PORT=3306|" "$ENV_FILE"
        sed -i "s|^#* *DB_DATABASE=.*|#DB_DATABASE=laravel|" "$ENV_FILE"
        sed -i "s|^#* *DB_USERNAME=.*|#DB_USERNAME=root|" "$ENV_FILE"
        sed -i "s|^#* *DB_PASSWORD=.*|#DB_PASSWORD=|" "$ENV_FILE"
    else
        sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=mysql|" "$ENV_FILE"
        sed -i "s|^#* *DB_HOST=.*|DB_HOST=${DB_HOST}|" "$ENV_FILE"
        sed -i "s|^#* *DB_PORT=.*|DB_PORT=${DB_PORT}|" "$ENV_FILE"
        sed -i "s|^#* *DB_DATABASE=.*|DB_DATABASE=${DB_NAME}|" "$ENV_FILE"
        sed -i "s|^#* *DB_USERNAME=.*|DB_USERNAME=${DB_USER}|" "$ENV_FILE"
        sed -i "s|^#* *DB_PASSWORD=.*|DB_PASSWORD=\"${DB_PASS}\"|" "$ENV_FILE"
    fi
done

if [ "$DB_CONN" = "sqlite" ]; then
    touch database/database.sqlite
fi

php artisan key:generate

# Set permissions based on architecture
if [ "$ENV_MODE" = "xampp" ]; then
    sudo chown -R "$USER:daemon" storage bootstrap/cache
    sudo chmod -R 775 storage bootstrap/cache
else
    chmod -R 775 storage bootstrap/cache
fi

php artisan migrate --force

if [ -f "package.json" ] && command -v npm &>/dev/null; then
    echo -e "${YELLOW}[INFO] Installing npm packages and building assets...${NC}"
    npm install
    npm run build
fi

# Success Banner
echo -e "\n${GREEN}${BOLD}==============================================================${NC}"
echo -e "${GREEN}${BOLD}      SUCCESS! Your Laravel Application is Ready to Use       ${NC}"
echo -e "${GREEN}${BOLD}==============================================================${NC}"
echo -e " Project Location : ${YELLOW}${CURRENT_DIR}/${PROJECT_FOLDER}${NC}"
echo -e " Architecture Mode: ${BOLD}${ENV_MODE^^}${NC} (PHP Target: ${TARGET_PHP})"
if [ "$DB_CONN" = "mysql" ]; then
echo -e " MySQL Engine     : ${BOLD}$( [ "$MYSQL_ENGINE" = "xampp_mysql" ] && echo "XAMPP MySQL (/opt/lampp/lampp startmysql)" || echo "Native Kali MySQL (sudo systemctl start mysql)" )${NC}"
fi
if [ "$ENV_MODE" = "xampp" ]; then
echo -e " Browser URL      : ${CYAN}http://localhost/${PROJECT_FOLDER}/public${NC}"
echo -e " phpMyAdmin       : ${CYAN}http://localhost/phpmyadmin${NC}"
else
echo -e " Development Run  : ${CYAN}cd ${PROJECT_FOLDER} && php artisan serve${NC}"
echo -e " Browser URL      : ${CYAN}http://127.0.0.1:8000${NC}"
fi
echo -e "${GREEN}${BOLD}==============================================================${NC}"