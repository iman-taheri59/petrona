<?php
/**
** Processes like/unlike
** @since    1.0
** @package Petrona
**/

add_action( 'wp_ajax_nopriv_techt_process_simple_like', 'techt_process_simple_like' );
add_action( 'wp_ajax_techt_process_simple_like', 'techt_process_simple_like' );
/**
** Post like counter processor function
**/
if ( ! function_exists( 'techt_process_simple_like' ) ) :
	function techt_process_simple_like() {
		// Security
		$nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( $_REQUEST['nonce'] ) : 0;
		if ( !wp_verify_nonce( $nonce, 'simple-likes-nonce' ) ) {
			exit( esc_html__( 'Not permitted', 'petrona' ) );
		}
		// Test if javascript is disabled
		$disabled = ( isset( $_REQUEST['disabled'] ) && $_REQUEST['disabled'] == true ) ? true : false;
		// Test if this is a comment
		$is_comment = ( isset( $_REQUEST['is_comment'] ) && $_REQUEST['is_comment'] == 1 ) ? 1 : 0;
		// Base variables
		$post_id = ( isset( $_REQUEST['post_id'] ) && is_numeric( $_REQUEST['post_id'] ) ) ? $_REQUEST['post_id'] : '';
		$result = array();
		$post_users = NULL;
		$like_count = 0;
		// Get plugin options
		if ( $post_id != '' ) {
			$count = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_comment_like_count", true ) : get_post_meta( $post_id, "_post_like_count", true ); // like count
			$count = ( isset( $count ) && is_numeric( $count ) ) ? $count : 0;
			if ( !techt_already_liked( $post_id, $is_comment ) ) { // Like the post
				if ( is_user_logged_in() ) { // user is logged in
					$user_id = get_current_user_id();
					$post_users = techt_post_user_likes( $user_id, $post_id, $is_comment );
					if ( $is_comment == 1 ) {
						// Update User & Comment
						$user_like_count = get_user_option( "_comment_like_count", $user_id );
						$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
						update_user_option( $user_id, "_comment_like_count", ++$user_like_count );
						if ( $post_users ) {
							update_comment_meta( $post_id, "_user_comment_liked", $post_users );
						}
					} else {
						// Update User & Post
						$user_like_count = get_user_option( "_user_like_count", $user_id );
						$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
						update_user_option( $user_id, "_user_like_count", ++$user_like_count );
						if ( $post_users ) {
							update_post_meta( $post_id, "_user_liked", $post_users );
						}
					}
				} else { // user is anonymous
					$user_ip = techt_sl_get_ip();
					$post_users = techt_post_ip_likes( $user_ip, $post_id, $is_comment );
					// Update Post
					if ( $post_users ) {
						if ( $is_comment == 1 ) {
							update_comment_meta( $post_id, "_user_comment_IP", $post_users );
						} else { 
							update_post_meta( $post_id, "_user_IP", $post_users );
						}
					}
				}
				$like_count = ++$count;
				$response['status'] = "liked";
				$response['icon'] = techt_get_liked_icon();
			} else { // Unlike the post
				if ( is_user_logged_in() ) { // user is logged in
					$user_id = get_current_user_id();
					$post_users = techt_post_user_likes( $user_id, $post_id, $is_comment );
					// Update User
					if ( $is_comment == 1 ) {
						$user_like_count = get_user_option( "_comment_like_count", $user_id );
						$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
						if ( $user_like_count > 0 ) {
							update_user_option( $user_id, "_comment_like_count", --$user_like_count );
						}
					} else {
						$user_like_count = get_user_option( "_user_like_count", $user_id );
						$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
						if ( $user_like_count > 0 ) {
							update_user_option( $user_id, '_user_like_count', --$user_like_count );
						}
					}
					// Update Post
					if ( $post_users ) {	
						$uid_key = array_search( $user_id, $post_users );
						unset( $post_users[$uid_key] );
						if ( $is_comment == 1 ) {
							update_comment_meta( $post_id, "_user_comment_liked", $post_users );
						} else { 
							update_post_meta( $post_id, "_user_liked", $post_users );
						}
					}
				} else { // user is anonymous
					$user_ip = techt_sl_get_ip();
					$post_users = techt_post_ip_likes( $user_ip, $post_id, $is_comment );
					// Update Post
					if ( $post_users ) {
						$uip_key = array_search( $user_ip, $post_users );
						unset( $post_users[$uip_key] );
						if ( $is_comment == 1 ) {
							update_comment_meta( $post_id, "_user_comment_IP", $post_users );
						} else { 
							update_post_meta( $post_id, "_user_IP", $post_users );
						}
					}
				}
				$like_count = ( $count > 0 ) ? --$count : 0; // Prevent negative number
				$response['status'] = "unliked";
				$response['icon'] = techt_get_unliked_icon();
			}
			if ( $is_comment == 1 ) {
				update_comment_meta( $post_id, "_comment_like_count", $like_count );
				update_comment_meta( $post_id, "_comment_like_modified", date( 'Y-m-d H:i:s' ) );
			} else { 
				update_post_meta( $post_id, "_post_like_count", $like_count );
				update_post_meta( $post_id, "_post_like_modified", date( 'Y-m-d H:i:s' ) );
			}
			$response['count'] = techt_get_like_count( $like_count );
			$response['testing'] = $is_comment;
			if ( $disabled == true ) {
				if ( $is_comment == 1 ) {
					wp_redirect( get_permalink( get_the_ID() ) );
					exit();
				} else {
					wp_redirect( get_permalink( $post_id ) );
					exit();
				}
			} else {
				wp_send_json( $response );
			}
		}
	}
