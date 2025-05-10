#!/bin/bash

# PHP 8.2 Installation and Apache2 Configuration Script for Ubuntu
# Created by Claude

# Make sure the script is run as root
if [ "$(id -u)" -ne 0 ]; then
  echo "This script must be run as root. Please use sudo."
  exit 1
fi

# Set colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${GREEN}=========================================${NC}"
echo -e "${GREEN}PHP 8.2 Installation and Apache2 Configuration${NC}"
echo -e "${GREEN}=========================================${NC}"

# Update system
echo -e "\n${YELLOW}Updating system packages...${NC}"
apt update && apt upgrade -y

# Install required packages for adding repositories
echo -e "\n${YELLOW}Installing required packages...${NC}"
apt install -y software-properties-common apt-transport-https ca-certificates lsb-release curl

# Add the Ondřej Surý PHP repository
echo -e "\n${YELLOW}Adding PHP repository...${NC}"
add-apt-repository ppa:ondrej/php -y

# Update package list
echo -e "\n${YELLOW}Updating package lists...${NC}"
apt update

# Install Apache if not already installed
echo -e "\n${YELLOW}Installing Apache2 if not already installed...${NC}"
apt install -y apache2

# Install PHP 8.2 and common extensions
echo -e "\n${YELLOW}Installing PHP 8.2 and common extensions...${NC}"
apt install -y php8.2 php8.2-cli php8.2-common php8.2-curl php8.2-gd php8.2-intl php8.2-mbstring php8.2-mysql php8.2-opcache php8.2-readline php8.2-xml php8.2-zip php8.2-bz2 php8.2-bcmath

# Install PHP 8.2 for Apache
echo -e "\n${YELLOW}Installing PHP 8.2 for Apache...${NC}"
apt install -y libapache2-mod-php8.2

# Disable all PHP versions in Apache
echo -e "\n${YELLOW}Disabling all PHP versions in Apache...${NC}"
a2dismod php* 2>/dev/null

# Enable PHP 8.2 in Apache
echo -e "\n${YELLOW}Enabling PHP 8.2 in Apache...${NC}"
a2enmod php8.2

# Create a PHP info file for testing
echo -e "\n${YELLOW}Creating PHP info file for testing...${NC}"
echo "<?php phpinfo(); ?>" > /var/www/html/phpinfo.php
chmod 644 /var/www/html/phpinfo.php

# Set PHP 8.2 as the default command-line version
echo -e "\n${YELLOW}Setting PHP 8.2 as the default CLI version...${NC}"
update-alternatives --set php /usr/bin/php8.2

# Configure PHP for development or production
echo -e "\n${YELLOW}Would you like to configure PHP for development or production? (dev/prod)${NC}"
read -r env_type

if [ "$env_type" = "dev" ]; then
    # Configure PHP for development
    echo -e "\n${YELLOW}Configuring PHP for development environment...${NC}"
    echo "
display_errors = On
display_startup_errors = On
error_reporting = E_ALL
memory_limit = 256M
post_max_size = 100M
upload_max_filesize = 100M
max_execution_time = 300
max_input_time = 300
date.timezone = UTC
    " > /etc/php/8.2/apache2/conf.d/99-custom.ini
    
    # Also apply to CLI
    cp /etc/php/8.2/apache2/conf.d/99-custom.ini /etc/php/8.2/cli/conf.d/99-custom.ini
    
elif [ "$env_type" = "prod" ]; then
    # Configure PHP for production
    echo -e "\n${YELLOW}Configuring PHP for production environment...${NC}"
    echo "
display_errors = Off
display_startup_errors = Off
error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT
memory_limit = 256M
post_max_size = 64M
upload_max_filesize = 64M
max_execution_time = 60
max_input_time = 60
expose_php = Off
date.timezone = UTC
opcache.enable = 1
opcache.memory_consumption = 128
opcache.interned_strings_buffer = 8
opcache.max_accelerated_files = 4000
opcache.validate_timestamps = 0
opcache.save_comments = 1
opcache.fast_shutdown = 0
    " > /etc/php/8.2/apache2/conf.d/99-custom.ini
    
    # Also apply to CLI
    cp /etc/php/8.2/apache2/conf.d/99-custom.ini /etc/php/8.2/cli/conf.d/99-custom.ini
    
else
    echo -e "${RED}Invalid option. No custom PHP configuration applied.${NC}"
fi

# Restart Apache to apply changes
echo -e "\n${YELLOW}Restarting Apache...${NC}"
systemctl restart apache2

# Check if PHP 8.2 is working
echo -e "\n${YELLOW}Checking PHP version...${NC}"
php -v

# Check if Apache is running
if systemctl is-active --quiet apache2; then
    echo -e "\n${GREEN}Apache is running correctly.${NC}"
else
    echo -e "\n${RED}Apache is not running. Attempting to start...${NC}"
    systemctl start apache2
    
    if systemctl is-active --quiet apache2; then
        echo -e "${GREEN}Apache started successfully.${NC}"
    else
        echo -e "${RED}Failed to start Apache. Please check the logs with: journalctl -xe${NC}"
    fi
fi

# Print success message
echo -e "\n${GREEN}=========================================${NC}"
echo -e "${GREEN}Installation completed successfully!${NC}"
echo -e "${GREEN}PHP 8.2 has been installed and configured for Apache2.${NC}"
echo -e "${GREEN}You can verify PHP is working by visiting:${NC}"
echo -e "${YELLOW}http://$(hostname -I | awk '{print $1}')/phpinfo.php${NC}"
echo -e "${GREEN}=========================================${NC}"

# Cleanup
echo -e "\n${YELLOW}Cleaning up...${NC}"
apt autoremove -y
apt clean

echo -e "\n${GREEN}Done!${NC}"
