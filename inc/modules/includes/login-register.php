<?php

/*Wp login ajax*/
function techt_ajax_login() {
	
	if( (!isset( $_POST['security'] ) || !wp_verify_nonce( $_POST['security'], 'ajax-login-nonce' ) )  ){		
		echo wp_json_encode( ['registered'=>false, 'message'=> esc_html__( 'Ooops, something went wrong, please try again later.', 'petrona' )] );
		exit;
	}
	
	$access_info = [];		
	$access_info['user_login']    = !empty($_POST['username']) ? $_POST['username'] : "";
	$access_info['user_password'] = !empty($_POST['password']) ? $_POST['password'] : "";
	$access_info['rememberme']    = true;
	
	$user_signon = wp_signon( $access_info );
	
	if ( !is_wp_error($user_signon) ){
		
		$userID = $user_signon->ID;
		wp_set_current_user( $userID, $access_info['user_login'] );
		wp_set_auth_cookie( $userID, true, true );
		
		echo wp_json_encode( ['loggedin' => true, 'message'=> esc_html__('Login successful, Redirecting...', 'petrona')] );
		
	} else {
		if ( isset( $user_signon->errors['invalid_email'][0] ) ) {
			
			echo wp_json_encode( ['loggedin' => false, 'message'=> esc_html__('Ops! Invalid Email..!', 'petrona')] );
		} elseif ( isset( $user_signon->errors['invalid_username'][0] ) ) {

			echo wp_json_encode( ['loggedin' => false, 'message'=> esc_html__('Ops! Invalid Username..!', 'petrona')] );
		} elseif ( isset( $user_signon->errors['incorrect_password'][0] ) ) {
			
			echo wp_json_encode( ['loggedin' => false, 'message'=> esc_html__('Ops! Incorrent Password..!', 'petrona')] );
		}
	}
	die();
}
add_action( 'wp_ajax_nopriv_techt_ajax_login', 'techt_ajax_login' );
/*Wp login ajax*/

/* login social application facebook/google */
function techt_login_social_app( $name, $email, $post_id, $widget_id, $type = ''){
	$response	= [];
	$user_data	= get_user_by( 'email', $email ); 

	if ( ! empty( $user_data ) && $user_data !== false ) {
		$user_ID = $user_data->ID;
		wp_set_auth_cookie( $user_ID );
		wp_set_current_user( $user_ID, $name );
		do_action( 'wp_login', $user_data->user_login, $user_data );
		echo wp_json_encode( ['loggedin' => true, 'message'=> esc_html__('Login successful, Redirecting...', 'petrona' )] );
	} else {
		
		$password = wp_generate_password( 12, true, false );
		
		$args = [
			'user_login' => $name,
			'user_pass'  => $password,
			'user_email' => $email,
			'first_name' => $name,
		];
		
		if ( username_exists( $name ) ) {
			$suffix_id = '-' . zeroise( wp_rand( 0, 9999 ), 4 );
			$name  .= $suffix_id;

			$args['user_login'] = strtolower( preg_replace( '/\s+/', '', $name ) );
		}

		$result = wp_insert_user( $args );

		$user_data = get_user_by( 'email', $email );

		if ( $user_data ) {
			$user_ID    = $user_data->ID;
			$user_email = $user_data->user_email;

			$user_meta = array(
				'login_source' => $type,
			);

			update_user_meta( $user_ID, 'techt_login_form', $user_meta );
			
			if(!empty($post_id) && !empty($widget_id)){
				$elementor = \Elementor\Plugin::$instance;			
				$meta_data = $elementor->documents->get( $post_id )->get_elements_data();
				
				$widget_data = techt_get_element_widget_data( $meta_data, $widget_id );
				
				$widget_settings = $elementor->elements_manager->create_element_instance( $widget_data );
				
				$get_settings = $widget_settings->get_settings();
				
				if(!empty($get_settings) && !empty($get_settings['user_role'])){
					$role = $get_settings['user_role'];
					if(!empty($role)){
						wp_update_user( array ('ID' => $user_ID, 'role' => $role) ) ;
					}
				}
			}
			
			if ( wp_check_password( $password, $user_data->user_pass, $user_data->ID ) ) {
				wp_set_auth_cookie( $user_ID );
				wp_set_current_user( $user_ID, $name );
				do_action( 'wp_login', $user_data->user_login, $user_data );
				echo wp_json_encode( ['loggedin' => true, 'message'=> esc_html__('Login successful, Redirecting...', 'petrona' )] );
			}
		}
	}
	
	die();
}
/* login social application facebook/google */

