<?php
/**
 * @package inc2734/wp-awesome-widgets
 * @author inc2734
 * @license GPL-2.0+
 */

class Inc2734_WP_Awesome_Widgets {

	public function __construct() {
		load_textdomain( 'inc2734-wp-awesome-widgets', __DIR__ . '/languages/' . get_locale() . '.mo' );

		$includes = array(
			'/abstract',
			'/widget/*',
		);
		foreach ( $includes as $include ) {
			foreach ( glob( __DIR__ . $include . '/*.php' ) as $file ) {
				if ( false !== strpos( basename( $file ), '_' ) ) {
					continue;
				}

				require_once( $file );
			}
		}

		add_action( 'admin_enqueue_scripts', [ $this, '_admin_enqueue_scripts' ], 9 );
	}

	public function _admin_enqueue_scripts() {
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}

		wp_enqueue_script(
			'wp-awesome-widgets-color-picker-field',
			get_theme_file_uri( '/../vendor/inc2734/wp-awesome-widgets/src/assets/js/color-picker-field.js' ),
			[ 'jquery', 'wp-color-picker' ],
			false,
			true
		);

		wp_enqueue_script(
			'wp-awesome-widgets-thumbnail-field',
			get_theme_file_uri( '/../vendor/inc2734/wp-awesome-widgets/src/assets/js/thumbnail-field.js' ),
			[ 'jquery' ],
			false,
			true
		);

		wp_enqueue_style(
			'wp-awesome-widgets-thumbnail-field',
			get_theme_file_uri( '/../vendor/inc2734/wp-awesome-widgets/src/assets/css/thumbnail-field.css' )
		);

		wp_enqueue_script(
			'wp-awesome-widgets-repeater',
			get_theme_file_uri( '/../vendor/inc2734/wp-awesome-widgets/src/assets/js/repeater.js' ),
			[ 'jquery', 'jquery-ui-sortable' ],
			false,
			true
		);

		wp_enqueue_style(
			'wp-awesome-widgets-repeater',
			get_theme_file_uri( '/../vendor/inc2734/wp-awesome-widgets/src/assets/css/repeater.css' )
		);

		wp_enqueue_style( 'wp-color-picker' );
	}
}
