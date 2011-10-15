<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Categories extends Admin_Controller {

	/**
	 * Doctrine EntityManager
	 * @access  protected
	 * @var     \Doctrine\ORM\EntityManager
	 */
	protected $em;

	/**
	 * The current active section
	 * @access  protected
	 * @var     int
	 */
	protected $section = 'categories';

	/**
	 * The array containing the rules for categories
	 * @access  private
	 * @var     array
	 */
	private $validation_rules = array(
		array(
			'field' => 'title',
			'label' => 'lang:category_title_label',
			'rules' => 'trim|required|max_length[130]'
		),
		array(
			'field'	=> 'description',
			'label'	=> 'lang:category_description_label',
			'rules'	=> 'trim|max_length[2000]'
		)
	);

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$this->lang->load(array(
			'simpleshop',
			'categories'
		));
		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');

	    $this->load->library(array(
		    'doctrine',
		    'form_validation'
	    ));
	    $this->em = $this->doctrine->em;
	}

	/**
	 * List all categories
	 *
	 * @return void
	 */
	public function index()
	{
		$this->template
			->title($this->module_details['name'], lang('categories_title'))
			->build('admin/categories/index', array(
				'categories' => $this->em->getRepository('Entity\Category')->findAll(array(), 'title')
		));
	}

	/**
	 * Create a new category
	 *
	 * @return	void
	 */
	public function create()
	{
		role_or_die('simpleshop', 'create_category');
		
		$this->form_validation->set_rules($this->validation_rules);

		// Create a new Category
		$category = new \Entity\Category;
		$category->setTitle($this->input->post('title'))
				->setDescription($this->input->post('description'));

		if ($this->form_validation->run())
		{
			// Save the Category
		    $this->em->persist($category);
		    $this->em->flush();

			// Redirect back to the form or main page
			if ($this->input->post('btnAction') == 'save_exit')
			{
				redirect('admin/simpleshop');
			}
			else
			{
				redirect('admin/simpleshop/categories/edit/' . $category->getId());
			}
		}

		$this->template
			->title($this->module_details['name'], lang('create_category'))
			->build('admin/categories/form', array(
				'category' => $category
		));
	}

}

/* End of file admin_categories.php */