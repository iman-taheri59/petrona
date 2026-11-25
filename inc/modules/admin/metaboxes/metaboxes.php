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
	
	public function __construct() {
		add_action('add_meta_boxes', array($this, 'add_custom_meta_boxes'));
		add_action('save_post', array($this, 'save_meta_data'));
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
	
	public function save_meta_data( $post_id ) {
		
		if(defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		
		foreach($_POST as $key => $value) {
			if(strstr($key, 'techt_')) {
				$new_key = str_replace("techt", "petrona", $key);
				if($value){
					update_post_meta($post_id, $new_key, $value);
				}else{
					delete_post_meta($post_id, $new_key);
				}
				
			}
		}
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
    			$html .= '<tr>';
				$html .= '<td width="15%">';
				$html .= '<input type="text"  placeholder="'.esc_html__('Title', 'petrona').'" name="techt_' . $id . '[][TitleItem]" value="' . $field['TitleItem'] != '' ? esc_attr( $field['TitleItem'] ) : '' .'" /></td>';
				$html .= '<td width="70%">';
				$html .= '<textarea placeholder="Description" cols="55" rows="5" name="techt_' . $id . '[][TitleDescription]">'. $field['TitleDescription'] != '' ? esc_attr( $field['TitleDescription'] ) : '' . '</textarea></td>';
				$html .= '<td width="15%"><a class="button remove-row" href="#1">'.esc_html__('Remove', 'petrona').'</a></td>';
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