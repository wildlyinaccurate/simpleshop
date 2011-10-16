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
			'rules' => 'trim|required|max_length[130]|callback__check_title'
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
					$this->session->set_flashdata('error', sprintf($this->lang->line('cat_mass_delete_error'), $category->getTitle()));
				}
			}

			try
			{
				$this->em->flush();
				$this->session->set_flashdata('success', sprintf($this->lang->line('cat_mass_delete_success'), implode(', ', $deleted)));
			}
			catch (\Doctrine\ORM\OptimisticLockException $e)
			{
				$this->session->set_flashdata('error', sprintf($this->lang->line('cat_mass_delete_error'), $category->getTitle()));
			}
		}
		else
		{
			$this->session->set_flashdata('error', $this->lang->line('cat_no_select_error'));
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

		$category OR redirect('admin/simpleshop/categories');

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
			$category->setTitle($this->input->post('title'))
					->setDescription($this->input->post('description'));
		}

		if ($this->form_validation->run())
		{
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

		if ($this->method == 'create')
		{
			$page_title = lang('create_category');
		}
		else
		{
			$page_title = sprintf(lang('edit_category'), $category->getTitle());
		}

		$this->template
			->title($this->module_details['name'], $page_title)
			->build('admin/categories/form', array(
				'page_title' => $page_title,
				'category' => $category
		));
	}

	/**
	 * Callback method that checks for unique category titles
	 *
	 * @access  public
	 * @param   string  $title
	 * @return  bool
	 */
	public function _check_title($title = '')
	{
		if ($this->em->getRepository('\Entity\Category')->findOneBy(array('title' => $title)))
		{
			$this->form_validation->set_message('_check_title', sprintf($this->lang->line('cat_already_exist_error'), $title));
			return FALSE;
		}

		return TRUE;
	}

}

/* End of file admin_categories.php */