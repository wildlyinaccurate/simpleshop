<section class="title">
<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('create_category'); ?></h4>
<?php else: ?>
	<h4><?php echo sprintf(lang('edit_category'), $category->getTitle()); ?></h4>
<?php endif; ?>
</section>

<section class="item">

<?php echo form_open(uri_string(), 'class="crud"'); ?>

<div class="tabs">

	<div id="simpleshop-category">
		<ul>
			<li class="even">
				<label for="title"><?php echo lang('category_title_label'); ?></label><br>
				<?php echo form_input('title', htmlspecialchars_decode($category->getTitle()), 'maxlength="130"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
			</li>

			<hr>

			<li class="even editor">
				<label for="description"><?php echo lang('category_description_label'); ?></label><br>
				<?php echo form_textarea(array('id' => 'description', 'name' => 'description', 'value' => $category->getDescription(), 'rows' => 10, 'class' => 'wysiwyg-simple')); ?>
			</li>

		</ul>
	</div>

</div>

<div class="buttons float-right padding-top">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
</div>

<?php echo form_close(); ?>

</section>