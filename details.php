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

		$doctrine = new Doctrine;
		$this->em = $doctrine->em;
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

			'roles' => array(
				'create_category'
			),

            'sections' => array(
                'categories' => array(
                    'name' => 'categories_title',
                    'uri' => 'admin/simpleshop/categories',
                    'shortcuts' => array(
                        array(
                            'name' => 'create_category',
                            'uri' => 'admin/simpleshop/categories/create',
                        ),
                    ),
                ),
            )
		);
	}

	public function install()
	{
		$metadatas = $this->em->getMetadataFactory()->getAllMetadata();

		$schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
		$schemaTool->dropSchema($metadatas);
		$schemaTool->createSchema($metadatas);
		
		return TRUE;
	}

	public function uninstall()
	{
		$metadatas = $this->em->getMetadataFactory()->getAllMetadata();

		$schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
		$schemaTool->dropSchema($metadatas);

		return TRUE;
		
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