<?php
/**
 * @var array  $item
 * @var string $field_prefix
 * @var string $social_icon_hover_animation_class
 */
if ( ! $settings[ $field_prefix . 'social_icon_hide' ] ) {
	?>
	<div class="owl-social-icon">
		<?php
		echo gf_owl_carousel_get_social_icons( $this, $item, [
			'class' => $social_icon_hover_animation_class
		] );
		?>
	</div>
	<?php
}
