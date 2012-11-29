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
            'menu' => 'simpleshop',

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
                    'name' => 'catalogue_title',
                    'uri' => 'admin/simpleshop/catalogue',
                    'shortcuts' => array(
                        array(
                            'name' => 'create_product',
                            'uri' => "admin/simpleshop/products/create?category_id={$this->input->get('category_id')}",
                            'class' => 'add'
                        ),
                        array(
                            'name' => 'create_category',
                            'uri' => "admin/simpleshop/categories/create?category_id={$this->input->get('category_id')}",
                            'class' => 'add'
                        ),
                    ),
                ),
                'orders' => array(
                    'name' => 'orders_title',
                    'uri' => 'admin/simpleshop/orders',
                ),
                'settings' => array(
                    'name' => 'settings_title',
                    'uri' => 'admin/simpleshop/settings',
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

        $metadatas = $this->em->getMetadataFactory()->getAllMetadata();

        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
        $schemaTool->dropSchema($metadatas);
        $schemaTool->createSchema($metadatas);

        return TRUE;
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

        $metadatas = $this->em->getMetadataFactory()->getAllMetadata();

        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
        $schemaTool->dropSchema($metadatas);

        return TRUE;

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
            $this->_load_doctrine();
            $this->_clear_metadata_cache();

            $metadatas = $this->em->getMetadataFactory()->getAllMetadata();

            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
            $schemaTool->updateSchema($metadatas, TRUE);
        }

        return TRUE;
    }

    /**
     * Returns the module's help text
     *
     * @return string
     */
    public function help()
    {
        return <<<HTML
<p>One day this might be helpful.</p>
HTML;

    }

    /**
     * Load up Doctrine for any schema changes (we don't want to
     * do this in the constructor as it creates unnecessary overhead)
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

}
/* End of file details.php */
