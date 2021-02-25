# PHP SECURITY CLASS 2021

## Homework
* For Thu 25 Feb
  * Lab: Insecure Deserialization
  * Lab: Using Components with Known Vulnerabilities
  * Lab: Insecure Direct Object References
  * Lab: Missing Function Access Level Control (ACL)
  * Lab: Unvalidated Redirects and Forwards
* For Wed 24 Feb
  * Lab: Cross-Site Scripting (XSS)
  * Lab: Cross Site Request Forgery (CSRF)
  * Lab: Security Misconfiguration
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
* Tools: https://github.com/jschreuder/BruteForceDetector
### XSS
* https://www.wordfence.com/blog/2020/05/nearly-a-million-wp-sites-targeted-in-large-scale-attacks/
* https://cve.mitre.org/cgi-bin/cvekey.cgi?keyword=XSS+PHP
* Definition: https://cwe.mitre.org/data/definitions/79.html
* Tools: https://www.php.net/tidy
* Tool: https://www.virustotal.com/#/home/url
* Tool: https://owasp.org/www-community/xss-filter-evasion-cheatsheet
### XXE
* https://news.lazyhackers.in/2021/01/06/a-deep-dive-into-xxe-injection/
* Definition: https://cwe.mitre.org/data/definitions/611.html
### CSRF
* https://wanago.io/2020/12/21/csrf-attacks-same-site-cookies/
* https://latesthackingnews.com/2020/09/23/more-bugs-discovered-in-discount-rules-for-woocommerce-plugin/
* Definition: https://cwe.mitre.org/data/definitions/352.html
### Security Misconfiguration
* https://www.helpnetsecurity.com/2019/09/25/cloud-misconfiguration-incidents/
* https://thehackernews.com/2021/02/the-weakest-link-in-your-security.html
* Tools: Zend Server
* Tools: (for Linux) logwatch
* Tools: Monitoring: Nagios: https://www.nagios.com/
### Insecure Deserialization
* https://thehackerish.com/insecure-deserialization-explained-with-examples/
* (not PHP, but shows danger) https://www.zerodayinitiative.com/blog/2020/3/5/cve-2020-2555-rce-through-a-deserialization-bug-in-oracles-weblogic-server
* Definition: https://cwe.mitre.org/data/definitions/502.html
### Using Components with Known Vulnerabilities
* https://nvd.nist.gov/products/cpe/search
  * and then enter the name of the product you want to investigate
### Broken Authentication and Session Management
* Definition: https://cwe.mitre.org/data/definitions/724.html
### Insecure Direct Object References
* Objects == the target of links, menus, etc.
* https://www.netsparker.com/blog/web-security/insecure-direct-object-reference-vulnerabilities-idor/
### Missing Function Access Level Control (ACL)
* Tools: https://github.com/potievdev/slim-rbac (middleware)
* Tools: https://docs.laminas.dev/laminas-permissions-acl/usage/
### Unvalidated Redirects and Forwards
* Tools: https://cheatsheetseries.owasp.org/cheatsheets/Unvalidated_Redirects_and_Forwards_Cheat_Sheet.html
### Secure File Uploads
* ZF Example:
  * https://github.com/dbierer/zf-master-aug-2019/blob/master/onlinemarket.work/module/Market/src/Controller/PostController.php
  * https://github.com/dbierer/zf-master-aug-2019/blob/master/onlinemarket.work/module/Market/src/Form/PostForm.php
  * https://github.com/dbierer/zf-master-aug-2019/blob/master/onlinemarket.work/module/Market/src/Form/PostFilter.php
```
use Zend\InputFilter\FileInput;
use Laminas\Filter\File\RenameUpload;
use Laminas\Validator\File\ {FilesSize, IsImage, ImageSize};
$photo = new FileInput('photo_filename');
$maxImgSize = new ImageSize($this->uploadConfig['img_size']);
$maxFileSize = new FilesSize($this->uploadConfig['file_size']);
$isImage = new IsImage();
$photo->getValidatorChain()
            ->attach($maxImgSize)
            ->attach($maxFileSize)
            ->attach($isImage);
$rename = new RenameUpload($this->uploadConfig['rename']);
$photo->getFilterChain()->attach($rename);
```
### Insecure CAPTCHA
* https://www.smbc-comics.com/comic/reverse-captcha
* https://developers.google.com/recaptcha/
* https://www.vice.com/en/article/gy8g8b/humans-not-invited-is-a-captcha-test-for-robots
* http://www.humansnotinvited.com/

