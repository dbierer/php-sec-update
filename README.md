# PHP SECURITY CLASS Jun 2019

## VM Updates
* The source code in the VM needs to be updated.  Please do the following:
  * Open a terminal window
  * Change to the `/home/vagrant` directory
  * Clone from the update repo:
```
git clone https://github.com/dbierer/php-sec-update-jun-2019.git
```
  * Change to the new directory just cloned:
```
cd php-sec-update-jun-2019
```
  * Run the copy script as root:
```
chmod +x ./copy.sh
sudo ./copy.sh
```
  * Verify that the database has been refreshed: look for a new table called `flowers`
  * If the refresh didn't occur property, refresh the database by importing from this file (you can also do this from phpMyAdmin):
```
mysqlimport security -uvagrant -pvagrant ./securitytraining/data/sql/security.sql
```
