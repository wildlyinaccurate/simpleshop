<?php
use Doctrine\ORM\EntityManager,
	Doctrine\ORM\Configuration;

define('MODULE_PATH', dirname(__DIR__) . '/');
define('DEBUGGING', FALSE);

class Doctrine {

	public $em = null;

	public function __construct()
	{
		// Get the CodeIgniter instance so that we can retrieve the DB details
		$ci = get_instance();

		// Set up class loading.
		require_once MODULE_PATH . 'libraries/Doctrine/Common/ClassLoader.php';

		$doctrineClassLoader = new \Doctrine\Common\ClassLoader('Doctrine', MODULE_PATH . 'libraries');
		$doctrineClassLoader->register();

		$entitiesClassLoader = new \Doctrine\Common\ClassLoader('Entity', MODULE_PATH . 'models');
		$entitiesClassLoader->register();

		$proxiesClassLoader = new \Doctrine\Common\ClassLoader('Proxies', MODULE_PATH . 'models');
		$proxiesClassLoader->register();

		$symfonyClassLoader = new \Doctrine\Common\ClassLoader('Symfony', MODULE_PATH . 'libraries/Doctrine');
		$symfonyClassLoader->register();

		$extensionsClassLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions', MODULE_PATH . 'libraries/Doctrine');
		$extensionsClassLoader->register();

		// Set some configuration options
		$config = new Configuration;

		// Metadata driver
		$driverImpl = $config->newDefaultAnnotationDriver(MODULE_PATH . 'models');
		$config->setMetadataDriverImpl($driverImpl);

		// Caching
		$cache = new \Doctrine\Common\Cache\ApcCache;
		$config->setMetadataCacheImpl($cache);
		$config->setQueryCacheImpl($cache);

		// Proxies
		$config->setProxyDir(MODULE_PATH . 'models/Proxies');
		$config->setProxyNamespace('Proxies');

		if (ENVIRONMENT == 'dev') {
			$config->setAutoGenerateProxyClasses(TRUE);
		} else {
			$config->setAutoGenerateProxyClasses(FALSE);
		}

		// SQL query logger
		if (DEBUGGING)
		{
			$logger = new \Doctrine\DBAL\Logging\EchoSQLLogger;
			$config->setSQLLogger($logger);
		}

		// Set up the table prefix
		$tablePrefix = new \DoctrineExtensions\TablePrefix($ci->db->dbprefix);

		$evm = new \Doctrine\Common\EventManager;
		$evm->addEventListener(\Doctrine\ORM\Events::loadClassMetadata, $tablePrefix);

		// Database connection information
		$connectionOptions = array(
			'driver' => 'pdo_mysql',
			'user' => $ci->db->username,
			'password' => $ci->db->password,
			'host' => $ci->db->hostname,
			'dbname' => $ci->db->database
		);

		// Create EntityManager
		$this->em = EntityManager::create($connectionOptions, $config, $evm);
	}
}
