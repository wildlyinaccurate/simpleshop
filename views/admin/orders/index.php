<section class="title">
    <h4><?php echo lang('catalogue_title'); ?></h4>
</section>

<section class="item">

    <?php if ($products): ?>

        <?php echo form_open('admin/simpleshop/products/delete'); ?>

        <table border="0" class="table-list">
            <thead>
            <tr>
                <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                <th><?php echo lang('product_product_label'); ?></th>
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
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo form_checkbox('action_to[]', $product->getId()); ?></td>
                    <td><?php echo $product->getTitle(); ?></td>
                    <td><?php echo $product->getProducts()->count(); ?></td>
                    <td class="align-center buttons buttons-small">
                        <?php echo anchor('admin/simpleshop/products/edit/' . $product->getId(), lang('global:edit'), 'class="button edit"'); ?>
                        <?php echo anchor('admin/simpleshop/products/delete/' . $product->getId(), lang('global:delete'), 'class="confirm button delete"') ;?>
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
        <p><?php echo lang('product_no_products'); ?></p>
    <?php endif; ?>
</section>
