<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Module_Simpleshop extends Module
{

    public $version = '0.1';

    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    /**
     * Returns the module information array
     *
     * @return array
     */
    public function info()
    {
        return array(
            'name' => array(
                'en' => 'Simple Shop'
            ),
            'description' => array(
                'en' => 'Manage a simple online shop.'
            ),
            'frontend' => true,
            'backend' => true,
            'menu' => 'content',

            'roles' => array(
                'create_category',
                'edit_category',
                'delete_category',
                'create_product',
                'edit_product',
                'delete_product',
            ),

            'sections' => array(
                'catalogue' => array(
                    'name' => 'simpleshop.catalogue_title',
                    'uri' => 'admin/simpleshop/catalogue',
                    'shortcuts' => array(
                        array(
                            'name' => 'simpleshop.create_product',
                            'uri' => "admin/simpleshop/products/create?category_id={$this->input->get('category_id')}",
                            'class' => 'add'
                        ),
                        array(
                            'name' => 'simpleshop.create_category',
                            'uri' => "admin/simpleshop/categories/create?category_id={$this->input->get('category_id')}",
                            'class' => 'add'
                        ),
                    ),
                ),
                'orders' => array(
                    'name' => 'simpleshop.orders_title',
                    'uri' => 'admin/simpleshop/orders',
                ),
            )
        );
    }

    /**
     * Install SimpleShop module
     *
     * @return bool
     */
    public function install()
    {
        $this->_load_doctrine();
        $this->_clear_metadata_cache();
        $this->_update_settings();

        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
        $metadatas = $this->em->getMetadataFactory()->getAllMetadata();

        try {
            $schemaTool->createSchema($metadatas);
        } catch (\Doctrine\ORM\Tools\ToolsException $e) {
            $notice = <<<TEXT
<b>Important:</b> Simple Shop did not update your database because it detected
that one or more Simple Shop tables already exist. To ensure that your Simple Shop
installation is up-to-date, it is recommended that you take a backup of your
Simple Shop tables and re-install the module.
TEXT;

            $this->session->set_flashdata('notice', $notice);
        }

        return true;
    }

    /**
     * Uninstall SimpleShop module
     *
     * @return bool
     */
    public function uninstall()
    {
        $this->_load_doctrine();
        $this->_clear_metadata_cache();

        ci()->settings_m->delete_by(array('module' => 'simpleshop'));

        $metadatas = $this->em->getMetadataFactory()->getAllMetadata();

        foreach ($metadatas as $metadata) {
            if ( ! $metadata->isMappedSuperclass) {
                foreach ($metadata->associationMappings as $association) {
                    if ( ! isset($association['joinTable'])) {
                        continue;
                    }

                    $this->db->query("DROP TABLE IF EXISTS `{$association['joinTable']['name']}`");
                }

                $this->db->query("DROP TABLE IF EXISTS `{$metadata->table['name']}`");
            }
        }

        return true;
    }

    /**
     * Upgrade the module - keep the schema up-to-date
     *
     * @param  string $old_version
     * @return bool
     */
    public function upgrade($old_version)
    {
        $old_version = (float) $old_version;

        if ($old_version < (float) $this->version) {
            $this->_update_settings();
        }

        return true;
    }

    private function _update_settings()
    {
        require_once __DIR__ . '/config/simpleshop.php';

        foreach ($config['simpleshop.default_settings'] as $setting) {
            if ( ! Settings::get($setting['slug'])) {
                $setting['module'] = 'simpleshop';

                $this->settings->add($setting);
            }
        }
    }

    /**
     * Load Doctrine and create a shortcut to the EntityManager
     * in $this->em
     *
     * @return  void
     * @author  Joseph Wynn <joseph@wildlyinaccurate.com>
     */
    private function _load_doctrine()
    {
        require_once __DIR__ . '/libraries/Doctrine.php';

        $doctrine = new Doctrine;
        $this->em = $doctrine->em;
    }

    /**
     * Clear Doctrine's metadata cache
     *
     * @return void
     */
    private function _clear_metadata_cache()
    {
        $cacheDriver = $this->em->getConfiguration()->getMetadataCacheImpl();
        $cacheDriver->deleteAll();
    }

    public function help()
    {
        return <<<HTML
Simple Shop doesn't have any documentation yet.
Please use the <a href="https://github.com/wildlyinaccurate/simpleshop/issues">GitHub Issue Tracker</a> for assistance.
HTML;
    }

}
