<section class="title">
	<h4><?php echo ($current_category) ? $current_category->getTitle() : lang('category_home_title'); ?></h4>
</section>

<section class="item">

	<div id="catalogue">
	<?php if ($categories): ?>
		<h4><?php echo lang('categories_title'); ?></h4>

		<?php $this->load->view('admin/tables/categories'); ?>
	<?php endif; ?>

		<h4><?php echo sprintf(lang('category_products_title'), ($current_category) ? $current_category->getTitle() : lang('category_home_title')); ?></h4>

		<?php if ($current_category && $current_category->getProducts()->count() > 0): ?>
			<?php $this->load->view('admin/tables/products'); ?>
		<?php else: ?>
			<p><?php echo lang('no_products'); ?> <?php echo anchor("admin/simpleshop/products/create?category_id={$current_category_id}", lang('create_product_now')); ?></p>
		<?php endif; ?>
	</div>
</section>
