<?php
/**
 * Default CLI configuration
 *
 * @category backoffice
 * @package backoffice_cli
 * @copyright Company
 */

// define the application path constant
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../../'));

$paths = array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
);

set_include_path(implode(PATH_SEPARATOR, $paths));

define('CURRENT_MODULE', 'backoffice');

// Run the main bootstrap
require_once APPLICATION_PATH . '/Bootstrap.php';
$boostrap = new Bootstrap(false);
$boostrap->bootstrap(array('Autoloader', 'Environment', 'Config', 'Db', 'ModulePaths'));

// Run the current's module CliBootstrap
require_once APPLICATION_PATH . '/modules/backoffice/CliBootstrap.php';
$cliModuleBootstrap = new CliBootstrap();