/*facebook verify data*/
function techt_facebook_verify_data_user( $fb_token, $fb_id, $fb_secret ) {
	$fb_api = 'https://graph.facebook.com/oauth/access_token';
	$fb_api = add_query_arg( [
		'client_id'     => $fb_id,
		'client_secret' => $fb_secret,
		'grant_type'    => 'client_credentials',
	], $fb_api );

	$fb_res = wp_remote_get( $fb_api );

	if ( is_wp_error( $fb_res ) ) {
		wp_send_json_error();
	}

	$fb_response = json_decode( wp_remote_retrieve_body( $fb_res ), true );

	$app_token = $fb_response['access_token'];

	$debug_token = 'https://graph.facebook.com/debug_token';
	$debug_token = add_query_arg( [
		'input_token'  => $fb_token,
		'access_token' => $app_token,
	], $debug_token );

	$response = wp_remote_get( $debug_token );

	if ( is_wp_error( $response ) ) {
		return false;
	}

	return json_decode( wp_remote_retrieve_body( $response ), true );
}

function techt_facebook_get_user_email( $user_id, $access_token ){
	$fb_url = 'https://graph.facebook.com/' . $user_id;
	$fb_url = add_query_arg( [
		'fields'       => 'email',
		'access_token' => $access_token,
	], $fb_url );

	$response = wp_remote_get( $fb_url );

	if ( is_wp_error( $response ) ) {
		return false;
	}

	return json_decode( wp_remote_retrieve_body( $response ), true );
}
/*facebook verify data*/

/*Wp facebook social login ajax*/
function techt_ajax_facebook_login() {
	
	if(!get_option('users_can_register')){
		echo wp_json_encode( ['registered'=>false, 'message'=> esc_html__( 'Registration option not enbled in your general settings.', 'petrona' )] );
		die();
	}
	
	if( (!isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'ajax-login-nonce' ) )  ){		
		echo wp_json_encode( ['registered'=>false, 'message'=> esc_html__( 'Ooops, something went wrong, please try again later.', 'petrona' )] );
		die();
	}
	
	$access_token = (!empty( $_POST['accessToken'] )) ? sanitize_text_field( $_POST['accessToken'] ) : '';
	$user_id = (!empty( $_POST['id'] )) ? sanitize_text_field( $_POST['id'] ) : 0;
	$email	=	(isset($_POST['email'])) ? sanitize_email($_POST['email']) : '';
	$name	=	(isset($_POST['name'])) ? sanitize_user( $_POST['name'] ) : '';
	$page_id	=	(isset($_POST['page_id'])) ? sanitize_text_field( $_POST['page_id'] ) : '';
	$widget_id	=	(isset($_POST['widget_id'])) ? sanitize_text_field( $_POST['widget_id'] ) : '';
	
	$fb_data= get_option( 'techt_api_connection_data' );
	$fb_app_id = (!empty($fb_data['techt_facebook_app_id'])) ? $fb_data['techt_facebook_app_id'] : '';
	$fb_secret_id = (!empty($fb_data['techt_facebook_app_secret'])) ? $fb_data['techt_facebook_app_secret'] : '';
				
	$verify_data = techt_facebook_verify_data_user( $access_token, $fb_app_id, $fb_secret_id );
	
	if ( empty( $user_id ) || ( $user_id !== $verify_data['data']['user_id'] ) || empty( $verify_data ) || empty( $fb_app_id ) || empty( $fb_secret_id ) || ( $fb_app_id !== $verify_data['data']['app_id'] ) || ( ! $verify_data['data']['is_valid'] ) ) {
		echo wp_json_encode( ['loggedin' => false, 'message'=> esc_html__('Invalid Authorization', 'petrona' )] );
		die();
	}
	
	$email_res = techt_facebook_get_user_email( $verify_data['data']['user_id'], $access_token );
	
	if ( !empty( $email ) && ( empty( $email_res['email'] ) || $email_res['email'] !== $email ) ) {
		echo wp_json_encode( ['loggedin' => false, 'message'=> esc_html__('Facebook email validation failed', 'petrona' )] );
		die();
	}

	$verify_email = !empty( $email ) && !empty( $email_res['email'] ) ? sanitize_email( $email_res['email'] ) : $verify_data['user_id'] . '@facebook.com';
	
	techt_login_social_app( $name, $verify_email, $page_id, $widget_id, 'facebook' );
	
	die();
}

