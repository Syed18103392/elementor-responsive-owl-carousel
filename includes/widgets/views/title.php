<?php
/**
 * @var array  $item
 * @var string $field_prefix
 */
if ( ! $settings[ $field_prefix . 'title_hide' ] ) {
	echo gf_owl_carousel_get_text_with_tag( $this, $settings[ $field_prefix . 'title_tag' ], $item['item_title'], [
		'class'        => 'owl-title',
		'data-setting' => 'item_title'
	] );
}
