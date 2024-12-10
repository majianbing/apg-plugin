<?php
//about theme info
add_action( 'admin_menu', 'shoes_store_gettingstarted' );
function shoes_store_gettingstarted() {
	add_theme_page( esc_html__('About Shoes Store ', 'shoes-store'), esc_html__('About Shoes Store', 'shoes-store'), 'edit_theme_options', 'shoes_store_guide', 'shoes_store_mostrar_guide');
}

// Add a Custom CSS file to WP Admin Area
function shoes_store_admin_theme_style() {
	wp_enqueue_style('shoes-store-custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/getstart/getstart.css');
	wp_enqueue_script('shoes-store-tabs', esc_url(get_template_directory_uri()) . '/inc/getstart/js/tab.js');
}
add_action('admin_enqueue_scripts', 'shoes_store_admin_theme_style');

//guidline for about theme
function shoes_store_mostrar_guide() { 
	//custom function about theme customizer
	$shoes_store_return = add_query_arg( array()) ;
	$shoes_store_theme = wp_get_theme( 'shoes-store' );
?>

<div class="wrapper-info">
    <div class="col-left sshot-section">
    	<h2><?php esc_html_e( 'Welcome to Shoes Store ', 'shoes-store' ); ?> <span class="version"><?php esc_html_e( 'Version', 'shoes-store' ); ?>: <?php echo esc_html($shoes_store_theme['Version']);?></span></h2>
    	<p><?php esc_html_e('All our WordPress themes are modern, minimalist, 100% responsive, seo-friendly,feature-rich, and multipurpose that best suit designers, bloggers and other professionals who are working in the creative fields.','shoes-store'); ?></p>
    </div>

    <div class="tab-sec">
    	<div class="tab">
			<button class="tablinks" onclick="shoes_store_open_tab(event, 'lite_theme')"><?php esc_html_e( 'Setup With Customizer', 'shoes-store' ); ?></button>
			<button class="tablinks" onclick="shoes_store_open_tab(event, 'theme_pro')"><?php esc_html_e( 'Get Premium', 'shoes-store' ); ?></button>
  			<button class="tablinks" onclick="shoes_store_open_tab(event, 'free_pro')"><?php esc_html_e( 'Free Vs Pro', 'shoes-store' ); ?></button>
		</div>

		<?php 
			$shoes_store_plugin_custom_css = '';
			if(class_exists('Ibtana_Visual_Editor_Menu_Class')){
				$shoes_store_plugin_custom_css ='display: block';
			}
		?>

		<div id="lite_theme" class="tabcontent open">
			<?php  if(!class_exists('Ibtana_Visual_Editor_Menu_Class')){ 
				$plugin_ins = Shoes_Store_Plugin_Activation_Settings::get_instance();
				$shoes_store_actions = $plugin_ins->recommended_actions;
				?>
				<div class="shoes-store-recommended-plugins">
				    <div class="shoes-store-action-list">
				        <?php if ($shoes_store_actions): foreach ($shoes_store_actions as $key => $shoes_store_actionValue): ?>
				                <div class="shoes-store-action" id="<?php echo esc_attr($shoes_store_actionValue['id']);?>">
			                        <div class="action-inner plugin-activation-redirect">
			                            <h3 class="action-title"><?php echo esc_html($shoes_store_actionValue['title']); ?></h3>
			                            <div class="action-desc"><?php echo esc_html($shoes_store_actionValue['desc']); ?></div>
			                            <?php echo wp_kses_post($shoes_store_actionValue['link']); ?>
			                            <a class="ibtana-skip-btn" get-start-tab-id="lite-theme-tab" href="javascript:void(0);"><?php esc_html_e('Skip','shoes-store'); ?></a>
			                        </div>
				                </div>
				            <?php endforeach;
				        endif; ?>
				    </div>
				</div>
			<?php } ?>
			<div class="lite-theme-tab" style="<?php echo esc_attr($shoes_store_plugin_custom_css); ?>">
				<h3><?php esc_html_e( 'Lite Theme Information', 'shoes-store' ); ?></h3>
				<hr class="h3hr">
				<p><?php esc_html_e('The VW Shoes Store WordPress Theme is a stylish and versatile solution designed for creating professional and visually appealing websites for shoe retailers and footwear brands. Perfect for online shoes stores, women’s shoes stores, and athletic shoes stores, this theme caters to diverse footwear niches, including luxury shoes stores, discounted shoes stores, and sustainable shoes stores. Built with user-friendly features and optimised code, it ensures seamless navigation, faster page load times, and responsive design, making it ideal for customers browsing on any device. With stunning visual elements like sliders, banners, and customizable layouts, this theme highlights your shoes store collections, seasonal shoes store deals, and exclusive shoes store promotions effectively. The theme provides tools for showcasing various footwear categories, such as sneakers stores, boots stores, and formal shoes stores, alongside accessories like shoes store insoles and shoes store laces. Integrated features like shoes store reviews, a shoes store loyalty program, and a secure shopping cart enhance user experience and build customer trust. Its SEO-friendly design ensures maximum online visibility, while features like shoes store free shipping options and flexible return policies cater to modern e-commerce demands. Whether you are managing a vintage shoes store, a custom shoes store, or a branded shoes store, the VW Shoes Store WordPress Theme is a comprehensive solution for building a captivating, functional, and customer-focused website.','shoes-store'); ?></p>
			  	<div class="col-left-inner">
			  		<h4><?php esc_html_e( 'Theme Documentation', 'shoes-store' ); ?></h4>
					<p><?php esc_html_e( 'If you need any assistance regarding setting up and configuring the Theme, our documentation is there.', 'shoes-store' ); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( SHOES_STORE_FREE_THEME_DOC ); ?>" target="_blank"> <?php esc_html_e( 'Documentation', 'shoes-store' ); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Theme Customizer', 'shoes-store'); ?></h4>
					<p> <?php esc_html_e('To begin customizing your website, start by clicking "Customize".', 'shoes-store'); ?></p>
					<div class="info-link">
						<a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e('Customizing', 'shoes-store'); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Having Trouble, Need Support?', 'shoes-store'); ?></h4>
					<p> <?php esc_html_e('Our dedicated team is well prepared to help you out in case of queries and doubts regarding our theme.', 'shoes-store'); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( SHOES_STORE_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support Forum', 'shoes-store'); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Reviews & Testimonials', 'shoes-store'); ?></h4>
					<p> <?php esc_html_e('All the features and aspects of this WordPress Theme are phenomenal. I\'d recommend this theme to all.', 'shoes-store'); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( SHOES_STORE_REVIEW ); ?>" target="_blank"><?php esc_html_e('Reviews', 'shoes-store'); ?></a>
					</div>

					<div class="link-customizer">
						<h3><?php esc_html_e( 'Link to customizer', 'shoes-store' ); ?></h3>
						<hr class="h3hr">
						<div class="first-row">
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-buddicons-buddypress-logo"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[control]=custom_logo') ); ?>" target="_blank"><?php esc_html_e('Upload your logo','shoes-store'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-format-gallery"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=shoes_store_post_settings') ); ?>" target="_blank"><?php esc_html_e('Post settings','shoes-store'); ?></a>
								</div>
							</div>

							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-slides"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=shoes_store_top_bar') ); ?>" target="_blank"><?php esc_html_e('Top Bar','shoes-store'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-category"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=shoes_store_slider_section') ); ?>" target="_blank"><?php esc_html_e('Slider Settings','shoes-store'); ?></a>
								</div>
							</div>
						
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-category"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=shoes_store_products_section') ); ?>" target="_blank"><?php esc_html_e('New Product Section','shoes-store'); ?></a>
								</div>

								<div class="row-box2">
									<span class="dashicons dashicons-screenoptions"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=widgets') ); ?>" target="_blank"><?php esc_html_e('Footer Widget','shoes-store'); ?></a>
								</div>
							</div>
							
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-text-page"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=shoes_store_footer') ); ?>" target="_blank"><?php esc_html_e('Footer Text','shoes-store'); ?></a>
								</div>

								<div class="row-box2">
									<span class="dashicons dashicons-admin-generic"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=shoes_store_left_right') ); ?>" target="_blank"><?php esc_html_e('General Settings','shoes-store'); ?></a>
								</div>
							</div>

							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-menu"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=nav_menus') ); ?>" target="_blank"><?php esc_html_e('Menus','shoes-store'); ?></a>
								</div>
							</div>
						</div>
					</div>
			  	</div>
				<div class="col-right-inner">
					<h3 class="page-template"><?php esc_html_e('How to set up Home Page Template','shoes-store'); ?></h3>
				  	<hr class="h3hr">
					<p><?php esc_html_e('Follow these instructions to setup Home page.','shoes-store'); ?></p>
                  	<p><span class="strong"><?php esc_html_e('1. Create a new page :','shoes-store'); ?></span><?php esc_html_e(' Go to ','shoes-store'); ?>
					  	<b><?php esc_html_e(' Dashboard >> Pages >> Add New Page','shoes-store'); ?></b></p>
                  	<p><?php esc_html_e('Name it as "Home" then select the template "Custom Home Page".','shoes-store'); ?></p>
                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/home-page-template.png" alt="" />
                  	<p><span class="strong"><?php esc_html_e('2. Set the front page:','shoes-store'); ?></span><?php esc_html_e(' Go to ','shoes-store'); ?>
					  	<b><?php esc_html_e(' Settings >> Reading ','shoes-store'); ?></b></p>
				  	<p><?php esc_html_e('Select the option of Static Page, now select the page you created to be the homepage, while another page to be your default page.','shoes-store'); ?></p>
                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/set-front-page.png" alt="" />
                  	<p><?php esc_html_e(' Once you are done with setup, then follow the','shoes-store'); ?> <a class="doc-links" href="<?php echo esc_url( SHOES_STORE_FREE_THEME_DOC ); ?>" target="_blank"><?php esc_html_e('Documentation','shoes-store'); ?></a></p>
			  	</div>
			</div>
		</div>

		<div id="theme_pro" class="tabcontent">
		  	<h3><?php esc_html_e( 'Premium Theme Information', 'shoes-store' ); ?></h3>
			<hr class="h3hr">
		    <div class="col-left-pro">
		    	<p><?php esc_html_e('The VW Shoes Store WordPress Theme is a stylish and versatile solution designed for creating professional and visually appealing websites for shoe retailers and footwear brands. Perfect for online shoes stores, women’s shoes stores, and athletic shoes stores, this theme caters to diverse footwear niches, including luxury shoes stores, discounted shoes stores, and sustainable shoes stores. Built with user-friendly features and optimised code, it ensures seamless navigation, faster page load times, and responsive design, making it ideal for customers browsing on any device. With stunning visual elements like sliders, banners, and customizable layouts, this theme highlights your shoes store collections, seasonal shoes store deals, and exclusive shoes store promotions effectively. The theme provides tools for showcasing various footwear categories, such as sneakers stores, boots stores, and formal shoes stores, alongside accessories like shoes store insoles and shoes store laces. Integrated features like shoes store reviews, a shoes store loyalty program, and a secure shopping cart enhance user experience and build customer trust. Its SEO-friendly design ensures maximum online visibility, while features like shoes store free shipping options and flexible return policies cater to modern e-commerce demands. Whether you are managing a vintage shoes store, a custom shoes store, or a branded shoes store, the VW Shoes Store WordPress Theme is a comprehensive solution for building a captivating, functional, and customer-focused website.','shoes-store'); ?></p>
		    </div>
		    <div class="col-right-pro">
		    	<div class="pro-links">
			    	<a href="<?php echo esc_url( SHOES_STORE_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'shoes-store'); ?></a>
					<a href="<?php echo esc_url( SHOES_STORE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Pro', 'shoes-store'); ?></a>
					<a href="<?php echo esc_url( SHOES_STORE_PRO_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'shoes-store'); ?></a>
				</div>
		    	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/responsive.png" alt="" />
		    </div>
		</div>

		<div id="free_pro" class="tabcontent">
		  	<div class="featurebox">
			    <h3><?php esc_html_e( 'Theme Features', 'shoes-store' ); ?></h3>
				<hr class="h3hr">
				<div class="table-image">
					<table class="tablebox">
						<thead>
							<tr>
								<th></th>
								<th><?php esc_html_e('Free Themes', 'shoes-store'); ?></th>
								<th><?php esc_html_e('Premium Themes', 'shoes-store'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php esc_html_e('Theme Customization', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Responsive Design', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Logo Upload', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Social Media Links', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Banner Settings', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Template Pages', 'shoes-store'); ?></td>
								<td class="table-img"><?php esc_html_e('3', 'shoes-store'); ?></td>
								<td class="table-img"><?php esc_html_e('10', 'shoes-store'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Home Page Template', 'shoes-store'); ?></td>
								<td class="table-img"><?php esc_html_e('1', 'shoes-store'); ?></td>
								<td class="table-img"><?php esc_html_e('1', 'shoes-store'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Theme sections', 'shoes-store'); ?></td>
								<td class="table-img"><?php esc_html_e('2', 'shoes-store'); ?></td>
								<td class="table-img"><?php esc_html_e('13', 'shoes-store'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Contact us Page Template / Support Templates', 'shoes-store'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('1', 'shoes-store'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Blog Templates & Layout', 'shoes-store'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('3(Full width/Left/Right Sidebar)', 'shoes-store'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Page Templates & Layout', 'shoes-store'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('3(Left/Right Sidebar)', 'shoes-store'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Color Pallete For Particular Sections', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Global Color Option', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Section Reordering', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Demo Importer', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Allow To Set Site Title, Tagline, Logo', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Enable Disable Options On All Sections, Logo', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Full Documentation', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Latest WordPress Compatibility', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Support 3rd Party Plugins', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Secure and Optimized Code', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Exclusive Functionalities', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Section Enable / Disable', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Section Google Font Choices', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Video Gallery', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Simple & Mega Menu Option', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Support to add custom CSS / JS ', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Shortcodes', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Custom Background, Colors, Header, Logo & Menu', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Premium Membership', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Budget Friendly Value', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Priority Error Fixing', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Custom Feature Addition', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('All Access Theme Pass', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Seamless Customer Support', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Shoes Store ', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Detail Services', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('About Business Page', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Team Member Page', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Project Description Page', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Support Page', 'shoes-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td></td>
								<td class="table-img"></td>
								<td class="update-link"><a href="<?php echo esc_url( SHOES_STORE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Upgrade to Pro', 'shoes-store'); ?></a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php } ?>