<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(dirname(__FILE__)) . '/core/Simpleshop_Admin_Controller.php';

/**
 * Catalogue (default admin controller)
 */
class Admin extends Simpleshop_Admin_Controller
{

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
		$category_repository = $this->em->getRepository('Entity\Category');
		$categories = $category_repository->findBy(array('parent_category' => $this->viewing_category_id), array('title' => 'ASC'));

		$this->template
            ->title($this->module_details['name'], lang('catalogue_title'))
			->append_metadata(js('catalogue.js', 'simpleshop'))
            ->build('admin/catalogue/index', array(
				'categories' => $categories,
		));
	}

}

/* End of file admin.php */
