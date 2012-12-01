<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(dirname(__FILE__)) . '/core/Simpleshop_Public_Controller.php';

/**
 * Simple Shop provides basic e-commerce functionality to a PyroCMS site.
 *
 * @category    Modules
 * @author      Joseph Wynn
 */
class simpleshop extends Simpleshop_Public_Controller
{

    /**
     * Constructor
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

        $this->template->title($this->module_details['name'])
            ->build('index', array(
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
            ->build('product', array(
                'product' => $product,
            ));
    }

}