endif;

/**
 * Utility to test if the post is already liked
 * @since    1.0
 */
if ( ! function_exists( 'techt_already_liked' ) ) :
	function techt_already_liked( $post_id, $is_comment ) {
		$post_users = NULL;
		$user_id = NULL;
		if ( is_user_logged_in() ) { // user is logged in
			$user_id = get_current_user_id();
			$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_liked" ) : get_post_meta( $post_id, "_user_liked" );
			if ( count( $post_meta_users ) != 0 ) {
				$post_users = $post_meta_users[0];
			}
		} else { // user is anonymous
			$user_id = techt_sl_get_ip();
			$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_IP" ) : get_post_meta( $post_id, "_user_IP" ); 
			if ( count( $post_meta_users ) != 0 ) { // meta exists, set up values
				$post_users = $post_meta_users[0];
			}
		}
		if ( is_array( $post_users ) && in_array( $user_id, $post_users ) ) {
			return true;
		} else {
			return false;
		}
	} // techt_already_liked()
endif;

/**
 * Output the like button
 * @since    1.0
 */
if ( ! function_exists( 'techt_get_simple_likes_button' ) ) :
	function techt_get_simple_likes_button( $post_id, $is_comment = NULL ) {
		$is_comment = ( NULL == $is_comment ) ? 0 : 1;
		$output = '';
		$nonce = wp_create_nonce( 'simple-likes-nonce' ); // Security
		if ( $is_comment == 1 ) {
			$post_id_class = esc_attr( ' sl-comment-button-' . $post_id );
			$comment_class = esc_attr( ' sl-comment' );
			$like_count = get_comment_meta( $post_id, "_comment_like_count", true );
			$like_count = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
		} else {
			$post_id_class = esc_attr( ' sl-button-' . $post_id );
			$comment_class = esc_attr( '' );
			$like_count = get_post_meta( $post_id, "_post_like_count", true );
			$like_count = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
		}
		$count = techt_get_like_count( $like_count );
		$icon_empty = techt_get_unliked_icon();
		$icon_full = techt_get_liked_icon();
		// Loader
		$loader = '<span id="sl-loader"></span>';
		// Liked/Unliked Variables
		if ( techt_already_liked( $post_id, $is_comment ) ) {
			$class = esc_attr( ' liked' );
			$title = esc_html__( 'Unlike', 'petrona' );
			$icon = $icon_full;
		} else {
			$class = '';
			$title = esc_html__( 'Like', 'petrona' );
			$icon = $icon_empty;
		}
		$output = '<span class="sl-wrapper"><a href="' . admin_url( 'admin-ajax.php?action=techt_process_simple_like' . '&post_id=' . $post_id . '&nonce=' . $nonce . '&is_comment=' . $is_comment . '&disabled=true' ) . '" class="sl-button' . $post_id_class . $class . $comment_class . '" data-nonce="' . $nonce . '" data-post-id="' . $post_id . '" data-iscomment="' . $is_comment . '" title="' . $title . '">' . $icon . $count . '</a>' . $loader . '</span>';
		return $output;
	} // techt_get_simple_likes_button()
endif;

/**
 * Utility retrieves post meta user likes (user id array), 
 * then adds new user id to retrieved array
 * @since    1.0
 */
if ( ! function_exists( 'techt_post_user_likes' ) ) :
	function techt_post_user_likes( $user_id, $post_id, $is_comment ) {
		$post_users = '';
		$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_liked" ) : get_post_meta( $post_id, "_user_liked" );
		if ( count( $post_meta_users ) != 0 ) {
			$post_users = $post_meta_users[0];
		}
		if ( !is_array( $post_users ) ) {
			$post_users = array();
		}
		if ( !in_array( $user_id, $post_users ) ) {
			$post_users['user-' . $user_id] = $user_id;
		}
		return $post_users;
	} // techt_post_user_likes()
endif;

