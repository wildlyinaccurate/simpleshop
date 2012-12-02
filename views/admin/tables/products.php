<?php echo form_open('admin/simpleshop/products/delete'); ?>

<table border="0" class="products table-list">
    <thead>
    <tr>
        <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
        <th><?php echo lang('simpleshop.products.product_label'); ?></th>
        <th><?php echo lang('simpleshop.products.price_label'); ?></th>
        <th><?php echo lang('simpleshop.products.stock_label'); ?></th>
        <th width="120"></th>
    </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="5">
                <div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
            </td>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo form_checkbox('action_to[]', $product->getId()); ?></td>
            <td class="title"><?php echo anchor("admin/simpleshop/products/edit/{$product->getId()}", $product->getTitle()); ?></td>
            <td class="price"><?php echo Settings::get('currency') . $product->getPrice(); ?></td>
            <td class="stock">
                <?php if ($product->getUnlimitedStock()): ?>
                    <?php echo lang('simpleshop.product.unlimited_stock'); ?>
                <?php else: ?>
                    <?php if ($product->getStock() > 0): ?>
                        <?php echo $product->getStock(); ?>
                    <?php else: ?>
                        <span class="warning"><?php echo lang('simpleshop.products.out_of_stock'); ?></span>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
            <td class="align-center buttons buttons-small">
                <?php echo anchor("admin/simpleshop/products/edit/{$product->getId()}", lang('global:edit'), 'class="button edit"'); ?>
                <?php echo anchor("admin/simpleshop/products/delete/{$product->getId()}?category_id={$viewing_category_id}", lang('global:delete'), 'class="confirm button delete"') ;?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="table_action_buttons">
<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
</div>

<?php echo form_close();
