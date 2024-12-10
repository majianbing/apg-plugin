<?php
/**
 * Shoes Store   Theme Customizer
 *
 * @package Shoes Store  
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shoes_store_custom_controls() {
	load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'shoes_store_custom_controls' );

function shoes_store_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-picker.php' );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.logo .site-title a',
	 	'render_callback' => 'shoes_store_Customize_partial_blogname',
	));

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => 'p.site-description',
		'render_callback' => 'shoes_store_Customize_partial_blogdescription',
	));

	// add home page setting pannel
	$wp_customize->add_panel( 'shoes_store_panel_id', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => esc_html__( 'Homepage Settings', 'shoes-store' ),
		'priority' => 10,
	));

	//Menus Settings
	$wp_customize->add_section( 'shoes_store_menu_section' , array(
    	'title' => __( 'Menus Settings', 'shoes-store' ),
		'panel' => 'shoes_store_panel_id'
	) );

	$wp_customize->add_setting('shoes_store_navigation_menu_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_navigation_menu_font_size',array(
		'label'	=> __('Menus Font Size','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_menu_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_navigation_menu_font_weight',array(
        'default' => 600,
        'transport' => 'refresh',
        'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_navigation_menu_font_weight',array(
        'type' => 'select',
        'label' => __('Menus Font Weight','shoes-store'),
        'section' => 'shoes_store_menu_section',
        'choices' => array(
        	'100' => __('100','shoes-store'),
            '200' => __('200','shoes-store'),
            '300' => __('300','shoes-store'),
            '400' => __('400','shoes-store'),
            '500' => __('500','shoes-store'),
            '600' => __('600','shoes-store'),
            '700' => __('700','shoes-store'),
            '800' => __('800','shoes-store'),
            '900' => __('900','shoes-store'),
        ),
	) );

	// text trasform
	$wp_customize->add_setting('shoes_store_menu_text_transform',array(
		'default'=> 'Capitalize',
		'sanitize_callback'	=> 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_menu_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Menus Text Transform','shoes-store'),
		'choices' => array(
            'Uppercase' => __('Uppercase','shoes-store'),
            'Capitalize' => __('Capitalize','shoes-store'),
            'Lowercase' => __('Lowercase','shoes-store'),
        ),
		'section'=> 'shoes_store_menu_section',
	));

	$wp_customize->add_setting('shoes_store_menus_item_style',array(
    'default' => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_menus_item_style',array(
    'type' => 'select',
    'section' => 'shoes_store_menu_section',
		'label' => __('Menu Item Hover Style','shoes-store'),
		'choices' => array(
      'None' => __('None','shoes-store'),
      'Zoom In' => __('Zoom In','shoes-store'),
    ),
	) );

	$wp_customize->add_setting('shoes_store_header_menus_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'shoes_store_header_menus_color', array(
		'label'    => __('Menus Color', 'shoes-store'),
		'section'  => 'shoes_store_menu_section',
	)));

	$wp_customize->add_setting('shoes_store_header_menus_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'shoes_store_header_menus_hover_color', array(
		'label'    => __('Menus Hover Color', 'shoes-store'),
		'section'  => 'shoes_store_menu_section',
	)));

	$wp_customize->add_setting('shoes_store_header_submenus_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'shoes_store_header_submenus_color', array(
		'label'    => __('Sub Menus Color', 'shoes-store'),
		'section'  => 'shoes_store_menu_section',
	)));

	$wp_customize->add_setting('shoes_store_header_submenus_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'shoes_store_header_submenus_hover_color', array(
		'label'    => __('Sub Menus Hover Color', 'shoes-store'),
		'section'  => 'shoes_store_menu_section',
	)));

	// Top Bar
	$wp_customize->add_section( 'shoes_store_top_bar' , array(
    	'title' => esc_html__( 'Top Bar', 'shoes-store' ),
		'panel' => 'shoes_store_panel_id'
	) );

	$wp_customize->add_setting('shoes_store_topbar_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('shoes_store_topbar_text',array(
		'label'	=> esc_html__( 'Add Text', 'shoes-store' ), 
		'section'	=> 'shoes_store_top_bar',
		'type'		=> 'text',
		'input_attrs' => array(
	    'placeholder' => __( 'FREE WORLDWIDE SHIPPING ON ORDER FROM $200', 'shoes-store' ),
	  ),
	));

	$wp_customize->add_setting('shoes_store_cart_icon',array(
		'default'	=> 'fa-solid fa-cart-shopping',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
        $wp_customize,'shoes_store_cart_icon',array(
		'label'	=> __('Add Cart Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_top_bar',
		'setting'	=> 'shoes_store_cart_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('shoes_store_heart_icon',array(
		'default'	=> 'fa-solid fa-heart',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
        $wp_customize,'shoes_store_heart_icon',array(
		'label'	=> __('Add Wishlist Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_top_bar',
		'setting'	=> 'shoes_store_heart_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('shoes_store_topbar_track_order_icon',array(
		'default'	=> 'fa-solid fa-truck-fast',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
        $wp_customize,'shoes_store_topbar_track_order_icon',array(
		'label'	=> esc_html__( 'Add Track Order Icon', 'shoes-store' ), 
		'transport' => 'refresh',
		'section'	=> 'shoes_store_top_bar',
		'setting'	=> 'shoes_store_topbar_track_order_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('shoes_store_topbar_myaccount_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
        $wp_customize,'shoes_store_topbar_myaccount_icon',array(
		'label'	=> esc_html__( 'Add Myaccount Icon', 'shoes-store' ), 
		'transport' => 'refresh',
		'section'	=> 'shoes_store_top_bar',
		'setting'	=> 'shoes_store_topbar_myaccount_icon',
		'type'		=> 'icon'
	)));

  $wp_customize->add_setting( 'shoes_store_search_hide_show',array(
    'default' => 1,
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_switch_sanitization'
  ));
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_search_hide_show',array(
    'label' => esc_html__( 'Show / Hide Search','shoes-store' ),
    'section' => 'shoes_store_top_bar'
  )));

	$wp_customize->add_setting('shoes_store_search_open_icon',array(
		'default'	=> 'fas fa-search',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser($wp_customize,'shoes_store_search_open_icon',array(
		'label'	=> __('Search Button Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_top_bar',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('shoes_store_search_close_icon',array(
		'default'	=> 'fa fa-window-close',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser($wp_customize,'shoes_store_search_close_icon',array(
		'label'	=> __('Search Button Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_top_bar',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('shoes_store_topbar_bg_color', array(
		'default'           => '#B5E448',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'shoes_store_topbar_bg_color', array(
		'label'    => __('Topbar Background Color', 'shoes-store'),
		'section'  => 'shoes_store_top_bar',
	)));

	$wp_customize->add_setting('shoes_store_product_category_bg_color', array(
		'default'           => '#B5E448',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'shoes_store_product_category_bg_color', array(
		'label'    => __('Category Background Color', 'shoes-store'),
		'section'  => 'shoes_store_top_bar',
	)));

	//Sticky Header
	$wp_customize->add_setting( 'shoes_store_sticky_header',array(
    'default' => 0,
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_switch_sanitization'
  ) );
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_sticky_header',array(
    'label' => esc_html__( 'Sticky Header','shoes-store' ),
    'section' => 'shoes_store_top_bar'
  )));

  $wp_customize->add_setting('shoes_store_sticky_header_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_sticky_header_padding',array(
		'label'	=> __('Sticky Header Padding','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
      'placeholder' => __( '10px', 'shoes-store' ),
    ),
		'section'=> 'shoes_store_top_bar',
		'type'=> 'text'
	));

	//Slider
	$wp_customize->add_section( 'shoes_store_slider_section' , array(
  	'title'      => __( 'Slider Settings', 'shoes-store' ),
  	'description' => __('For more options of Slider section </br> <a class="go-pro-btn" target="blank" href="https://www.vwthemes.com/products/gift-shop-wordpress-theme">GET PRO</a>','shoes-store'),
		'panel' => 'shoes_store_panel_id',
	) );

	$wp_customize->add_setting('shoes_store_slide_number',array(
		'default'	=> '',
		'sanitize_callback'	=> 'shoes_store_sanitize_choices',
	));
	$wp_customize->add_control('shoes_store_slide_number',array(
		'label'	=> __('Number of slides to show','shoes-store'),
		'description' => __('Selct Max 3 number Of slide and refresh page','shoes-store'),
		'section'	=> 'shoes_store_slider_section',
		'type'		=> 'select',
		'choices'  => array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
		),
	));

	$shoes_store_count =  get_theme_mod('shoes_store_slide_number');

	for($shoes_store_i=1; $shoes_store_i<=$shoes_store_count; $shoes_store_i++) {		
		
	 	$wp_customize->add_setting('shoes_store_slider_title'.$shoes_store_i,array(
			'default'	=> '',
			'sanitize_callback'	=> 'sanitize_text_field'
		));
		$wp_customize->add_control('shoes_store_slider_title'.$shoes_store_i,array(
			'label'	=> __('Slider Title','shoes-store'),
			'section'	=> 'shoes_store_slider_section',
			'input_attrs' => array(
	        'placeholder' => __( 'Step into Style: Comfort, Performance, and Innovation.', 'shoes-store' ),
	      ),
			'type'	=> 'text'
		));

	 	$wp_customize->add_setting('shoes_store_slider_text'.$shoes_store_i,array(
			'default'	=> '',
			'sanitize_callback'	=> 'sanitize_text_field'
		));
		$wp_customize->add_control('shoes_store_slider_text'.$shoes_store_i,array(
			'label'	=> __('Slider Content','shoes-store'),
			'section'	=> 'shoes_store_slider_section',
			'input_attrs' => array(
	        'placeholder' => __( 'Discover the latest sneaker trends crafted for style, performance, and all-day comfort, wherever you go.', 'shoes-store' ),
	      ),
			'type'		=> 'text'
		));

		$wp_customize->add_setting('shoes_store_side_img'.$shoes_store_i,array(
			'default'	=> '',
			'sanitize_callback'	=> 'esc_url_raw',
		));
		$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'shoes_store_side_img'.$shoes_store_i,array(
		  'label' => __('Add Image','shoes-store'),
		  'section' => 'shoes_store_slider_section',
		  'description' => __('Image Size (	810 × 370 px) and use transparent image.','shoes-store'),
		)));
	}

	$wp_customize->add_setting('shoes_store_slider_image_bg_color', array(
		'default'           => '#B5E448',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'shoes_store_slider_image_bg_color', array(
		'label'    => __('Image Background Color', 'shoes-store'),
		'section'  => 'shoes_store_slider_section',
	)));

	$wp_customize->add_setting('shoes_store_slider_previous_icon',array(
		'default'	=> 'fa-solid fa-angle-left',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
        $wp_customize,'shoes_store_slider_previous_icon',array(
		'label'	=> __('Slider Previous Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_slider_section',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('shoes_store_slider_next_icon',array(
		'default'	=> 'fa-solid fa-angle-right',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
        $wp_customize,'shoes_store_slider_next_icon',array(
		'label'	=> __('Slider Next Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_slider_section',
		'type'		=> 'icon'
	)));

	// New Product Section
	$wp_customize->add_section('shoes_store_products_section',array(
		'title'	=> __('New Product Section','shoes-store'),
		'panel' => 'shoes_store_panel_id',
	));

	$wp_customize->add_setting( 'shoes_store_hide_show_products_section',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
	));
	$wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_hide_show_products_section',array(
		'label' => esc_html__( 'Show / Hide Section','shoes-store' ),
		'section' => 'shoes_store_products_section'
	)));

	$wp_customize->add_setting('shoes_store_product_section_heading',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_product_section_heading',array(
		'label'	=> __('Add Product Title','shoes-store'),
		'section'	=> 'shoes_store_products_section',
		'type'		=> 'text',
		'input_attrs' => array(
      'placeholder' => __( 'New Product', 'shoes-store' ),
      ),
	));

	$shoes_store_args = array(
	    'type'      => 'product',
	    'taxonomy'  => 'product_cat'
	);
	$shoes_store_categories = get_categories($shoes_store_args);

	$shoes_store_cat_posts = array();
	$shoes_store_cat_posts[''] = 'Select'; // Default option with no selection

	foreach ($shoes_store_categories as $shoes_store_category) {
	    $shoes_store_cat_posts[$shoes_store_category->slug] = $shoes_store_category->name;
	}

	$wp_customize->add_setting('shoes_store_best_product_category', array(
	    'default'           => '',
	    'sanitize_callback' => 'shoes_store_sanitize_choices',
	));

	$wp_customize->add_control('shoes_store_best_product_category', array(
	    'type'    => 'select',
	    'choices' => $shoes_store_cat_posts,
	    'label'   => __('Select Product Category', 'shoes-store'),
	    'section' => 'shoes_store_products_section',
	));

	//Footer Text
	$wp_customize->add_section('shoes_store_footer',array(
		'title'	=> esc_html__('Footer Settings','shoes-store'),
		'panel' => 'shoes_store_panel_id',
	));

	$wp_customize->add_setting( 'shoes_store_footer_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'shoes_store_switch_sanitization'
    ));
    $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_footer_hide_show',array(
      'label' => esc_html__( 'Show / Hide Footer','shoes-store' ),
      'section' => 'shoes_store_footer'
    )));

 	// font size
	$wp_customize->add_setting('shoes_store_button_footer_font_size',array(
		'default'=> 25,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_button_footer_font_size',array(
		'label'	=> __('Footer Heading Font Size','shoes-store'),
  		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'shoes_store_footer',
	));

	$wp_customize->add_setting('shoes_store_button_footer_heading_letter_spacing',array(
		'default'=> 1,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_button_footer_heading_letter_spacing',array(
		'label'	=> __('Heading Letter Spacing','shoes-store'),
  		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
	),
		'section'=> 'shoes_store_footer',
	));

	// text trasform
	$wp_customize->add_setting('shoes_store_button_footer_text_transform',array(
		'default'=> 'Capitalize',
		'sanitize_callback'	=> 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_button_footer_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Heading Text Transform','shoes-store'),
		'choices' => array(
			'Uppercase' => __('Uppercase','shoes-store'),
			'Capitalize' => __('Capitalize','shoes-store'),
			'Lowercase' => __('Lowercase','shoes-store'),
		),
		'section'=> 'shoes_store_footer',
	));

	$wp_customize->add_setting('shoes_store_footer_heading_weight',array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_footer_heading_weight',array(
        'type' => 'select',
        'label' => __('Heading Font Weight','shoes-store'),
        'section' => 'shoes_store_footer',
        'choices' => array(
        	'100' => __('100','shoes-store'),
            '200' => __('200','shoes-store'),
            '300' => __('300','shoes-store'),
            '400' => __('400','shoes-store'),
            '500' => __('500','shoes-store'),
            '600' => __('600','shoes-store'),
            '700' => __('700','shoes-store'),
            '800' => __('800','shoes-store'),
            '900' => __('900','shoes-store'),
        ),
	) );

	$wp_customize->add_setting('shoes_store_footer_template',array(
		'default'	=> esc_html('shoes_store-footer-one'),
		'sanitize_callback'	=> 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_footer_template',array(
		'label'	=> esc_html__('Footer style','shoes-store'),
		'section'	=> 'shoes_store_footer',
		'setting'	=> 'shoes_store_footer_template',
		'type' => 'select',
		'choices' => array(
			'shoes_store-footer-one' => esc_html__('Style 1', 'shoes-store'),
			'shoes_store-footer-two' => esc_html__('Style 2', 'shoes-store'),
			'shoes_store-footer-three' => esc_html__('Style 3', 'shoes-store'),
			'shoes_store-footer-four' => esc_html__('Style 4', 'shoes-store'),
			'shoes_store-footer-five' => esc_html__('Style 5', 'shoes-store'),
		)
	));

	$wp_customize->add_setting('shoes_store_footer_background_color', array(
		'default'           => '#B5E448',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'shoes_store_footer_background_color', array(
		'label'    => __('Footer Background Color', 'shoes-store'),
		'section'  => 'shoes_store_footer',
	)));

	$wp_customize->add_setting('shoes_store_footer_background_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'shoes_store_footer_background_image',array(
    'label' => __('Footer Background Image','shoes-store'),
    'section' => 'shoes_store_footer'
	)));

	$wp_customize->add_setting('shoes_store_footer_img_position',array(
	  'default' => 'center center',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_footer_img_position',array(
		'type' => 'select',
		'label' => __('Footer Image Position','shoes-store'),
		'section' => 'shoes_store_footer',
		'choices' 	=> array(
			'left top' 		=> esc_html__( 'Top Left', 'shoes-store' ),
			'center top'   => esc_html__( 'Top', 'shoes-store' ),
			'right top'   => esc_html__( 'Top Right', 'shoes-store' ),
			'left center'   => esc_html__( 'Left', 'shoes-store' ),
			'center center'   => esc_html__( 'Center', 'shoes-store' ),
			'right center'   => esc_html__( 'Right', 'shoes-store' ),
			'left bottom'   => esc_html__( 'Bottom Left', 'shoes-store' ),
			'center bottom'   => esc_html__( 'Bottom', 'shoes-store' ),
			'right bottom'   => esc_html__( 'Bottom Right', 'shoes-store' ),
		),
	));

  // Footer
  $wp_customize->add_setting('shoes_store_img_footer',array(
    'default'=> 'scroll',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
  ));
  $wp_customize->add_control('shoes_store_img_footer',array(
    'type' => 'select',
    'label' => __('Footer Background Attatchment','shoes-store'),
    'choices' => array(
      'fixed' => __('fixed','shoes-store'),
      'scroll' => __('scroll','shoes-store'),
    ),
    'section'=> 'shoes_store_footer',
  ));

  // footer padding
  $wp_customize->add_setting('shoes_store_footer_padding',array(
    'default'=> '',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('shoes_store_footer_padding',array(
    'label' => __('Footer Top Bottom Padding','shoes-store'),
    'description' => __('Enter a value in pixels. Example:20px','shoes-store'),
    'input_attrs' => array(
      'placeholder' => __( '10px', 'shoes-store' ),
    ),
    'section'=> 'shoes_store_footer',
    'type'=> 'text'
  ));

  $wp_customize->add_setting('shoes_store_footer_widgets_heading',array(
    'default' => 'Left',
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
  ));
  $wp_customize->add_control('shoes_store_footer_widgets_heading',array(
    'type' => 'select',
    'label' => __('Footer Widget Heading','shoes-store'),
    'section' => 'shoes_store_footer',
    'choices' => array(
      'Left' => __('Left','shoes-store'),
      'Center' => __('Center','shoes-store'),
      'Right' => __('Right','shoes-store')
    ),
  ) );

  $wp_customize->add_setting('shoes_store_footer_widgets_content',array(
    'default' => 'Left',
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
  ));
  $wp_customize->add_control('shoes_store_footer_widgets_content',array(
    'type' => 'select',
    'label' => __('Footer Widget Content','shoes-store'),
    'section' => 'shoes_store_footer',
    'choices' => array(
      'Left' => __('Left','shoes-store'),
      'Center' => __('Center','shoes-store'),
      'Right' => __('Right','shoes-store')
  	),
	) );
	
	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('shoes_store_footer_text', array(
		'selector' => '.copyright p',
		'render_callback' => 'shoes_store_Customize_partial_shoes_store_footer_text',
	));

	$wp_customize->add_setting('shoes_store_footer_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_footer_text',array(
		'label'	=> esc_html__('Copyright Text','shoes-store'),
		'input_attrs' => array(
      'placeholder' => esc_html__( 'Copyright 2024, .....', 'shoes-store' ),
      ),
		'section'=> 'shoes_store_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'shoes_store_copyright_hide_show',array(
	  'default' => 1,
	  'transport' => 'refresh',
	  'sanitize_callback' => 'shoes_store_switch_sanitization'
	));
	$wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_copyright_hide_show',array(
		'label' => esc_html__( 'Show / Hide Copyright','shoes-store' ),
		'section' => 'shoes_store_footer'
	)));

	$wp_customize->add_setting('shoes_store_copyright_alingment',array(
	    'default' => 'center',
	    'sanitize_callback' => 'shoes_store_sanitize_choices'
		));
		$wp_customize->add_control(new Shoes_Store_Image_Radio_Control($wp_customize, 'shoes_store_copyright_alingment', array(
	    'type' => 'select',
	    'label' => esc_html__('Copyright Alignment','shoes-store'),
	    'section' => 'shoes_store_footer',
	    'settings' => 'shoes_store_copyright_alingment',
	    'choices' => array(
	        'left' => esc_url(get_template_directory_uri()).'/assets/images/copyright1.png',
	        'center' => esc_url(get_template_directory_uri()).'/assets/images/copyright2.png',
	        'right' => esc_url(get_template_directory_uri()).'/assets/images/copyright3.png'
	))));

	$wp_customize->add_setting('shoes_store_copyright_background_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'shoes_store_copyright_background_color', array(
		'label'    => __('Copyright Background Color', 'shoes-store'),
		'section'  => 'shoes_store_footer',
	)));

	$wp_customize->add_setting('shoes_store_copyright_font_size',array(
		'default'=> '',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_copyright_font_size',array(
		'label' => __('Copyright Font Size','shoes-store'),
		'description' => __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
      	'placeholder' => __( '10px', 'shoes-store' ),
	    ),
		'section'=> 'shoes_store_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'shoes_store_hide_show_scroll',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
	));
	$wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_hide_show_scroll',array(
		'label' => esc_html__( 'Show / Hide Scroll to Top','shoes-store' ),
		'section' => 'shoes_store_footer'
	)));

  //Selective Refresh
	$wp_customize->selective_refresh->add_partial('shoes_store_scroll_to_top_icon', array(
		'selector' => '.scrollup i',
		'render_callback' => 'shoes_store_Customize_partial_shoes_store_scroll_to_top_icon',
	));

  $wp_customize->add_setting('shoes_store_scroll_top_alignment',array(
    'default' => 'Right',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control(new Shoes_Store_Image_Radio_Control($wp_customize, 'shoes_store_scroll_top_alignment', array(
    'type' => 'select',
    'label' => esc_html__('Scroll To Top','shoes-store'),
    'section' => 'shoes_store_footer',
    'settings' => 'shoes_store_scroll_top_alignment',
    'choices' => array(
        'Left' => esc_url(get_template_directory_uri()).'/assets/images/layout1.png',
        'Center' => esc_url(get_template_directory_uri()).'/assets/images/layout2.png',
        'Right' => esc_url(get_template_directory_uri()).'/assets/images/layout3.png'
  ))));

 	$wp_customize->add_setting('shoes_store_scroll_top_icon',array(
    'default' => 'fas fa-long-arrow-alt-up',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser($wp_customize,'shoes_store_scroll_top_icon',array(
    'label' => __('Add Scroll to Top Icon','shoes-store'),
    'transport' => 'refresh',
    'section' => 'shoes_store_footer',
    'setting' => 'shoes_store_scroll_top_icon',
    'type'    => 'icon'
  )));

  $wp_customize->add_setting('shoes_store_scroll_to_top_font_size',array(
    'default'=> '',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('shoes_store_scroll_to_top_font_size',array(
    'label' => __('Icon Font Size','shoes-store'),
    'description' => __('Enter a value in pixels. Example:20px','shoes-store'),
    'input_attrs' => array(
      'placeholder' => __( '10px', 'shoes-store' ),
    ),
    'section'=> 'shoes_store_footer',
    'type'=> 'text'
  ));

  $wp_customize->add_setting('shoes_store_scroll_to_top_padding',array(
    'default'=> '',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('shoes_store_scroll_to_top_padding',array(
    'label' => __('Icon Top Bottom Padding','shoes-store'),
    'description' => __('Enter a value in pixels. Example:20px','shoes-store'),
    'input_attrs' => array(
      'placeholder' => __( '10px', 'shoes-store' ),
    ),
    'section'=> 'shoes_store_footer',
    'type'=> 'text'
  ));

  $wp_customize->add_setting('shoes_store_scroll_to_top_width',array(
    'default'=> '',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('shoes_store_scroll_to_top_width',array(
    'label' => __('Icon Width','shoes-store'),
    'description' => __('Enter a value in pixels Example:20px','shoes-store'),
    'input_attrs' => array(
      'placeholder' => __( '10px', 'shoes-store' ),
  ),
	  'section'=> 'shoes_store_footer',
	  'type'=> 'text'
  ));

  $wp_customize->add_setting('shoes_store_scroll_to_top_height',array(
    'default'=> '',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('shoes_store_scroll_to_top_height',array(
    'label' => __('Icon Height','shoes-store'),
    'description' => __('Enter a value in pixels. Example:20px','shoes-store'),
    'input_attrs' => array(
      'placeholder' => __( '10px', 'shoes-store' ),
    ),
    'section'=> 'shoes_store_footer',
    'type'=> 'text'
  ));

  $wp_customize->add_setting( 'shoes_store_scroll_to_top_border_radius', array(
    'default'              => '',
    'transport'        => 'refresh',
    'sanitize_callback'    => 'shoes_store_sanitize_number_range'
  ) );
  $wp_customize->add_control( 'shoes_store_scroll_to_top_border_radius', array(
    'label'       => esc_html__( 'Icon Border Radius','shoes-store' ),
    'section'     => 'shoes_store_footer',
    'type'        => 'range',
    'input_attrs' => array(
      'step'             => 1,
      'min'              => 1,
      'max'              => 50,
    ),
  ) );

 	//Blog Post
	$wp_customize->add_panel( 'shoes_store_blog_post_parent_panel', array(
		'title' => esc_html__( 'Blog Post Settings', 'shoes-store' ),
		'panel' => 'shoes_store_panel_id',
		'priority' => 20,
	));

	// Add example section and controls to the middle (second) panel
	$wp_customize->add_section( 'shoes_store_post_settings', array(
		'title' => esc_html__( 'Post Settings', 'shoes-store' ),
		'panel' => 'shoes_store_blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('shoes_store_toggle_postdate', array(
		'selector' => '.post-main-box h2 a',
		'render_callback' => 'shoes_store_Customize_partial_shoes_store_toggle_postdate',
	));

	//Blog layout
  $wp_customize->add_setting('shoes_store_blog_layout_option',array(
    'default' => 'Left',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
  ));
  $wp_customize->add_control(new Shoes_Store_Image_Radio_Control($wp_customize, 'shoes_store_blog_layout_option', array(
    'type' => 'select',
    'label' => __('Blog Post Layouts','shoes-store'),
    'section' => 'shoes_store_post_settings',
    'choices' => array(
      'Default' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout1.png',
      'Center' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout2.png',
      'Left' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout3.png',
  ))));

	$wp_customize->add_setting('shoes_store_theme_options',array(
    'default' => 'Right Sidebar',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_theme_options',array(
    'type' => 'select',
    'label' => esc_html__('Post Sidebar Layout','shoes-store'),
    'description' => esc_html__('Here you can change the sidebar layout for posts. ','shoes-store'),
    'section' => 'shoes_store_post_settings',
    'choices' => array(
        'Left Sidebar' => esc_html__('Left Sidebar','shoes-store'),
        'Right Sidebar' => esc_html__('Right Sidebar','shoes-store'),
        'One Column' => esc_html__('One Column','shoes-store'),
        'Grid Layout' => esc_html__('Grid Layout','shoes-store')
    ),
	) );

 	$wp_customize->add_setting('shoes_store_theme_options',array(
    'default' => 'Right Sidebar',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_theme_options',array(
    'type' => 'select',
    'label' => esc_html__('Post Sidebar Layout','shoes-store'),
    'description' => esc_html__('Here you can change the sidebar layout for posts. ','shoes-store'),
    'section' => 'shoes_store_post_settings',
    'choices' => array(
        'Left Sidebar' => esc_html__('Left Sidebar','shoes-store'),
        'Right Sidebar' => esc_html__('Right Sidebar','shoes-store'),
        'One Column' => esc_html__('One Column','shoes-store'),
        'Grid Layout' => esc_html__('Grid Layout','shoes-store')
        ),
	) );

	$wp_customize->add_setting('shoes_store_theme_options',array(
    'default' => 'Right Sidebar',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_theme_options',array(
    'type' => 'select',
    'label' => esc_html__('Post Sidebar Layout','shoes-store'),
    'description' => esc_html__('Here you can change the sidebar layout for posts. ','shoes-store'),
    'section' => 'shoes_store_post_settings',
    'choices' => array(
        'Left Sidebar' => esc_html__('Left Sidebar','shoes-store'),
        'Right Sidebar' => esc_html__('Right Sidebar','shoes-store'),
        'One Column' => esc_html__('One Column','shoes-store'),
        'Grid Layout' => esc_html__('Grid Layout','shoes-store')
        ),
	) );

	$wp_customize->add_setting('shoes_store_toggle_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
  $wp_customize,'shoes_store_toggle_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_post_settings',
		'setting'	=> 'shoes_store_toggle_postdate_icon',
		'type'		=> 'icon'
	)));

 	$wp_customize->add_setting( 'shoes_store_blog_toggle_postdate',array(
    'default' => 1,
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_switch_sanitization'
  ));
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_blog_toggle_postdate',array(
    'label' => esc_html__( 'Show / Hide Post Date','shoes-store' ),
    'section' => 'shoes_store_post_settings'
  )));

	$wp_customize->add_setting('shoes_store_toggle_author_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
  $wp_customize,'shoes_store_toggle_author_icon',array(
		'label'	=> __('Add Author Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_post_settings',
		'setting'	=> 'shoes_store_toggle_author_icon',
		'type'		=> 'icon'
	)));

  $wp_customize->add_setting( 'shoes_store_blog_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
  ));
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_blog_toggle_author',array(
		'label' => esc_html__( 'Show / Hide Author','shoes-store' ),
		'section' => 'shoes_store_post_settings'
  )));

  $wp_customize->add_setting('shoes_store_toggle_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
  $wp_customize,'shoes_store_toggle_comments_icon',array(
		'label'	=> __('Add Comments Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_post_settings',
		'setting'	=> 'shoes_store_toggle_comments_icon',
		'type'		=> 'icon'
	)));

  $wp_customize->add_setting( 'shoes_store_blog_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
  ) );
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_blog_toggle_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','shoes-store' ),
		'section' => 'shoes_store_post_settings'
  )));

  $wp_customize->add_setting('shoes_store_toggle_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
  $wp_customize,'shoes_store_toggle_time_icon',array(
		'label'	=> __('Add Time Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_post_settings',
		'setting'	=> 'shoes_store_toggle_time_icon',
		'type'		=> 'icon'
	)));

  $wp_customize->add_setting( 'shoes_store_blog_toggle_time',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
  ) );
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_blog_toggle_time',array(
		'label' => esc_html__( 'Show / Hide Time','shoes-store' ),
		'section' => 'shoes_store_post_settings'
  )));

  $wp_customize->add_setting( 'shoes_store_featured_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
	));
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_featured_image_hide_show', array(
		'label' => esc_html__( 'Show / Hide Featured Image','shoes-store' ),
		'section' => 'shoes_store_post_settings'
  )));

  $wp_customize->add_setting( 'shoes_store_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'shoes_store_sanitize_number_range'
	) );
	$wp_customize->add_control( 'shoes_store_featured_image_border_radius', array(
		'label'       => esc_html__( 'Featured Image Border Radius','shoes-store' ),
		'section'     => 'shoes_store_post_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'shoes_store_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'shoes_store_sanitize_number_range'
	) );
	$wp_customize->add_control( 'shoes_store_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Featured Image Box Shadow','shoes-store' ),
		'section'     => 'shoes_store_post_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Featured Image
	$wp_customize->add_setting('shoes_store_blog_post_featured_image_dimension',array(
   'default' => 'default',
   'sanitize_callback'	=> 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_blog_post_featured_image_dimension',array(
		'type' => 'select',
		'label'	=> __('Blog Post Featured Image Dimension','shoes-store'),
		'section'	=> 'shoes_store_post_settings',
		'choices' => array(
		'default' => __('Default','shoes-store'),
		'custom' => __('Custom Image Size','shoes-store'),
      ),
	));

	$wp_customize->add_setting('shoes_store_blog_post_featured_image_custom_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
		));
	$wp_customize->add_control('shoes_store_blog_post_featured_image_custom_width',array(
		'label'	=> __('Featured Image Custom Width','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
    	'placeholder' => __( '10px', 'shoes-store' ),),
		'section'=> 'shoes_store_post_settings',
		'type'=> 'text',
		'active_callback' => 'shoes_store_blog_post_featured_image_dimension'
		));

	$wp_customize->add_setting('shoes_store_blog_post_featured_image_custom_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_blog_post_featured_image_custom_height',array(
		'label'	=> __('Featured Image Custom Height','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
    	'placeholder' => __( '10px', 'shoes-store' ),),
		'section'=> 'shoes_store_post_settings',
		'type'=> 'text',
		'active_callback' => 'shoes_store_blog_post_featured_image_dimension'
	));

  $wp_customize->add_setting( 'shoes_store_excerpt_number', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'shoes_store_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'shoes_store_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','shoes-store' ),
		'section'     => 'shoes_store_post_settings',
		'type'        => 'range',
		'settings'    => 'shoes_store_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('shoes_store_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','shoes-store'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','shoes-store'),
		'section'=> 'shoes_store_post_settings',
		'type'=> 'text'
	));

  $wp_customize->add_setting('shoes_store_excerpt_settings',array(
    'default' => 'Excerpt',
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_excerpt_settings',array(
    'type' => 'select',
    'label' => esc_html__('Post Content','shoes-store'),
    'section' => 'shoes_store_post_settings',
    'choices' => array(
    	'Content' => esc_html__('Content','shoes-store'),
        'Excerpt' => esc_html__('Excerpt','shoes-store'),
        'No Content' => esc_html__('No Content','shoes-store')
        ),
	) );

  $wp_customize->add_setting('shoes_store_blog_page_posts_settings',array(
    'default' => 'Into Blocks',
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_blog_page_posts_settings',array(
    'type' => 'select',
    'label' => __('Display Blog Posts','shoes-store'),
    'section' => 'shoes_store_post_settings',
    'choices' => array(
    	'Into Blocks' => __('Into Blocks','shoes-store'),
        'Without Blocks' => __('Without Blocks','shoes-store')
        ),
	) );

	$wp_customize->add_setting( 'shoes_store_blog_pagination_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
  ));
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_blog_pagination_hide_show',array(
		'label' => esc_html__( 'Show / Hide Blog Pagination','shoes-store' ),
		'section' => 'shoes_store_post_settings'
  )));

	$wp_customize->add_setting('shoes_store_blog_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_blog_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','shoes-store'),
		'input_attrs' => array(
      'placeholder' => __( '[...]', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_post_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'shoes_store_blog_pagination_type', array(
    'default'			=> 'blog-page-numbers',
    'sanitize_callback'	=> 'shoes_store_sanitize_choices'
  ));
  $wp_customize->add_control( 'shoes_store_blog_pagination_type', array(
    'section' => 'shoes_store_post_settings',
    'type' => 'select',
    'label' => __( 'Blog Pagination', 'shoes-store' ),
    'choices'		=> array(
      'blog-page-numbers'  => __( 'Numeric', 'shoes-store' ),
      'next-prev' => __( 'Older Posts/Newer Posts', 'shoes-store' ),
  )));

  // Button Settings
	$wp_customize->add_section( 'shoes_store_button_settings', array(
		'title' => esc_html__( 'Button Settings', 'shoes-store' ),
		'panel' => 'shoes_store_blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('shoes_store_button_text', array(
		'selector' => '.post-main-box .more-btn a',
		'render_callback' => 'shoes_store_Customize_partial_shoes_store_button_text',
	));

  $wp_customize->add_setting('shoes_store_button_text',array(
		'default'=> esc_html__('Read More','shoes-store'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_button_text',array(
		'label'	=> esc_html__('Add Button Text','shoes-store'),
		'input_attrs' => array(
    'placeholder' => esc_html__( 'Read More', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_button_settings',
		'type'=> 'text'
	));

	// font size button
	$wp_customize->add_setting('shoes_store_button_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_button_font_size',array(
		'label'	=> __('Button Font Size','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
  		'placeholder' => __( '10px', 'shoes-store' ),
    ),
  	'type'        => 'text',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'shoes_store_button_settings',
	));


	$wp_customize->add_setting( 'shoes_store_button_border_radius', array(
		'default'              => 5,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'shoes_store_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'shoes_store_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','shoes-store' ),
		'section'     => 'shoes_store_button_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	// button padding
	$wp_customize->add_setting('shoes_store_button_top_bottom_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_button_top_bottom_padding',array(
		'label'	=> __('Button Top Bottom Padding','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
      'placeholder' => __( '10px', 'shoes-store' ),
    ),
		'section'=> 'shoes_store_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_button_left_right_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_button_left_right_padding',array(
		'label'	=> __('Button Left Right Padding','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
      'placeholder' => __( '10px', 'shoes-store' ),
    ),
		'section'=> 'shoes_store_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_button_letter_spacing',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_button_letter_spacing',array(
		'label'	=> __('Button Letter Spacing','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
      	'placeholder' => __( '10px', 'shoes-store' ),
  ),
  	'type'        => 'text',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
	),
		'section'=> 'shoes_store_button_settings',
	));

	// text trasform
	$wp_customize->add_setting('shoes_store_button_text_transform',array(
		'default'=> 'Capitalize',
		'sanitize_callback'	=> 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_button_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Button Text Transform','shoes-store'),
		'choices' => array(
      'Uppercase' => __('Uppercase','shoes-store'),
      'Capitalize' => __('Capitalize','shoes-store'),
      'Lowercase' => __('Lowercase','shoes-store'),
    ),
		'section'=> 'shoes_store_button_settings',
	));

	// Related Post Settings
	$wp_customize->add_section( 'shoes_store_related_posts_settings', array(
		'title' => esc_html__( 'Related Posts Settings', 'shoes-store' ),
		'panel' => 'shoes_store_blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('shoes_store_related_post_title', array(
		'selector' => '.related-post h3',
		'render_callback' => 'shoes_store_Customize_partial_shoes_store_related_post_title',
	));

  $wp_customize->add_setting( 'shoes_store_related_post',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
  ) );
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_related_post',array(
		'label' => esc_html__( 'Related Post','shoes-store' ),
		'section' => 'shoes_store_related_posts_settings'
  )));

  $wp_customize->add_setting('shoes_store_related_post_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_related_post_title',array(
		'label'	=> esc_html__('Add Related Post Title','shoes-store'),
		'input_attrs' => array(
      'placeholder' => esc_html__( 'Related Post', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_related_posts_settings',
		'type'=> 'text'
	));

 	$wp_customize->add_setting('shoes_store_related_posts_count',array(
		'default'=> 3,
		'sanitize_callback'	=> 'shoes_store_sanitize_number_absint'
	));
	$wp_customize->add_control('shoes_store_related_posts_count',array(
		'label'	=> esc_html__('Add Related Post Count','shoes-store'),
		'input_attrs' => array(
      'placeholder' => esc_html__( '3', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_related_posts_settings',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'shoes_store_related_posts_excerpt_number', array(
		'default'              => 20,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'shoes_store_sanitize_number_range'
	) );
	$wp_customize->add_control( 'shoes_store_related_posts_excerpt_number', array(
		'label'       => esc_html__( 'Related Posts Excerpt length','shoes-store' ),
		'section'     => 'shoes_store_related_posts_settings',
		'type'        => 'range',
		'settings'    => 'shoes_store_related_posts_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	// Single Posts Settings
	$wp_customize->add_section( 'shoes_store_single_blog_settings', array(
		'title' => __( 'Single Post Settings', 'shoes-store' ),
		'panel' => 'shoes_store_blog_post_parent_panel',
	));

	$wp_customize->add_setting('shoes_store_single_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
  $wp_customize,'shoes_store_single_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_single_blog_settings',
		'setting'	=> 'shoes_store_single_postdate_icon',
		'type'		=> 'icon'
	)));

  $wp_customize->add_setting( 'shoes_store_single_postdate',array(
    'default' => 1,
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_switch_sanitization'
	) );
	$wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_single_postdate',array(
		'label' => esc_html__( 'Show / Hide Date','shoes-store' ),
		'section' => 'shoes_store_single_blog_settings'
	)));

	$wp_customize->add_setting('shoes_store_single_author_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
  $wp_customize,'shoes_store_single_author_icon',array(
		'label'	=> __('Add Author Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_single_blog_settings',
		'setting'	=> 'shoes_store_single_author_icon',
		'type'		=> 'icon'
	)));

  $wp_customize->add_setting( 'shoes_store_single_author',array(
    'default' => 1,
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_switch_sanitization'
	) );
	$wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_single_author',array(
    'label' => esc_html__( 'Show / Hide Author','shoes-store' ),
    'section' => 'shoes_store_single_blog_settings'
	)));

 	$wp_customize->add_setting('shoes_store_single_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
  $wp_customize,'shoes_store_single_comments_icon',array(
		'label'	=> __('Add Comments Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_single_blog_settings',
		'setting'	=> 'shoes_store_single_comments_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'shoes_store_single_comments',array(
    'default' => 1,
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_switch_sanitization'
	) );
	$wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_single_comments',array(
    'label' => esc_html__( 'Show / Hide Comments','shoes-store' ),
    'section' => 'shoes_store_single_blog_settings'
	)));

	$wp_customize->add_setting('shoes_store_single_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
  $wp_customize,'shoes_store_single_time_icon',array(
		'label'	=> __('Add Time Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_single_blog_settings',
		'setting'	=> 'shoes_store_single_time_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'shoes_store_single_time',array(
    'default' => 1,
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_switch_sanitization'
	) );
	$wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_single_time',array(
    'label' => esc_html__( 'Show / Hide Time','shoes-store' ),
    'section' => 'shoes_store_single_blog_settings'
	)));

	$wp_customize->add_setting( 'shoes_store_toggle_tags',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
	));
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_toggle_tags', array(
		'label' => esc_html__( 'Show / Hide Tags','shoes-store' ),
		'section' => 'shoes_store_single_blog_settings'
  )));

	$wp_customize->add_setting( 'shoes_store_single_post_breadcrumb',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
  ) );
 	$wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_single_post_breadcrumb',array(
		'label' => esc_html__( 'Show / Hide Breadcrumb','shoes-store' ),
		'section' => 'shoes_store_single_blog_settings'
  )));

	// Single Posts Category
 	 $wp_customize->add_setting( 'shoes_store_single_post_category',array(
		'default' => true,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
  ) );
	$wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_single_post_category',array(
		'label' => esc_html__( 'Show / Hide Category','shoes-store' ),
		'section' => 'shoes_store_single_blog_settings'
  )));

	$wp_customize->add_setting('shoes_store_single_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_single_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','shoes-store'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','shoes-store'),
		'section'=> 'shoes_store_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'shoes_store_single_blog_post_navigation_show_hide',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
	));
	$wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_single_blog_post_navigation_show_hide', array(
	  'label' => esc_html__( 'Show / Hide Post Navigation','shoes-store' ),
	  'section' => 'shoes_store_single_blog_settings'
	)));

	$wp_customize->add_setting( 'shoes_store_single_post_breadcrumb',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
    ) );
 	$wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_single_post_breadcrumb',array(
		'label' => esc_html__( 'Show / Hide Breadcrumb','shoes-store' ),
		'section' => 'shoes_store_single_blog_settings'
  )));

	//navigation text
	$wp_customize->add_setting('shoes_store_single_blog_prev_navigation_text',array(
		'default'=> 'PREVIOUS',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_single_blog_prev_navigation_text',array(
		'label'	=> __('Post Navigation Text','shoes-store'),
		'input_attrs' => array(
      'placeholder' => __( 'PREVIOUS', 'shoes-store' ),
      ),
		'section'=> 'shoes_store_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_single_blog_next_navigation_text',array(
		'default'=> 'NEXT',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_single_blog_next_navigation_text',array(
		'label'	=> __('Post Navigation Text','shoes-store'),
		'input_attrs' => array(
      'placeholder' => __( 'NEXT', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_single_blog_comment_title',array(
		'default'=> 'Leave a Reply',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('shoes_store_single_blog_comment_title',array(
		'label'	=> __('Add Comment Title','shoes-store'),
		'input_attrs' => array(
      'placeholder' => __( 'Leave a Reply', 'shoes-store' ),
    	),
		'section'=> 'shoes_store_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_single_blog_comment_button_text',array(
		'default'=> 'Post Comment',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('shoes_store_single_blog_comment_button_text',array(
		'label'	=> __('Add Comment Button Text','shoes-store'),
		'input_attrs' => array(
    'placeholder' => __( 'Post Comment', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_single_blog_comment_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_single_blog_comment_width',array(
		'label'	=> __('Comment Form Width','shoes-store'),
		'description'	=> __('Enter a value in %. Example:50%','shoes-store'),
		'input_attrs' => array(
      'placeholder' => __( '100%', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_single_blog_settings',
		'type'=> 'text'
	));

	 // Grid layout setting
	$wp_customize->add_section( 'shoes_store_grid_layout_settings', array(
		'title' => __( 'Grid Layout Settings', 'shoes-store' ),
		'panel' => 'shoes_store_blog_post_parent_panel',
	));

	$wp_customize->add_setting('shoes_store_grid_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
        $wp_customize,'shoes_store_grid_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_grid_layout_settings',
		'setting'	=> 'shoes_store_grid_postdate_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'shoes_store_grid_postdate',array(
	  'default' => 1,
	  'transport' => 'refresh',
	  'sanitize_callback' => 'shoes_store_switch_sanitization'
  ) );
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_grid_postdate',array(
    'label' => esc_html__( 'Show / Hide Post Date','shoes-store' ),
    'section' => 'shoes_store_grid_layout_settings'
  )));

	$wp_customize->add_setting('shoes_store_grid_author_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
        $wp_customize,'shoes_store_grid_author_icon',array(
		'label'	=> __('Add Author Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_grid_layout_settings',
		'setting'	=> 'shoes_store_grid_author_icon',
		'type'		=> 'icon'
	)));

  $wp_customize->add_setting( 'shoes_store_grid_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
  ) );
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_grid_author',array(
		'label' => esc_html__( 'Show / Hide Author','shoes-store' ),
		'section' => 'shoes_store_grid_layout_settings'
  )));

  $wp_customize->add_setting('shoes_store_grid_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
        $wp_customize,'shoes_store_grid_comments_icon',array(
		'label'	=> __('Add Comments Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_grid_layout_settings',
		'setting'	=> 'shoes_store_grid_comments_icon',
		'type'		=> 'icon'
	)));

  $wp_customize->add_setting( 'shoes_store_grid_time',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
  ) );
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_grid_time',array(
		'label' => esc_html__( 'Show / Hide Time','shoes-store' ),
		'section' => 'shoes_store_grid_layout_settings'
  )));

  $wp_customize->add_setting('shoes_store_grid_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
        $wp_customize,'shoes_store_grid_time_icon',array(
		'label'	=> __('Add Time Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_grid_layout_settings',
		'setting'	=> 'shoes_store_grid_time_icon',
		'type'		=> 'icon'
	)));

  $wp_customize->add_setting( 'shoes_store_grid_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
  ) );
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_grid_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','shoes-store' ),
		'section' => 'shoes_store_grid_layout_settings'
  )));

 	$wp_customize->add_setting('shoes_store_grid_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_grid_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','shoes-store'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','shoes-store'),
		'section'=> 'shoes_store_grid_layout_settings',
		'type'=> 'text'
	));

  $wp_customize->add_setting('shoes_store_display_grid_posts_settings',array(
    'default' => 'Into Blocks',
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_display_grid_posts_settings',array(
    'type' => 'select',
    'label' => __('Display Grid Posts','shoes-store'),
    'section' => 'shoes_store_grid_layout_settings',
    'choices' => array(
    	'Into Blocks' => __('Into Blocks','shoes-store'),
      'Without Blocks' => __('Without Blocks','shoes-store')
      ),
	) );

	$wp_customize->add_setting('shoes_store_grid_button_text',array(
		'default'=> esc_html__('Read More','shoes-store'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_grid_button_text',array(
		'label'	=> esc_html__('Add Button Text','shoes-store'),
		'input_attrs' => array(
      'placeholder' => esc_html__( 'Read More', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_grid_layout_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_grid_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_grid_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','shoes-store'),
		'input_attrs' => array(
        'placeholder' => __( '[...]', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_grid_layout_settings',
		'type'=> 'text'
	));

  $wp_customize->add_setting('shoes_store_grid_excerpt_settings',array(
    'default' => 'Excerpt',
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_grid_excerpt_settings',array(
    'type' => 'select',
    'label' => esc_html__('Grid Post Content','shoes-store'),
    'section' => 'shoes_store_grid_layout_settings',
    'choices' => array(
    	'Content' => esc_html__('Content','shoes-store'),
      'Excerpt' => esc_html__('Excerpt','shoes-store'),
      'No Content' => esc_html__('No Content','shoes-store')
    ),
	) );

  $wp_customize->add_setting( 'shoes_store_grid_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'shoes_store_sanitize_number_range'
	) );
	$wp_customize->add_control( 'shoes_store_grid_featured_image_border_radius', array(
		'label'       => esc_html__( 'Grid Featured Image Border Radius','shoes-store' ),
		'section'     => 'shoes_store_grid_layout_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'shoes_store_grid_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'shoes_store_sanitize_number_range'
	) );
	$wp_customize->add_control( 'shoes_store_grid_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Grid Featured Image Box Shadow','shoes-store' ),
		'section'     => 'shoes_store_grid_layout_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Other
	$wp_customize->add_panel( 'shoes_store_other_parent_panel', array(
		'title' => esc_html__( 'Other Settings', 'shoes-store' ),
		'panel' => 'shoes_store_panel_id',
		'priority' => 20,
	));

	// Layout
	$wp_customize->add_section( 'shoes_store_left_right', array(
  	'title' => esc_html__('General Settings', 'shoes-store'),
		'panel' => 'shoes_store_other_parent_panel'
	) );

	$wp_customize->add_setting('shoes_store_width_option',array(
    'default' => 'Full Width',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control(new Shoes_Store_Image_Radio_Control($wp_customize, 'shoes_store_width_option', array(
    'type' => 'select',
    'label' => esc_html__('Width Layouts','shoes-store'),
    'description' => esc_html__('Here you can change the width layout of Website.','shoes-store'),
    'section' => 'shoes_store_left_right',
    'choices' => array(
        'Full Width' => esc_url(get_template_directory_uri()).'/assets/images/full-width.png',
        'Wide Width' => esc_url(get_template_directory_uri()).'/assets/images/wide-width.png',
        'Boxed' => esc_url(get_template_directory_uri()).'/assets/images/boxed-width.png',
  ))));

	$wp_customize->add_setting('shoes_store_page_layout',array(
    'default' => 'One_Column',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_page_layout',array(
    'type' => 'select',
    'label' => esc_html__('Page Sidebar Layout','shoes-store'),
    'description' => esc_html__('Here you can change the sidebar layout for pages. ','shoes-store'),
    'section' => 'shoes_store_left_right',
    'choices' => array(
        'Left_Sidebar' => esc_html__('Left Sidebar','shoes-store'),
        'Right_Sidebar' => esc_html__('Right Sidebar','shoes-store'),
        'One_Column' => esc_html__('One Column','shoes-store')
    ),
	) );
	
    // Pre-Loader
	$wp_customize->add_setting( 'shoes_store_loader_enable',array(
    'default' => 0,
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_switch_sanitization'
  ) );
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_loader_enable',array(
    'label' => esc_html__( 'Pre-Loader','shoes-store' ),
    'section' => 'shoes_store_left_right'
  )));

	$wp_customize->add_setting('shoes_store_preloader_bg_color', array(
		'default'           => '#B5E448',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'shoes_store_preloader_bg_color', array(
		'label'    => __('Pre-Loader Background Color', 'shoes-store'),
		'section'  => 'shoes_store_left_right',
	)));

	$wp_customize->add_setting('shoes_store_preloader_border_color', array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'shoes_store_preloader_border_color', array(
		'label'    => __('Pre-Loader Border Color', 'shoes-store'),
		'section'  => 'shoes_store_left_right',
	)));

	$wp_customize->add_setting('shoes_store_preloader_bg_img',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'shoes_store_preloader_bg_img',array(
    'label' => __('Preloader Background Image','shoes-store'),
    'section' => 'shoes_store_left_right'
	)));

    //404 Page Setting
	$wp_customize->add_section('shoes_store_404_page',array(
		'title'	=> __('404 Page Settings','shoes-store'),
		'panel' => 'shoes_store_other_parent_panel',
	));

	$wp_customize->add_setting('shoes_store_404_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('shoes_store_404_page_title',array(
		'label'	=> __('Add Title','shoes-store'),
		'input_attrs' => array(
            'placeholder' => __( '404 Not Found', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_404_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_404_page_content',array(
		'label'	=> __('Add Text','shoes-store'),
		'input_attrs' => array(
            'placeholder' => __( 'Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_404_page_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_404_page_button_text',array(
		'label'	=> __('Add Button Text','shoes-store'),
		'input_attrs' => array(
            'placeholder' => __( 'Go Back', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_404_page',
		'type'=> 'text'
	));

	//No Result Page Setting
	$wp_customize->add_section('shoes_store_no_results_page',array(
		'title'	=> __('No Results Page Settings','shoes-store'),
		'panel' => 'shoes_store_other_parent_panel',
	));

	$wp_customize->add_setting('shoes_store_no_results_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('shoes_store_no_results_page_title',array(
		'label'	=> __('Add Title','shoes-store'),
		'input_attrs' => array(
            'placeholder' => __( 'Nothing Found', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_no_results_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_no_results_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_no_results_page_content',array(
		'label'	=> __('Add Text','shoes-store'),
		'input_attrs' => array(
            'placeholder' => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_no_results_page',
		'type'=> 'text'
	));

	//Social Icon Setting
	$wp_customize->add_section('shoes_store_social_icon_settings',array(
		'title'	=> __('Sidebar Social Icons Settings','shoes-store'),
		'panel' => 'shoes_store_other_parent_panel',
	));

	$wp_customize->add_setting('shoes_store_social_icon_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_social_icon_font_size',array(
		'label'	=> __('Icon Font Size','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_social_icon_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_social_icon_padding',array(
		'label'	=> __('Icon Padding','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_social_icon_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_social_icon_width',array(
		'label'	=> __('Icon Width','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_social_icon_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_social_icon_height',array(
		'label'	=> __('Icon Height','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_social_icon_settings',
		'type'=> 'text'
	));

	//Responsive Media Settings
	$wp_customize->add_section('shoes_store_responsive_media',array(
		'title'	=> esc_html__('Responsive Media','shoes-store'),
		'panel' => 'shoes_store_other_parent_panel',
	));

  	$wp_customize->add_setting('shoes_store_res_open_menu_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
        $wp_customize,'shoes_store_res_open_menu_icon',array(
		'label'	=> __('Add Open Menu Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_responsive_media',
		'setting'	=> 'shoes_store_res_open_menu_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('shoes_store_res_close_menu_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Shoes_Store_Fontawesome_Icon_Chooser(
        $wp_customize,'shoes_store_res_close_menu_icon',array(
		'label'	=> __('Add Close Menu Icon','shoes-store'),
		'transport' => 'refresh',
		'section'	=> 'shoes_store_responsive_media',
		'setting'	=> 'shoes_store_res_close_menu_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('shoes_store_resp_menu_toggle_btn_bg_color', array(
		'default'           => '#B5E448',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'shoes_store_resp_menu_toggle_btn_bg_color', array(
		'label'    => __('Toggle Button Bg Color', 'shoes-store'),
		'section'  => 'shoes_store_responsive_media',
	)));

  //Woocommerce settings
	$wp_customize->add_section('shoes_store_woocommerce_section', array(
		'title'    => __('WooCommerce Layout', 'shoes-store'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'shoes_store_woocommerce_shop_page_sidebar', array( 'selector' => '.post-type-archive-product #sidebar',
		'render_callback' => 'shoes_store_customize_partial_shoes_store_woocommerce_shop_page_sidebar', ) );

    //Woocommerce Shop Page Sidebar
	$wp_customize->add_setting( 'shoes_store_woocommerce_shop_page_sidebar',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
  ) );
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_woocommerce_shop_page_sidebar',array(
		'label' => esc_html__( 'Show / Hide Shop Page Sidebar','shoes-store' ),
		'section' => 'shoes_store_woocommerce_section'
  )));

   $wp_customize->add_setting('shoes_store_shop_page_layout',array(
    'default' => 'Right Sidebar',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_shop_page_layout',array(
    'type' => 'select',
    'label' => __('Shop Page Sidebar Layout','shoes-store'),
    'section' => 'shoes_store_woocommerce_section',
    'choices' => array(
        'Left Sidebar' => __('Left Sidebar','shoes-store'),
        'Right Sidebar' => __('Right Sidebar','shoes-store'),
    ),
	) );

   //Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'shoes_store_woocommerce_single_product_page_sidebar', array( 'selector' => '.single-product #sidebar',
		'render_callback' => 'shoes_store_customize_partial_shoes_store_woocommerce_single_product_page_sidebar', ) );

    //Woocommerce Single Product page Sidebar
	$wp_customize->add_setting( 'shoes_store_woocommerce_single_product_page_sidebar',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'shoes_store_switch_sanitization'
   ) );
 	$wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_woocommerce_single_product_page_sidebar',array(
		'label' => esc_html__( 'Show / Hide Single Product Sidebar','shoes-store' ),
		'section' => 'shoes_store_woocommerce_section'
  )));

   $wp_customize->add_setting('shoes_store_single_product_layout',array(
    'default' => 'Right Sidebar',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_single_product_layout',array(
    'type' => 'select',
    'label' => __('Single Product Sidebar Layout','shoes-store'),
    'section' => 'shoes_store_woocommerce_section',
    'choices' => array(
        'Left Sidebar' => __('Left Sidebar','shoes-store'),
        'Right Sidebar' => __('Right Sidebar','shoes-store'),
    ),
	) );

	//Products per page
    $wp_customize->add_setting('shoes_store_products_per_page',array(
		'default'=> '9',
		'sanitize_callback'	=> 'shoes_store_sanitize_float'
	));
	$wp_customize->add_control('shoes_store_products_per_page',array(
		'label'	=> __('Products Per Page','shoes-store'),
		'description' => __('Display on shop page','shoes-store'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'shoes_store_woocommerce_section',
		'type'=> 'number',
	));

    //Products per row
    $wp_customize->add_setting('shoes_store_products_per_row',array(
		'default'=> '4',
		'sanitize_callback'	=> 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_products_per_row',array(
		'label'	=> __('Products Per Row','shoes-store'),
		'description' => __('Display on shop page','shoes-store'),
		'choices' => array(
      '2' => '2',
			'3' => '3',
			'4' => '4',
    ),
		'section'=> 'shoes_store_woocommerce_section',
		'type'=> 'select',
		));

	//Products padding
	$wp_customize->add_setting('shoes_store_products_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_products_padding_top_bottom',array(
		'label'	=> __('Products Padding Top Bottom','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
        'placeholder' => __( '10px', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_products_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_products_padding_left_right',array(
		'label'	=> __('Products Padding Left Right','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_woocommerce_section',
		'type'=> 'text'
	));

	//Products box shadow
	$wp_customize->add_setting( 'shoes_store_products_box_shadow', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'shoes_store_sanitize_number_range'
	) );
	$wp_customize->add_control( 'shoes_store_products_box_shadow', array(
		'label'       => esc_html__( 'Products Box Shadow','shoes-store' ),
		'section'     => 'shoes_store_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Products border radius
    $wp_customize->add_setting( 'shoes_store_products_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'shoes_store_sanitize_number_range'
	) );
	$wp_customize->add_control( 'shoes_store_products_border_radius', array(
		'label'       => esc_html__( 'Products Border Radius','shoes-store' ),
		'section'     => 'shoes_store_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'shoes_store_products_button_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'shoes_store_sanitize_number_range'
	) );
	$wp_customize->add_control( 'shoes_store_products_button_border_radius', array(
		'label'       => esc_html__( 'Products Button Border Radius','shoes-store' ),
		'section'     => 'shoes_store_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('shoes_store_products_btn_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_products_btn_padding_top_bottom',array(
		'label'	=> __('Products Button Padding Top Bottom','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
        'placeholder' => __( '10px', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_products_btn_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_products_btn_padding_left_right',array(
		'label'	=> __('Products Button Padding Left Right','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
        'placeholder' => __( '10px', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_woocommerce_sale_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_woocommerce_sale_font_size',array(
		'label'	=> __('Sale Font Size','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
        'placeholder' => __( '10px', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_woocommerce_section',
		'type'=> 'text'
	));

	//Products Sale Badge
	$wp_customize->add_setting('shoes_store_woocommerce_sale_position',array(
    'default' => 'right',
    'sanitize_callback' => 'shoes_store_sanitize_choices'
	));
	$wp_customize->add_control('shoes_store_woocommerce_sale_position',array(
    'type' => 'select',
    'label' => __('Sale Badge Position','shoes-store'),
    'section' => 'shoes_store_woocommerce_section',
    'choices' => array(
        'left' => __('Left','shoes-store'),
        'right' => __('Right','shoes-store'),
    ),
	) );

	$wp_customize->add_setting('shoes_store_woocommerce_sale_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_woocommerce_sale_padding_top_bottom',array(
		'label'	=> __('Sale Padding Top Bottom','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('shoes_store_woocommerce_sale_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('shoes_store_woocommerce_sale_padding_left_right',array(
		'label'	=> __('Sale Padding Left Right','shoes-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','shoes-store'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'shoes-store' ),
        ),
		'section'=> 'shoes_store_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'shoes_store_woocommerce_sale_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'shoes_store_sanitize_number_range'
	) );
	$wp_customize->add_control( 'shoes_store_woocommerce_sale_border_radius', array(
		'label'       => esc_html__( 'Sale Border Radius','shoes-store' ),
		'section'     => 'shoes_store_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	// Related Product
  $wp_customize->add_setting( 'shoes_store_related_product_show_hide',array(
    'default' => 1,
    'transport' => 'refresh',
    'sanitize_callback' => 'shoes_store_switch_sanitization'
  ) );
  $wp_customize->add_control( new Shoes_Store_Toggle_Switch_Custom_Control( $wp_customize, 'shoes_store_related_product_show_hide',array(
    'label' => esc_html__( 'Show / Hide Related product','shoes-store' ),
    'section' => 'shoes_store_woocommerce_section'
  )));

}

add_action( 'customize_register', 'shoes_store_customize_register' );

load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Shoes_Store_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	*/
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Shoes_Store_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section( new Shoes_Store_Customize_Section_Pro( $manager,'shoes_store_go_pro', array(
			'priority'   => 1,
			'title'    => esc_html__( 'SHOES STORE PRO', 'shoes-store' ),
			'pro_text' => esc_html__( 'UPGRADE PRO', 'shoes-store' ),
			'pro_url'  => esc_url('https://www.vwthemes.com/products/shoe-store-wordpress-theme'),
		) )	);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'shoes-store-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'shoes-store-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Shoes_Store_Customize::get_instance();