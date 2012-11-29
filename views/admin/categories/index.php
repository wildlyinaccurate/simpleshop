<section class="title">
    <h4><?php echo lang('categories_title'); ?></h4>
</section>

<section class="item">
    <?php if ($categories): ?>
        <?php $this->load->view('admin/tables/categories'); ?>
    <?php else: ?>
        <p><?php echo lang('category_no_categories'); ?></p>
    <?php endif; ?>
</section>
