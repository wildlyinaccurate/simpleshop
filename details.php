<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Module_Simpleshop extends Module {

	public $version = '1.0';

	/** @var \Doctrine\ORM\EntityManager */
	private $em;

	/**
	 * Constructor - Load Doctrine
	 */
	public function __construct()
	{
		require_once __DIR__ . '/libraries/Doctrine.php';
		$this->em = new Doctrine;
	}

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Simple Shop'
			),
			'description' => array(
				'en' => 'Manage a simple online shop.'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'simpleshop',

            'sections' => array(
                'categories' => array(
                    'name' => 'simpleshop.categories_title',
                    'uri' => 'admin/simpleshop/categories',
                    'shortcuts' => array(
                        array(
                            'name' => 'simpleshop.create_category',
                            'uri' => 'admin/simpleshop/categories/create',
                        ),
                    ),
                ),
            )
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('simpleshop_products');
		$this->dbforge->drop_table('simpleshop_categories');

		$products = <<<SQL
CREATE TABLE `{$this->db->dbprefix('simpleshop_products')}` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `price` double(14,2) NOT NULL,
  `stock` mediumint(8) unsigned DEFAULT NULL,
  `unlimited_stock` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
SQL;

		$categories = <<<SQL
CREATE TABLE `{$this->db->dbprefix('simpleshop_categories')}` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
SQL;


		if ($this->db->query($products) && $this->db->query($categories))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		if ($this->dbforge->drop_table('simpleshop_products') &&
			$this->dbforge->drop_table('simpleshop_categories'))
		{
			return TRUE;
		}
	}

	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		return <<<HTML
<p>One day this might be helpful.</p>
HTML;

	}
}
/* End of file details.php */