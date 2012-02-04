<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SimpleShop Admin Base Controller
 *
 * Loads various libraries and partials that are used throughout the module
 */
class Simpleshop_Admin_Controller extends Admin_Controller {

	/**
	 * Doctrine Entity Manager
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $em;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();

		// Module language file
		$this->lang->load('simpleshop');

		// Shortcuts partial
		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts')
				->append_metadata(css('simpleshop.css', 'simpleshop'));

		// Form validation and Doctrine
	    $this->load->library(array(
		    'doctrine',
		    'form_validation'
	    ));

		// Helper functions
		$this->load->helper('simpleshop');

	    // Create a shortcut property to the Doctrine Entity Manager
	    $this->em = $this->doctrine->em;
	}

}

/** End of file Simpleshop_Admin_Controller.php */