<section class="title">
	<h4><?php echo lang('products_title'); ?></h4>
</section>

<section class="item">
	<?php if ($products): ?>
		<?php $this->load->view('admin/tables/products'); ?>
	<?php else: ?>
		<p><?php echo lang('product_no_products'); ?></p>
	<?php endif; ?>
</section>
