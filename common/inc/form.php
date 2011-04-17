<div id="dynowidg-widget">
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">
			<?php _e('Title:'); ?>
		</label>
		
		<input 
			class="widefat" 
			id="<?php echo $this->get_field_id('title'); ?>" 
			name="<?php echo $this->get_field_name('title'); ?>" 
			type="text" 
			value="<?php echo esc_attr($instance['title']); ?>" />
	</p>

	<p>
		<label 
			for="<?php echo $this->get_field_id( 'showheader' ); ?>">
			<?php _e('Show Title on the front end?:', 'dynowidg'); ?>
		</label>
		<input 
			id="<?php echo $this->get_field_id( 'showheader' ); ?>"
			name="<?php echo $this->get_field_name( 'showheader' ); ?>"
			type="checkbox"
			value="1" 
			<?php echo ($instance['showheader']==1) ?  ' checked="checked" ':''; ?> />
	</p>

	<p>
		<label 
			for="<?php echo $this->get_field_id( 'cls' ); ?>">
			<?php _e('Classname:', 'dynowidg'); ?>
		</label>
		<input 
			class="widefat" 
			id="<?php echo $this->get_field_id( 'cls' ); ?>"
			name="<?php echo $this->get_field_name( 'cls' ); ?>"
			value="<?php echo esc_attr($instance['cls']); ?>"/>
	</p>

	<p>
		<label 
			for="<?php echo $this->get_field_id( 'cid' ); ?>">
			<?php _e('Dynamic Content:', 'dynowidg'); ?>
		</label>
		<select class="widefat" id="<?php echo $this->get_field_id('cid'); ?>" name="<?php echo $this->get_field_name('cid'); ?>">
			<option value=""></option>
<?php foreach( $DynoWidg_all as $data => $content ):?>
			<option 
				value="<?php echo $content->ID;?>"
				<?php echo selected( $instance['cid'], $content->ID ) ?>>
				<?php echo $content->post_title;?>
			</option>
<?php endforeach; ?>
		</select>
	</p>
	
	<dl>
		<dt>
			<?php _e('Logged In', 'dynowidg') ?>
			<span> - </span>
			<span style="display:none"> + </span>
		</dt>
		<dd>
			<p>
				<label for="loggedout-<?php echo $this->get_field_id('authenicated'); ?>">
					<input 
						class="checkbox authenicationCheckbox" 
						type="checkbox" 
						value="loggedout"
						<?php checked($instance['authenicated'], 'loggedout') ?> 
						id="loggedout-<?php echo $this->get_field_id('authenicated'); ?>" 
						name="<?php echo $this->get_field_name('authenicated'); ?>" />
					
						<?php _e('Logged-out users', 'dynowidg') ?>
				</label>
			</p>
			<p>
				<label for="loggedin-<?php echo $this->get_field_id('authenicated'); ?>">
					<input 
						class="checkbox authenicationCheckbox" 
						type="checkbox" 
						value="loggedin"
						<?php checked($instance['authenicated'], 'loggedin') ?> 
						id="loggedin-<?php echo $this->get_field_id('authenicated'); ?>" 
						name="<?php echo $this->get_field_name('authenicated'); ?>" />
					
						<?php _e('Logged-in users', 'dynowidg') ?>
				</label>
			</p>
		</dd>
		
		<dt>
			<?php _e('Conditionally', 'dynowidg') ?>
			<span> - </span>
			<span style="display:none"> + </span>
		</dt>
		<dd>
<?php foreach ($DynoWidg_conditional as $key => $label): ?>
	<?php $instance['cond-'. $key] = isset($instance['cond-'. $key]) ? $instance['cond-'. $key] : false; ?>
			<p>
				<input 
					class="checkbox" 
					type="checkbox" 
					<?php checked($instance['cond-'. $key], true) ?> 
					id="<?php echo $this->get_field_id('cond-'. $key); ?>" 
					name="<?php echo $this->get_field_name('cond-'. $key); ?>" />
				<label for="<?php echo $this->get_field_id('cond-'. $key); ?>">
					<?php echo $label .' '. __('Page', 'dynowidg'); ?>
				</label>
			</p>
