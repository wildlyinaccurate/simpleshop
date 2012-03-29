<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SimpleShop Public Base Controller
 *
 * Loads various libraries and partials that are used throughout the module
 */
class Simpleshop_Public_Controller extends Public_Controller {

	/**
	 * Doctrine Entity Manager
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $em;

	/**
	 * Nested Set Manager
	 * @var \DoctrineExtensions\NestedSet\Manager
	 */
	protected $nsm;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$this->lang->load('simpleshop');
		$this->load->config('simpleshop');
		$this->load->helper('simpleshop');
	    $this->load->library(array(
		    'doctrine',
		    'form_validation'
	    ));

	    // Create a shortcut property to the Doctrine Entity Manager and Nested Set Manager
	    $this->em = $this->doctrine->em;

		$config = new \DoctrineExtensions\NestedSet\Config($this->em, 'Entity\Category');
		$this->nsm = new \DoctrineExtensions\NestedSet\Manager($config);
	}

}

/* End of file Simpleshop_Admin_Controller.php */
