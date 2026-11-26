<?php
/**
 * Petrona Meta-box
 *
 * @package Petrona
 * @since 1.0
 */
class Techt_Metaboxes {
	private static $_instance = null;

	public static function instance() {
	    if ( is_null( self::$_instance ) ) {
	        self::$_instance = new self();
	    }
	    return self::$_instance;
	}
	
	/**
	 * Nonce action used by every Petrona meta box.
	 *
	 * @var string
	 */
	const NONCE_ACTION = 'petrona_save_meta';

	/**
	 * Nonce field name.
	 *
	 * @var string
	 */
	const NONCE_FIELD = 'petrona_meta_nonce';

	public function __construct() {
		add_action('add_meta_boxes', array($this, 'add_custom_meta_boxes'));
		add_action('save_post', array($this, 'save_meta_data'), 10, 2 );
	}
	
	public function add_custom_meta_boxes () {
		$post_types = get_post_types( array( 'public' => true ) );
		foreach ( $post_types as $post_type ) {
			if ( $post_type == 'post' ) {
				add_meta_box( 'petrona_post_options', esc_html__('Post Options', 'petrona'), array($this, 'post_options'), $post_type );
			}
			else if ( $post_type == 'page' ) {
				add_meta_box( 'petrona_page_options', esc_html__('Page Options', 'petrona'), array($this, 'page_options'), $post_type );
			}
			else if ( $post_type == 'portfolio' ) {
				add_meta_box( 'petrona_portfolio_options', esc_html__('Portfolio Options', 'petrona'), array($this, 'portfolio_options'), $post_type );
			} 
			elseif( $post_type == 'petrona_templates' ) {
				add_meta_box( 'petrona_template_options', esc_html__('Template Options', 'petrona'), array($this, 'template_options'), $post_type );
			}
		}
	}
	
