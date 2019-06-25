!#/bin/bash
TARGET="/home/vagrant/Zend/workspaces/DefaultWorkspace"
echo "Copying files to " $TARGET
cp -r -v sandbox/public/* $TARGET/sandbox/public
cp -r -v securitytraining/data/sql/* $TARGET/securitytraining/data/sql/
cp -r -v securitytraining/public/* $TARGET/securitytraining/public/
cp -r -v securitytraining/src/controller/* $TARGET/securitytraining/src/controller/
cp -r -v securitytraining/src/view/layouts/* $TARGET/securitytraining/src/view/layouts/
cp -r -v securitytraining/src/vulnerabilities/* $TARGET/securitytraining/src/vulnerabilities/
echo "Resetting permissions"
chown -R vagrant:www-data $TARGET/securitytraining
chmod -R 775 $TARGET/securitytraining
echo "Refreshing database"
mysql -uvagrant -pvagrant security < ./securitytraining/data/sql/security.sql
