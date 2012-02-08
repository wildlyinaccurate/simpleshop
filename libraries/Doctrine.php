<?php
use Doctrine\ORM\EntityManager,
	Doctrine\ORM\Configuration;

define('MODULE_PATH', dirname(__DIR__) . '/');
define('DEBUGGING', false);

class Doctrine {

	/** @var \Doctrine\ORM\EntityManager */
	public $em;

	/** @var \CI_Controller */
	private $_ci;

	public function __construct()
	{
		// Include the database configuration file so we can retrieve the DB details
		require APPPATH . 'config/database.php';

		// Also get the CodeIgniter instance so that we can find out the table prefix
		$this->_ci = get_instance();

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

		// Detect which caching mechanism is available, if any.
		// See http://www.doctrine-project.org/docs/orm/2.1/en/reference/caching.html
		if (extension_loaded('apc') && ini_get('apc.enabled'))
		{
			$cache = new \Doctrine\Common\Cache\ApcCache;
		}
		elseif (extension_loaded('memcache'))
		{
			// Configure your Memcache server here
			$memcache = new Memcache;
			$memcache->connect('memcache_host', 11211);

			$cache = new \Doctrine\Common\Cache\MemcacheCache;
			$cache->setMemcache($memcache);
		}
		elseif (extension_loaded('memcached'))
		{
			$memcached = new Memcached;

			$cache = new \Doctrine\Common\Cache\MemcachedCache;
			$cache->setMemcached($memcached);
		}
		elseif (extension_loaded('xcache') && ini_get('xcache.cacher'))
		{
			$cache = new \Doctrine\Common\Cache\XcacheCache;
		}
		else
		{
			// This is a fallback cache which is used if none of the above caches
			// are installed. It provides very little (if any) performance gains.
			$cache = new \Doctrine\Common\Cache\ArrayCache;
		}

		// Set metadata and query caching
		$config->setMetadataCacheImpl($cache);
		$config->setQueryCacheImpl($cache);

		// Proxies
		$config->setProxyDir(MODULE_PATH . 'models/Proxies');
		$config->setProxyNamespace('Proxies');

		if (ENVIRONMENT == 'development') {
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

		// Event Manager
		$evm = new \Doctrine\Common\EventManager;

		// Load the TablePrefix event listener
		$tablePrefix = new \DoctrineExtensions\TablePrefix($this->_ci->db->dbprefix);
		$evm->addEventListener(\Doctrine\ORM\Events::loadClassMetadata, $tablePrefix);

		// Database connection information
		$connectionOptions = array(
			'driver' => 'pdo_mysql',
			'user' => $db[ENVIRONMENT]['username'],
			'password' => $db[ENVIRONMENT]['password'],
			'host' => $db[ENVIRONMENT]['hostname'],
			'dbname' => $db[ENVIRONMENT]['database']
		);

		// Create EntityManager
		$this->em = EntityManager::create($connectionOptions, $config, $evm);

	    // Map ENUM as strings to get around errors with non-Doctrine tables containing ENUM columns
	    $db_platform = $this->em->getConnection()->getDatabasePlatform();
	    $db_platform->registerDoctrineTypeMapping('enum', 'string');
	    $db_platform->registerDoctrineTypeMapping('set', 'string');
            $db_platform->registerDoctrineTypeMapping('blob', 'string');
	}
}
