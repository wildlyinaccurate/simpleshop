<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Simple Shop provides basic e-commerce functionality to a PyroCMS site.
 *
 * @category    Modules
 * @author      Joseph Wynn
 */
class Simpleshop extends Public_Controller {

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
		exit('Welcome! (Front-End)');
	}

}

/* End of file simpleshop.php */