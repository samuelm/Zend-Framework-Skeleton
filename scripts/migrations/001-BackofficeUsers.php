<?php

/**
 * Create the main table
 *
 * @package migrations
 */

class BackofficeUsers extends Akrabat_Db_Schema_AbstractChange
{
    public function up(){
        $sql = "CREATE TABLE `backoffice_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(40) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `password_valid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `email` varchar(340) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `last_password_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_username` (`username`),
  KEY `idx_email` (`email`(255))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;";
        $this->_db->query($sql);
        
        $sql = "INSERT INTO `backoffice_users` (`id`,`firstname`,`lastname`,`username`,`password`,`password_valid`,`email`,`phone_number`,`last_login`,`last_password_update`)
VALUES
	(1, 'John', 'Doe', 'john.doe', '6c64e8dcebc17e3d08546a355b52817f63eb6fe2', 0, 'john@doe.es', '987654321', '2010-12-01 12:31:03', '2010-10-14 17:53:44');
";
        $this->_db->query($sql);
    }
    
    public function down(){
        $sql = "DROP TABLE IF EXISTS `backoffice_users`";
        $this->_db->query($sql);
    }
}