<?php endforeach; ?>
		</dd>
		
		<dt>
			<?php _e('Pages', 'dynowidg') ?>
			<span> - </span>
			<span style="display:none"> + </span>
		</dt>
		<dd>
<?php foreach ($DynoWidg_pages as $page){ 
$instance['page-'.$page->ID] = isset($instance['page-'.$page->ID]) ? $instance['page-'.$page->ID] : false;   
?>
			<p>
				<input 
					class="checkbox" 
					type="checkbox" 
					<?php checked($instance['page-'.$page->ID], true) ?> 
					id="<?php echo $this->get_field_id('page-'.$page->ID); ?>" 
					name="<?php echo $this->get_field_name('page-'.$page->ID); ?>" />
				<label for="<?php echo $this->get_field_id('page-'.$page->ID); ?>">
					<?php echo $page->post_title ?>
				</label>
			</p>
<?php	}  ?>
		</dd>
		
		<dt>
			<?php _e('Category', 'dynowidg') ?>
			<span> - </span>
			<span style="display:none"> + </span>
		</dt>
		<dd>
<?php foreach ($DynoWidg_category as $cat){ 
	$instance['cat-'.$cat->cat_ID] = isset($instance['cat-'.$cat->cat_ID]) ? $instance['cat-'.$cat->cat_ID] : false;   
?>
			<p>
				<input 
					class="checkbox" 
					type="checkbox" 
					<?php checked($instance['cat-'.$cat->cat_ID], true) ?> 
					id="<?php echo $this->get_field_id('cat-'.$cat->cat_ID); ?>" 
					name="<?php echo $this->get_field_name('cat-'.$cat->cat_ID); ?>" />
				<label for="<?php echo $this->get_field_id('cat-'.$cat->cat_ID); ?>">
					<?php echo $cat->cat_name ?>
				</label>
			</p>
<?php } ?>
		</dd>
		
		<dt>
			<?php _e('Custom Post Types', 'dynowidg') ?>
			<span> - </span>
			<span style="display:none"> + </span>
		</dt>
		<dd>

<?php foreach ($DynoWidg_contenttype as $post_key => $custom_post){ 
	$instance['type-'. $post_key] = isset($instance['type-'. $post_key]) ? $instance['type-'. $post_key] : false;
?>
			<p>
				<input 
					class="checkbox" 
					type="checkbox" 
					<?php checked($instance['type-'. $post_key], true) ?> 
					id="<?php echo $this->get_field_id('type-'. $post_key); ?>" 
					name="<?php echo $this->get_field_name('type-'. $post_key); ?>" />
				<label for="<?php echo $this->get_field_id('type-'. $post_key); ?>">
					<?php echo stripslashes($custom_post->labels->name) ?>
				</label>
			</p>
<?php } ?>
		</dd>
		
		<dt>
			<?php _e('Specific', 'dynowidg') ?>
			<span> - </span>
			<span style="display:none"> + </span>
		</dt>
		<dd>
			<p>
				<label for="<?php echo $this->get_field_id('specific'); ?>">
					<?php _e('Comma separated list or IDs or Slugs:', 'dynowidg') ?>
				</label>
				
				<input 
					class="widefat" 
					id="<?php echo $this->get_field_id('specific'); ?>" 
					name="<?php echo $this->get_field_name('specific'); ?>" 
					type="text" 
					value="<?php echo $instance['specific']; ?>" />
			</p>
		</dd>
	</dl>

	<p>
		<label 
			for="<?php echo $this->get_field_id( 'hideShow' ); ?>">
			<?php _e('Show or Hide Widget:', 'dynowidg'); ?>
		</label>
		<select 
			class="widefat" 
			name="<?php echo $this->get_field_name('hideShow'); ?>" 
			id="<?php echo $this->get_field_id('hideShow'); ?>">
			<option value="0" <?php echo selected( $instance['hideShow'], 0 ) ?>><?php _e('Hide if checked', 'dynowidg') ?></option> 
			<option value="1" <?php echo selected( $instance['hideShow'], 1 ) ?>><?php _e('Show if checked', 'dynowidg') ?></option>
		</select>
	</p>
</div>