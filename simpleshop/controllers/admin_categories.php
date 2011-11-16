<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Include the SimpleShop base controller
require_once dirname(dirname(__FILE__)) . '/core/Simpleshop_Admin_Controller.php';

/**
 * Category management controller
 */
class Admin_Categories extends Simpleshop_Admin_Controller {

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
	protected $section = 'catalogue';

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

		$this->lang->load('categories');
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
	 * Delete a category
	 *
	 * @param   int     $id
	 * @return  void
	 */
	public function delete($id = 0)
	{
		$id_array = ( ! empty($id)) ? array($id) : $this->input->post('action_to');

		// Delete multiple
		if ( ! empty($id_array))
		{
			$deleted = array();

			foreach ($id_array as $id)
			{
				$category = $this->em->find('\Entity\Category', $id);

				try
				{
					$this->em->remove($category);
					$deleted[] = $category->getTitle();
				}
				catch (InvalidArgumentException $e)
				{
					$this->session->set_flashdata('error', sprintf($this->lang->line('category_single_delete_error'), $category->getTitle()));
				}
			}

			try
			{
				$this->em->flush();
				$this->session->set_flashdata('success', sprintf($this->lang->line('category_mass_delete_success'), implode(', ', $deleted)));
			}
			catch (\Doctrine\ORM\OptimisticLockException $e)
			{
				$this->session->set_flashdata('error', $this->lang->line('category_mass_delete_error'));
			}
		}
		else
		{
			$this->session->set_flashdata('error', $this->lang->line('category_no_select_error'));
		}

		redirect('admin/simpleshop/categories');
	}

	/**
	 * Create a new category
	 *
	 * @return	void
	 */
	public function create()
	{
		$this->_create_edit_category(new \Entity\Category);
	}

	/**
	 * Edit an existing category
	 *
	 * @param   int     $category_id
	 * @return  void
	 */
	public function edit($category_id = NULL)
	{
		$category = $this->em->find('\Entity\Category', $category_id);

		$category OR redirect('admin/simpleshop/categories');

		$this->_create_edit_category($category);
	}

	/**
	 * Display the create/edit form
	 *
	 * @param   Entity\Category $category
	 * @return  void
	 */
	private function _create_edit_category(\Entity\Category $category)
	{
		role_or_die('simpleshop', 'create_category');

		$this->form_validation->set_rules($this->validation_rules);

		if ($_POST)
		{
			// Update the category if any data was submitted
			$category->setTitle($this->input->post('title'))
					->setDescription($this->input->post('description'));
		}

		if ($this->form_validation->run())
		{
			// See if a parent category was selected
			$parent_category_id = $this->input->post('parent_category');

			if ((int) $parent_category_id > 0 && $parent_category = $this->em->find('Entity\Category', $parent_category_id))
			{
				// A parent category was selected
				$category->setParentCategory($parent_category);
			}

			// Save the Category
			$this->em->persist($category);
		    $this->em->flush();

			// Redirect back to the form or main page
			if ($this->input->post('btnAction') == 'save_exit')
			{
				redirect('admin/simpleshop/categories');
			}
			else
			{
				redirect('admin/simpleshop/categories/edit/' . $category->getId());
			}
		}
		
		// Set the page title depending on whether we're creating or editing a category
		if ($this->method == 'create')
		{
			$page_title = lang('create_category');
		}
		else
		{
			$page_title = sprintf(lang('edit_category'), $category->getTitle());
		}

		// Get the root categories to build the tree from
		$root_categories = $this->em->getRepository('Entity\Category')->findBy(array('parent_category' => null), array('title' => 'ASC'));

		$this->template
			->title($this->module_details['name'], $page_title)
			->build('admin/categories/form', array(
				'page_title' => $page_title,
				'category' => $category,
				'root_categories' => $root_categories
		));
	}

}

/* End of file admin_categories.php */