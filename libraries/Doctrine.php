<?php

use Doctrine\Common\ClassLoader;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

define('SIMPLESHOP_MODULE_PATH', dirname(__DIR__) . '/');

/**
 * Doctrine bootstrap library for CodeIgniter
 *
 * @author	Joseph Wynn <joseph@wildlyinaccurate.com>
 * @link	http://wildlyinaccurate.com/integrating-doctrine-2-with-codeigniter-2
 */
class Doctrine
{

	public $em;

	public function __construct()
	{
		require_once __DIR__ . '/Doctrine/ORM/Tools/Setup.php';

		Setup::registerAutoloadDirectory(__DIR__);

		$extensionsClassLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions', SIMPLESHOP_MODULE_PATH . 'libraries/Doctrine');
		$extensionsClassLoader->register();

		$ci =& get_instance();

		// Load the database configuration from CodeIgniter
		require APPPATH . 'config/database.php';

		$connection_options = array(
			'driver'		=> 'pdo_mysql',
			'user'			=> $db[ENVIRONMENT]['username'],
			'password'		=> $db[ENVIRONMENT]['password'],
			'host'			=> $db[ENVIRONMENT]['hostname'],
			'dbname'		=> $db[ENVIRONMENT]['database'],
			'charset'		=> $db[ENVIRONMENT]['char_set'],
			'driverOptions'	=> array(
				'charset'	=> $db[ENVIRONMENT]['char_set'],
			),
		);

		$models_namespace = 'Simpleshop/Entity';
		$models_path = SIMPLESHOP_MODULE_PATH . 'Simpleshop';
		$proxies_dir = SIMPLESHOP_MODULE_PATH . 'Simpleshop/Entity/Proxies';
		$metadata_paths = array(SIMPLESHOP_MODULE_PATH . 'Simpleshop/Entity');

		$dev_mode = (ENVIRONMENT == PYRO_DEVELOPMENT);
		$config = Setup::createAnnotationMetadataConfiguration($metadata_paths, $dev_mode, $proxies_dir);

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

		$config->setMetadataCacheImpl($cache);
		$config->setQueryCacheImpl($cache);

		$this->em = EntityManager::create($connection_options, $config);

		// Load the TablePrefix event listener
		$tablePrefix = new \DoctrineExtensions\TablePrefix($ci->db->dbprefix);
		$this->em->getEventManager()->addEventListener(\Doctrine\ORM\Events::loadClassMetadata, $tablePrefix);

		$loader = new ClassLoader($models_namespace, $models_path);
		$loader->register();
	}

}