## Resources
CVE Details
* https://cve.mitre.org/
* https://www.cvedetails.com/
US Govt Security Vulnerabilities Database
* https://nvd.nist.gov/vuln/search
* Old class notes:
  * https://github.com/dbierer/php-class-notes/blob/master/php-security-notes-2019.md
OWASP Cheat Sheet Series
* https://cheatsheetseries.owasp.org/Glossary.html
Project Honeypot
* https://www.projecthoneypot.org/

# Summary of Preventative Measures

## SQL Injection Suggested Protection:
*  1: use prepared statements to enhance protection against sql injection
*  2: filter and validate all inputs
*  3: treat the database with suspicion as it could have been compromised
*  4: use database users with the lowest possible level of access to do the job required
*  5: encrypting the database passwords might negatively impact performance, but
      you can at least put the credentials in a separate include file
*  6: penetration testing tools for SQL injection:
    * http://sqlmap.org/
    * https://www.owasp.org/index.php/Category:OWASP_SQLiX_Project

LAB: solution should use prepared statements!!!
LAB: examples for SQL injection:
* Went through this worksheet: https://www.exploit-db.com/papers/13045/
* Unable to hack in!
* ID=xxx shows admin however, which is bad


## Brute Force Suggested Protection:
*  0: Any suggested protection may be evaded if the attack is launched from a "botnet"
*  1: Tracking failed login attempts + some kind of redirection or slowdown if X # failed attempts
*  2: CAPTCHA
*  3: Cookie handling: check to see if cookie is being returned or not
*  4: Log attempts based on IP address
*  5: Employ a series of strategies if B.F. attacked detected.  Randomly choose one.  Suggestions:
    -- "Landing" page
    -- Send an email and ask for confirmation
    -- Random Timeout i.e. 30 mins
    -- Send to a page with a CAPTCHA
    -- Ask a security question
* 6: Consider resetting the password + use out-of-band notification (i.e. email)
* 7: if a high level of abuse is noted, extreme measures are called for: i.e. total lockout at IP level
* 8: Generate random temporary redirect pages if excessive failed logins are detected.  Add random ipsum lorem to the temporary pages to further confuse automated attack systems.
* 9: Add random hidden content to the return HTML to further confuse automated attack systems
* 10: Have multiple password and a random rotation

## XSS:
* 1: escape, validate, filter all input
* 2: htmlspecialchars() on output (esp. suspect data)
* 3: use prepared statements + SQL injection protection to prevent stored XSS
* 4: strip_tags() and stripslashes() (maybe) on input
    UNLESS: if you're implementing a CMS, don't strip all tags (used 2nd param of strip_tags())
    Only allow certain ones
    Consider using Zend\Filter\StripTags which can also filter out selected attribs
    strip_tags('<b onclick="javascript:alert("test")">', '<b>');
    would still execute the javascript
* 5: Control the length of your input data
* 6: For CMS implementation, consider using other libraries
    i.e. Zend\Escaper
* 7: Use Zend\Escaper\HtmlAttrib (???) which escapes *contents* of attribs
* 8: from Keoghan to All Participants: just thought I'd share this for the times where html is needed to be allowed through:
    https://github.com/ezyang/htmlpurifier (not sure if everyone will have some across it or not)
* 9: User education: instruct them where to look and what not to do
* 10: Email address validation: https://stackoverflow.com/questions/13719821/email-validation-using-regular-expression-in-php/13719870#13719870
* 11: Inject your data into a DOM, minimized the need to sanitise
```
$document->querySelector("#name-output")->innerText = $_GET["name"]
// also: using PHP DOM extension:
$document->getElementById("name-output"); // doesn't have querySelector by default.
```
* 12: Might need to set [`CORS`](https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS) headers to allow "legal" cross information sharing for servers under your control

## Insecure Direct Object Reference / Missing Function Level Access Control
* 1: When building the SELECT, encrypt the database key which is exposed to the form
* 2: Implement proper access control for valuable company resources ("objects")
* 3: Redirect and log the "illegal" attempt (i.e. enforce the access control)
* 4: Don't display resources that this user should not access
* 5: Proper session protection + proper logout procedure
* 6: Modify the names of the resources to make them less predictable

## CSRF
* 1: Use hard-to-predict tokens for each unique form access
    I.e. use open ssl pbkdf functionality: http://php.net/manual/en/function.openssl-pbkdf2.php
* 2: Potential programming problem: what if valid user opens same form in 2 windows?
    Possible solution: using an AJAX request (but: can trust the client?)