	public function save_meta_data( $post_id, $post = null ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// SECURITY: previously there was no nonce and no capability check at all.
		if ( ! isset( $_POST[ self::NONCE_FIELD ] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ self::NONCE_FIELD ] ) ), self::NONCE_ACTION ) ) {
			return;
		}

		$post = $post ? $post : get_post( $post_id );

		if ( ! $post instanceof WP_Post ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( ! in_array( $post->post_type, array( 'post', 'page', 'portfolio', 'petrona_templates' ), true ) ) {
			return;
		}

		/*
		 * Only keys that are actually rendered by a Petrona meta box (and therefore
		 * covered by our nonce) are accepted. Previously every techt_* parameter of
		 * *any* request that reached save_post was written to post meta.
		 */
		$allowed_keys = $this->get_allowed_meta_keys( $post->post_type );

		foreach ( $_POST as $key => $value ) {
			if ( ! is_string( $key ) || 0 !== strpos( $key, 'techt_' ) ) {
				continue;
			}

			$new_key = str_replace( 'techt', 'petrona', $key );

			if ( ! isset( $allowed_keys[ $new_key ] ) ) {
				continue;
			}

			$sanitize = $allowed_keys[ $new_key ];
			$value    = wp_unslash( $value );

			if ( $this->is_metadata_empty( $value ) ) {
				delete_post_meta( $post_id, $new_key );
				continue;
			}

			update_post_meta( $post_id, $new_key, $this->sanitize_meta_value( $value, $sanitize ) );
		}
	}

	/**
	 * Map of `petrona_*` meta keys a post type may store to their sanitiser.
	 *
	 * The list mirrors the fields rendered in
	 * inc/modules/admin/metaboxes/views/*_options.php.
	 *
	 * @param string $post_type Post type being saved.
	 * @return array<string,string>
	 */
	protected function get_allowed_meta_keys( $post_type ) {
		/*
		 * Field name => sanitiser type. The names are taken from the actual fields
		 * rendered in inc/modules/admin/metaboxes/views/*_options.php; anything not
		 * listed here is dropped on save.
		 */
		$common = array(
			// Header.
			'header_show_header'        => 'key',
			'header_type'               => 'key',
			'header_template'           => 'int',
			'header_sticky_template'    => 'int',
			'enable_sticky_header'      => 'key',
			'transparent_header'        => 'key',
			'full_width_header'         => 'key',
			'header_logo_main'          => 'int',
			'header_page_menu'          => 'int',
			'menu_colors'               => 'color',
			'menu_active_colors'        => 'color',
			'custom_header_bg'          => 'background',
			'custom_header_border_color'=> 'color',
			// Content.
			'sidebar_position'          => 'key',
			'sidebar_status'            => 'key',
			'show_page_title'           => 'key',
			'show_hero_image'           => 'key',
			'show_featured_image_in_content' => 'key',
			'enable_dark_background'    => 'key',
			'enable_stretched_content_layout' => 'key',
			'content_padding_top'       => 'int',
			'content_padding_bottom'    => 'int',
			'article_spacing_top'       => 'int',
			'article_spacing_bottom'    => 'int',
			'body_bg_colors'            => 'color',
			'custom_urls'               => 'post',
			'open_links'                => 'key',
			'nofollow_links'            => 'key',
			// Footer.
			'footer_show_footer'        => 'key',
			'footer_type'               => 'key',
			'footer_template'           => 'int',
			'footer_background'         => 'background',
			'footer_text'               => 'post',
			'footer_link_color'         => 'color',
			'footer_link_hover_color'   => 'color',
			'fixed_footer'              => 'key',
			// Preloader.
			'preloader_show_preloader'  => 'key',
			'preloader_type'            => 'key',
			'preloader_bg'              => 'background',
			'preloader_colors'          => 'color',
			'preloader_color_1'         => 'color',
			'preloader_color_2'         => 'color',
			'preloader_color_3'         => 'color',
			'show_preloader'            => 'key',
			// Typography (menu).
			'menu_font'                 => 'text',
			'menu_font_size'            => 'int',
			'menu_font_weight'          => 'key',
			'menu_font_style'           => 'key',
			'menu_font_transform'       => 'key',
			'menu_font_line_height'     => 'text',
			'menu_font_latter_spacing'  => 'text',
			// Media.
			'video_url'                 => 'url',
			'audio_embed_code'          => 'post',
		);

		$by_type = array(
			'post'              => array(),
			'page'              => array(),
			'portfolio'         => array(
				'portfolio_sources'         => 'key',
				'portfolio_client'          => 'text',
				'portfolio_location'        => 'text',
				'portfolio_year'            => 'text',
				'portfolio_status'          => 'text',
				'portfolio_gallery_images'  => 'ids',
				'show_portfolio_details'    => 'key',
			),
			'petrona_templates' => array(
				'template_types' => 'key',
			),
		);

		$fields  = isset( $by_type[ $post_type ] ) ? array_merge( $common, $by_type[ $post_type ] ) : array();
		$allowed = array();

		foreach ( $fields as $field => $sanitize ) {
			$allowed[ 'petrona_' . $field ] = $sanitize;
		}

		/**
		 * Filter the meta keys a Petrona meta box may persist.
		 *
		 * @param array  $allowed   Meta key => sanitiser.
		 * @param string $post_type Post type being saved.
		 */
		return apply_filters( 'petrona_allowed_meta_keys', $allowed, $post_type );
	}

	/**
	 * Sanitise a single submitted meta value.
	 *
	 * @param mixed  $value    Raw (unslashed) value.
	 * @param string $sanitize Sanitiser identifier.
	 * @return mixed
	 */
	protected function sanitize_meta_value( $value, $sanitize ) {
		switch ( $sanitize ) {
			case 'int':
				return is_array( $value ) ? array_map( 'absint', $value ) : absint( $value );

			case 'url':
				return esc_url_raw( $value );

			case 'key':
				return sanitize_key( $value );

			case 'color':
				return sanitize_hex_color( $value );

			case 'background':
				return is_array( $value ) ? array_map( 'sanitize_text_field', $value ) : sanitize_text_field( $value );

			case 'ids':
				$value = is_array( $value ) ? $value : explode( ',', (string) $value );
				$value = array_filter( array_map( 'absint', $value ) );
				return array_values( array_unique( $value ) );

			case 'repeater':
				$rows = array();
				if ( is_array( $value ) ) {
					foreach ( $value as $row ) {
						if ( ! is_array( $row ) ) {
							continue;
						}
						$clean = array();
						foreach ( $row as $field => $field_value ) {
							$clean[ sanitize_key( $field ) ] = wp_kses_post( wp_unslash( (string) $field_value ) );
						}
						if ( array_filter( $clean ) ) {
							$rows[] = $clean;
						}
					}
				}
				return $rows;

			case 'post':
			default:
				return wp_kses_post( $value );
		}
	}

	/**
	 * Whether a submitted value should clear the meta entry.
	 *
	 * @param mixed $value Value.
	 * @return bool
	 */
	protected function is_metadata_empty( $value ) {
		if ( is_array( $value ) ) {
			return ! array_filter(
				$value,
				static function ( $item ) {
					return ! ( is_array( $item ) ? empty( array_filter( $item ) ) : '' !== (string) $item );
				}
			);
		}

		return '' === trim( (string) $value );
	}

	/**
	 * Print the nonce field shared by all Petrona meta boxes.
	 *
	 * @return void
	 */
	public function nonce_field() {
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_FIELD );
	}

	
	public function post_options() {
		include plugin_dir_path(__FILE__) . '/views/post_options.php';
	}
	
	public function page_options() {
		include plugin_dir_path(__FILE__) . '/views/page_options.php';
	}
	
	public function portfolio_options() {
		include plugin_dir_path(__FILE__) . '/views/portfolio_options.php';
	}
	
	public function default_options() {
		include plugin_dir_path(__FILE__) . '/views/default_options.php';
	}	

	public function template_options() {
		include plugin_dir_path( __FILE__ ) . '/views/template_options.php';
	}
	
	// -------------------------------
	protected function build_dependency_atts( $dependency ) {
		if( empty( $dependency ) || !is_array( $dependency ) ) {
			return false;
		}
		$dep_string = "";
		if( !empty( $dependency['option'] ) ) {
			$dep_string .= sprintf( " data-dep-option='%s'", $dependency['option'] );
		}
		if( !empty( $dependency['value'] ) ) {
			$dep_string .= sprintf( " data-dep-value='%s'", $dependency['value'] );
		}
		if( !empty( $dependency['current_default'] ) ) {
			$dep_string .= sprintf( " data-dep-default='%s'", $dependency['current_default'] );
		}
		if( !empty( $dependency['value_in'] ) && is_array( $dependency['value_in'] ) ) {
			$dep_string .= sprintf( " data-dep-value-in='%s'", implode( ',', $dependency['value_in'] ) );
		}
		if( !empty( $dependency['value_not_in'] ) && is_array( $dependency['value_not_in'] ) ) {
			$dep_string .= sprintf( " data-dep-value-not-in='%s'", implode( ',', $dependency['value_not_in'] ) );
		}
		return $dep_string;
	}
	
	public function text($id, $label, $desc = '')
	{
		global $post;
	
		$html = '';
		$html .= '<div class="techt_metabox_field">';
		$html .= '<div class="techt_desc">';
		$html .= '<label for="techt_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '<div class="techt_field">';
		$html .= '<input type="text" id="techt_' . $id . '" name="techt_' . $id . '" value="' . get_post_meta($post->ID, 'petrona_' . $id, true) . '" />';
		$html .= '</div>';
		$html .= '</div>';
	
		echo ( $html );
	}

	public function select_font_family($id, $label, $desc = '')
	{
		global $post;	
		$persian_fonts = techt_get_persian_fonts_array();
		$google_fonts  = techt_get_google_fonts_array();
		
		$html = '';
		$html .= '<div class="techt_metabox_field">';
		$html .= '<div class="techt_desc">';
		$html .= '<label for="techt_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '<div class="techt_field">';
		$html .= '<select class="techt-meta-value techt-select2" id="techt_' . $id . '" name="techt_' . $id . '">';
		$html .= '<option value="">' . esc_html__('Default', 'petrona') . '</option>';
		if ( ! empty( $persian_fonts ) ) {
			$html .= '<optgroup label="' . esc_html__( 'Persian Fonts', 'petrona' ) . '">';
			foreach($persian_fonts as $font) {
				if(get_post_meta($post->ID, 'petrona_' . $id, true) == $font) {
					$selected = 'selected="selected"';
				} else {
					$selected = '';
				}
				
				$html .= '<option ' . $selected . 'value="' . $font . '">' . $font . '</option>';
			}
			$html .= '</optgroup>';
		}
		if ( ! empty( $google_fonts ) ) {
			$html .= '<optgroup label="' . esc_html__( 'Google Fonts', 'petrona' ) . '">';
			foreach($google_fonts as $font) {
				if(get_post_meta($post->ID, 'petrona_' . $id, true) == $font) {
					$selected = 'selected="selected"';
				} else {
					$selected = '';
				}
				$html .= '<option ' . $selected . 'value="' . $font . '">' . $font . '</option>';
			}
			$html .= '</optgroup>';
		}
		$html .= '</select>';
		$html .= '</div>';
		$html .= '</div>';
	
		echo ( $html );
	}	
	
	public function select($id, $label, $options, $desc = '')
	{
		global $post;
	
		$html = '';
		$html .= '<div class="techt_metabox_field">';
		$html .= '<div class="techt_desc">';
		$html .= '<label for="techt_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '<div class="techt_field">';
		$html .= '<select class="techt-meta-value" id="techt_' . $id . '" name="techt_' . $id . '">';
		foreach($options as $key => $option) {
			if(get_post_meta($post->ID, 'petrona_' . $id, true) == $key) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
	
			$html .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
		}
		$html .= '</select>';
		$html .= '</div>';
		$html .= '</div>';
	
		echo ( $html );
	}	
	
	public function multiple($id, $label, $options, $desc = '')
	{
		global $post;
	
		$html = '';
		$html .= '<div class="techt_metabox_field">';
		$html .= '<div class="techt_desc">';
		$html .= '<label for="techt_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '<div class="techt_field">';
		$html .= '<select multiple="multiple" id="techt_' . $id . '" name="techt_' . $id . '[]">';
		foreach($options as $key => $option) {
			if(is_array(get_post_meta($post->ID, 'petrona_' . $id, true)) && in_array($key, get_post_meta($post->ID, 'petrona_' . $id, true))) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
	
			$html .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
		}
		$html .= '</select>';
		$html .= '</div>';
		$html .= '</div>';
	
		echo ( $html );
	}

	public function editor($id, $label, $desc = '', $default = '') {
		global $post;
		
		$db_value = get_post_meta($post->ID, 'petrona_' . $id, true);

		
		if( metadata_exists( 'post', $post->ID, 'petrona_'. $id ) ) {
			$value = $db_value;
		} else {
			$value = $default;
		}

		// Settings that we'll pass to wp_editor
		$args = array (
		    'tinymce' => true,
		    'editor_height' => 230,
		); ?>

		<div class="techt_metabox_field">
			<div class="techt_desc">
				<label for="<?php echo 'techt_' . $id; ?>"><?php echo $label; ?></label>
				<p><?php echo $desc; ?></p>
			</div>
			<div class="techt_field">
				<?php wp_editor( htmlspecialchars_decode($value),'techt_'. $id, $args ); ?>
			</div>
		</div>
		<?php
	}
	
	public function textarea($id, $label, $desc = '', $default = '' )
	{
		global $post;
	
		$db_value = get_post_meta($post->ID, 'petrona_' . $id, true);
	
		if( metadata_exists( 'post', $post->ID, 'petrona_'. $id ) ) {
			$value = $db_value;
		} else {
			$value = $default;
		}
	
		$html = '';
		$html = '';
		$html .= '<div class="techt_metabox_field">';
		$html .= '<div class="techt_desc">';
		$html .= '<label for="techt_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '<div class="techt_field">';
		$html .= '<textarea cols="120" rows="10" id="techt_' . $id . '" name="techt_' . $id . '">' . $value . '</textarea>';
		$html .= '</div>';
		$html .= '</div>';
	
		echo ( $html );
	}
	
	public function upload($id, $label, $desc = '')
	{
		global $post;
	
		$html = '';
		$html = '';
		$html .= '<div class="techt_metabox_field">';
		$html .= '<div class="techt_desc">';
		$html .= '<label for="techt_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '<div class="techt_field">';
		$html .= '<div class="techt_upload">';
		$html .= '<div><input name="techt_' . $id . '" class="upload_field" id="techt_' . $id . '" type="text" value="' . get_post_meta($post->ID, 'petrona_' . $id, true) . '" /></div>';
		$html .= '<div class="techt_upload_button_container"><input class="techt_upload_button" type="button" value="Browse" /></div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';

		echo ( $html );
	}
	
	public function multiple_images($id, $label, $desc = '')
	{
		global $post;
	
		$html = '';
		$html = '';
		$html .= '<div class="techt_metabox_field">';
		$html .= '<div class="techt_desc">';
		$html .= '<label for="techt_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '<div class="techt_field">';
		
		$html .= '<div class="techt_multiple_images" data-formid="' . $id . '">';
		$html .= '<div class="techt_multiple_image_button_container"><input class="techt_multiple_upload_button" type="button" value="' . esc_html__( 'Add Images', 'petrona' ) . '" /></div>';
		$html .= '<div class="techt_uploaded_images clearfix">';
		$html .= '<input type="hidden" id="techt_' . $id . '_first" name="techt_' . $id . '[]" value="__">';
		$selected_image = Techt_Core_Utility::get_val_from_array( get_post_meta( $post->ID, 'petrona_' . $id, false ) );
		$i = 0;
		if( is_array( $selected_image ) ) {
			foreach( $selected_image as $image_id ) {
				$i++;
				if( $i == 1 )
					continue;
				$image = Techt_Core_Utility::get_val_from_array( wp_get_attachment_image_src( $image_id ) );
				$html .= '<div class="image">';
		        $html .= '<img src="' . $image . '">';
		        $html .= '<input type="hidden" id="techt_' . $id . '" name="techt_' . $id . '[]" value="' . $image_id . '">';
		        $html .= '<i class="remove dashicons dashicons-no-alt"></i>';
		        $html .= '</div>';
			}
		}
		$html .= '</div>';
		$html .= '</div>';
		
		$html .= '</div>';
		$html .= '</div>';
	
		echo ( $html );
	}

	function repeater($id, $label, $desc = '') {
		global $post;
	
		$html = '';
		$html = '';
		$html .= '<div class="techt_metabox_field">';
		$html .= '<div class="techt_desc">';
		$html .= '<label for="techt_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '<div class="techt_field">';
		
		$html .= '<div class="techt_repeater" data-formid="' . $id . '">';
		$repeatable_fields = Techt_Core_Utility::get_val_from_array( get_post_meta( $post->ID, 'petrona_' . $id, false ) );
		
		$html .= '<script type="text/javascript">
		jQuery(document).ready(function( $ ){
			$( "#techt-repeater-add-row" ).on("click", function() {
				var row = $( ".empty-row.screen-reader-text" ).clone(true);
				row.removeClass( "empty-row screen-reader-text" );
				row.insertBefore( "#repeater-fieldset-one tbody>tr:last" );
				return false;
			});
		  
			$( ".remove-row" ).on("click", function() {
				$(this).parents("tr").remove();
				return false;
			});
		});
		</script>';
	  
		$html .= '<table id="repeater-fieldset-one" width="100%">';
		$html .= '<tbody>';
		if ( $repeatable_fields ){
			foreach ( $repeatable_fields as $field ) {
				/*
				 * The ternary used to be concatenated before evaluation
				 * (`'...' . $x != '' ? ... : '' . '" />'`), so the stored value was
				 * replaced by "1" or an empty string and the markup was corrupted.
				 */
				$item_title = isset( $field['TitleItem'] ) ? $field['TitleItem'] : '';
				$item_desc  = isset( $field['TitleDescription'] ) ? $field['TitleDescription'] : '';

				$title_value = ( '' !== $item_title ) ? esc_attr( $item_title ) : '';
				$desc_value  = ( '' !== $item_desc ) ? esc_textarea( $item_desc ) : '';

    			$html .= '<tr>';
				$html .= '<td width="15%">';
				$html .= '<input type="text" placeholder="' . esc_attr__( 'Title', 'petrona' ) . '" name="techt_' . esc_attr( $id ) . '[][TitleItem]" value="' . $title_value . '" /></td>';
				$html .= '<td width="70%">';
				$html .= '<textarea placeholder="Description" cols="55" rows="5" name="techt_' . esc_attr( $id ) . '[][TitleDescription]">' . $desc_value . '</textarea></td>';
				$html .= '<td width="15%"><a class="button remove-row" href="#1">' . esc_html__( 'Remove', 'petrona' ) . '</a></td>';
    			$html .= '</tr>';
			}
		}else{

    		// show a blank one
			$html .= '<tr>';
			$html .= '<td>'; 
			$html .= '<input type="text" placeholder="Title" title="Title" name="techt_' . $id . '[][TitleItem]" /></td>';
			$html .= '<td>';
			$html .= '<textarea  placeholder="Description" name="techt_' . $id . '[][TitleDescription]" cols="55" rows="5">  </textarea>';
			$html .= '</td>';
			$html .= '<td><a class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></td>';
			$html .= '</tr>';
		}

    	// empty hidden one for jQuery
		$html .= '<tr class="empty-row screen-reader-text">';
		$html .= '<td>';
        $html .= '<input type="text" placeholder="Title" name="techt_' . $id . '[][TitleItem]"/></td>';
		$html .= '<td>';
		$html .= '<textarea placeholder="Description" cols="55" rows="5" name="techt_' . $id . '[][TitleDescription]"></textarea>';
		$html .= '</td>';
		$html .= '<td><a class="button remove-row" href="#">Remove</a></td>';
		$html .= '</tr>';
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '<p><a id="techt-repeater-add-row" class="button" href="#">Add another</a></p>';

		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
	
		echo ( $html );
	}

	public function color($id, $label, $desc = '')	{
		global $post;
	
		$html = '';
		$html .= '<div class="techt_metabox_field">';
		$html .= '<div class="techt_desc">';
		$html .= '<label for="techt_' . $id . '">';
		$html .= $label;
		$html .= '</label>';
		if($desc) {
			$html .= '<p>' . $desc . '</p>';
		}
		$html .= '</div>';
		$html .= '<div class="techt_field">';
		$html .= '<input type="text" id="techt_' . $id . '" name="techt_' . $id . '" value="' . get_post_meta($post->ID, 'petrona_' . $id, true) . '" class="color-picker" data-alpha-enabled="true"/>';
		$html .= '</div>';
		$html .= '</div>';
	
		echo ( $html );
	}

	public function subsection_start( $title, $dependency = false ) {
		$html = "<div class='techt-metabox-subsection opened'" . $this->build_dependency_atts( $dependency ) . ">";
		$html .= "<div class='subsection-title'>";
		$html .= "<h4 class='title'>" . $title . "</h4>";
		$html .= "</div>";
		$html .= "<div class='subsection-content'>";
		
		echo ( $html );
	}
	
	public function subsection_end() {
		echo "</div></div>\n";
	}	

	public function static_subsection_start( $title ) {
		$html = "<div class='techt-metabox-subsection'>";
		$html .= "<div class='subsection-title'>";
		$html .= "<h4 class='title'>" . $title . "</h4>";
		$html .= "</div>";
		$html .= "<div class='subsection-content'>";
		
		echo ( $html );
	}
	
	public function static_subsection_end() {
		echo "</div></div>\n";
	}

	public function description( $text ) {
		$html = "<div class='techt-metabox-description'>";
		$html .= "<div class='description-content'>";
		$html .= "<p class='description'>" . $text . "</p>";
		$html .= "</div>";
		$html .= "</div>";
		
		echo ( $html );
	}
}

Techt_Metaboxes::instance();