#!/bin/bash
echo "Deploying files..."
git pull
cp -r * /opt/local/www/apache2/html/
cp ~/config.ini /opt/local/www/apache2/html/Config/config.ini