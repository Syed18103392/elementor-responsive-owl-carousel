<?php

namespace Owl_Carousel_Elementor\Widgets;

defined( 'ABSPATH' ) || exit;

use Exception;
use Elementor\Repeater;
use Owl_Carousel_Elementor;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/**
 * Elementor Responsive Owl Carousel widget
 *
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Owl_Carousel extends \Elementor\Widget_Base {
	/**
	 * Control Settings field prefix
	 *
	 * @since 1.0.0
	 */
	const FIELD_PREFIX = 'carousel_';

	/**
	 * Owl_Carousel constructor.
	 *
	 * @param array $data
	 * @param null  $args
	 *
	 * @throws Exception
	 */
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_scripts' ] );

		// frontend assets
		wp_register_style( 'owce-carousel', GF_OWL_CAROUSEL_PLUGIN_ASSETS . '/css/owl.carousel.min.css', null, '2.3.4' );
		wp_register_style( 'owce-custom', GF_OWL_CAROUSEL_PLUGIN_ASSETS . '/css/custom.css', null, GF_OWL_CAROUSEL_VERSION );
		wp_register_style( 'animate', GF_OWL_CAROUSEL_PLUGIN_ASSETS . '/css/animate.min.css', null, '3.7.0' );

		wp_register_script( 'owce-carousel', GF_OWL_CAROUSEL_PLUGIN_ASSETS . '/js/owl.carousel.min.js', array( 'jquery' ), '2.3.4', true );
		wp_register_script( 'owce-custom', GF_OWL_CAROUSEL_PLUGIN_ASSETS . '/js/custom.js', array( 'jquery', 'owce-carousel' ), GF_OWL_CAROUSEL_VERSION, true );
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve list widget name.
	 *
	 * @return string Widget name.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_name() {
		return 'owl-carousel-elementor';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve list widget title.
	 *
	 * @return string Widget title.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_title() {
		return esc_html__( 'Responsive Owl Carousel', 'gf-owl-carousel-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve list widget icon.
	 *
	 * @return string Widget icon.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_icon() {
		return 'eicon-slides';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the list widget belongs to.
	 *
	 * @return array Widget categories.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @return array Widget keywords.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_keywords() {
		return array(
			'owl carousel',
			'carousel',
			'testimonial',
			'slider',
			'slideshow',
			'team',
		);
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @return array Widget scripts dependencies.
	 * @since  1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_script_depends() {
		return [ 'owce-carousel', 'owce-custom', 'owce-editor' ];
	}

	/**
	 * Editor scripts
	 *
	 * Enqueue plugin javascript integrations for Elementor editor.
	 *
	 * @since  1.2.1
	 * @access public
	 */
	public function editor_scripts() {
		wp_register_script( 'owce-editor', GF_OWL_CAROUSEL_PLUGIN_ASSETS . '/js/editor.js', array( 'jquery', 'elementor-editor' ), GF_OWL_CAROUSEL_VERSION, true );

		wp_enqueue_script( 'owce-editor' );
	}

	/**
	 * Retrieve the list of styles the widget depended on.
	 *
	 * Used to set styles dependencies required to run the widget.
	 *
	 * @return array Widget styles dependencies.
	 * @since  1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_style_depends() {
		return [ 'owce-carousel', 'animate', 'owce-custom', 'elementor-icons-fa-solid' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$field_prefix = self::FIELD_PREFIX;

		$this->start_controls_section(
			$field_prefix . 'content',
			[
				'label' => esc_html__( 'Items', 'gf-owl-carousel-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT
			]
		);

		gf_owl_carousel_select_control( $this, 'layout', 'Select Layout', [
			'options' => get_carousel_layouts(),
			'default' => 'basic',
			'classes' => 'js_carousel_layout',
			/*'selector' => 'no-refresh'*/
		] );

		gf_owl_carousel_select_control( $this, 'layout_testimonial', 'Style', [
			'options'   => get_carousel_layout_styles( 'testimonial' ),
			'default'   => 'one',
			'condition' => [
				$field_prefix . 'layout' => [ 'testimonial' ]
			]
		] );

		gf_owl_carousel_select_control( $this, 'layout_team', 'Style', [
			'options'   => get_carousel_layout_styles( 'team' ),
			'default'   => 'one',
			'condition' => [
				$field_prefix . 'layout' => [ 'team' ]
			]
		] );

		$this->start_controls_tabs(
			$field_prefix . 'items_tabs'
		);

		$this->start_controls_tab(
			$field_prefix . 'items_tab',
			[
				'label' => __( 'Carousel Items', 'gf-owl-carousel-elementor' ),
			]
		);

		$repeater = new Repeater();

		gf_owl_carousel_text_control( $repeater, 'item_title', 'Title', [
			'selectors' => [ '' ],
			'classes'   => 'js_repeater_single  js_hide_on_layout_image'
		] );

		gf_owl_carousel_text_control( $repeater, 'item_subtitle', 'Sub title', [
			'selectors' => [ '' ],
			'classes'   => 'js_repeater_single js_hide_on_layout_image',
		] );

		gf_owl_carousel_text_control( $repeater, 'item_content', 'Content', [
			'type'      => 'textarea',
			'selectors' => [ '' ],
			'classes'   => 'js_repeater_single js_hide_on_layout_image '
		] );

		gf_owl_carousel_image_control( $repeater, 'item_image', 'Upload photo', [
			'selectors' => [ '' ],
			'classes'   => 'js_repeater_single'
		] );

		// Adding link option 
		$repeater->add_control(
			$field_prefix . 'item_link',
			[
				'label' => esc_html__( 'Item Link', 'elementor' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => '#',
				],
				'classes' => 'js_repeater_single js_hide_on_layout_team js_hide_on_layout_testimonial  js_hide_on_layout_image',
			]
		);


		gf_owl_carousel_slider_control( $repeater, 'item_rating', 'Rating', [
			'property'   => 'no-selector',
			'size_units' => [ '' ],
			'range'      => [
				'' => [
					'min'  => 1,
					'max'  => 5,
					'step' => 1
				]
			],
			'default'    => [ 'unit' => '', 'size' => 5 ],
			'classes'    => 'js_repeater_single js_hide_on_layout_basic js_hide_on_layout_image'
		] );

		gf_owl_carousel_social_icons_control( $repeater, get_social_icons(), [
			'classes' => 'js_repeater_single js_hide_on_layout_basic js_hide_on_layout_image js_hide_on_layout_testimonial'
		] );

		$this->add_control(
			'items_list',
			[
				'label'       => esc_html__( 'items', 'gf-owl-carousel-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'classes'     => 'js_items_list_repeater',
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'item_title'   => esc_html__( 'Item 1', 'gf-owl-carousel-elementor' ),
						'item_content' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit', 'gf-owl-carousel-elementor' )
					],
					[
						'item_title'   => esc_html__( 'Item 2', 'gf-owl-carousel-elementor' ),
						'item_content' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit', 'gf-owl-carousel-elementor' )
					
					],
					[
						'item_title'   => esc_html__( 'Item 3', 'gf-owl-carousel-elementor' ),
						'item_content' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit', 'gf-owl-carousel-elementor' )
					],
					[
						'item_title'   => esc_html__( 'Item 4', 'gf-owl-carousel-elementor' ),
						'item_content' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit', 'gf-owl-carousel-elementor' )
					]
				],
				'title_field' => '{{{ item_title }}}',
			]
		);

		$this->end_controls_tab(); // $field_prefix . 'items_tab'

		$this->start_controls_tab(
			$field_prefix . 'items_options',
			[
				'label' => esc_html__( 'Options', 'gf-owl-carousel-elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => $field_prefix . 'thumbnail',
				'exclude' => [ 'custom' ],
				'default' => 'owl_elementor_thumbnail'
			]
		);

		gf_owl_carousel_number_control( $this, 'items_count', 'Number of Items', [
			'responsive'     => true,
			'default'        => 3,
			'tablet_default' => 2,
			'mobile_default' => 1,
			'min'            => 1,
			'max'            => 12,
			'step'           => 1,
			'description'    => esc_html__( 'The number of items visible on the screen at a time', 'gf-owl-carousel-elementor' ),
		] );

		gf_owl_carousel_number_control( $this, 'items_slideby', 'Slide by', [
			'responsive'     => true,
			'default'        => 1,
			'tablet_default' => 1,
			'mobile_default' => 1,
			'min'            => 1,
			'max'            => 12,
			'step'           => 1,
			'description'    => esc_html__( 'The number of slides to be moved at a time', 'gf-owl-carousel-elementor' ),
		] );

		gf_owl_carousel_switcher_control( $this, 'rtl', 'Enable RTL', [
			'default' => false,
		] );
		
		$this->add_control(
			$field_prefix . 'animate_in',
			[
				'label'       => esc_html__( 'Entry Animation', 'gf-owl-carousel-elementor' ),
				'description' => esc_html__( 'Animate works only with 1 item.', 'gf-owl-carousel-elementor' ),
				'type'        => Controls_Manager::ANIMATION,
				'label_block' => true,
				'frontend_available' => true,
				'condition'   => [ $field_prefix . 'items_count' => 1 ],
			]
		);
		
		$this->add_control(
			$field_prefix . 'animate_out',
			[
				'label'       => esc_html__( 'Exit Animation', 'gf-owl-carousel-elementor' ),
				'description' => esc_html__( 'Animate works only with 1 item.', 'gf-owl-carousel-elementor' ),
				'type'        => Controls_Manager::EXIT_ANIMATION,
				'label_block' => true,
				'frontend_available' => true,
				'condition'   => [ $field_prefix . 'items_count' => 1 ],
			]
		);

		gf_owl_carousel_switcher_control( $this, 'autoplay', 'Autoplay' );

		gf_owl_carousel_number_control( $this, 'autoplay_timeout', 'Autoplay timeout', [
			'default'   => 5000,
			'step'      => 50,
			'condition' => [ $field_prefix . 'autoplay' => 'yes', ]
		] );

		gf_owl_carousel_switcher_control( $this, 'autoplay_hover_pause', 'Autoplay pause on hover', [
			'default'   => false,
			'condition' => [ $field_prefix . 'autoplay' => 'yes' ]
		] );

		gf_owl_carousel_number_control( $this, 'smart_speed', 'Slide speed', [
			'default'     => 500,
			'step'        => 50,
			'description' => esc_html__( 'Duration of change of per slide', 'gf-owl-carousel-elementor' ),
		] );

		gf_owl_carousel_switcher_control( $this, 'rewind', 'Rewind', [
			'description' => esc_html__( 'Go backwards when the boundary is reached.',  'gf-owl-carousel-elementor' ),
			'default'     => '',
			'condition'   => [ $field_prefix . 'enable_loop!' => 'yes' ]
		] );

		gf_owl_carousel_switcher_control( $this, 'enable_loop', 'Loop', [
			'description'    => esc_html__( 'Infinity loop. Duplicate last and first items to get loop illusion.', 'gf-owl-carousel-elementor' ),
			'responsive'     => true,
			'default'        => '',
			'tablet_default' => '',
			'mobile_default' => '',
			'condition'      => [ $field_prefix . 'rewind!' => 'yes' ]
		] );

		gf_owl_carousel_switcher_control( $this, 'show_nav', 'Show next/prev', [
			'responsive'     => true,
			'default'        => '',
			'tablet_default' => '',
			'mobile_default' => ''
		] );

		gf_owl_carousel_switcher_control( $this, 'show_dots', 'Show dots', [ 'responsive' => true ] );

		gf_owl_carousel_switcher_control( $this, 'mouse_drag', 'Mouse drag' );

		gf_owl_carousel_switcher_control( $this, 'touch_drag', 'Touch drag' );

		gf_owl_carousel_switcher_control( $this, 'lazyLoad', 'LazyLoad', [ 'default' => '' ] );

		gf_owl_carousel_switcher_control( $this, 'lightbox', 'Lightbox', [
			'description' => esc_html__( 'Enable lightbox effect to images', 'gf-owl-carousel-elementor' ),
			'default'     => '',
			'condition'   => [ $field_prefix . 'layout_team!' => 'two' ]
		] );
		
		gf_owl_carousel_switcher_control( $this, 'lightbox_title', 'Lightbox title', [
			'description' => 'Show image title in the lightbox mode. <a target="_blank" href="https://prnt.sc/15sqxgc">see screenshot</a>',
			'default'     => 'yes',
			'condition'   => [
				$field_prefix . 'lightbox'     => 'yes',
				$field_prefix . 'layout_team!' => 'two'
			]
		] );

		gf_owl_carousel_switcher_control( $this, 'lightbox_description', 'Lightbox Description', [
			'description' => 'Show image description in the lightbox mode. <a target="_blank" href="https://prnt.sc/15sqxgc">see screenshot</a>',
			'default'     => '',
			'condition'   => [
				$field_prefix . 'lightbox'     => 'yes',
				$field_prefix . 'layout_team!' => 'two'
			]
		] );

		gf_owl_carousel_switcher_control( $this, 'lightbox_editor_mode', 'Disable Lightbox in Editor', [
			'description' => esc_html__( 'Disable open image in lightbox in the editor mode', 'gf-owl-carousel-elementor' ),
			'default'     => 'yes',
			'condition'   => [
				$field_prefix . 'lightbox'     => 'yes',
				$field_prefix . 'layout_team!' => 'two'
			]
		] );

		gf_owl_carousel_switcher_control( $this, 'auto_height', 'Auto height', [
			'default'     => '',
			'description' => esc_html__( 'Works only with 1 item on screen. Calculate all visible items and change height according to heighest item.', 'gf-owl-carousel-elementor' ),
			'condition'   => [ $field_prefix . 'items_count' => 1 ]
		] );

		$this->end_controls_tab(); // $field_prefix . 'items_options'

		$this->end_controls_tabs(); // $field_prefix . 'items_tabs'

		$this->end_controls_section(); // $field_prefix . 'content'

		gf_owl_carousel_common_controls_section( $this, 'items_single', 'Items', '.item', [
			'align'                   => true,
			'tag'                     => false,
			'color'                   => false,
			'border'                  => true,
			'border_default'          => [
				'border' => [
					'default' => 'solid',
				],
				'width'  => [
					'default' => [
						'top'      => '1',
						'right'    => '1',
						'bottom'   => '1',
						'left'     => '1',
						'isLinked' => true,
					],
				],
				'color'  => [
					'default' => '#EDEDED',
				],
			],
			//'box_shadow'         => true,
			'border_radius'           => true,
			'typography'              => false,
			'hide'                    => false,
			'margin'                  => false,
			'padding'                 => true,
			'gap'                     => 'right',
			'background'              => true,
			'background_type'         => [ 'classic' ],
			'background_exclude'      => [ 'image' ],
			'hover_animation'         => true,
			'hover_animation_default' => 'float'
		] );

		gf_owl_carousel_common_controls_section( $this, 'title', 'Title', '.owl-title', [
			'default_tag' => 'h3',
			'condition'   => [
				$field_prefix . 'layout' => [
					'basic',
					'testimonial',
					'team'
				]
			]
		] );

		gf_owl_carousel_common_controls_section( $this, 'subtitle', 'Sub Title', '.owl-subtitle', [
			'default_tag' => 'h5',
			'condition'   => [
				$field_prefix . 'layout' => [
					'basic',
					'testimonial',
					'team'
				]
			]
		] );

		gf_owl_carousel_common_controls_section(
			$this,
			'content',
			'Content',
			'.owl-content',
			array(
				'default_tag'      => 'p',
				'condition'        => [
					$field_prefix . 'layout' => [
						'basic',
						'testimonial',
						'team'
					]
				],
				'show_hide_button' => [
					$field_prefix . 'layout' => [
						'team',
						'testimonial',
						'team'
					]
				],
			)
		);

		gf_owl_carousel_common_controls_section(
			$this,
			'image',
			'Image',
			'.owl-thumb img',
			array(
				'image'            => true,
				'tag'              => false,
				'color'            => false,
				'padding'          => true,
				'border'           => true,
				'border_radius'    => true,
				'typography'       => false,
				'size'             => true,
				'show_hide_button' => [
					$field_prefix . 'layout' => [
						'team',
						'testimonial'
					]
				],
			)
		);

		gf_owl_carousel_common_controls_section(
			$this,
			'rating_icon',
			'Rating icon',
			'.owl-rating-icon i',
			array(
				'icon'       => true,
				'font_size'  => true,
				'tag'        => false,
				'typography' => false,
				'condition'  => [ $field_prefix . 'layout' => [ 'testimonial' ] ],
			)
		);

		gf_owl_carousel_common_controls_section(
			$this,
			'quote_icon',
			'Quote icon',
			'.owl-quote-icon i',
			array(
				'icon'         => true,
				'font_size'    => true,
				'tag'          => false,
				'typography'   => false,
				'hide_default' => 'yes',
				'default'      => [ 'library' => 'solid', 'value' => 'fa fa-quote-left' ],
				'condition'    => [ $field_prefix . 'layout' => [ 'testimonial' ] ]
			)
		);

		gf_owl_carousel_common_controls_section(
			$this,
			'social_icon',
			'Social icon',
			'.owl-social-icon i',
			array(
				'font_size'               => true,
				'hover_color'             => true,
				'hover_background'        => true,
				'tag'                     => false,
				'typography'              => false,
				'border'                  => true,
				'padding'                 => true,
				'size'                    => true,
				'border_radius'           => true,
				'background'              => true,
				'background_type'         => [ 'classic' ],
				'background_exclude'      => [ 'image' ],
				'hover_animation'         => true,
				'hover_animation_default' => 'bob',
				'condition'               => [ $field_prefix . 'layout' => [ 'team' ] ],
			)
		);

		gf_owl_carousel_common_controls_section(
			$this,
			'navigation',
			'Navigation',
			'.owl-nav i',
			array(
				'tag'                => false,
				'background'         => true,
				'background_type'    => [ 'classic' ],
				'background_exclude' => [ 'image' ],
				'typography'         => true,
				'hide'               => false,
				'condition'          => [ $field_prefix . 'show_nav' => 'yes' ],
			)
		);

		gf_owl_carousel_common_controls_section(
			$this,
			'dots',
			'Dots',
			'.owl-dot span',
			array(
				'tag'                => false,
				'color'              => false,
				'background'         => true,
				'size'               => true,
				'background_type'    => [ 'classic' ],
				'background_exclude' => [ 'image' ],
				'typography'         => false,
				'hide'               => false,
				'condition'          => [ $field_prefix . 'show_dots' => 'yes' ],
			)
		);
	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings     = $this->get_settings_for_display();
		$field_prefix = self::FIELD_PREFIX;

		$layout          = $this->get_owl_settings( 'layout' );
		$layout_style    = $this->get_owl_settings( 'layout_' . $layout ) ?? 'one';
		$show_nav        = $this->get_owl_settings( 'show_nav' );
		$show_nav_tablet = $this->get_owl_settings( 'show_nav_tablet' );
		$show_nav_mobile = $this->get_owl_settings( 'show_nav_mobile' );

		$item_hover_animation_class = '';
		$item_hover_animation       = $this->get_owl_settings( 'items_single_hover_animation' );

		if ( ! empty( $item_hover_animation ) ) {
			$item_hover_animation_class = 'elementor-animation-' . $item_hover_animation;
		}

		$social_icon_hover_animation_class = '';
		$social_icon_hover_animation       = $this->get_owl_settings( 'social_icon_hover_animation' );

		if ( ! empty( $social_icon_hover_animation ) ) {
			$social_icon_hover_animation_class = 'elementor-animation-' . $social_icon_hover_animation;
		}

		$settings_js = [
			'field_prefix' => $field_prefix,

			'layout' => $layout,
			'rtl'    => $this->get_owl_settings( 'rtl' ),

			'items_count'        => $this->get_owl_settings( 'items_count' ),
			'items_count_tablet' => $this->get_owl_settings( 'items_count_tablet' ),
			'items_count_mobile' => $this->get_owl_settings( 'items_count_mobile' ),

			'items_slideby'        => $this->get_owl_settings( 'items_slideby' ),
			'items_slideby_tablet' => $this->get_owl_settings( 'items_slideby_tablet' ),
			'items_slideby_mobile' => $this->get_owl_settings( 'items_slideby_mobile' ),

			'margin'        => ! empty( $this->get_owl_settings( 'items_single_gap' )['size'] ) ? $this->get_owl_settings( 'items_single_gap' )['size'] : 10,
			'margin_tablet' => ! empty( $this->get_owl_settings( 'items_single_gap_tablet' ) ) ? $this->get_owl_settings( 'items_single_gap_tablet' )['size'] : 0,
			'margin_mobile' => ! empty( $this->get_owl_settings( 'items_single_gap_mobile' ) ) ? $this->get_owl_settings( 'items_single_gap_mobile' )['size'] : 0,

			'nav'        => $show_nav,
			'nav_tablet' => $show_nav_tablet,
			'nav_mobile' => $show_nav_mobile,

			'dots'        => $this->get_owl_settings( 'show_dots' ),
			'dots_tablet' => $this->get_owl_settings( 'show_dots_tablet' ),
			'dots_mobile' => $this->get_owl_settings( 'show_dots_mobile' ),

			'autoplay'             => $this->get_owl_settings( 'autoplay' ),
			'autoplay_timeout'     => $this->get_owl_settings( 'autoplay_timeout' ),
			'autoplay_hover_pause' => $this->get_owl_settings( 'autoplay_hover_pause' ),

			'animate_in'  => $this->get_owl_settings( 'animate_in' ),
			'animate_out' => $this->get_owl_settings( 'animate_out' ),

			'rewind'      => $this->get_owl_settings( 'rewind' ),
			'loop'        => $this->get_owl_settings( 'enable_loop' ),
			'loop_tablet' => $this->get_owl_settings( 'enable_loop_tablet' ),
			'loop_mobile' => $this->get_owl_settings( 'enable_loop_mobile' ),

			'smart_speed' => $this->get_owl_settings( 'smart_speed' ),
			'lazyLoad'    => $this->get_owl_settings( 'lazyLoad' ),
			'auto_height' => $this->get_owl_settings( 'auto_height' ),

			'mouse_drag' => $this->get_owl_settings( 'mouse_drag' ),
			'touch_drag' => $this->get_owl_settings( 'touch_drag' ),
		];

		$this->add_render_attribute(
			'carousel-options',
			[
				'id'           => 'owce-carousel-' . $this->get_id(),
				'class'        => 'owl-carousel owl-theme js-owce-carousel owce-carousel owce-carousel-' . $layout . ' owce-carousel-' . $layout . '-' . $layout_style,
				'data-options' => [ wp_json_encode( $settings_js ) ]
			]
		);

		$css_classes = $show_nav != 'yes' ? 'owce-carousel-no-nav' : '';
		$css_classes .= $show_nav_tablet != 'yes' ? ' owce-carousel-no-nav-tablet' : '';
		$css_classes .= $show_nav_mobile != 'yes' ? ' owce-carousel-no-nav-mobile' : '';

		echo "<div class='js-owce-carousel-container owce-carousel-container " . esc_attr( $css_classes ) . "'>";
		echo "<div " . $this->get_render_attribute_string( 'carousel-options' ) . ">";
		require GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/widgets/views/' . $layout . '/' . $layout_style . '.php';
		echo "</div></div>";
	}

	/**
	 * Get Settings.
	 *
	 * @param string $key required. The key of the requested setting.
	 *
	 * @return string A single value.
	 * @since  1.0.0
	 * @access private
	 *
	 */
	private function get_owl_settings( $key ) {
		return $this->get_settings( self::FIELD_PREFIX . $key );
	}
}