add_action( 'wp_ajax_nopriv_techt_ajax_facebook_login', 'techt_ajax_facebook_login' );
/*Wp facebook social login ajax*/

/*Google Login Start*/
/*verify google */
function techt_verify_google_data_user( $token, $client_id ){
	// require_once TECHT_INCLUDES_URL . 'vendor/autoload.php';

	$client_data = new \Google_Client( array( 'client_id' => $client_id ) );  //PHPCS:ignore:PHPCompatibility.PHP.ShortArray.Found

	$verified = $client_data->verifyIdToken( $token );

	if ( $verified ) {
		return $verified;
	} else {
		echo wp_json_encode( ['loggedin' => false, 'message'=> esc_html__('Unauthorized access', 'petrona' )] );
		die();
	}
}
/*verify google */
add_action( 'wp_ajax_nopriv_techt_google_ajax_register', 'techt_google_ajax_register' );
function techt_google_ajax_register() {
	
	if(!get_option('users_can_register')){
		echo wp_json_encode( ['registered'=>false, 'message'=> esc_html__( 'Registration option not enbled in your general settings.', 'petrona' )] );
		exit;
	}
	
	if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'ajax-login-nonce' ) ){		
		echo wp_json_encode( ['registered'=>false, 'message'=> esc_html__( 'Ooops, something went wrong, please try again later.', 'petrona' )] );
		exit;
	 }
	
	$response  = array();
	$user_data = array();
	$result    = '';
	$response['loggedin'] = false;
	$response['message'] = 'Invalid User.';
	if ( isset( $_POST['email'] ) && sanitize_email( $_POST['email'] ) ) {
		
		$name       = isset( $_POST['name'] ) ? sanitize_text_field($_POST['name']) : '';
		$email      = isset( $_POST['email'] ) ? sanitize_email($_POST['email']) : '';
		$page_id	=	(isset($_POST['page_id'])) ? sanitize_text_field( $_POST['page_id'] ) : '';
		$widget_id	=	(isset($_POST['widget_id'])) ? sanitize_text_field( $_POST['widget_id'] ) : '';
		$id_token = filter_input( INPUT_POST, 'id_token', FILTER_SANITIZE_STRING );
		$google_data= get_option( 'techt_api_connection_data' );
		$client_id = (!empty($google_data['techt_google_client_id'])) ? $google_data['techt_google_client_id'] : '';
		$verified = techt_verify_google_data_user( $id_token, $client_id );

		if ( empty( $verified ) ) {
			echo wp_json_encode( ['loggedin'=>false, 'message'=> esc_html__( 'User not verified by Google', 'petrona' )] );
			exit;
		}
		
		$v_client_id = isset( $verified['aud'] ) ? $verified['aud'] : '';
		$v_name      = isset( $verified['name'] ) ? $verified['name'] : '';
		$v_email     = isset( $verified['email'] ) ? $verified['email'] : '';
		

		if ( ( $client_id !== $v_client_id ) || ( $email !== $v_email ) || ( $name !== $v_name ) ) {
			echo wp_json_encode( ['loggedin'=>false, 'message'=> esc_html__( 'User not verified by Google', 'petrona' )] );
			exit;
		}

		techt_login_social_app( $v_name, $v_email, $page_id, $widget_id, 'google' );
		
	} else {
		echo wp_json_encode( $response );
		die;
	}
}
/*google login end*/
/*Forgot Password*/
function techt_ajax_forgot_password_ajax() {
	global $wpdb, $wp_hasher;
	
	$nonce = $_POST['nonce'];
	
	if ( ! wp_verify_nonce( $nonce, 'tp_user_lost_password_action' ) )
        die ( 'Security checked!');
		
	$user_login = $_POST['user_login'];
	
	$errors = new WP_Error();
 
    if ( empty( $_POST['user_login'] ) || ! is_string( $_POST['user_login'] ) ) {        
		echo wp_json_encode( [ 'lost_pass'=>'empty_username', 'message'=> sprintf(__( '<strong>ERROR</strong>: Enter a username or email address.', 'petrona' )) ] );
		exit;
    } elseif ( strpos( $_POST['user_login'], '@' ) ) {
        $user_data = get_user_by( 'email', trim( wp_unslash( $_POST['user_login'] ) ) );
        if ( empty( $user_data ) ) {          
			echo wp_json_encode( [ 'lost_pass'=>'invalid_email', 'message'=> sprintf(__( '<strong>ERROR</strong>: There is no account with that username or email address.', 'petrona' )) ] );
			exit;
        }
    } else {
        $login     = trim( $_POST['user_login'] );
        $user_data = get_user_by( 'login', $login );
		if ( ! $user_data ) {			
			echo wp_json_encode( [ 'lost_pass'=>'invalidcombo', 'message'=> sprintf(__( '<strong>ERROR</strong>: There is no account with that username or email address.', 'petrona' )) ] );
			exit;
		}
    }
 
    do_action( 'lostpassword_post', $errors );

    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;
    $key        = get_password_reset_key( $user_data );

    if ( is_wp_error( $key ) ) {
		return $key;
    }

    if ( is_multisite() ) {
		$site_name = get_network()->site_name;
    } else {
		$site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}
	
	/*forgot password mail*/
	if(!empty($_POST['tceol']) && (!empty($_POST['tceol']['tp_cst_email_lost_opt']) && $_POST['tceol']['tp_cst_email_lost_opt']=='yes')){
					
		$elsub =  html_entity_decode($_POST['tceol']['tp_cst_email_lost_subject']);
		$elmsg =  html_entity_decode($_POST['tceol']['tp_cst_email_lost_message']);
		$reset_url = $_POST["resetpageurl"];
		$forgot_url = $_POST["forgotpageurl"];
		if(!empty($_POST["f_p_opt"]) && $_POST["f_p_opt"]=='default'){		
			$tplr_link = network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' );		
		}else if(!empty($_POST["f_p_opt"]) && $_POST["f_p_opt"]=='f_p_frontend'){		
			$tplr_link = network_site_url( "wp-login.php?action=techtrp&key=$key&redirecturl=$reset_url&forgoturl=$forgot_url&login=" . rawurlencode( $user_login ), 'login' );
		}
		
		$elfind = array( '/\[tplr_sitename\]/', '/\[tplr_username\]/', '/\[tplr_link\]/' );
		$lrreplacement = array( $site_name,$user_login,$tplr_link);		
		$clrmessage = preg_replace( $elfind,$lrreplacement,$elmsg );
		
		$lrheaders = array( 'Content-Type: text/html; charset=UTF-8' );
		 
		wp_mail( $user_email, $elsub, $clrmessage, $lrheaders );
		
	}else{ 
		$message = esc_html__( 'Someone has requested a password reset for the following account:', 'petrona' ) . "\r\n\r\n";

		$message .= sprintf( esc_html__( 'Site Name: %s', 'petrona' ), $site_name ) . "\r\n\r\n";

		$message .= sprintf( esc_html__( 'Username: %s', 'petrona' ), $user_login ) . "\r\n\r\n";
		$message .= esc_html__( 'If this was a mistake, just ignore this email and nothing will happen.', 'petrona' ) . "\r\n\r\n";
		$message .= esc_html__( 'To reset your password, visit the following address:', 'petrona' ) . "\r\n\r\n";
		
		$reset_url = $_POST["resetpageurl"];
		$forgot_url = $_POST["forgotpageurl"];
		if(!empty($_POST["f_p_opt"]) && $_POST["f_p_opt"]=='default'){		
			$message .= '<' . network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . ">\r\n";		
		}else if(!empty($_POST["f_p_opt"]) && $_POST["f_p_opt"]=='f_p_frontend'){		
			$message .= '<' . network_site_url( "wp-login.php?action=techtrp&key=$key&redirecturl=$reset_url&forgoturl=$forgot_url&login=" . rawurlencode( $user_login ), 'login' ) . ">\r\n";
		}
	}
	

	$title = sprintf( esc_html__( '[%s] Password Reset', 'petrona' ), $site_name );

	$title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );

	$message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );
	
	if(!empty($_POST['tceol']) && (!empty($_POST['tceol']['tp_cst_email_lost_opt']) && $_POST['tceol']['tp_cst_email_lost_opt']=='yes')){
		echo wp_json_encode( [ 'lost_pass'=>'confirm', 'message'=> esc_html__('Check your e-mail for the reset password link.', 'petrona') ] );
	}else{
		if ( wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) )
		echo wp_json_encode( [ 'lost_pass'=>'confirm', 'message'=> esc_html__('Check your e-mail for the reset password link.', 'petrona') ] );
	else
		echo wp_json_encode( [ 'lost_pass'=>'could_not_sent', 'message'=> esc_html__('The e-mail could not be sent.', 'petrona') . "<br />\n" . esc_html__('Possible reason: your host may have disabled the mail() function.', 'petrona') ] );
	}
	

	exit;
}
add_action( 'wp_ajax_nopriv_techt_ajax_forgot_password', 'techt_ajax_forgot_password_ajax' );
add_action( 'wp_ajax_techt_ajax_forgot_password', 'techt_ajax_forgot_password_ajax' );
/*Forgot Password*/
/*reset password start*/
add_action( 'wp_ajax_nopriv_techt_ajax_reset_password', 'techt_ajax_reset_password_ajax' );
add_action( 'wp_ajax_techt_ajax_reset_password', 'techt_ajax_reset_password_ajax' );
function techt_ajax_reset_password_ajax() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        $user_login = $_REQUEST['user_login'];
        $user_key = $_REQUEST['user_key'];
 
        $user = check_password_reset_key( $user_key, $user_login );
 
        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) {
			   echo wp_json_encode( [ 'reset_pass'=>'expire', 'message'=> esc_html__('The entered key has expired. Please start reset process again.', 'petrona') ] );
            } else {
				echo wp_json_encode( [ 'reset_pass'=>'invalid', 'message'=> esc_html__('The entered key is invalid. Please start reset process again.', 'petrona') ] );
            }
            exit;
        }
 
        if ( isset( $_POST['user_pass'] ) ) {
            if ( $_POST['user_pass'] != $_POST['user_pass_conf'] ) {                
				echo wp_json_encode( [ 'reset_pass'=>'mismatch', 'message'=> esc_html__('Password does not match. Please try again.', 'petrona') ] );
				exit;
            }
 
            if ( empty( $_POST['user_pass'] ) ) {                
                echo wp_json_encode( [ 'reset_pass'=>'empty', 'message'=> esc_html__('Password Field is Empty. Enter Password.
				', 'petrona') ] );                
                exit;
            }
			
            reset_password( $user, $_POST['user_pass'] );
			
           echo wp_json_encode( [ 'reset_pass'=>'success', 'message'=> esc_html__('Your password has been changed. Use your new password to sign in.', 'petrona') ] );
		   
        } else {
            echo "Invalid request.";
        }
 
        exit;
    }
}

add_action( 'login_form_techtrp','techt_redirect_to_custom_password_reset');
if(!empty($_REQUEST['forgoturl'])){
	add_action( 'login_form_resetpass','techt_redirect_to_custom_password_reset' );	
}

function techt_redirect_to_custom_password_reset() {
		
    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
        // Verify key / login combo
		 
        $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );		
        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) {
				$redirect_url = $_REQUEST['forgoturl'];
				$redirect_url = add_query_arg( 'expired', 'expired', $redirect_url );
				wp_redirect($redirect_url);
            } else {
				$redirect_url = $_REQUEST['forgoturl'];
				$redirect_url = add_query_arg( 'invalid', 'invalid', $redirect_url );
				wp_redirect($redirect_url);
            }
            exit;
        }
		if(!empty($_REQUEST['redirecturl'])){
			
			$redirect_url = $_REQUEST['redirecturl'];
			$redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
			$redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );
			$redirect_url = add_query_arg( 'action', 'techtrpf', $redirect_url );
			$redirect_url = add_query_arg( 'forgoturl', $_REQUEST['forgoturl'], $redirect_url );
			wp_redirect($redirect_url);
		}else{
			wp_redirect(home_url());
		}
        exit;
    }
}
/*reset password end*/

