<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/../core/Simpleshop_Admin_Controller.php';

/**
 * Catalogue (default admin controller)
 */
class Admin_settings extends Simpleshop_Admin_Controller
{

    protected $section = 'settings';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->language(array(
            'settings',
        ));
    }

    /**
     * Index / Landing Page
     *
     * @return void
     */
    public function index()
    {
        $this->template
            ->title($this->module_details['name'], lang('settings_title'))
            ->build('admin/settings/index', array(
            ));
    }

}
