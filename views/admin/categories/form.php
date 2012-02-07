<section class="title">
	<h4><?php echo $page_title; ?></h4>
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
			
			<li>
				<label for="parent_category"><?php echo lang('category_parent_label'); ?></label><br>
				<select name="parent_category" id="parent_category">
					<option value="0"><?php echo lang('none_label'); ?></option>

					<?php foreach ($root_categories as $root_category): ?>
						<option value="<?php echo $root_category->getId(); ?>"><?php echo $root_category->getTitle(); ?></option>

						<?php $child_categories = array(); ?>
						<?php foreach ($child_categories as $child_category): ?>
							<option value="<?php echo $child_category->getId(); ?>"><?php echo str_repeat('&nbsp;&nbsp;', $child_category->getLevel() * 2) . $child_category->getTitle(); ?></option>
						<?php endforeach; ?>
					<?php endforeach; ?>
				</select>
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
