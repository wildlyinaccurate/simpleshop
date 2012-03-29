<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(dirname(__FILE__)) . '/core/Simpleshop_Public_Controller.php';

/**
 * Simple Shop provides basic e-commerce functionality to a PyroCMS site.
 *
 * @category    Modules
 * @author      Joseph Wynn
 */
class Simpleshop extends Simpleshop_Public_Controller
{

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * View the catalogue index
	 *
	 * /simpleshop/category/{id}/{slug} routes here.
	 *
	 * @param	int		$category_id
	 * @return	void
	 * @author  Joseph Wynn <joe@chromaagency.com>
	 */
	function index($category_id = null)
	{
		$category_repository = $this->em->getRepository('Entity\Category');
		$categories = $category_repository->findBy(array('parent_category' => $category_id), array('title' => 'ASC'));
		$current_category = $category_repository->find($category_id);

		$this->template->title($this->module_details['name'])
			->set_breadcrumb('This should be a setting')
			->build('index', array(
				'categories' => $categories,
				'current_category' => $current_category,
		));
	}

}

/* End of file simpleshop.php */
