<?php
/**
 * @var string $item_hover_animation_class
 */
if ( ! empty( $settings ) ) :
	if ( $settings['items_list'] ) :
		foreach ( $settings['items_list'] as $item ) : ?>
			<div class="item carousel-item-<?php echo esc_attr( $item['_id'] . ' ' . $item_hover_animation_class );
			?>">
				<?php
				require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/thumbnail.php';
				?>
				<div class="owl-team-footer">
					<?php
					require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/title.php';
					require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/subtitle.php';
					require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/social.php';
					?>
				</div>
			</div>
		<?php
		endforeach;
	endif;
endif;
