<?php

/**
 * Class description
 *
 * @package   package_name
 * @author    Cherry Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Techt_Download_Handler' ) ) {

	/**
	 * Define Techt_Download_Handler class
	 */
	class Techt_Download_Handler {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Dwonload hook
		 *
		 * @var string
		 */
		private $hook = 'petrona_download';

		/**
		 * Constructor for the class
		 */
		public function init() {
			add_action( 'init', array( $this, 'process_download' ), 99 );
		}

		/**
		 * Returns download hook name
		 *
		 * @return string
		 */
		public function hook() {
			return $this->hook;
		}

		/**
		 * Get download link for passed ID.
		 *
		 * @param  integer $id Media post ID.
		 * @return string
		 */
		public function get_download_link( $id = 0 ) {
			$id = absint( $id );

			return add_query_arg(
				array(
					$this->hook() => $id,
					'_wpnonce'    => wp_create_nonce( 'petrona_download_' . $id ),
				),
				esc_url( home_url( '/' ) )
			);
		}

		/**
		 * Get file size by attachment ID
		 * @param  integer $id [description]
		 * @return [type]      [description]
		 */
		public function get_file_size( $id = 0 ) {

			$file_path = get_attached_file( $id );

			if ( ! $file_path ) {
				return;
			}

			$file_size = filesize( $file_path );

			return size_format( $file_size );
		}

		/**
		 * Check if is download request and handle it.
		 */
		public function process_download() {

			if ( empty( $_GET[ $this->hook() ] ) ) {
				return;
			}

			$id = absint( $_GET[ $this->hook() ] );

			if ( ! $id ) {
				return;
			}

			/*
			 * SECURITY: downloading an arbitrary attachment used to be completely
			 * unauthenticated. Attachments inherit the status of their parent post,
			 * so private/draft/password protected uploads were downloadable by ID
			 * enumeration. Access is now checked against the parent post.
			 */
			$nonce = isset( $_GET['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) : '';

			if ( ! wp_verify_nonce( $nonce, 'petrona_download_' . $id ) ) {
				wp_die(
					esc_html__( 'The download link has expired. Please reload the page and try again.', 'petrona' ),
					esc_html__( 'Invalid download link', 'petrona' ),
					array( 'response' => 403 )
				);
			}

			$post = get_post( $id );

			if ( ! $post || 'attachment' !== $post->post_type ) {
				return;
			}

			$parent = $post->post_parent ? get_post( $post->post_parent ) : null;

			if ( $parent ) {
				// Inherit the visibility of the parent post.
				$allowed_statuses = array( 'publish' );

				if ( is_user_logged_in() && current_user_can( 'read_post', $parent->ID ) ) {
					$allowed_statuses[] = 'private';
				}

				if ( ! in_array( $parent->post_status, $allowed_statuses, true ) ) {
					wp_die(
						esc_html__( 'You are not allowed to download this file.', 'petrona' ),
						esc_html__( 'Forbidden', 'petrona' ),
						array( 'response' => 403 )
					);
				}

				if ( post_password_required( $parent ) ) {
					wp_die(
						esc_html__( 'This file belongs to a protected post.', 'petrona' ),
						esc_html__( 'Forbidden', 'petrona' ),
						array( 'response' => 403 )
					);
				}
			} elseif ( ! is_user_logged_in() || ! current_user_can( 'upload_files' ) ) {
				// Unattached media is private by definition.
				wp_die(
					esc_html__( 'You are not allowed to download this file.', 'petrona' ),
					esc_html__( 'Forbidden', 'petrona' ),
					array( 'response' => 403 )
				);
			}

			$file_path = get_attached_file( $id );

			if ( ! $file_path ) {
				return;
			}

			if ( ! is_file( $file_path ) ) {
				return;
			}

			if ( ini_get( 'zlib.output_compression' ) ) {
				ini_set('zlib.output_compression', 'Off');
			}

			// get the file mime type using the file extension
			switch( strtolower( substr( strrchr( $file_path, '.' ), 1 ) ) ) {
				case 'pdf':
					$mime = 'application/pdf';
					break;
				case 'zip':
					$mime = 'application/zip';
					break;
				case 'jpeg':
				case 'jpg':
					$mime = 'image/jpg';
					break;
				default:
					$mime = 'application/force-download';
					break;
			}

			// Prefer the registered mime type; fall back to an explicit allow list.
			$mime = get_post_mime_type( $id );

			if ( ! $mime ) {
				switch ( strtolower( (string) pathinfo( $file_path, PATHINFO_EXTENSION ) ) ) {
					case 'pdf':
						$mime = 'application/pdf';
						break;
					case 'zip':
						$mime = 'application/zip';
						break;
					case 'jpeg':
					case 'jpg':
						$mime = 'image/jpeg';
						break;
					default:
						$mime = 'application/octet-stream';
						break;
				}
			}

			/*
			 * SECURITY: the file name is attacker influenced and must not be able to
			 * break out of the header (CR/LF injection). basename() alone does not
			 * strip control characters.
			 */
			$filename = sanitize_file_name( basename( $file_path ) );
			$filename = preg_replace( '/[\r\n]+/', '', $filename );
			$filename = str_replace( '"', '', (string) $filename );

			nocache_headers();

			header( 'X-Content-Type-Options: nosniff' );
			header( 'Content-Type: ' . $mime );
			header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
			header( 'Content-Transfer-Encoding: binary' );
			header( 'Content-Length: ' . (int) filesize( $file_path ) );

			$this->readfile_chunked( $file_path );

			die();

		}

		/**
		 * Process chuncked download
		 *
		 * @param  string $file     Filepath
		 * @param  bool   $retbytes
		 * @return mixed
		 */
		public function readfile_chunked( $filename, $retbytes = true ) {

			$chunksize = 1 * ( 1024 * 1024 );
			$buffer    = '';
			$cnt       = 0;
			$handle    = fopen( $filename, 'rb' );

			if ( false === $handle ) {
				return false;
			}

			while ( ! feof( $handle ) ) {
				$buffer = fread( $handle, $chunksize );
				echo $buffer;
				ob_flush();
				flush();
				if ( $retbytes ) {
					$cnt += strlen( $buffer );
				}
			}

			$status = fclose($handle);

			if ( $retbytes && $status ) {
				return $cnt; // return num. bytes delivered like readfile() does.
			}

			return $status;
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;

		}
	}

}

/**
 * Returns instance of Techt_Download_Handler
 *
 * @return object
 */
function techt_download_handler() {
	return Techt_Download_Handler::get_instance();
}
techt_download_handler()->init();