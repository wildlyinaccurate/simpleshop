<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/../core/Simpleshop_Admin_Controller.php';

/**
 * Catalogue (default admin controller)
 */
class admin extends Simpleshop_Admin_Controller
{

    protected $section = 'catalogue';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->language(array(
            'categories',
            'products',
        ));
    }

    /**
     * Index / Landing Page
     *
     * @return void
     */
    public function index()
    {
        $category_repository = $this->em->getRepository('Simpleshop\Entity\Category');
        $categories = $category_repository->findBy(array('parent_category' => $this->viewing_category_id), array('title' => 'ASC'));

        if ($this->viewing_category) {
            $products = $this->viewing_category->getProducts();
        } else {
            $products = $this->em->getRepository('Simpleshop\Entity\Product')
                ->getProductsWithNoCategory();
        }

        $this->template
            ->title($this->module_details['name'], lang('simpleshop.catalogue_title'))
            ->append_js('module::catalogue.js')
            ->build('admin/catalogue/index', array(
                'categories' => $categories,
                'products' => $products,
            ));
    }

}
