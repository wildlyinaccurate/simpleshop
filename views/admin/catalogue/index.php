<section class="title">
    <h4 class="breadcrumbs">
        <?php echo simpleshop_category_breadcrumbs($viewing_category_node); ?>
        <strong><?php echo ($viewing_category) ? $viewing_category->getTitle() : lang('simpleshop.categories.home_title'); ?></strong>
    </h4>
</section>

<section class="item">
    <div class="catalogue">
        <?php if ($categories): ?>
            <h4><?php echo lang('simpleshop.categories_title'); ?></h4>
            <?php $this->load->view('admin/tables/categories'); ?>
        <?php endif; ?>

        <h4><?php echo sprintf(lang('simpleshop.categories.products_title'), ($viewing_category) ? $viewing_category->getTitle() : lang('simpleshop.categories.home_title')); ?></h4>

        <?php if ($products->count() > 0): ?>
            <?php $this->load->view('admin/tables/products', array('products' => $products)); ?>
        <?php else: ?>
            <p><?php echo lang('simpleshop.no_products'); ?> <?php echo anchor("admin/simpleshop/products/create?category_id={$viewing_category_id}", lang('simpleshop.create_product_now')); ?></p>
        <?php endif; ?>
    </div>
</section>
