<?php
/**
 * @var string $item_hover_animation_class
 * @var string $field_prefix
 */
if ( ! empty( $settings ) ) :
	if ( $settings['items_list'] ) :
		foreach ( $settings['items_list'] as $item ) : //gf_owl_carousel_debug($item);
			?>
			<div class="item carousel-item-<?php echo esc_attr( $item['_id'] . ' ' . $item_hover_animation_class ); ?>">
				<?php
				require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/thumbnail.php';
				require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/quote.php';
				require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/content.php';
				require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/rating.php';
				require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/title.php';
				require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/subtitle.php';
				?>
			</div>
		<?php
		endforeach;
	endif;
endif;
