<?php
// $rtlLicenseClassName  = 'RTL_License_a8a91f9370d0e954';
// $rtlLicenseFilePath   = __DIR__ . DIRECTORY_SEPARATOR . $rtlLicenseClassName . '.php';
// $rtlLicenseFileHash   = @sha1_file($rtlLicenseFilePath);

// if ( $rtlLicenseFileHash === '33b26d8e6e228fbfefe2e8c893b961749dae8dda' && file_exists($rtlLicenseFilePath) ) {
// 	require_once $rtlLicenseFilePath;

// 	if ( class_exists($rtlLicenseClassName) && method_exists($rtlLicenseClassName, 'isActive') ) {
// 		$rtlLicenseClass = new $rtlLicenseClassName();

// 		if ( $rtlLicenseClass->{'isActive'}() === true ) {
			petrona_init_customizer();
			add_action('admin_init', 'petrona_init_options' );
			add_action('admin_menu', 'petrona_add_setting_page');
// 		}
// 	}
// }

function petrona_init_customizer(){
    
    /**
     * Enable fonts
     *
     * @since 1.0
     */
    // Enqueue fonts in the editor.
    // if(is_rtl()){
    //     add_editor_style( techt_enqueue_persian_font('Vazir') );
    // }else{
    //     add_editor_style( techt_enqueue_google_fonts_url('Roboto Slab') );
    //     add_editor_style( techt_enqueue_google_fonts_url( 'Poppins' ) );
    // }

    /**
     * Sanitization Callback.
     */
    require get_parent_theme_file_path( '/inc/customizer/sanitize-callback.php' );

    /**
     * Customizer additions.
     */
    require get_parent_theme_file_path( '/inc/customizer/customizer.php' );

    /**
    * Customizer Basic Settings.
    */
    require get_parent_theme_file_path( '/inc/customizer/basic-settings.php' );

}

// Register our settings. Add the settings section, and settings fields
function petrona_init_options(){
    register_setting('petrona_settings_options', 'petrona_options', 'petrona_recap_validate' );
	add_settings_section('recap_section', esc_html__('reCAPTCHA v3 Keys', 'petrona'), 'recap_section_text_fn', 'petrona_recaptcha');
	add_settings_field('site_key_recaptcha', esc_html__('Site Key reCAPTCHA v3', 'petrona'), 'site_key_recaptcha_string_fn','petrona_recaptcha', 'recap_section');
    add_settings_field('secret_key_recaptcha', esc_html__('Secret Key reCAPTCHA v3', 'petrona'), 'secret_key_recaptcha_string_fn','petrona_recaptcha', 'recap_section');
}

// Add sub page to the Settings Menu
function petrona_add_setting_page() {

	add_menu_page(
        esc_html__('Petrona Settings', 'petrona'),
        esc_html__('Petrona Settings', 'petrona'),
        'administrator',
        'petrona-settings',
        'petrona_recaptcha_page'
    );

    add_submenu_page(
        'petrona-settings',
        esc_html__('reCaptcha', 'petrona'),
        esc_html__('reCaptcha', 'petrona'),
        'administrator',
        'petrona_recaptcha',
        'petrona_recaptcha_page'
    );

}


function petrona_recaptcha_page() {
    ?>
        <div class="wrap">
            <form action="options.php" method="post">
            <?php settings_fields('petrona_settings_options'); ?>
            <?php do_settings_sections('petrona_recaptcha'); ?>
            <p class="submit">
                <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
            </p>
            </form>

           
        </div>
    <?php
}

function recap_section_text_fn() {
	echo '<p>' . __('Note: <a href="https://www.google.com/recaptcha/intro/v3.html" target="_blank">reCAPTCHA v3</a> is a free service by Google that protects your website from spam and abuse.', 'petrona') . '</p>';
}

function site_key_recaptcha_string_fn() {
	$options = get_option('petrona_options');
    $value = $options['site_key_recaptcha'] ?? "";
    echo "<input id='petrona_site_key_recaptcha' name='petrona_options[site_key_recaptcha]' size='40' type='text' value='{$value}'/>";;
}

function secret_key_recaptcha_string_fn() {
	$options = get_option('petrona_options');
    $value = $options['secret_key_recaptcha'] ?? "";
    echo "<input id='petrona_secret_key_recaptcha' name='petrona_options[secret_key_recaptcha]' size='40' type='text' value='{$value}'/>";;
}

function petrona_recap_validate($input) {
	// Check our textbox option field contains no HTML tags - if so strip them out
	$input['site_key_recaptcha'] =  wp_filter_nohtml_kses($input['site_key_recaptcha']);
    $input['secret_key_recaptcha'] =  wp_filter_nohtml_kses($input['secret_key_recaptcha']);
	return $input; // return validated input
}
