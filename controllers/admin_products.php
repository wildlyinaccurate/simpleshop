<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Products extends Admin_Controller {

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$this->lang->load(array('simpleshop'));

		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
	}

	/**
	 * List all products
	 *
	 * @return void
	 */
	function index()
	{
		die('Products!');
	}

}

/* End of file admin_products.php */