function techt_ajax_register_user( $email='', $first_name='', $last_name='',$tp_user_role='' ) {
	    $errors = new \WP_Error();
		$result    = '';
	    if ( ! is_email( $email ) ) {
	        $errors->add( 'email', esc_html__( 'The email address you entered is not valid.', 'petrona' ) );
	        return $errors;
	    }
	 
	    if ( username_exists( $email ) || email_exists( $email ) ) {
	        $errors->add( 'email_exists', esc_html__( 'An account exists with this email address.', 'petrona' ) );
	        return $errors;
	    }
		
	    if(!empty($_POST["dis_password"]) && $_POST["dis_password"]=='yes'){
			if(!empty($_POST["dis_password_conf"]) && $_POST["dis_password_conf"]!='yes' && $_POST['password']){
				$password = $_POST['password'];
			}else{
				if($_POST['password'] == $_POST['conf_password']){	
					$password = $_POST['password'];
				}else{
					$errors->add( 'pass_mismatch', esc_html__( 'Password & Confirm Password Not Match!', 'petrona' ) );
					return $errors;
				}
			}			
		}else{
			$password = wp_generate_password( 12, false );
		}
		
		if(!empty($_POST["user_login"])){
			$user_login = $_POST['user_login'];
		}else{
			$user_login = $email;
		}
		
	    $user_data = array(
	        'user_login'    => $user_login,
	        'user_email'    => $email,
	        'user_pass'     => $password,
	        'first_name'    => $first_name,
	        'last_name'     => $last_name,
	        'nickname'      => $first_name,
	    );
		$user_id_get = username_exists( $user_login );
		
		$user_id='';
		if ( ! $user_id_get ) {
			$user_id = wp_insert_user( $user_data );
			if(empty($_POST['tceo'])){
				if(!empty($_POST["dis_password"]) && $_POST["dis_password"]=='no'){
					wp_new_user_notification( $user_id, null, 'both' );
				}else{
					wp_new_user_notification( $user_id, null, 'both' );
				}
			}
			
			$tp_user_role='subscriber';
			$post_id   = $_POST['page_id'];
			$widget_id = $_POST['widget_id'];
						
			$elementor = \Elementor\Plugin::$instance;			
			$meta_data      = $elementor->documents->get( $post_id )->get_elements_data();
			
			$widget_data = techt_get_element_widget_data( $meta_data, $widget_id );
			
			$widget_settings = $elementor->elements_manager->create_element_instance( $widget_data );
			
			$get_settings = $widget_settings->get_settings();
			
			if(!empty($get_settings) && !empty($get_settings['user_role'])){
				$tp_user_role = $get_settings['user_role'];
			}
			wp_update_user( array ('ID' => $user_id, 'role' => $tp_user_role) ) ;
		}
		
	    return $user_id;
}
if(get_option('users_can_register')){
	add_action( 'wp_ajax_nopriv_techt_ajax_register', 'techt_ajax_register' );
}

