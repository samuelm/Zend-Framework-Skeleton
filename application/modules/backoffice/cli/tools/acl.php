<?php
/**
 * Gets all the methods in a controller and 
 * grabs all the acl information
 *
 * @category backoffice
 * @package backoffice_cli
 * @subpackage backoffice_cli_tools
 * @copyright Company
 */

require_once dirname(__FILE__) . '/../cli.php';

if (!Zend_Registry::get('IS_DEVELOPMENT')) {
    echo 'Please use this tool only in the development environment.';
    die();
}

try {
    $opts = new Zend_Console_Getopt(array('path|p=s' => 'Path to the desired folder/file. For example: /var/www/myapp/controllers/',));
    $opts->parse();
} catch(Zend_Console_Getopt_Exception $e) {
    echo $e->getUsageMessage();
    exit(); 
}

$path = $opts->getOption('p');
if (!$path) {
    echo $opts->getUsageMessage();
    exit();
}

if (!is_readable($path)) {
    echo 'Error! Path ' . $path . ' is not readable.';
    exit();
}

$files = array();
if (is_file($path)) {
    $files  []= basename($path);
    $path = dirname($path);
} else {
    if (($dir = opendir($path)) !== false) {
        while (($file = readdir($dir)) !== false) {
            if (fnmatch('*.php', $file) && $file !== 'ErrorController.php') {
                $files[]= $file;
            }
        }
        closedir($dir);
    }
}

$resources = array();
$inflector = App_Inflector::getInstance();

foreach ($files as $file) {
    $filepath = $path . DIRECTORY_SEPARATOR . $file;
    require_once $filepath;
    
    $reflectionFile = new Zend_Reflection_File($filepath);
    foreach($reflectionFile->getClasses() as $class) {
        $classInfo = array(
            'description' => $class->getDocblock()->getShortDescription(),
            'name' => $inflector->convertControllerName($class->getName()),
            'methods' => array(),
        );
        
        foreach ($class->getMethods() as $method) {
            if (substr($method->getName(), -6) == 'Action') {
                $classInfo['methods'][] = array(
                    'description' => $method->getDocblock()->getShortDescription(),
                    'name' => $inflector->convertActionName($method->getName()),
                );
            }
        }
        
        $resources[] = $classInfo;
    }
}

$acl = App_Cli_Acl::getInstance();
$inserts = $acl->generateInserts($resources);
if (empty($inserts)) {
    echo 'No new resources / privileges found.';
    exit();
}

$date = new Zend_Date();
echo '-- ACL data' . PHP_EOL;
echo '-- Report generated at ' . $date . PHP_EOL;

foreach ($inserts as $insert) {
    echo $insert . PHP_EOL;
}