* 3: Create a profile of the user including User Agent + Language + IP Address etc.
* 4: Implement session protection + XSS measures
* 5: DO NOT use md5 for your hash!!!  Use something like password_hash()
* 6: Consider sending the CSRF token out via a cookie rather than a hidden form field
    * DO NOT use the word "token" to identify the field
    * Use a random string of characters, and store that info in the session
* 7: Once a token is used, throw it away - that makes sense, but I've always wondered what to do with tokens that are _not_ used. Seems like a vulnerability having many active tokens as many users navigate complex sites with many forms.
    * Set some sort of expiration, otherwise you have active, valid, unused tokens sitting around.
LAB: quick test: download form, make a change, submit manually, and see that you've change the password

## Session Protection:
* 1: Run session_regenerate_id() frequently to keep validity of session ID short
    but still maintain the session
* 2: Have the session ID go through cookies (instead of URL)
* 3: Create a profile of the user (i.e. IP address, browser, language settings)
    If anything changes while session is active, flag the session as suspicious
    maybe log this fact, shut down the session, etc.
* 4: Provide a logout option which destroys the session, expires the cookie and unsets data
* 5: Keep sessions as short as possible (but keep usability in mind!)
* 6: Be cautious about fixed session IDs (i.e. "remember me")!!!

## Security Misconfig
* 1: Keep all open source + other software updated
* 2: Improperly configured filesystem rights
* 3: Leaving defaults in place
* 4: Web server defaults for directories should restrict what users can see
* 5: use apachectl -l and apachectl -M to see which modules are loaded
    look for ssl_module especially
* 6: php.ini settings: allow_url_include = off; open_basedir = /set/this/to/something; doc_root = /set/to/something

## Missing Function Level Access Control
* 1: Utilize an Access Control List (ACL) which defines:
  * Resources == tangible assets which need to be secured (i.e. routes, URLs, classes, database tables, directories)
  * Permissions == what actions to be performed on the assets
  * Groups == categories of users
  * Rules == allow XXX group XXX permission to XXX resource
* 2: This vulnerability is difficult to test with most tools
  * Might be able to use a "headless" browser such as `Selenium` (https://docs/seleniumhqorg/)
* 3: Unit testing might help
  * BUT: unit testing won't help with javascript

## Unvalidated Redirects and Forwards
* Also called "Unauthorized Redirects" or "Open Redirects"

## Insufficient Crypto Handling of Sensitive Data
* 1: Don't use old/weak crypto methods (i.e. md5 or sha1)
* 2: Need to determine what is "sensitive data" for your app
* 3: Make sure measures are in place when you store or transfer this data
* 4: Don't store or transmit sensitive data in plain text
* 5: Keep crypto software up to date
* 6: DO NOT use mcrypt!!!! Use openssl_encrypt() or openssl_decrypt() or Sodium (http://php.net/sodium)
    See: https://wiki.php.net/rfc/mcrypt-viking-funeral
* 7: Use a "modern" algorithm; AES is OK + a "modern" mode: suggestions:
    * XTS
    * GCM
    * CTR
* 8: For more info: https://en.wikipedia.org/wiki/Block_cipher

## Insecure Deserialization
* 1: Maybe don't store such information in a cookie: store someplace else (i.e. the Session)
* 2: Enumerate the strategies and only store the enumeration in the cookie; upon return compare with a whitelist of strategies
* 3: Create a digital signature or hash of the serialized object prior to storage and confirm upon restoration
* 4: Check to see if `__wakeup()` has been defined, and if so, make sure it doesn't invalidate security measures when object is restored

## Command Injection
* 1: Do you really need to run system(), exec() etc.?  Maybe another way
* 2: Use escapeshellcmd/args()
* 3: php.ini setting "disable_functions = xxx" if you want to block usage of these
* 4: Filtering / validation i.e. filter_var with one of the flags
    Typecasting

## Remote Code Injection
* 1: Don't mix user input with these commands: include, require, eval()
* 2: Set php.ini allow_url_include = off
* 3: Possibly refactor your code so you don't need the user to supply actual PHP filenames
    Establish some sort of routing capability / url rewriting
    Whitelist allowed pages w/ name mappings that the user can choose
    Don't let the user see the actual php file they're going to be using
* 4: Be sure to initiate proper access control / authorization

## Javascript
* 1: consider using "code obfuscation" to obscure your javascript to slow down potential attacks from this vector
* 2: consider using "minified" JS libraries which improves performance and is more difficult to read

## Miscellaneous
* 1: create links that follow known attack vectors (e.g. `/wp-login`) that just wastes time and collects attacker data
