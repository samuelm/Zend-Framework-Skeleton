
Zend Framework Skeleton Reloaded
================================

This is a fork of the excellent Zend-Framework-Skeleton by christophervalles.
I just adapted it to my own need .
Check below the original description.

Here is what new / different in this fork

* Use of HTML5 
* Intégration of boilter template (http://html5boilerplate.com/) layout and css
* .htaccess enhanced 
* Remove Zend Unit Test form the test directory ( we don't need to test Zend )
* User HTML5 and bootstrap for the backoffice ( http://twitter.github.com/bootstrap/index.html ) template
* Change the way the form render to fit bootstrap layout ( no more dl )

I'm still working on it and i plan to add many features.



Full Description from the original project
===========

This is a Zend Framework Skeleton, below you'll find some specs about it.

* Zend Framework
* Module structure
* ZFDebug
* TDD ready
* PHPUnit ready
* Zend_Log configured (using firebug in development)
* Zend_Translate configured (using .mo files)
* Zend_Translate configured to log the missing translations in dev environment
* Zend_Translate defaults to english
* FlashMessages plugin installed
* VersionHeader plugin installed (send the version of the app through a special header)
* DBAdapter already configured (just change the credentials on the app.ini)
* Cache Backends configurable through app.ini
* File cache backend configured
* Automatic CSRF check in all the forms
* Autoloader configured
* Router configured to read the routes from xml files
* Different bootstrap and entry point per module
* Zend_Locale configured to detect the locale and degrades gracefully
* App configured to use three environments (dev, staging, production)
* Zend_Registry up and running
* All the handy data stored in the Registry and constants like environment, some paths (app path, root path)...
* View Helper to translate using the following method $this->t() instead of $this->translate() (much shorter)
* Flag and Flippers concept of flickr implemented through ACL
* Flag and Flippers configurable via BO (Still some stuff in development)
* CLI tool to generate basic ACL rules for controllers and actions
* Basic Inflector
* Three custom validators to handle passwords
* Basic BO structure with two levels of navigation
* BO menu generated automatically based on an array and filtered through the Flag and flippers configured
* All the tables needed dumped in migration files
* Akrabat db migration system implemented
* Amazon CloudFront Invalidator implemented
* Amazon SNS publish feature implemented
* Amazon S3 integrated
* Amazon Simple Email Service integrate through a custom mail transport
* App_Logger attached to Amazon SES to receive notifications of the errors (based on zend_log and it's logs levels)
* Implemented a dependency injector container and moved a lot of objects there
* Integrated gearmand and some workers to do jobs asynchronously (optional and configurable through config file)
* Analytics worker to send info to Amazon Simple DB
* Upload worker to upload files to Amazon S3
* Remove cdn worker to invalidate files on Amazon CloudFront
* Send email worker to send the emails through Amazon Simple Email Service
* Chain-of-resonsability pattern implemented in the controllers and 3 commands available (publish to facebook, twitter or send email)
* CDN View helper to fetch the files directly from the cdn (supports multiple domains to speed up the page load time)
* Bitly Short Url service integrated
* Custom logic to handle emails and their templates
* Install script



Credentials to access the BO
============================

Admin Group
-----------
Username: john.doe  
Password: lorem

Installation
============

1. Get a copy of the files in your machine
2. Run the install script located at ./scripts
3. Create the virtual hosts (one per module)
    
    <VirtualHost *:80>
        ServerAdmin admin@example.com
        
        ServerName frontend.zfs.local
        DocumentRoot PATH_TO_THE_PROJECT/public/frontend
        <Directory />
            Options FollowSymLinks
            AllowOverride All 
        </Directory>
        <Directory PATH_TO_THE_PROJECT/public/frontend>
            Options -Indexes
            AllowOverride All
            Order allow,deny
            allow from all
        </Directory>
        
        ErrorLog /var/log/apache2/frontend-error.log
        
        # Possible values include: debug, info, notice, warn, error, crit,
        # alert, emerg.
        LogLevel warn
        
        CustomLog /var/log/apache2/frontend-access.log combined
    </VirtualHost>
    
    <VirtualHost *:80>
        ServerAdmin admin@example.com
        
        ServerName backoffice.zfs.local
        DocumentRoot PATH_TO_THE_PROJECT/public/backoffice
        <Directory />
            Options FollowSymLinks
            AllowOverride All 
        </Directory>
        <Directory PATH_TO_THE_PROJECT/public/backoffice>
            Options -Indexes
            AllowOverride All
            Order allow,deny
            allow from all
        </Directory>
        
        ErrorLog /var/log/apache2/backoffice-error.log
        
        # Possible values include: debug, info, notice, warn, error, crit,
        # alert, emerg.
        LogLevel warn
        
        CustomLog /var/log/apache2/backoffice-access.log combined
    </VirtualHost>

5. If you are working on a local machine add the servername to your local hosts file

    `On *nix: echo 'frontend.zfs.local' >> /etc/hosts`  
    `On *nix: echo 'backoffice.zfs.local' >> /etc/hosts`

That's it you can start now using the skeleton to build the next amazing app!