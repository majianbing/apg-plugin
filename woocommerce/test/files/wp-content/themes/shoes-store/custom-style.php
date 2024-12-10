<?php

	$shoes_store_custom_css= "";

	$shoes_store_slider_image_bg_color = get_theme_mod('shoes_store_slider_image_bg_color');
	if($shoes_store_slider_image_bg_color != false){
		$shoes_store_custom_css .='#slider .shoes-bg svg path{';
			$shoes_store_custom_css .='fill: '.esc_attr($shoes_store_slider_image_bg_color).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_topbar_bg_color = get_theme_mod('shoes_store_topbar_bg_color');
	if($shoes_store_topbar_bg_color != false){
		$shoes_store_custom_css .='.main-header .topbar{';
			$shoes_store_custom_css .='background-color: '.esc_attr($shoes_store_topbar_bg_color).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_product_category_bg_color = get_theme_mod('shoes_store_product_category_bg_color');
	if($shoes_store_product_category_bg_color != false){
		$shoes_store_custom_css .='.top-category, .category-front, .category-back{';
			$shoes_store_custom_css .='background-color: '.esc_attr($shoes_store_product_category_bg_color).';';
		$shoes_store_custom_css .='}';
	}

	/*---------------------------Width Layout -------------------*/

	$shoes_store_theme_lay = get_theme_mod( 'shoes_store_width_option','Full Width');
    if($shoes_store_theme_lay == 'Boxed'){
		$shoes_store_custom_css .='body{';
			$shoes_store_custom_css .='max-width: 1140px; width: 100%; margin-right: auto; margin-left: auto;';
		$shoes_store_custom_css .='}';
		$shoes_store_custom_css .='.scrollup i{';
			$shoes_store_custom_css .='right: 100px;';
		$shoes_store_custom_css .='}';
		$shoes_store_custom_css .='.row.outer-logo{';
			$shoes_store_custom_css .='margin-left: 0px;';
		$shoes_store_custom_css .='}';
	}else if($shoes_store_theme_lay == 'Wide Width'){
		$shoes_store_custom_css .='body{';
			$shoes_store_custom_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$shoes_store_custom_css .='}';
		$shoes_store_custom_css .='.scrollup i{';
			$shoes_store_custom_css .='right: 30px;';
		$shoes_store_custom_css .='}';
		$shoes_store_custom_css .='.row.outer-logo{';
			$shoes_store_custom_css .='margin-left: 0px;';
		$shoes_store_custom_css .='}';
	}else if($shoes_store_theme_lay == 'Full Width'){
		$shoes_store_custom_css .='body{';
			$shoes_store_custom_css .='max-width: 100%;';
		$shoes_store_custom_css .='}';
	}

	/*-------------- Sticky Header Padding ----------------*/

	$shoes_store_sticky_header_padding = get_theme_mod('shoes_store_sticky_header_padding');
	if($shoes_store_sticky_header_padding != false){
		$shoes_store_custom_css .='.header-fixed{';
			$shoes_store_custom_css .='padding: '.esc_attr($shoes_store_sticky_header_padding).';';
		$shoes_store_custom_css .='}';
	}

	/*----------------Responsive Media -----------------------*/

	$shoes_store_resp_sidebar = get_theme_mod( 'shoes_store_sidebar_hide_show',true);
    if($shoes_store_resp_sidebar == true){
    	$shoes_store_custom_css .='@media screen and (max-width:575px) {';
		$shoes_store_custom_css .='#sidebar{';
			$shoes_store_custom_css .='display:block;';
		$shoes_store_custom_css .='} }';
	}else if($shoes_store_resp_sidebar == false){
		$shoes_store_custom_css .='@media screen and (max-width:575px) {';
		$shoes_store_custom_css .='#sidebar{';
			$shoes_store_custom_css .='display:none;';
		$shoes_store_custom_css .='} }';
	}

	$shoes_store_resp_scroll_top = get_theme_mod( 'shoes_store_resp_scroll_top_hide_show',true);
	if($shoes_store_resp_scroll_top == true && get_theme_mod( 'shoes_store_hide_show_scroll',true) == false){
    	$shoes_store_custom_css .='.scrollup i{';
			$shoes_store_custom_css .='visibility:hidden !important;';
		$shoes_store_custom_css .='} ';
	}
    if($shoes_store_resp_scroll_top == true){
    	$shoes_store_custom_css .='@media screen and (max-width:575px) {';
		$shoes_store_custom_css .='.scrollup i{';
			$shoes_store_custom_css .='visibility:visible !important;';
		$shoes_store_custom_css .='} }';
	}else if($shoes_store_resp_scroll_top == false){
		$shoes_store_custom_css .='@media screen and (max-width:575px){';
		$shoes_store_custom_css .='.scrollup i{';
			$shoes_store_custom_css .='visibility:hidden !important;';
		$shoes_store_custom_css .='} }';
	}

	$shoes_store_resp_stickyheader = get_theme_mod( 'shoes_store_stickyheader_hide_show',false);
	if($shoes_store_resp_stickyheader == true && get_theme_mod( 'shoes_store_sticky_header',false) != true){
    	$shoes_store_custom_css .='.header-fixed{';
			$shoes_store_custom_css .='position:static;';
		$shoes_store_custom_css .='} ';
	}
	
	/*-------------- Copyright Alignment ----------------*/

	$shoes_store_copyright_alingment = get_theme_mod('shoes_store_copyright_alingment');
	if($shoes_store_copyright_alingment != false){
		$shoes_store_custom_css .='.copyright p{';
			$shoes_store_custom_css .='text-align: '.esc_attr($shoes_store_copyright_alingment).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_footer_background_color = get_theme_mod('shoes_store_footer_background_color');
	if($shoes_store_footer_background_color != false){
		$shoes_store_custom_css .='#footer{';
			$shoes_store_custom_css .='background-color: '.esc_attr($shoes_store_footer_background_color).';';
		$shoes_store_custom_css .='}';
	}

	/*------------- Preloader Background Color  -------------------*/

	$shoes_store_preloader_bg_color = get_theme_mod('shoes_store_preloader_bg_color');
	if($shoes_store_preloader_bg_color != false){
		$shoes_store_custom_css .='#preloader{';
			$shoes_store_custom_css .='background-color: '.esc_attr($shoes_store_preloader_bg_color).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_preloader_border_color = get_theme_mod('shoes_store_preloader_border_color');
	if($shoes_store_preloader_border_color != false){
		$shoes_store_custom_css .='.loader-line{';
			$shoes_store_custom_css .='border-color: '.esc_attr($shoes_store_preloader_border_color).'!important;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_preloader_bg_img = get_theme_mod('shoes_store_preloader_bg_img');
	if($shoes_store_preloader_bg_img != false){
		$shoes_store_custom_css .='#preloader{';
			$shoes_store_custom_css .='background: url('.esc_attr($shoes_store_preloader_bg_img).');-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;';
		$shoes_store_custom_css .='}';
	}

	/*-------------- Copyright Alignment ----------------*/

	$shoes_store_copyright_alingment = get_theme_mod('shoes_store_copyright_alingment');
	if($shoes_store_copyright_alingment != false){
		$shoes_store_custom_css .='.copyright p{';
			$shoes_store_custom_css .='text-align: '.esc_attr($shoes_store_copyright_alingment).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_copyright_background_color = get_theme_mod('shoes_store_copyright_background_color');
	if($shoes_store_copyright_background_color != false){
		$shoes_store_custom_css .='#footer-2{';
			$shoes_store_custom_css .='background-color: '.esc_attr($shoes_store_copyright_background_color).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_footer_background_image = get_theme_mod('shoes_store_footer_background_image');
	if($shoes_store_footer_background_image != false){
		$shoes_store_custom_css .='#footer{';
			$shoes_store_custom_css .='background: url('.esc_attr($shoes_store_footer_background_image).')no-repeat;background-size:cover';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_theme_lay = get_theme_mod( 'shoes_store_img_footer','scroll');
	if($shoes_store_theme_lay == 'fixed'){
		$shoes_store_custom_css .='#footer{';
			$shoes_store_custom_css .='background-attachment: fixed !important; background-position: center !important;';
		$shoes_store_custom_css .='}';
	}elseif ($shoes_store_theme_lay == 'scroll'){
		$shoes_store_custom_css .='#footer{';
			$shoes_store_custom_css .='background-attachment: scroll !important; background-position: center !important;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_footer_img_position = get_theme_mod('shoes_store_footer_img_position','center center');
	if($shoes_store_footer_img_position != false){
		$shoes_store_custom_css .='#footer{';
			$shoes_store_custom_css .='background-position: '.esc_attr($shoes_store_footer_img_position).'!important;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_footer_widgets_heading = get_theme_mod( 'shoes_store_footer_widgets_heading','Left');
    if($shoes_store_footer_widgets_heading == 'Left'){
		$shoes_store_custom_css .='#footer h3, #footer .wp-block-search .wp-block-search__label{';
		$shoes_store_custom_css .='text-align: left;';
		$shoes_store_custom_css .='}';
	}else if($shoes_store_footer_widgets_heading == 'Center'){
		$shoes_store_custom_css .='#footer h3, #footer .wp-block-search .wp-block-search__label{';
			$shoes_store_custom_css .='text-align: center;';
		$shoes_store_custom_css .='}';
	}else if($shoes_store_footer_widgets_heading == 'Right'){
		$shoes_store_custom_css .='#footer h3, #footer .wp-block-search .wp-block-search__label{';
			$shoes_store_custom_css .='text-align: right;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_footer_widgets_content = get_theme_mod( 'shoes_store_footer_widgets_content','Left');
    if($shoes_store_footer_widgets_content == 'Left'){
		$shoes_store_custom_css .='#footer .widget{';
		$shoes_store_custom_css .='text-align: left;';
		$shoes_store_custom_css .='}';
	}else if($shoes_store_footer_widgets_content == 'Center'){
		$shoes_store_custom_css .='#footer .widget{';
			$shoes_store_custom_css .='text-align: center;';
		$shoes_store_custom_css .='}';
	}else if($shoes_store_footer_widgets_content == 'Right'){
		$shoes_store_custom_css .='#footer .widget{';
			$shoes_store_custom_css .='text-align: right;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_copyright_font_size = get_theme_mod('shoes_store_copyright_font_size');
	if($shoes_store_copyright_font_size != false){
		$shoes_store_custom_css .='#footer-2 a, #footer-2 p{';
			$shoes_store_custom_css .='font-size: '.esc_attr($shoes_store_copyright_font_size).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_copyright_alingment = get_theme_mod('shoes_store_copyright_alingment');
	if($shoes_store_copyright_alingment != false){
		$shoes_store_custom_css .='#footer-2 p{';
			$shoes_store_custom_css .='text-align: '.esc_attr($shoes_store_copyright_alingment).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_copyright_padding_top_bottom = get_theme_mod('shoes_store_copyright_padding_top_bottom');
	if($shoes_store_copyright_padding_top_bottom != false){
		$shoes_store_custom_css .='#footer-2{';
			$shoes_store_custom_css .='padding-top: '.esc_attr($shoes_store_copyright_padding_top_bottom).'; padding-bottom: '.esc_attr($shoes_store_copyright_padding_top_bottom).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_footer_padding = get_theme_mod('shoes_store_footer_padding');
	if($shoes_store_footer_padding != false){
		$shoes_store_custom_css .='#footer{';
			$shoes_store_custom_css .='padding: '.esc_attr($shoes_store_footer_padding).' 0;';
		$shoes_store_custom_css .='}';
	}
	/*-------------- Copyright Alignment ----------------*/

	$shoes_store_copyright_alingment = get_theme_mod('shoes_store_copyright_alingment');
	if($shoes_store_copyright_alingment != false){
		$shoes_store_custom_css .='.copyright p{';
			$shoes_store_custom_css .='text-align: '.esc_attr($shoes_store_copyright_alingment).';';
		$shoes_store_custom_css .='}';
	}

	/*----------------Scroll to top Settings ------------------*/

	$shoes_store_scroll_to_top_font_size = get_theme_mod('shoes_store_scroll_to_top_font_size');
	if($shoes_store_scroll_to_top_font_size != false){
		$shoes_store_custom_css .='.scrollup i{';
			$shoes_store_custom_css .='font-size: '.esc_attr($shoes_store_scroll_to_top_font_size).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_scroll_to_top_padding = get_theme_mod('shoes_store_scroll_to_top_padding');
	$shoes_store_scroll_to_top_padding = get_theme_mod('shoes_store_scroll_to_top_padding');
	if($shoes_store_scroll_to_top_padding != false){
		$shoes_store_custom_css .='.scrollup i{';
			$shoes_store_custom_css .='padding-top: '.esc_attr($shoes_store_scroll_to_top_padding).';padding-bottom: '.esc_attr($shoes_store_scroll_to_top_padding).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_scroll_to_top_width = get_theme_mod('shoes_store_scroll_to_top_width');
	if($shoes_store_scroll_to_top_width != false){
		$shoes_store_custom_css .='.scrollup i{';
			$shoes_store_custom_css .='width: '.esc_attr($shoes_store_scroll_to_top_width).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_scroll_to_top_height = get_theme_mod('shoes_store_scroll_to_top_height');
	if($shoes_store_scroll_to_top_height != false){
		$shoes_store_custom_css .='.scrollup i{';
			$shoes_store_custom_css .='height: '.esc_attr($shoes_store_scroll_to_top_height).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_scroll_to_top_border_radius = get_theme_mod('shoes_store_scroll_to_top_border_radius');
	if($shoes_store_scroll_to_top_border_radius != false){
		$shoes_store_custom_css .='.scrollup i{';
			$shoes_store_custom_css .='border-radius: '.esc_attr($shoes_store_scroll_to_top_border_radius).'px;';
		$shoes_store_custom_css .='}';
	}

	/*------------------ Logo  -------------------*/

	$shoes_store_logo_padding = get_theme_mod('shoes_store_logo_padding');
	if($shoes_store_logo_padding != false){
		$shoes_store_custom_css .='.logo{';
			$shoes_store_custom_css .='padding: '.esc_attr($shoes_store_logo_padding).' !important;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_logo_margin = get_theme_mod('shoes_store_logo_margin');
	if($shoes_store_logo_margin != false){
		$shoes_store_custom_css .='.logo{';
			$shoes_store_custom_css .='margin: '.esc_attr($shoes_store_logo_margin).';';
		$shoes_store_custom_css .='}';
	}

	// Site title Font Size
	$shoes_store_site_title_font_size = get_theme_mod('shoes_store_site_title_font_size');
	if($shoes_store_site_title_font_size != false){
		$shoes_store_custom_css .='.logo p.site-title, .logo h1{';
			$shoes_store_custom_css .='font-size: '.esc_attr($shoes_store_site_title_font_size).';';
		$shoes_store_custom_css .='}';
	}

	// Site tagline Font Size
	$shoes_store_site_tagline_font_size = get_theme_mod('shoes_store_site_tagline_font_size');
	if($shoes_store_site_tagline_font_size != false){
		$shoes_store_custom_css .='.logo p.site-description{';
			$shoes_store_custom_css .='font-size: '.esc_attr($shoes_store_site_tagline_font_size).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_site_title_color = get_theme_mod('shoes_store_site_title_color');
	if($shoes_store_site_title_color != false){
		$shoes_store_custom_css .='p.site-title a, .logo h1 a{';
			$shoes_store_custom_css .='color: '.esc_attr($shoes_store_site_title_color).'!important;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_site_tagline_color = get_theme_mod('shoes_store_site_tagline_color');
	if($shoes_store_site_tagline_color != false){
		$shoes_store_custom_css .='.logo p.site-description{';
			$shoes_store_custom_css .='color: '.esc_attr($shoes_store_site_tagline_color).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_logo_width = get_theme_mod('shoes_store_logo_width');
	if($shoes_store_logo_width != false){
		$shoes_store_custom_css .='.logo img{';
			$shoes_store_custom_css .='width: '.esc_attr($shoes_store_logo_width).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_logo_height = get_theme_mod('shoes_store_logo_height');
	if($shoes_store_logo_height != false){
		$shoes_store_custom_css .='.logo img{';
			$shoes_store_custom_css .='height: '.esc_attr($shoes_store_logo_height).';object-fit:cover;';
		$shoes_store_custom_css .='}';
	}

	// Header Background Color
	$shoes_store_header_background_color = get_theme_mod('shoes_store_header_background_color');
	if($shoes_store_header_background_color != false){
		$shoes_store_custom_css .='.page-template-custom-home-page .home-page-header, .home-page-header{';
			$shoes_store_custom_css .='background-color: '.esc_attr($shoes_store_header_background_color).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_header_img_position = get_theme_mod('shoes_store_header_img_position','center top');
	if($shoes_store_header_img_position != false){
		$shoes_store_custom_css .='.page-template-custom-home-page .home-page-header, .home-page-header{';
			$shoes_store_custom_css .='background-position: '.esc_attr($shoes_store_header_img_position).'!important;';
		$shoes_store_custom_css .='}';
	}

	/*---------------------------Blog Layout -------------------*/

	$shoes_store_theme_lay = get_theme_mod( 'shoes_store_blog_layout_option','Left');
    if($shoes_store_theme_lay == 'Default'){
		$shoes_store_custom_css .='.post-main-box{';
			$shoes_store_custom_css .='';
		$shoes_store_custom_css .='}';
	}else if($shoes_store_theme_lay == 'Center'){
		$shoes_store_custom_css .='.post-main-box, .post-main-box h2, .post-info, .new-text p, .content-bttn{';
			$shoes_store_custom_css .='text-align:center;';
		$shoes_store_custom_css .='}';
		$shoes_store_custom_css .='.post-info{';
			$shoes_store_custom_css .='margin-top:10px;';
		$shoes_store_custom_css .='}';
		$shoes_store_custom_css .='.post-info hr{';
			$shoes_store_custom_css .='margin:15px auto;';
		$shoes_store_custom_css .='}';
	}else if($shoes_store_theme_lay == 'Left'){
		$shoes_store_custom_css .='.post-main-box, .post-main-box h2, .post-info, .new-text p, .content-bttn, #our-services p{';
			$shoes_store_custom_css .='text-align:Left;';
		$shoes_store_custom_css .='}';
		$shoes_store_custom_css .='.post-info hr{';
			$shoes_store_custom_css .='margin-bottom:10px;';
		$shoes_store_custom_css .='}';
		$shoes_store_custom_css .='.post-main-box h2{';
			$shoes_store_custom_css .='margin-top:10px;';
		$shoes_store_custom_css .='}';
		$shoes_store_custom_css .='.service-text .more-btn{';
			$shoes_store_custom_css .='display:inline-block;';
		$shoes_store_custom_css .='}';
	}

	/*--------------------- Blog Page Posts -------------------*/

	$shoes_store_blog_page_posts_settings = get_theme_mod( 'shoes_store_blog_page_posts_settings','Into Blocks');
    if($shoes_store_blog_page_posts_settings == 'Without Blocks'){
		$shoes_store_custom_css .='.post-main-box{';
			$shoes_store_custom_css .='box-shadow: none; border: none; margin:30px 0;';
		$shoes_store_custom_css .='}';
	}

	// featured image dimention
	$shoes_store_blog_post_featured_image_dimension = get_theme_mod('shoes_store_blog_post_featured_image_dimension', 'default');
	$shoes_store_blog_post_featured_image_custom_width = get_theme_mod('shoes_store_blog_post_featured_image_custom_width',250);
	$shoes_store_blog_post_featured_image_custom_height = get_theme_mod('shoes_store_blog_post_featured_image_custom_height',250);
	if($shoes_store_blog_post_featured_image_dimension == 'custom'){
		$shoes_store_custom_css .='.post-main-box img{';
			$shoes_store_custom_css .='width: '.esc_attr($shoes_store_blog_post_featured_image_custom_width).'!important; height: '.esc_attr($shoes_store_blog_post_featured_image_custom_height).';';
		$shoes_store_custom_css .='}';
	}

	/*---------------- Posts Settings ------------------*/

	$shoes_store_featured_image_border_radius = get_theme_mod('shoes_store_featured_image_border_radius', 0);
	if($shoes_store_featured_image_border_radius != false){
		$shoes_store_custom_css .='.box-image img, .feature-box img{';
			$shoes_store_custom_css .='border-radius: '.esc_attr($shoes_store_featured_image_border_radius).'px;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_featured_image_box_shadow = get_theme_mod('shoes_store_featured_image_box_shadow',0);
	if($shoes_store_featured_image_box_shadow != false){
		$shoes_store_custom_css .='.box-image img, .feature-box img, #content-vw img{';
			$shoes_store_custom_css .='box-shadow: '.esc_attr($shoes_store_featured_image_box_shadow).'px '.esc_attr($shoes_store_featured_image_box_shadow).'px '.esc_attr($shoes_store_featured_image_box_shadow).'px #cccccc;';
		$shoes_store_custom_css .='}';
	}

	/*---------------- Button Settings ------------------*/

	$shoes_store_button_letter_spacing = get_theme_mod('shoes_store_button_letter_spacing',14);
	$shoes_store_custom_css .='.post-main-box .more-btn{';
		$shoes_store_custom_css .='letter-spacing: '.esc_attr($shoes_store_button_letter_spacing).';';
	$shoes_store_custom_css .='}';

	$shoes_store_button_border_radius = get_theme_mod('shoes_store_button_border_radius');
	if($shoes_store_button_border_radius != false){
		$shoes_store_custom_css .='.post-main-box .more-btn a{';
			$shoes_store_custom_css .='border-radius: '.esc_attr($shoes_store_button_border_radius).'px !important;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_button_top_bottom_padding = get_theme_mod('shoes_store_button_top_bottom_padding');
	$shoes_store_button_left_right_padding = get_theme_mod('shoes_store_button_left_right_padding');
	if($shoes_store_button_top_bottom_padding != false || $shoes_store_button_left_right_padding != false){
		$shoes_store_custom_css .='.post-main-box .more-btn{';
			$shoes_store_custom_css .='padding-top: '.esc_attr($shoes_store_button_top_bottom_padding).'!important; padding-bottom: '.esc_attr($shoes_store_button_top_bottom_padding).'!important;padding-left: '.esc_attr($shoes_store_button_left_right_padding).'!important;padding-right: '.esc_attr($shoes_store_button_left_right_padding).'!important;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_button_font_size = get_theme_mod('shoes_store_button_font_size',14);
	$shoes_store_custom_css .='.post-main-box .more-btn a{';
		$shoes_store_custom_css .='font-size: '.esc_attr($shoes_store_button_font_size).';';
	$shoes_store_custom_css .='}';

	$shoes_store_theme_lay = get_theme_mod( 'shoes_store_button_text_transform','Capitalize');
	if($shoes_store_theme_lay == 'Capitalize'){
		$shoes_store_custom_css .='.post-main-box .more-btn a{';
			$shoes_store_custom_css .='text-transform:Capitalize;';
		$shoes_store_custom_css .='}';
	}
	if($shoes_store_theme_lay == 'Lowercase'){
		$shoes_store_custom_css .='.post-main-box .more-btn a{';
			$shoes_store_custom_css .='text-transform:Lowercase;';
		$shoes_store_custom_css .='}';
	}
	if($shoes_store_theme_lay == 'Uppercase'){
		$shoes_store_custom_css .='.post-main-box .more-btn a{';
			$shoes_store_custom_css .='text-transform:Uppercase;';
		$shoes_store_custom_css .='}';
	}

	/*---------------- Single Blog Page Settings ------------------*/

	$shoes_store_single_blog_comment_button_text = get_theme_mod('shoes_store_single_blog_comment_button_text', 'Post Comment');
	if($shoes_store_single_blog_comment_button_text == ''){
		$shoes_store_custom_css .='#comments p.form-submit {';
			$shoes_store_custom_css .='display: none;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_comment_width = get_theme_mod('shoes_store_single_blog_comment_width');
	if($shoes_store_comment_width != false){
		$shoes_store_custom_css .='#comments textarea{';
			$shoes_store_custom_css .='width: '.esc_attr($shoes_store_comment_width).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_single_blog_post_navigation_show_hide = get_theme_mod('shoes_store_single_blog_post_navigation_show_hide',true);
	if($shoes_store_single_blog_post_navigation_show_hide != true){
		$shoes_store_custom_css .='.post-navigation{';
			$shoes_store_custom_css .='display: none;';
		$shoes_store_custom_css .='}';
	}

	/*--------------------- Grid Posts Posts -------------------*/

	$shoes_store_display_grid_posts_settings = get_theme_mod( 'shoes_store_display_grid_posts_settings','Into Blocks');
    if($shoes_store_display_grid_posts_settings == 'Without Blocks'){
		$shoes_store_custom_css .='.grid-post-main-box{';
			$shoes_store_custom_css .='box-shadow: none; border: none; margin:30px 0;';
		$shoes_store_custom_css .='}';
	}

	/*----------------Woocommerce Products Settings ------------------*/

	$shoes_store_related_product_show_hide = get_theme_mod('shoes_store_related_product_show_hide',true);
	if($shoes_store_related_product_show_hide != true){
		$shoes_store_custom_css .='.related.products{';
			$shoes_store_custom_css .='display: none;';
		$shoes_store_custom_css .='}';
	}

	/*----------------Woocommerce Products Settings ------------------*/

	$shoes_store_products_padding_top_bottom = get_theme_mod('shoes_store_products_padding_top_bottom');
	if($shoes_store_products_padding_top_bottom != false){
		$shoes_store_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$shoes_store_custom_css .='padding-top: '.esc_attr($shoes_store_products_padding_top_bottom).'!important; padding-bottom: '.esc_attr($shoes_store_products_padding_top_bottom).'!important;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_products_padding_left_right = get_theme_mod('shoes_store_products_padding_left_right');
	if($shoes_store_products_padding_left_right != false){
		$shoes_store_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$shoes_store_custom_css .='padding-left: '.esc_attr($shoes_store_products_padding_left_right).'!important; padding-right: '.esc_attr($shoes_store_products_padding_left_right).'!important;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_products_box_shadow = get_theme_mod('shoes_store_products_box_shadow');
	if($shoes_store_products_box_shadow != false){
		$shoes_store_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
				$shoes_store_custom_css .='box-shadow: '.esc_attr($shoes_store_products_box_shadow).'px '.esc_attr($shoes_store_products_box_shadow).'px '.esc_attr($shoes_store_products_box_shadow).'px #ddd;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_products_border_radius = get_theme_mod('shoes_store_products_border_radius');
	if($shoes_store_products_border_radius != false){
		$shoes_store_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$shoes_store_custom_css .='border-radius: '.esc_attr($shoes_store_products_border_radius).'px;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_products_btn_padding_top_bottom = get_theme_mod('shoes_store_products_btn_padding_top_bottom');
	if($shoes_store_products_btn_padding_top_bottom != false){
		$shoes_store_custom_css .='.woocommerce a.button{';
			$shoes_store_custom_css .='padding-top: '.esc_attr($shoes_store_products_btn_padding_top_bottom).' !important; padding-bottom: '.esc_attr($shoes_store_products_btn_padding_top_bottom).' !important;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_products_btn_padding_left_right = get_theme_mod('shoes_store_products_btn_padding_left_right');
	if($shoes_store_products_btn_padding_left_right != false){
		$shoes_store_custom_css .='.woocommerce a.button{';
			$shoes_store_custom_css .='padding-left: '.esc_attr($shoes_store_products_btn_padding_left_right).' !important; padding-right: '.esc_attr($shoes_store_products_btn_padding_left_right).' !important;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_products_button_border_radius = get_theme_mod('shoes_store_products_button_border_radius', 0);
	if($shoes_store_products_button_border_radius != false){
		$shoes_store_custom_css .='.woocommerce ul.products li.product .button, a.checkout-button.button.alt.wc-forward,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.woocommerce a.button{';
			$shoes_store_custom_css .='border-radius: '.esc_attr($shoes_store_products_button_border_radius).'px !important;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_woocommerce_sale_position = get_theme_mod( 'shoes_store_woocommerce_sale_position','right');
    if($shoes_store_woocommerce_sale_position == 'left'){
		$shoes_store_custom_css .='.woocommerce ul.products li.product .onsale{';
			$shoes_store_custom_css .='left: 14px !important; right: auto !important;';
		$shoes_store_custom_css .='}';
	}else if($shoes_store_woocommerce_sale_position == 'right'){
		$shoes_store_custom_css .='.woocommerce ul.products li.product .onsale{';
			$shoes_store_custom_css .='left: auto!important; right: 14px !important;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_woocommerce_sale_font_size = get_theme_mod('shoes_store_woocommerce_sale_font_size');
	if($shoes_store_woocommerce_sale_font_size != false){
		$shoes_store_custom_css .='.woocommerce span.onsale{';
			$shoes_store_custom_css .='font-size: '.esc_attr($shoes_store_woocommerce_sale_font_size).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_woocommerce_sale_padding_top_bottom = get_theme_mod('shoes_store_woocommerce_sale_padding_top_bottom');
	if($shoes_store_woocommerce_sale_padding_top_bottom != false){
		$shoes_store_custom_css .='.woocommerce span.onsale{';
			$shoes_store_custom_css .='padding-top: '.esc_attr($shoes_store_woocommerce_sale_padding_top_bottom).'; padding-bottom: '.esc_attr($shoes_store_woocommerce_sale_padding_top_bottom).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_woocommerce_sale_padding_left_right = get_theme_mod('shoes_store_woocommerce_sale_padding_left_right');
	if($shoes_store_woocommerce_sale_padding_left_right != false){
		$shoes_store_custom_css .='.woocommerce span.onsale{';
			$shoes_store_custom_css .='padding-left: '.esc_attr($shoes_store_woocommerce_sale_padding_left_right).'; padding-right: '.esc_attr($shoes_store_woocommerce_sale_padding_left_right).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_woocommerce_sale_border_radius = get_theme_mod('shoes_store_woocommerce_sale_border_radius', 0);
	if($shoes_store_woocommerce_sale_border_radius != false){
		$shoes_store_custom_css .='.woocommerce span.onsale{';
			$shoes_store_custom_css .='border-radius: '.esc_attr($shoes_store_woocommerce_sale_border_radius).'px;';
		$shoes_store_custom_css .='}';
	}

	/*-------------- Sticky Header Padding ----------------*/

	$shoes_store_sticky_header_padding = get_theme_mod('shoes_store_sticky_header_padding');
	if($shoes_store_sticky_header_padding != false){
		$shoes_store_custom_css .='.header-fixed{';
			$shoes_store_custom_css .='padding: '.esc_attr($shoes_store_sticky_header_padding).';';
		$shoes_store_custom_css .='}';
	}

	/*----------------Social Icons Settings ------------------*/

	$shoes_store_social_icon_font_size = get_theme_mod('shoes_store_social_icon_font_size');
	if($shoes_store_social_icon_font_size != false){
		$shoes_store_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$shoes_store_custom_css .='font-size: '.esc_attr($shoes_store_social_icon_font_size).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_social_icon_padding = get_theme_mod('shoes_store_social_icon_padding');
	if($shoes_store_social_icon_padding != false){
		$shoes_store_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$shoes_store_custom_css .='padding: '.esc_attr($shoes_store_social_icon_padding).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_social_icon_width = get_theme_mod('shoes_store_social_icon_width');
	if($shoes_store_social_icon_width != false){
		$shoes_store_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$shoes_store_custom_css .='width: '.esc_attr($shoes_store_social_icon_width).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_social_icon_height = get_theme_mod('shoes_store_social_icon_height');
	if($shoes_store_social_icon_height != false){
		$shoes_store_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$shoes_store_custom_css .='height: '.esc_attr($shoes_store_social_icon_height).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_social_icon_border_radius = get_theme_mod('shoes_store_social_icon_border_radius');
	if($shoes_store_social_icon_border_radius != false){
		$shoes_store_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$shoes_store_custom_css .='border-radius: '.esc_attr($shoes_store_social_icon_border_radius).'px;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_resp_menu_toggle_btn_bg_color = get_theme_mod('shoes_store_resp_menu_toggle_btn_bg_color');
	if($shoes_store_resp_menu_toggle_btn_bg_color != false){
		$shoes_store_custom_css .='@media screen and (max-width:1000px) {';
		$shoes_store_custom_css .='.toggle-nav i{';
			$shoes_store_custom_css .='background: '.esc_attr($shoes_store_resp_menu_toggle_btn_bg_color).';';
		$shoes_store_custom_css .='}}';
	}

	$shoes_store_grid_featured_image_box_shadow = get_theme_mod('shoes_store_grid_featured_image_box_shadow',0);
	if($shoes_store_grid_featured_image_box_shadow != false){
		$shoes_store_custom_css .='.grid-post-main-box .box-image img, .grid-post-main-box .feature-box img, #content-vw img{';
			$shoes_store_custom_css .='box-shadow: '.esc_attr($shoes_store_grid_featured_image_box_shadow).'px '.esc_attr($shoes_store_grid_featured_image_box_shadow).'px '.esc_attr($shoes_store_grid_featured_image_box_shadow).'px #cccccc;';
		$shoes_store_custom_css .='}';
	}

	/*-------------- Menus Setings ----------------*/

	$shoes_store_navigation_menu_font_size = get_theme_mod('shoes_store_navigation_menu_font_size');
	if($shoes_store_navigation_menu_font_size != false){
		$shoes_store_custom_css .='.main-navigation ul a{';
			$shoes_store_custom_css .='font-size: '.esc_attr($shoes_store_navigation_menu_font_size).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_navigation_menu_font_weight = get_theme_mod('shoes_store_navigation_menu_font_weight','600');
	if($shoes_store_navigation_menu_font_weight != false){
		$shoes_store_custom_css .='.main-navigation ul a{';
			$shoes_store_custom_css .='font-weight: '.esc_attr($shoes_store_navigation_menu_font_weight).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_theme_lay = get_theme_mod( 'shoes_store_menu_text_transform','Capitalize');
	if($shoes_store_theme_lay == 'Capitalize'){
		$shoes_store_custom_css .='.main-navigation ul a{';
			$shoes_store_custom_css .='text-transform:Capitalize;';
		$shoes_store_custom_css .='}';
	}
	if($shoes_store_theme_lay == 'Lowercase'){
		$shoes_store_custom_css .='.main-navigation ul a{';
			$shoes_store_custom_css .='text-transform:Lowercase;';
		$shoes_store_custom_css .='}';
	}
	if($shoes_store_theme_lay == 'Uppercase'){
		$shoes_store_custom_css .='.main-navigation ul a{';
			$shoes_store_custom_css .='text-transform:Uppercase;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_header_menus_color = get_theme_mod('shoes_store_header_menus_color');
	if($shoes_store_header_menus_color != false){
		$shoes_store_custom_css .='.main-navigation ul a{';
			$shoes_store_custom_css .='color: '.esc_attr($shoes_store_header_menus_color).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_header_menus_hover_color = get_theme_mod('shoes_store_header_menus_hover_color');
	if($shoes_store_header_menus_hover_color != false){
		$shoes_store_custom_css .='.main-navigation ul a:hover{';
			$shoes_store_custom_css .='color: '.esc_attr($shoes_store_header_menus_hover_color).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_header_submenus_color = get_theme_mod('shoes_store_header_submenus_color');
	if($shoes_store_header_submenus_color != false){
		$shoes_store_custom_css .='.main-navigation ul ul a{';
			$shoes_store_custom_css .='color: '.esc_attr($shoes_store_header_submenus_color).';';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_header_submenus_hover_color = get_theme_mod('shoes_store_header_submenus_hover_color');
	if($shoes_store_header_submenus_hover_color != false){
		$shoes_store_custom_css .='.main-navigation ul.sub-menu a:hover{';
			$shoes_store_custom_css .='color: '.esc_attr($shoes_store_header_submenus_hover_color).'!important;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_menus_item = get_theme_mod( 'shoes_store_menus_item_style','None');
    if($shoes_store_menus_item == 'None'){
		$shoes_store_custom_css .='.main-navigation ul a{';
			$shoes_store_custom_css .='';
		$shoes_store_custom_css .='}';
	}else if($shoes_store_menus_item == 'Zoom In'){
		$shoes_store_custom_css .='.main-navigation ul a:hover{';
			$shoes_store_custom_css .='transition: all 0.3s ease-in-out !important; transform: scale(1.2) !important;';
		$shoes_store_custom_css .='}';
	}

	/*---------------------------Footer Style -------------------*/

	$shoes_store_theme_lay = get_theme_mod( 'shoes_store_footer_template','shoes_store-footer-one');
    if($shoes_store_theme_lay == 'shoes_store-footer-one'){
		$shoes_store_custom_css .='#footer{';
			$shoes_store_custom_css .='';
		$shoes_store_custom_css .='}';

	}else if($shoes_store_theme_lay == 'shoes_store-footer-two'){
		$shoes_store_custom_css .='#footer{';
			$shoes_store_custom_css .='background: linear-gradient(to right, #f9f8ff, #dedafa);';
		$shoes_store_custom_css .='}';
		$shoes_store_custom_css .='#footer p, #footer li a, #footer, #footer h3, #footer a.rsswidget, #footer #wp-calendar a, .copyright a, #footer .custom_details, #footer ins span, #footer .tagcloud a, .main-inner-box span.entry-date a, nav.woocommerce-MyAccount-navigation ul li:hover a, #footer ul li a, #footer table, #footer th, #footer td, #footer caption, #sidebar caption,#footer nav.wp-calendar-nav a,#footer .search-form .search-field{';
			$shoes_store_custom_css .='color:#000;';
		$shoes_store_custom_css .='}';
		$shoes_store_custom_css .='#footer ul li::before{';
			$shoes_store_custom_css .='background:#000;';
		$shoes_store_custom_css .='}';
		$shoes_store_custom_css .='#footer table, #footer th, #footer td,#footer .search-form .search-field,#footer .tagcloud a{';
			$shoes_store_custom_css .='border: 1px solid #000;';
		$shoes_store_custom_css .='}';

	}else if($shoes_store_theme_lay == 'shoes_store-footer-three'){
		$shoes_store_custom_css .='#footer{';
			$shoes_store_custom_css .='background: #232524;';
		$shoes_store_custom_css .='}';
	}
	else if($shoes_store_theme_lay == 'shoes_store-footer-four'){
		$shoes_store_custom_css .='#footer{';
			$shoes_store_custom_css .='background: #B5E448;';
		$shoes_store_custom_css .='}';
		$shoes_store_custom_css .='#footer p, #footer li a, #footer, #footer h3, #footer a.rsswidget, #footer #wp-calendar a, .copyright a, #footer .custom_details, #footer ins span, #footer .tagcloud a, .main-inner-box span.entry-date a, nav.woocommerce-MyAccount-navigation ul li:hover a, #footer ul li a, #footer table, #footer th, #footer td, #footer caption, #sidebar caption,#footer nav.wp-calendar-nav a,#footer .search-form .search-field{';
			$shoes_store_custom_css .='color:#fff;';
		$shoes_store_custom_css .='}';
		$shoes_store_custom_css .='#footer ul li::before{';
			$shoes_store_custom_css .='background:#fff;';
		$shoes_store_custom_css .='}';
		$shoes_store_custom_css .='#footer table, #footer th, #footer td,#footer .search-form .search-field,#footer .tagcloud a{';
			$shoes_store_custom_css .='border: 1px solid #fff;';
		$shoes_store_custom_css .='}';
	}
	else if($shoes_store_theme_lay == 'shoes_store-footer-five'){
		$shoes_store_custom_css .='#footer{';
			$shoes_store_custom_css .='background: linear-gradient(to right, #01093a, #2d0b00);';
		$shoes_store_custom_css .='}';
	}

	/*---------------- Footer Settings ------------------*/

	$shoes_store_button_footer_heading_letter_spacing = get_theme_mod('shoes_store_button_footer_heading_letter_spacing',1);
	$shoes_store_custom_css .='#footer h3, a.rsswidget.rss-widget-title{';
		$shoes_store_custom_css .='letter-spacing: '.esc_attr($shoes_store_button_footer_heading_letter_spacing).'px;';
	$shoes_store_custom_css .='}';

	$shoes_store_button_footer_font_size = get_theme_mod('shoes_store_button_footer_font_size','30');
	$shoes_store_custom_css .='#footer h3, a.rsswidget.rss-widget-title{';
		$shoes_store_custom_css .='font-size: '.esc_attr($shoes_store_button_footer_font_size).'px;';
	$shoes_store_custom_css .='}';

	$shoes_store_theme_lay = get_theme_mod( 'shoes_store_button_footer_text_transform','Capitalize');
	if($shoes_store_theme_lay == 'Capitalize'){
		$shoes_store_custom_css .='#footer h3{';
			$shoes_store_custom_css .='text-transform:Capitalize;';
		$shoes_store_custom_css .='}';
	}
	if($shoes_store_theme_lay == 'Lowercase'){
		$shoes_store_custom_css .='#footer h3, a.rsswidget.rss-widget-title{';
			$shoes_store_custom_css .='text-transform:Lowercase;';
		$shoes_store_custom_css .='}';
	}
	if($shoes_store_theme_lay == 'Uppercase'){
		$shoes_store_custom_css .='#footer h3, a.rsswidget.rss-widget-title{';
			$shoes_store_custom_css .='text-transform:Uppercase;';
		$shoes_store_custom_css .='}';
	}

	$shoes_store_footer_heading_weight = get_theme_mod('shoes_store_footer_heading_weight','500');
	if($shoes_store_footer_heading_weight != false){
		$shoes_store_custom_css .='#footer h3, a.rsswidget.rss-widget-title{';
			$shoes_store_custom_css .='font-weight: '.esc_attr($shoes_store_footer_heading_weight).';';
		$shoes_store_custom_css .='}';
	}
