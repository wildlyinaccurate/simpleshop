<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Simpleshop\Entity\Product;

require_once __DIR__ . '/../core/Simpleshop_Admin_Controller.php';

/**
 * Product management controller
 */
class Admin_Products extends Simpleshop_Admin_Controller
{

    /**
     * The current active section
     * @access  protected
     * @var     int
     */
    protected $section = 'catalogue';

    /**
     * The array containing the rules for products
     * @access  private
     * @var     array
     */
    private $validation_rules = array(
        array(
            'field' => 'title',
            'label' => 'lang:simpleshop.products.title_label',
            'rules' => 'trim|required|max_length[130]'
        ),
        array(
            'field'	=> 'description',
            'label'	=> 'lang:simpleshop.products.description_label',
            'rules'	=> 'trim|max_length[2000]'
        ),
        array(
            'field'	=> 'price',
            'label'	=> 'lang:simpleshop.products.price_label',
            'rules'	=> 'numeric'
        ),
        array(
            'field'	=> 'categories',
            'label'	=> 'lang:simpleshop.products.categories_label',
            'rules'	=> ''
        ),
        array(
            'field' => 'stock',
            'label' => 'lang:simpleshop.products.stock_label',
            'rules' => 'is_natural'
        ),
        array(
            'field' => 'unlimited_stock',
            'label' => 'lang:simpleshop.products.unlimited_stock_label',
            'rules' => ''
        ),
    );

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->lang->load('products');
    }

    /**
     * List all products
     *
     * @return void
     */
    public function index()
    {
        $this->template
            ->title($this->module_details['name'], lang('simpleshop.products_title'))
            ->build('admin/products/index', array(
                'products' => $this->em->getRepository('Simpleshop\Entity\Product')->findAll(array(), array('title' => 'ASC')),
            ));
    }

    /**
     * Delete a product
     *
     * @param  int  $id
     * @return void
     */
    public function delete($id = 0)
    {
        role_or_die('simpleshop', 'delete_product');

        $id_array = ( ! empty($id)) ? array($id) : $this->input->post('action_to');

        // Delete multiple
        if ( ! empty($id_array)) {
            $deleted = array();

            foreach ($id_array as $id) {
                $product = $this->em->find('Simpleshop\Entity\Product', $id);

                try {
                    $this->em->remove($product);
                    $deleted[] = $product->getTitle();
                } catch (InvalidArgumentException $e) {
                    $this->session->set_flashdata('error', sprintf(lang('simpleshop.products.single_delete_error'), $product->getTitle()));
                }
            }

            try {
                $this->em->flush();
                $this->session->set_flashdata('success', sprintf(lang('simpleshop.products.mass_delete_success'), implode(', ', $deleted)));
            } catch (\Doctrine\ORM\OptimisticLockException $e) {
                $this->session->set_flashdata('error', lang('simpleshop.products.mass_delete_error'));
            }
        } else {
            $this->session->set_flashdata('error', lang('simpleshop.products.no_select_error'));
        }

        redirect('admin/simpleshop');
    }

    /**
     * Create a new product
     *
     * @return void
     */
    public function create()
    {
        role_or_die('simpleshop', 'create_product');

        $this->_display_form(new Product);
    }

    /**
     * Edit an existing product
     *
     * @param  int  $product_id
     * @return void
     */
    public function edit($product_id = NULL)
    {
        role_or_die('simpleshop', 'edit_product');

        $product = $this->em->find('Simpleshop\Entity\Product', $product_id);

        $product OR redirect('admin/simpleshop');

        $this->_display_form($product);
    }

    /**
     * Display the create/edit form
     *
     * @param  Simpleshop\Entity\Product $product
     * @return void
     */
    private function _display_form(Product $product)
    {
        role_or_die('simpleshop', 'create_product');

        $this->form_validation->set_rules($this->validation_rules);

        if ($_POST) {
            $product->setTitle($this->input->post('title'))
                ->setDescription($this->input->post('description'))
                ->setPrice($this->input->post('price'))
                ->setStock($this->input->post('stock'))
                ->setUnlimitedStock($this->input->post('unlimited_stock'));

            // Remove all product categories, and then set them from form data
            $product->getCategories()->clear();

            foreach ($this->input->post('categories') as $category_id) {
                if ($category = $this->em->find('Simpleshop\Entity\Category', $category_id)) {
                    $product->addCategory($category);
                }
            }
        }

        if ($this->form_validation->run()) {
            // Save the Product
            $this->em->persist($product);
            $this->em->flush();

            $this->session->set_flashdata('success', sprintf(lang('simpleshop.products.save_success'), $product->getTitle()));

            // Redirect back to the form or main page
            if ($this->input->post('btnAction') == 'save_exit') {
                redirect('admin/simpleshop');
            } else {
                redirect('admin/simpleshop/products/edit/' . $product->getId());
            }
        }

        if ($this->method == 'create') {
            $page_title = lang('simpleshop.create_product');
        } else {
            $page_title = sprintf(lang('simpleshop.edit_product'), $product->getTitle());
        }

        // Get the root categories to build the tree from
        $root_categories = $this->em->getRepository('Simpleshop\Entity\Category')->findBy(array('parent_category' => null), array('title' => 'ASC'));

        $this->template
            ->title($this->module_details['name'], $page_title)
            ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, true))
            ->build('admin/products/form', array(
                'page_title' => $page_title,
                'product' => $product,
                'selected_category_id' => $this->input->get('category_id'),
                'root_categories' => $root_categories,
                'nsm' => $this->nsm,
        ));
    }

}
