# PHP SECURITY CLASS 2021

## Homework
* For Tue 23  Feb
  * Firefox and Security Training App
  * Lab: SQL Injection
  * Lab: Brute Force
  * Lab: ZAP
    * https://chrisdecairos.ca/intercepting-traffic-with-zaproxy/
## VM Updates
* Update the OS (no need to *upgrade*)
  * Bring up the VM and login (user: vagrant, pwd: vagrant)
  * Click on dots lower left side of the GUI
  * Search for `software updater`
  * When you see the list of packages to up (s/be around 340 MB), click `Install Now`
  * Authenticate as user vagrant, pwd "vagrant"
  * Depending on your connection this will take from 30 minutes to an hour to complete
  * Restart the VM when update has completed
 * The source code in the VM needs to be updated.  Please do the following:
  * Open a terminal window
  * Change to the `/home/vagrant` directory
  * Clone from the update repo:
```
git clone https://github.com/dbierer/php-sec-update.git
```
  * Change to the new directory just cloned:
```
cd php-sec-update
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

## Lab Notes
* Brute Force Detector Lab:
  * Make sure the table bfdetect exists:
```
CREATE TABLE `bfdetect` (
  `id` bigint(3) unsigned NOT NULL auto_increment,
  `today` varchar(20) NOT NULL,
  `minute` varchar(3) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `forward_ip` varchar(500) NOT NULL,
  `useragent` varchar(100) NOT NULL,
  `userlan` varchar(100) NOT NULL,
  `isnotify` char(1) default '0',
  `notify4today` char(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
```
* Based on the config, found in the securitytraining app config under the `bfdetect` key, the detector checks the table for previous requests from the various $_SERVER params and logs the request.
* After four (config) requests are made from the same `$_SERVER` params within a 5 minute (config) setting, a log entry is created and a response to the attacker is slowed with a sleep option.
* In order for this script to work, you have to log more than 4 requests in 5 minutes in order for the log entry and sleep response.
* The table is not populated with data due to this timing requirement which is based on the current server time.
* You can populate the table with four quick CLI executions, then run the fifth from the securitytraining brute force page with the login.
* If the `bfdetect` table is not found, load the table create SQL from the dump `/securitytraining/data/sql/course.sql` and you should be able to run the BF tool.

* ZAP Lab
  * https://chrisdecairos.ca/intercepting-traffic-with-zaproxy/

## Vulnerabilities
### SQL Injection
* https://portswigger.net/daily-swig/blocked-accounts-abused-in-evolution-cms-sql-injection-attacks
* https://bertwagner.com/posts/how-to-steal-data-using-a-second-order-sql-injection-attack/
* https://gbhackers.com/latest-google-sql-dorks/
* Definition: http://cwe.mitre.org/data/definitions/89.html
* Tools: https://www.darkhackerworld.com/2020/07/sql-injection-tools.html
### Brute Force
* https://www.itnews.com.au/news/australian-govt-entity-hit-by-brute-force-attack-560343
* https://www.fintechnews.org/the-2020-cybersecurity-stats-you-need-to-know/
* https://en.wikipedia.org/wiki/Botnet
* Password: https://www.mywot.com/blog/this-chart-will-show-you-how-long-it-takes-to-crack-your-password
* Tools: https://resources.infosecinstitute.com/topic/popular-tools-for-brute-force-attacks/

## Resources
CVE Details
* https://www.cvedetails.com/
US Govt Security Vulnerabilities Database
* https://nvd.nist.gov/vuln/search
* Old class notes:
  * https://github.com/dbierer/php-class-notes/blob/master/php-security-notes-2019.md
