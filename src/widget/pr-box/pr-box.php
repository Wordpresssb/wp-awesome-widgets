<?php
/**
 * @package inc2734/wp-awesome-widgets
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * PR box widget
 */
class Inc2734_WP_Awesome_Widgets_PR_Box extends Inc2734_WP_Awesome_Widgets_Abstract_Widget {

	/**
	 * @var array
	 */
	protected $_defaults = [
		'title'    => null,
		'lead'     => null,
		'bg-color' => '#fff',
		'items'    => [
			[
				'src'       => '',
				'title'     => '',
				'summary'   => '',
				'link-text' => '',
				'link-url'  => '',
			],
		],
		'thumbnail-aspect-ratio' => '16to9',
		'sm-columns'             => 1,
		'md-columns'             => 1,
		'lg-columns'             => 3,
		'link-text'              => null,
		'link-url'               => null,
		'chameleon'              => 0,
	];

	public function __construct() {
		parent::__construct(
			false,
			__( 'WPAW: PR Box', 'inc2734-wp-awesome-widgets' ),
			[
				'customize_selective_refresh' => true,
			]
		);
	}

	public function update( $new_instance, $old_instance ) {
		$new_instance = shortcode_atts( $this->_defaults, $new_instance );

		if ( ! preg_match( '/^\d+$/', $new_instance['sm-columns'] ) ) {
			$new_instance['sm-columns'] = $this->_defaults['sm-columns'];
		}

		if ( ! preg_match( '/^\d+$/', $new_instance['md-columns'] ) ) {
			$new_instance['md-columns'] = $this->_defaults['md-columns'];
		}

		if ( ! preg_match( '/^\d+$/', $new_instance['lg-columns'] ) ) {
			$new_instance['lg-columns'] = $this->_defaults['lg-columns'];
		}

		foreach ( $new_instance['items'] as $key => $item ) {
			if ( ! array_filter( $item ) ) {
				unset( $new_instance['items'][ $key ] );
			}
		}

		return $new_instance;
	}
}

add_action(
	'widgets_init',
	function() {
		register_widget( 'Inc2734_WP_Awesome_Widgets_PR_Box' );
	}
);