function techt_get_element_widget_data( $elements, $id ) {

	foreach ( $elements as $element ) {
		if ( $id === $element['id'] ) {
			return $element;
		}

		if ( ! empty( $element['elements'] ) ) {
			$element = techt_get_element_widget_data( $element['elements'], $id );

			if ( $element ) {
				return $element;
			}
		}
	}

	return false;
}
function techt_ajax_register() {
	
	 if( !isset( $_POST['security'] ) || !wp_verify_nonce( $_POST['security'], 'ajax-login-nonce' ) ){		
		echo wp_json_encode( ['registered'=>false, 'message'=> esc_html__( 'Ooops, something went wrong, please try again later.', 'petrona' )] );
		exit;
	 }
	 
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) { 
		if ( ! get_option( 'users_can_register' ) ) {
			echo wp_json_encode( ['registered'=>false, 'message'=> esc_html__( 'Registering new users is currently not allowed.', 'petrona' )] );
		} else {
			$email      = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
			$first_name = isset($_POST['first_name']) ? sanitize_text_field( $_POST['first_name'] ) : '';
			$last_name  = isset($_POST['last_name']) ? sanitize_text_field( $_POST['last_name'] ) : '';
			$user_login  = isset($_POST['user_login']) ? sanitize_text_field( $_POST['user_login'] ) : '';
			$passwordemc  = isset($_POST['password']) ? $_POST['password'] : '';
		
			$captcha = isset($_POST["token"]) ? $_POST["token"] : '';
			$dis_cap = $_POST["dis_cap"];
			$auto_loggedin = $_POST["auto_loggedin"];
			
			if(!empty($dis_cap) && $dis_cap=='yes'){
				if(!$captcha){
					$message = sprintf(__( 'Please check the captcha form.', 'petrona' ), get_bloginfo( 'name' ) );
					echo wp_json_encode( ['registered' => false, 'message'=> $message] );					
					exit;
				}
			}
			$options= get_option('petrona_options');
			$resscore='';
			$check_captcha = false;
			if( !empty($dis_cap) && $dis_cap=='yes' && !empty($options['secret_key_recaptcha']) && !empty($captcha) ){
				$secretKey = $options['secret_key_recaptcha'];
				$ip = $_SERVER['REMOTE_ADDR'];
				
				$url = 'https://www.google.com/recaptcha/api/siteverify';
				$data = array('secret' => $secretKey, 'response' => $captcha);
				
				$options = array(
					'http' => array(
					  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					  'method'  => 'POST',
					  'content' => http_build_query($data)
					)
				  );
				  
				  
				$context  = stream_context_create($options);
				$response = file_get_contents($url, false, $context);
				$responseKeys = json_decode($response,true);
				$resscore=$responseKeys["score"];
				$check_captcha = true;
				if(!$responseKeys['success']){
					$message = sprintf(__( 'Please check the reCaptcha form.', 'petrona' ), get_bloginfo( 'name' ) );
					echo wp_json_encode( ['registered' => false, 'message'=> $message, 'recaptcha' => false ] );
					exit;
				}
			}
			
			$result     = techt_ajax_register_user( $email, $first_name, $last_name );
			if(empty($result)){				
				echo wp_json_encode( ['registered'=>false, 'message'=> esc_html__( 'Username Already Exists.', 'petrona' )] );				
			}else if ( is_wp_error( $result ) ) {
				// Parse errors into a string and append as parameter to redirect
				$errors  = $result->get_error_message();
				echo wp_json_encode( ['registered' => false, 'message'=> $errors ] );
			} else {
				// Success
				
				if(!empty($_POST['tceo']) && (!empty($_POST['tceo']['tp_cst_email_opt']) && $_POST['tceo']['tp_cst_email_opt']=='yes')){
					
					$esub =  html_entity_decode($_POST['tceo']['tp_cst_email_subject']);
					$emsg =  html_entity_decode($_POST['tceo']['tp_cst_email_message']);
					$find = array( '/\[tp_firstname\]/', '/\[tp_lastname\]/', '/\[tp_username\]/', '/\[tp_email\]/', '/\[tp_password\]/' );
					$replacement = array( $first_name,$last_name, $user_login, $email,$passwordemc );
					$cmessage = preg_replace( $find, $replacement, $emsg );
					$headers = array( 'Content-Type: text/html; charset=UTF-8' );
					 
					wp_mail( $email, $esub, $cmessage, $headers );
				}				
				$message = sprintf(__( 'You have successfully registered to %s. We have emailed your password to the email address you entered.', 'petrona' ), get_bloginfo( 'name' ) );
				$response = ['registered' => true, 'message'=> $message, 'recaptcha' => $check_captcha, 'recaptcha_score' => $resscore ];
				
				if((!empty($auto_loggedin) && $auto_loggedin==true)){
					$access_info = [];
					$access_info['user_login']    = !empty($email) ? $email : "";
					$access_info['user_password'] = !empty($_POST['password']) ? $_POST['password'] : "";
					$access_info['rememberme']    = true;
					$user_signon = wp_signon( $access_info, false );
					if ( !is_wp_error($user_signon) ){				
						$response = ['registered' => true, 'message'=> esc_html__('Login successful, Redirecting...', 'petrona')];
					} else {			
						$response = ['registered' => false, 'message'=> esc_html__('Registered Successfully, Ops! Login Failed...!', 'petrona')];
					}
				}
				echo wp_json_encode($response);
			}
		}

		exit;
	}
}