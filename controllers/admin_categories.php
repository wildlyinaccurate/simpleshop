<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Categories extends Admin_Controller {

	protected $section = 'categories';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$metadatas = $this->doctrine->em->getMetadataFactory()->getAllMetadata();
		$tool = new \Doctrine\ORM\Tools\SchemaTool($this->doctrine->em);
		$tool->createSchema($metadatas);

		exit ("J");

		$this->load->model('category_model');
		$this->lang->load(array('simpleshop'));

		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
	}

	/**
	 * List all categories
	 *
	 * @return void
	 */
	public function index()
	{
		$this->template
			->title($this->module_details['name'], lang('simpleshop.categories_title'))
			->build('admin/categories/index', array(
				'categories' => $this->category_model->get_all()
		));
	}

	/**
	 * Create a new category
	 *
	 * @return	void
	 */
	public function create()
	{
		$this->template
			->title($this->module_details['name'], lang('simpleshop.create_category'))
			->build('admin/categories/create', array(

		));
	}

}

/* End of file admin_categories.php */