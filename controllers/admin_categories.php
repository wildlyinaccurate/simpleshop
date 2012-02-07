<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Include the SimpleShop base controller
require_once dirname(dirname(__FILE__)) . '/core/Simpleshop_Admin_Controller.php';

/**
 * Category management controller
 */
class Admin_Categories extends Simpleshop_Admin_Controller
{

	/**
	 * Nested Set Manager
	 * @var \DoctrineExtensions\NestedSet\Manager
	 */
	protected $nsm;

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

		$config = new \DoctrineExtensions\NestedSet\Config($this->em);
		$this->nsm = new \DoctrineExtensions\NestedSet\Manager($config);
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
					$node = $this->nsm->wrapNode($category);
					$node->delete();
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

		redirect('admin/simpleshop');
	}

	/**
	 * Create a new category
	 *
	 * @return	void
	 */
	public function create()
	{
		$this->_display_form(new \Entity\Category);
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

		$category OR redirect('admin/simpleshop');

		$this->_display_form($category);
	}

	/**
	 * Display the create/edit form
	 *
	 * @param   Entity\Category $category
	 * @return  void
	 */
	private function _display_form(\Entity\Category $category)
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

			if ((int) $parent_category_id)
			{
				$parent_category = $this->em->find('Entity\Category', $parent_category_id);
			}

			if ($parent_category)
			{
				// A parent category was selected
				$parent_node = $this->nsm->wrapNode($parent_category);
				$parent_node->addChild($category);
			}
			else
			{
				// Create this category as a new root node
				$this->nsm->createRoot($category);
			}

			$message = ($this->method == 'create') ? $this->lang->line('category_add_success') : $this->lang->line('category_edit_success');
			$this->session->set_flashdata('success', sprintf($message, $this->input->post('title')));

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
		
		// Set the page title depending on whether we're creating or editing a category
		if ($this->method == 'create')
		{
			$page_title = lang('create_category');
		}
		else
		{
			$page_title = sprintf(lang('edit_category'), $category->getTitle());
		}

		$root_categories = $this->em->getRepository('Entity\Category')
			->findBy(array('parent_category' => null), array('title' => 'ASC'));

		$this->template
			->title($this->module_details['name'], $page_title)
			->build('admin/categories/form', array(
				'page_title' => $page_title,
				'category' => $category,
				'root_categories' => $root_categories,
				'nsm' => $this->nsm,
		));
	}

}

/* End of file admin_categories.php */
