<section class="title">
	<h4><?php echo ($category) ? $category->getTitle() : lang('category_home_title'); ?></h4>
</section>

<section class="item">

	<div id="catalogue">
	<?php if ($child_categories): ?>
		<h4><?php echo lang('categories_title'); ?></h4>

		<?php echo form_open('admin/simpleshop/categories/delete'); ?>

			<table border="0" class="table-list">
				<thead>
				<tr>
					<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
					<th><?php echo lang('category_category_label'); ?></th>
					<th><?php echo lang('product_products_label'); ?></th>
					<th width="110"></th>
				</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="4">
							<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach ($child_categories as $child_category): ?>
					<tr>
						<td><?php echo form_checkbox('action_to[]', $child_category->getId()); ?></td>
						<td><?php echo anchor("admin/simpleshop/catalogue?category_id={$child_category->getId()}", $child_category->getTitle()); ?></td>
						<td><?php echo $child_category->getProducts()->count(); ?></td>
						<td>
							<?php echo anchor("admin/simpleshop/categories/edit/{$child_category->getId()}?category_id={$child_category->getId()}", lang('global:edit'), 'class="btn orange edit"'); ?>
							<?php echo anchor("admin/simpleshop/categories/delete/{$child_category->getId()}?category_id={$category_id}", lang('global:delete'), 'class="confirm btn red delete"') ;?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<div class="table_action_buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
			</div>

			<?php echo form_close(); ?>
		<?php endif; ?>

		<h4><?php echo sprintf(lang('category_products_title'), ($category) ? $category->getTitle() : lang('category_home_title')); ?></h4>

		<?php if ($category && $category->getProducts()->count() > 0): ?>
			<?php echo form_open('admin/simpleshop/products/delete'); ?>

			<table border="0" class="table-list">
				<thead>
				<tr>
					<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
					<th><?php echo lang('product_product_label'); ?></th>
					<th><?php echo lang('product_price_label'); ?></th>
					<th><?php echo lang('product_stock_label'); ?></th>
					<th width="110"></th>
				</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="4">
							<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach ($category->getProducts() as $product): ?>
					<tr>
						<td><?php echo form_checkbox('action_to[]', $product->getId()); ?></td>
						<td><?php echo $product->getTitle(); ?></td>
						<td><?php echo $product->getPrice(); ?></td>
						<td><?php echo $product->getStock(); ?></td>
						<td class="align-center buttons buttons-small">
							<?php echo anchor("admin/simpleshop/products/edit/{$product->getId()}?category_id={$product->getId()}", lang('global:edit'), 'class="button edit"'); ?>
							<?php echo anchor("admin/simpleshop/products/delete/{$product->getId()}?category_id={$category_id}", lang('global:delete'), 'class="confirm button delete"') ;?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<div class="table_action_buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
			</div>

			<?php echo form_close(); ?>

		<?php else: ?>
			<p><?php echo lang('no_products'); ?> <?php echo anchor("admin/simpleshop/products/create?category_id={$category_id}", lang('create_product_now')); ?></p>
		<?php endif; ?>
	</div>
</section>
