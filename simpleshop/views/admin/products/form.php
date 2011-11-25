<section class="title">
	<h4><?php echo $page_title; ?></h4>
</section>

<section class="item">

<?php echo form_open(uri_string(), 'class="crud"'); ?>

<div id="simpleshop-product" class="form_inputs">
	<ul>
		<li class="even input">
			<label for="title"><?php echo lang('product_title_label'); ?> <span>*</span></label>
			<?php echo form_input('title', set_value('title', $product->getTitle()), 'id="title" maxlength="130"'); ?>
		</li>

		<li>
			<label for="price"><?php echo lang('product_price_label'); ?></label>
			<?php echo form_input('price', set_value('price', $product->getPrice()), 'id="price"'); ?>
		</li>

		<li class="even">
			<label for="stock"><?php echo lang('product_stock_label'); ?></label>
			<?php echo form_input('stock', set_value('stock', $product->getStock()), 'id="stock"'); ?>

			<input type="checkbox" class="inline-checkbox" name="unlimited_stock" id="unlimited_stock" value="1" <?php echo set_checkbox('unlimited_stock', '1', $product->getUnlimitedStock()); ?> />
			<label for="unlimited_stock" class="inline-checkbox"><?php echo lang('product_unlimited_stock_label'); ?></label>
		</li>

		<li class="editor">
			<label for="description"><?php echo lang('product_description_label'); ?></label>
			<br style="clear: both;" />
			<?php echo form_textarea(array(
				'id' => 'description',
				'name' => 'description',
				'value' => set_value('description', $product->getDescription()),
				'rows' => 10,
				'class' => 'wysiwyg-simple'));
			?>
		</li>

		<li class="even inline-checkbox product-categories">
			<h4><?php echo lang('product_categories_label'); ?></h4>

			<ul>
			<?php
			$collection = new \Doctrine\Common\Collections\ArrayCollection($root_categories);
			$category_iterator = new \Entity\RecursiveCategoryIterator($collection);
			$caching_iterator = new RecursiveCachingIterator($category_iterator);
			$recursive_iterator = new RecursiveIteratorIterator($caching_iterator, RecursiveIteratorIterator::SELF_FIRST);
			?>

			<?php foreach ($recursive_iterator as $category): ?>
				<li>
					<input type="checkbox" name="categories[]" id="category-<?php echo $category->getId(); ?>" value="<?php echo $category->getId(); ?>" <?php echo set_checkbox('categories[]', $category->getId(), $product->getCategories()->contains($category)); ?> />
					<label for="category-<?php echo $category->getId(); ?>"><?php echo $category->getTitle(); ?></label>

					<?php if ($recursive_iterator->hasChildren()): ?>
						<ul>
					<?php else: ?>
						</li>

						<?php if ( ! $recursive_iterator->hasNext()): ?>
								</ul>
							</li>
						<?php endif; ?>
					<?php endif; ?>
			<?php endforeach; ?>
			</ul>
		</li>
	</ul>
</div>

<div class="buttons float-right padding-top" style="clear: both;">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
</div>

<?php echo form_close(); ?>

</section>