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

		$this->load->language(array(
			'categories',
			'products'
		));
	}

	/**
	 * Index / Landing Page
	 *
	 * @return void
	 */
	function index()
	{
		$category_id = $this->input->get('category_id');

		$category = $this->em->find('Entity\Category', $category_id);
		$child_categories = $this->em->getRepository('Entity\Category')->findBy(array('parent_category' => $category_id), array('title' => 'ASC'));

		$this->template
            ->title($this->module_details['name'], lang('catalogue_title'))
			->append_metadata(js('catalogue.js', 'simpleshop'))
            ->build('admin/catalogue/index', array(
				'category_id' => $category_id,
				'category' => $category,
				'child_categories' => $child_categories
		));
	}

}

/* End of file admin.php */