/**
 * Utility retrieves post meta ip likes (ip array), 
 * then adds new ip to retrieved array
 * @since    1.0
 */
if ( ! function_exists( 'techt_post_ip_likes' ) ) :
	function techt_post_ip_likes( $user_ip, $post_id, $is_comment ) {
		$post_users = '';
		$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_IP" ) : get_post_meta( $post_id, "_user_IP" );
		// Retrieve post information
		if ( count( $post_meta_users ) != 0 ) {
			$post_users = $post_meta_users[0];
		}
		if ( !is_array( $post_users ) ) {
			$post_users = array();
		}
		if ( !in_array( $user_ip, $post_users ) ) {
			$post_users['ip-' . $user_ip] = $user_ip;
		}
		return $post_users;
	} // techt_post_ip_likes()
endif;

/**
 * Utility to retrieve IP address
 * @since    1.0
 */
if ( ! function_exists( 'techt_sl_get_ip' ) ) :
	function techt_sl_get_ip() {
		if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) && ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = ( isset( $_SERVER['REMOTE_ADDR'] ) ) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
		}
		$ip = filter_var( $ip, FILTER_VALIDATE_IP );
		$ip = ( $ip === false ) ? '0.0.0.0' : $ip;
		return $ip;
	} // techt_sl_get_ip()
endif;

/**
 * Utility returns the button icon for "like" action
 * @since    1.0
 */
if ( ! function_exists( 'techt_get_liked_icon' ) ) :
	function techt_get_liked_icon() {
		/* If already using Font Awesome with your theme, replace svg with: <i class="fa fa-heart"></i> */
		$icon = '<i class="fas fa-heart"></i>';
		return $icon;
	} // techt_get_liked_icon()
endif;

/**
 * Utility returns the button icon for "unlike" action
 * @since    1.0
 */
if ( ! function_exists( 'techt_get_unliked_icon' ) ) :
	function techt_get_unliked_icon() {
		/* If already using Font Awesome with your theme, replace svg with: <i class="fa fa-heart-o"></i> */
		$icon = '<i class="far fa-heart"></i>';
		return $icon;
	} // techt_get_unliked_icon()
endif;

/**
 * Utility function to format the button count,
 * appending "K" if one thousand or greater,
 * "M" if one million or greater,
 * and "B" if one billion or greater (unlikely).
 * $precision = how many decimal points to display (1.25K)
 * @since    1.0
 */
if ( ! function_exists( 'techt_sl_format_count' ) ) :
	function techt_sl_format_count( $number ) {
		$precision = 2;
		if ( $number >= 1000 && $number < 1000000 ) {
			$formatted = number_format( $number/1000, $precision ).'K';
		} else if ( $number >= 1000000 && $number < 1000000000 ) {
			$formatted = number_format( $number/1000000, $precision ).'M';
		} else if ( $number >= 1000000000 ) {
			$formatted = number_format( $number/1000000000, $precision ).'B';
		} else {
			$formatted = $number; // Number is less than 1000
		}
		$formatted = str_replace( '.00', '', $formatted );
		return $formatted;
	} // techt_sl_format_count()
endif;

/**
** Total like get Function
**/
if ( ! function_exists( 'techt_get_like_count' ) ) :
	function techt_get_like_count( $like_count ) {
		$like_text = esc_html__( '0', 'petrona' );
		if ( is_numeric( $like_count ) && $like_count > 0 ) { 
			$number = techt_sl_format_count( $like_count );
		} else {
			$number = $like_text;
		}
		$count = '<span class="sl-count">' . $number . '</span>';
		return $count;
	} // techt_get_like_count()
endif;

/**
** Total like show Function
**/
if ( ! function_exists( 'techt_total_like' ) ) :
	function techt_total_like() {
		$like_count = get_post_meta( get_the_id(), "_post_like_count", true );
		$like_count = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
		if ( is_numeric( $like_count ) && $like_count > 0 ) { 
			$number = techt_sl_format_count( $like_count );
		} else {
			$number = 0;
		}	
		echo esc_html( $number );
	}
endif;

/**
 * Enqueue scripts and styles.
 */
function techt_like_scripts() {
	if( is_single() ) {	
		wp_enqueue_style( 'techt-post-like', TECHT_MADULES_URL . '/public/assets/css/post-like.css' );
		wp_enqueue_script( 'techt-like-js', TECHT_MADULES_URL . '/public/assets/js/simple-likes-public.js', array('jquery'), false, true );
		wp_localize_script( 'techt-like-js', 'techt_like', array(
		    'ajaxurl' => admin_url( 'admin-ajax.php' ),
		    'like' => esc_html__( 'Like', 'petrona' ),
		    'unlike' => esc_html__( 'Unlike', 'petrona' )
		) ); 
	}
}
add_action( 'wp_enqueue_scripts', 'techt_like_scripts' );
