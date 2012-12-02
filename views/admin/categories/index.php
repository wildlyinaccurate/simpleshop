<section class="title">
    <h4><?php echo lang('simpleshop.categories_title'); ?></h4>
</section>

<section class="item">
    <?php if ($categories): ?>
        <?php $this->load->view('admin/tables/categories'); ?>
    <?php else: ?>
        <p><?php echo lang('simpleshop.categories.no_categories'); ?></p>
    <?php endif; ?>
</section>
