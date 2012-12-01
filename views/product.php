<div class="product">
	<h2><?php echo $product->getTitle(); ?></h2>

	<div class="description"><?php echo $product->getDescription(); ?></div>
	<span class="price"><?php echo lang('product_price_label'); ?>: <?php echo $product->getPrice(); ?>
</div>
