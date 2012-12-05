<div class="product">
	<h2><?php echo $product->getTitle(); ?></h2>

	<div class="description"><?php echo $product->getDescription(); ?></div>
    <span class="price"><?php echo Settings::get('currency'); ?><?php echo $product->getPrice(); ?></span>
    <a class="buy" href="<?php echo simpleshop_purchase_url($product); ?>"><?php echo lang('simpleshop.products.add_to_cart'); ?></a>
</div>
