<div class="categories">
    <h3><?php echo lang('simpleshop.categories_title'); ?></h3>

    <ul>
    <?php foreach ($categories as $category): ?>
        <li><?php echo anchor("simpleshop/category/{$category->getId()}/{$category->getSlug()}", $category); ?></li>
    <?php endforeach; ?>
    </ul>
</div>

<?php if ($current_category): ?>
    <div class="products">
        <h3><?php echo lang('simpleshop.products_title'); ?></h3>

        <ul>
        <?php foreach ($current_category->getProducts() as $product): ?>
            <?php $product_url = simpleshop_product_url($product); ?>

            <li>
                <b class="title"><?php echo anchor($product_url, $product->getTitle()); ?></b>
                <span class="price"><?php echo Settings::get('currency'); ?><?php echo anchor($product_url, $product->getPrice()); ?></span>
                <a class="buy" href="<?php echo simpleshop_purchase_url($product); ?>"><?php echo lang('simpleshop.products.add_to_cart'); ?></a>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
