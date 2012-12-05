<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/../core/Simpleshop_Public_Controller.php';

/**
 *
 *
 * @author  Joseph Wynn <joseph@wildlyinaccurate.com>
 */
class Cart extends Simpleshop_Public_Controller
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
     * Cart
     *
     * @return  void
     * @author  Joseph Wynn <joseph@wildlyinaccurate.com>
     */
    public function checkout()
    {
        $this->load->library('payments');

        $this->template->title($this->module_details['name'])
            ->build('cart/checkout', array(
                'product' => $this->em->find('Simpleshop\Entity\Product', $this->input->get('product')),
            ));
    }

}
