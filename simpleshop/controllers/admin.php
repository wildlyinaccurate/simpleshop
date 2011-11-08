<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Include the SimpleShop base controller
require_once dirname(dirname(__FILE__)) . '/core/Simpleshop_Admin_Controller.php';

/**
 * Catalogue (default admin controller)
 */
class Admin extends Simpleshop_Admin_Controller {

    protected $section = 'catalogue';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Index / Landing Page
	 *
	 * @return void
	 */
	function index()
	{
		$categories = $this->em->getRepository('Entity\Category')->findBy(array(), array('title' => 'ASC'));
		$products = $this->em->getRepository('Entity\Product')->findBy(array(), array('title' => 'ASC'));

		$this->template
            ->title($this->module_details['name'], lang('catalogue_title'))
			->append_metadata(css('simpleshop.css', 'simpleshop'))
            ->build('admin/catalogue/index', array(
				'categories' => $categories,
				'products' => $products
		));
	}

}

/* End of file admin.php */