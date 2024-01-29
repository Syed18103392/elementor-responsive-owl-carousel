<?php
/**
 * @var string $item_hover_animation_class
 * @var string $field_prefix
 */
if (!empty($settings)):
	if ($settings['items_list']):
		foreach ($settings['items_list'] as $item): ?>
			<div class="item carousel-item-<?php echo esc_attr($item['_id'] . ' ' . $item_hover_animation_class); ?>">
				<?php
				require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/thumbnail.php';
				require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/title.php';
				require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/subtitle.php';
				require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/content.php';
				?>
				<div class='bottom-area'>
					<a class="elementor-button elementor-button-link elementor-size-sm elementor-animation-float"
						href="https://kirby.consulting/sapiente-culpa-et-voluptatem-et-maiores/">
						<span class="elementor-button-content-wrapper">
							<span class="elementor-button-icon elementor-align-icon-right">
								<svg aria-hidden="true" class="e-font-icon-svg e-far-arrow-alt-circle-right"
									viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
									<path
										d="M504 256C504 119 393 8 256 8S8 119 8 256s111 248 248 248 248-111 248-248zm-448 0c0-110.5 89.5-200 200-200s200 89.5 200 200-89.5 200-200 200S56 366.5 56 256zm72 20v-40c0-6.6 5.4-12 12-12h116v-67c0-10.7 12.9-16 20.5-8.5l99 99c4.7 4.7 4.7 12.3 0 17l-99 99c-7.6 7.6-20.5 2.2-20.5-8.5v-67H140c-6.6 0-12-5.4-12-12z">
									</path>
								</svg> </span>
							<span class="elementor-button-text">Read More</span>
						</span>
					</a>
				</div>
			</div>
			<?php
		endforeach;
	endif;
endif;

