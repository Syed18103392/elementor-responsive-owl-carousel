<?php
/**
 * @var array  $item
 * @var string $field_prefix
 */
if ( ! $settings[ $field_prefix . 'quote_icon_hide' ] ) { ?>
	<div class="owl-quote-icon">
		<?php echo gf_owl_carousel_get_rendered_icons( $settings[ $field_prefix . 'quote_icon' ] ); ?>
	</div>
	<?php
}
