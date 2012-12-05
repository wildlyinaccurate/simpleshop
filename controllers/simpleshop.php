<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/../core/Simpleshop_Public_Controller.php';

/**
 * Main front-end controller (catalogue)
 *
 * @author  Joseph Wynn <joseph@wildlyinaccurate.com>
 */
class Simpleshop extends Simpleshop_Public_Controller
{

    /**
     * Constructor ahoy!
     */
    public function __construct()
    {
        parent::__construct();

        $this->lang->load(array(
            'categories',
            'products',
        ));
    }

    /**
     * View the catalogue index
     *
     * @param   int     $category_id
     * @return  void
     * @author  Joseph Wynn <joseph@wildlyinaccurate.com>
     */
    public function index($category_id = null)
    {
        $category_repository = $this->em->getRepository('Simpleshop\Entity\Category');
        $categories = $category_repository->findBy(array('parent_category' => $category_id), array('title' => 'ASC'));

        $current_category = ($category_id) ? $category_repository->find($category_id) : null;

        if ($category_id) {
            $products = $current_category->getProducts();
        } else {
            $products = $this->em->getRepository('Simpleshop\Entity\Product')
                ->getProductsWithNoCategory();
        }

        $this->template->title($this->module_details['name'])
            ->build('catalogue/index', array(
                'categories' => $categories,
                'current_category' => $current_category,
        ));
    }

    /**
     * Show details about the selected product
     *
     * @param   int     $id
     * @return  void
     * @author  Joseph Wynn <joseph@wildlyinaccurate.com>
     */
    public function product($id = null)
    {
        $product = $this->em->getRepository('Simpleshop\Entity\Product')->find($id);

        $product OR show_404();

        $this->template->title($product->getTitle())
            ->build('catalogue/product', array(
                'product' => $product,
            ));
    }

}
