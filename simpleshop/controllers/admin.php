<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller {

    protected $section = 'orders';

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
	 * Index / Landing Page
	 *
	 * @return void
	 */
	function index()
	{
		$this->template
            ->title($this->module_details['name'])
            ->build('admin/index');
	}

}

/* End of file admin.php */