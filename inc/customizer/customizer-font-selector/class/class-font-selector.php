<?php
/**
 * Font selector.
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}
/**
 * Class Techt_Font_Selector
 */
class Techt_Font_Selector extends WP_Customize_Control {
	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'selector-font';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_style( 'techt-typography', get_theme_file_uri( '/inc/customizer/customizer-font-selector/css/typography.css' ), null );
		wp_enqueue_script( 'techt-typography-js', get_theme_file_uri( '/inc/customizer/customizer-font-selector/js/typography.js' ), array( 'jquery', 'techt-select2' ), '1.0', true );
	}

	/**
	 * Render the control's content.
	 * Allows the content to be overriden without having to rewrite the wrapper in $this->render().
	 *
	 * @access protected
	 */
	protected function render_content() {
		$this_val = $this->value(); ?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>

			<select class="techt-typography-select" <?php $this->link(); ?>>
				<option value="" 
				<?php if ( ! $this_val ) {
					echo 'selected="selected"';} ?>><?php esc_html_e( 'Default', 'petrona' ); ?></option>
				<?php

				// Persian font options
				$persian_fonts = techt_get_persian_fonts_array();
				if ( ! empty( $persian_fonts ) ) { ?>
					<optgroup label="<?php esc_attr_e( 'Persian Fonts', 'petrona' ); ?>">
						<?php
						// Loop through font options and add to select
						foreach ( $persian_fonts as $font ) { ?>
							<option value="<?php echo esc_html( $font ); ?>" <?php selected( $font, $this_val ); 	?>><?php echo esc_html( $font ); ?></option>
						<?php } ?>
					</optgroup>
				<?php }
				// Get Standard font options
				$std_fonts = techt_get_standard_fonts();
				if ( ! empty( $std_fonts ) ) { ?>
					<optgroup label="<?php esc_attr_e( 'Standard Fonts', 'petrona' ); ?>">
						<?php
						// Loop through font options and add to select
						foreach ( $std_fonts as $font ) {
						?>
							<option value="<?php echo esc_html( $font ); ?>" <?php selected( $font, $this_val ); 	?>><?php echo esc_html( $font ); ?></option>
						<?php } ?>
					</optgroup>
				<?php }
				// Google font options
				$google_fonts = techt_get_google_fonts_array();
				if ( ! empty( $google_fonts ) ) { ?>
					<optgroup label="<?php esc_attr_e( 'Google Fonts', 'petrona' ); ?>">
						<?php
						// Loop through font options and add to select
						foreach ( $google_fonts as $font ) { ?>
							<option value="<?php echo esc_html( $font ); ?>" <?php selected( $font, $this_val ); 	?>><?php echo esc_html( $font ); ?></option>
						<?php } ?>
					</optgroup>
				<?php }
			
			?>	
			</select>
		</label>
		<?php
	}
}