<h3><?php echo lang('categories_title'); ?></h3>

<ul>

<?php foreach ($categories as $category): ?>
    <li><?php echo anchor("simpleshop/category/{$category->getId()}/{$category->getSlug()}", $category); ?></li>
<?php endforeach; ?>

</ul>

<?php if ($current_category): ?>
    <h3><?php echo lang('products_title'); ?></h3>

    <ul>

    <?php foreach ($current_category->getProducts() as $product): ?>
        <li>
            <h4><?php echo anchor("simpleshop/product/{$product->getId()}/{$product->getSlug()}", $product->getTitle()); ?></h4>
            <?php echo $product->getDescription(); ?>
        </li>
    <?php endforeach; ?>

    </ul>
<?php endif; ?>
