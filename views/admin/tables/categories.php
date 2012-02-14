<?php echo form_open('admin/simpleshop/categories/delete'); ?>

	<table border="0" class="table-list">
		<thead>
		<tr>
			<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
			<th><?php echo lang('category_category_label'); ?></th>
			<th><?php echo lang('category_products_label'); ?></th>
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
			<?php foreach ($categories as $category): ?>
			<tr>
				<td><?php echo form_checkbox('action_to[]', $category->getId()); ?></td>
				<td><?php echo anchor("admin/simpleshop/catalogue?category_id={$category->getId()}", $category->getTitle()); ?></td>
				<td><?php echo $category->getProducts()->count(); ?></td>
				<td>
					<?php echo anchor("admin/simpleshop/categories/edit/{$category->getId()}?category_id={$category->getId()}", lang('global:edit'), 'class="btn orange edit"'); ?>
					<?php echo anchor("admin/simpleshop/categories/delete/{$category->getId()}?category_id={$current_category->getId()}", lang('global:delete'), 'class="confirm btn red delete"') ;?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="table_action_buttons">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
	</div>

<?php echo form_close(); ?>
