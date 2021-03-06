!#/bin/bash
echo "IMPORTANT: need to run this as root"
TARGET="/home/vagrant/Zend/workspaces/DefaultWorkspace"
echo "Copying files to " $TARGET
cp -r -v sandbox/public/* $TARGET/sandbox/public
cp -r -v securitytraining/composer.json $TARGET/securitytraining/composer.json
cp -r -v securitytraining/public/* $TARGET/securitytraining/public/
cp -r -v securitytraining/data/sql/* $TARGET/securitytraining/data/sql/
cp -r -v securitytraining/src/controller/* $TARGET/securitytraining/src/controller/
cp -r -v securitytraining/src/view/layouts/* $TARGET/securitytraining/src/view/layouts/
cp -r -v securitytraining/src/vulnerabilities/* $TARGET/securitytraining/src/vulnerabilities/
echo "Resetting permissions"
chown -R vagrant:www-data $TARGET/securitytraining
chmod -R 775 $TARGET/securitytraining
echo "Refreshing database"
mysql -uvagrant -pvagrant security < ./securitytraining/data/sql/security.sql
echo "Updating composer packages"
cd $TARGET/securitytraining
composer update
composer dump-autoload
echo "Applying patches"
sed -i 's/class_alias/\/\/ class_alias/g' vendor/zendframework/zend-test/autoload/phpunit-class-aliases.php
echo "Installing phpMyAdmin 5.0.4"
cd /tmp
wget https://files.phpmyadmin.net/phpMyAdmin/5.0.4/phpMyAdmin-5.0.4-all-languages.zip
unzip phpMyAdmin-5.0.4-all-languages.zip
cd phpMyAdmin-5.0.4-all-languages
cp -rf * /etc/phpmyadmin
rm phpMyAdmin-5.0.4-all-languages.zip
rm -rf phpMyAdmin-5.0.4-all-languages
ln -s -f /etc/phpmyadmin /var/www/html/phpmyadmin
