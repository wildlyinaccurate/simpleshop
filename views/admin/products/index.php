<section class="title">
    <h4><?php echo lang('simpleshop.products_title'); ?></h4>
</section>

<section class="item">
    <?php if ($products): ?>
        <?php $this->load->view('admin/tables/products', array('products' => $products)); ?>
    <?php else: ?>
        <div class="no_data">
        	<?php echo lang('simpleshop.products.no_products'); ?>
        	<?php echo anchor("admin/simpleshop/products/create", lang('simpleshop.create_product_now')); ?>
    	</div>
    <?php endif; ?>
</section>
