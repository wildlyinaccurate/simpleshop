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
	 * Nested Set Manager
	 * @var \DoctrineExtensions\NestedSet\Manager
	 */
	protected $nsm;

	/**
	 * ID of the category currently being viewed in the catalogue
	 * @var int|null
	 */
	protected $viewing_category_id = null;

	/**
	 * The Entity for the category currently being viewed
	 * @var \Entity\Category|null
	 */
	protected $viewing_category = null;

	/**
	 * NestedSet-wrapped Node for the category currently being viewed
	 * @var DoctrineExtensions\NestedSet\NodeWrapper|null
	 */
	protected $viewing_category_node = null;

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

	    // Create a shortcut property to the Doctrine Entity Manager and Nested Set Manager
	    $this->em = $this->doctrine->em;

		$config = new \DoctrineExtensions\NestedSet\Config($this->em, 'Entity\Category');
		$this->nsm = new \DoctrineExtensions\NestedSet\Manager($config);

		// Get the currently viewed category
		if ($this->input->get('category_id'))
		{
			$this->viewing_category_id = $this->input->get('category_id');
			$this->viewing_category = $this->em->find('\Entity\Category', $this->viewing_category_id);

			if ($this->viewing_category)
			{
				$this->viewing_category_node = $this->nsm->wrapNode($this->viewing_category);
			}
		}
	}

}

/* End of file Simpleshop_Admin_Controller.php */
