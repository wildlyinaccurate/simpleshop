<?php

// Kind of hacky way to get the PyroCMS APPPATH (system/cms)
define('APPPATH', realpath(__DIR__ . '/../../../../..') . '/system/cms/');
define('BASEPATH', APPPATH);
define('ENVIRONMENT', 'local');

chdir(dirname(__DIR__) . '/');

require_once 'libraries/Doctrine/Common/ClassLoader.php';

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine', 'libraries');
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Symfony', 'libraries/Doctrine');
$classLoader->register();

$configFile = 'libraries/Doctrine.php';

$helperSet = null;
if (file_exists($configFile)) {
    if ( ! is_readable($configFile)) {
        trigger_error(
            'Configuration file [' . $configFile . '] does not have read permission.', E_ERROR
        );
    }

    require $configFile;

    foreach ($GLOBALS as $helperSetCandidate) {
        if ($helperSetCandidate instanceof \Symfony\Component\Console\Helper\HelperSet) {
            $helperSet = $helperSetCandidate;
            break;
        }
    }
}

$doctrine = new Doctrine;
$em = $doctrine->em;

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet);
