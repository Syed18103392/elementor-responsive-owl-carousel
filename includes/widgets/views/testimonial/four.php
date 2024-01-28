<?php
/**
 * @var string $item_hover_animation_class
 * @var string $field_prefix
 */
if ( ! empty( $settings ) ) :
	if ( $settings['items_list'] ) :
		foreach ( $settings['items_list'] as $item ) :
			?>
			<div class="item carousel-item-<?php echo esc_attr( $item['_id'] . ' ' . $item_hover_animation_class ); ?>">
				<?php
				require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/quote.php';
				?>
				<div class="owl-testimonial-header">
					<div class="owl-testimonial-header-left">
						<?php
						require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/title.php';
						require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/subtitle.php';
						require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/rating.php';
						?>
					</div>
					<div class="owl-testimonial-header-right">
						<?php
						require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/thumbnail.php';
						?>
					</div>
				</div>
				<?php
				require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/content.php';
				?>
			</div>
		<?php
		endforeach;
	endif;
endif;
