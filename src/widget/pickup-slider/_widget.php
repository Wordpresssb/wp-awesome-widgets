<?php
/**
 * @package inc2734/wp-awesome-widgets
 * @author inc2734
 * @license GPL-2.0+
 */

$query_args = [
	'post_type'      => 'any',
	'posts_per_page' => -1,
	'tax_query'      => [
		[
			'taxonomy' => 'post_tag',
			'terms'    => [ 'pickup' ],
			'field'    => 'slug',
		],
	],
];

if ( ! empty( $instance['random'] ) ) {
	$query_args = array_merge( $query_args, [
		'orderby' => 'rand',
	] );
}

$pickup_posts = get_posts( $query_args );

if ( ! $pickup_posts ) {
	return;
}

global $post;
?>

<?php echo wp_kses_post( $args['before_widget'] ); ?>

	<?php
	$is_block_link = 'overall' === $instance['link-type'];
	$wrapper_tag   = $is_block_link ? 'a' : 'div';
	$button_tag    = $is_block_link ? 'span' : 'a';
	?>

	<div
		class="wpaw-pickup-slider wpaw-pickup-slider--<?php echo esc_attr( $args['widget_id'] ); ?>"
		id="wpaw-pickup-slider-<?php echo esc_attr( $args['widget_id'] ); ?>"
		>
		<div class="wpaw-pickup-slider__inner">
			<div class="wpaw-pickup-slider__canvas">
				<?php foreach ( $pickup_posts as $post ) : ?>
					<?php
					setup_postdata( $post );
					$thumbnail_size = wp_is_mobile() ? 'large' : 'full';
					$thumbnail_size = apply_filters( 'inc2734_wp_awesome_widgets_pickup_slider_image_size', $thumbnail_size, wp_is_mobile(), $args['widget_id'] );
					?>
					<<?php echo esc_attr( $wrapper_tag ); ?>
						class="wpaw-pickup-slider__item"
						<?php if ( $is_block_link ) : ?>
							href="<?php the_permalink(); ?>"
						<?php endif; ?>
						>
						<div class="wpaw-pickup-slider__figure"
							style="background-image: url(<?php echo esc_url( wp_get_attachment_image_url( get_post_thumbnail_id(), $thumbnail_size ) ); ?>);">
						</div>
						<div class="wpaw-pickup-slider__item-body">
							<div class="wpaw-pickup-slider__item-title">
								<?php the_title(); ?>
							</div>
							<ul class="wpaw-pickup-slider__item-meta c-meta">
								<li class="c-meta__item c-meta__item--author"><?php echo get_avatar( $post->post_author ); ?><?php echo esc_html( get_the_author() ); ?></li>
								<li class="c-meta__item"><?php echo esc_html( get_the_time( get_option( 'date_format' ) ) ); ?></li>
							</ul>

							<<?php echo esc_attr( $button_tag ); ?>
								class="wpaw-pickup-slider__item-more"
								<?php if ( ! $is_block_link ) : ?>
									href="<?php the_permalink(); ?>"
								<?php endif; ?>
								>
								<?php esc_html_e( 'READ MORE', 'inc2734-wp-awesome-widgets' ); ?>
							</<?php echo esc_attr( $button_tag ); ?>>
						</div>
					</<?php echo esc_attr( $wrapper_tag ); ?>>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
	</div>

<?php echo wp_kses_post( $args['after_widget'] ); ?>
