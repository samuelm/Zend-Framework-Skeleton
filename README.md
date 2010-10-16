Description
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
* Memcache and file cache backends configured
* Automatic CSRF check in all the forms
* Autoloader configured
* Router configured to read the routes from xml files
* Different bootstrap and entry point per module
* Zend_Locale configured to detect the locale and degrades gracefully
* App configured to use three environments (dev, staging, production)
* Zend_Registry up and running
* All the handy data stored in the Registry and constants like environment, some paths (app path, root path), config object...
* View Helper to translate using the following method $this->t() instead of $this->translate() (much shorter)
* Flag and Flippers concept of flickr implemented through ACL
* Flag and Flippers configurable via BO (Still some stuff in development)
* CLI tool to generate basic ACL rules for controllers and actions
* Basic Inflector
* Strong password rules (The new password cannot be any of the last 4 used)
* Three custom validators to handle passwords
* Basic BO structure with two levels of navigation
* BO menu generated automatically based on an array and filtered through the Flag and flippers configured
* All the tables needed dumped in a sql file under /docs

Credentials to access the BO
============================

Admin Group
-----------
Username: john.doe

Password: lorem

Member Group
------------
Username: member.test

Password: lorem

Installation
============

0. You have to have a memcached server and the memcache php extension installed
1. Get a copy of the files in your machine
2. Create two folders called cache and logs in the root of the project and subfolders in logs one for each module
    
    `On *nix: mkdir -p cache logs/backoffice logs/frontend/missing_translations`
    
3. Give read/write access to those folders
    
    `On *nix: chmod -R 777 cache logs`
    
4. Create the virtual hosts (one per module)
    
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