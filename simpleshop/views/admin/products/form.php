<section class="title">
	<h4><?php echo $page_title; ?></h4>
</section>

<section class="item">

<?php echo form_open(uri_string(), 'class="crud"'); ?>

<div class="tabs">

	<div id="simpleshop-product">
		<ul>
			<li class="even">
				<label for="title"><?php echo lang('product_title_label'); ?></label><br>
				<?php echo form_input('title', htmlspecialchars_decode($product->getTitle()), 'id="title" maxlength="130"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
			</li>

			<li class="even">
				<label for="price"><?php echo lang('product_price_label'); ?></label><br>
				<?php echo form_input('price', htmlspecialchars_decode($product->getPrice()), 'id="title" maxlength="130"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
			</li>
			<hr>

			<li class="even editor">
				<label for="description"><?php echo lang('product_description_label'); ?></label><br>
				<?php echo form_textarea(array('id' => 'description', 'name' => 'description', 'value' => $product->getDescription(), 'rows' => 10, 'class' => 'wysiwyg-simple')); ?>
			</li>

		</ul>
	</div>

</div>

<div class="buttons float-right padding-top">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
</div>

<?php echo form_close(); ?>

</section>