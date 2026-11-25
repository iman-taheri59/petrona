<?php 

// save menu custom fields
add_action( 'wp_update_nav_menu_item', 'techt_update_custom_nav_fields', 10, 3 );

function techt_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
	$check = array( 'enable_mega_menu', 'mega_menu_template', 'mega_menu_width', 'mega_menu_position', 'badge' );

	if ( ! array_key_exists( '_techt_menu_meta_nonce_name', $_POST )
		|| ! wp_verify_nonce( $_POST['_techt_menu_meta_nonce_name'], 'techt_menu_meta_nonce' )
	) {
		return $menu_id;
	}
	foreach ( $check as $key ) {

		if ( ! isset( $_POST[ 'menu-item-' . $key ][ $menu_item_db_id ] ) ) {
			if ( ! isset( $args[ 'menu-item-' . $key ] ) ) {
				$value = '';
			} else {
				$value = $args[ 'menu-item-' . $key ];
			}
		} else {
			$value = sanitize_text_field( $_POST[ 'menu-item-' . $key ][ $menu_item_db_id ] );
		}

		if ( $value ) {
			update_post_meta( $menu_item_db_id, '_menu_item_' . $key, $value );
		} else {
			delete_post_meta( $menu_item_db_id, '_menu_item_' . $key );
		}
	}
}

add_action( 'wp_nav_menu_item_custom_fields','techt_add_custom_nav_fields', 10, 2 );

function techt_add_custom_nav_fields( $item_id, $item ) {
	wp_nonce_field( 'techt_menu_meta_nonce', '_techt_menu_meta_nonce_name' );

	$check = array( 'icon_class', 'enable_mega_menu', 'mega_menu_template', 'mega_menu_width', 'mega_menu_position', 'badge' );

	foreach ( $check as $key ) {
		$value = get_post_meta( $item_id, '_menu_item_'.$key, true ) ? get_post_meta( $item_id, '_menu_item_'.$key, true ) : '';
		$field_id = sprintf('edit-menu-item-attr-%s-%s', $key, $item_id);
		$field_name = sprintf('menu-item-%s[%s]', $key, $item_id);
		if($key == 'icon_class'){
			$label = __( 'Icon Class', 'petrona' );
			$field_class = sprintf('edit-menu-item-attr-%s depend-field', $key);
			?>
			<p class="description description-wide">
				<?php techt_input_menu_field('text', $field_id, $field_name , $field_class, $label, $value, $is_hidden = false); ?>
			</p>
			<?php
		}else if($key == 'enable_mega_menu'){
			$label = __( 'Enable Mega Menu', 'petrona' );
			$field_class = sprintf('edit-menu-item-attr-%s depend-field', $key);

			$checked = $value == '1' ? 'checked' : '';
			?>
			<p class="description description-wide">
				<label for="<?php echo $field_id; ?>">
					<?php echo $label; ?><br />
					<input type="checkbox" id="<?php echo $field_id; ?>" class="<?php echo $field_class; ?>" name="<?php echo $field_name; ?>" value="1" <?php echo $checked; ?> />
				</label>
			</p>
			<?php
		}else if($key == 'mega_menu_template'){
			$label = __( 'Select Mega Menu', 'petrona' );
			$field_class = sprintf('edit-menu-item-attr-1%s widefat', $key);
			$args = array( 
				'post_type' => 'petrona_templates', 
				'posts_per_page' => -1,
				// 'post_status'    => array( 'publish'),
				'meta_key' => 'petrona_template_types',
				'meta_value'  => 'megamenu',
				'meta_compare' => '>=',
				'orderby'      => 'meta_value',
				'order'        => 'ASC',
				'meta_query'   => array(
					'relation' => 'OR',
					array(
						'key'     => 'petrona_template_types',
						'value'   => 'megamenu',
						'compare' => '==',
						'type'    => 'page',
					),
				),
			);
			
			$megamenus = get_posts($args);
			$options = array();
			$options[''] = esc_html__('Select', 'petrona');
			if( $megamenus ) {
				foreach ($megamenus as $megamenu) {
					$options[$megamenu->ID] = $megamenu->post_title;
				}
			}
			?>
			<p class="description description-wide">
				<a href="edit.php?post_type=petrona_templates"><?php echo __('Create / Edit Mega Menu'); ?></a>
				<?php techt_select_menu_field($field_id, $field_name , $field_class, $label, $options, $value); ?>
			</p>
			<?php
		}else if($key == 'mega_menu_width'){
			$label = __( 'Select Width', 'petrona' );
			$field_class = sprintf('edit-menu-item-attr-1%s widefat', $key);

			$options = array(
				'2' => __( '2 Column', 'petrona' ),
                '3' => __( '3 Column', 'petrona' ),
                '4' => __( '4 Column', 'petrona' ),
                'full' => __( 'Full Width', 'petrona' ),
			);
			$value = ! $value ? 'full' : $value;
			?>
			<p class="description description-wide">
				<?php techt_select_menu_field($field_id, $field_name , $field_class, $label, $options, $value); ?>
			</p>
			<?php
		}
		
	}
}

function techt_input_menu_field($type, $field_id, $field_name , $field_class, $label, $value, $is_hidden = false){
	$hide_class = $is_hidden ? ' hidden-field' : '';
	?>
	
		<label for="<?php echo $field_id; ?>">
			<?php echo $label; ?><br />
			<input type="<?php echo $type; ?>" id="<?php echo $field_id; ?>" class="<?php echo $field_class; ?>" name="<?php echo $field_name; ?>" value="<?php echo esc_attr( $value ); ?>" />
		</label>
	
	<?php
}

function techt_select_menu_field($field_id, $field_name , $field_class, $label, $options, $value, $is_hidden = false){

	$hide_class = $is_hidden ? ' hidden-field' : '';
	?>
		<label for="<?php echo $field_id; ?>">
			<?php echo $label; ?>
        </label>
		<select id="<?php echo $field_id; ?>" class="<?php echo $field_class; ?>" name="<?php echo $field_name; ?>">
			<?php foreach($options as $id => $title){
				$selected = '';
				if(! $value && $title == 'Select'){
					$selected = 'selected';
				}
				if($value && $id == $value){
					$selected = 'selected';
				}
				?>
				<option value="<?php echo  $id; ?>" <?php echo  $selected; ?>><?php echo  $title; ?></option>
				
			<?php } ?>
		</select>
	<?php
}