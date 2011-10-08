<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_Model {

	protected $_table = 'simpleshop_categories';
	protected $instantiate_model = TRUE;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

}

/* End of file category_model.php */