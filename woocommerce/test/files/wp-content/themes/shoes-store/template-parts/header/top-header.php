<?php
/**
 * The template part for Top Header
 *
 * @package Shoes Store 
 * @subpackage shoes-store
 * @since shoes-store 1.0
 */
?>

<div class="main-header <?php if( get_theme_mod( 'shoes_store_sticky_header', false) == 1) { ?> header-sticky"<?php } else { ?>close-sticky <?php } ?>">
  <?php if(get_theme_mod('shoes_store_topbar_text') != '') {?>
    <div class="topbar py-2">
      <div class="container">
        <p class="topbar-text mb-0 text-uppercase text-start"><?php echo esc_html(get_theme_mod('shoes_store_topbar_text')) ?></p>
      </div>
    </div>
  <?php }?>
  <div class="menu-header py-3">
    <div class="container">
      <div class="row">
        <div class="col-xxl-6 col-xl-6 col-lg-7 col-md-5 col-sm-5 col-5 align-self-center">
          <?php get_template_part('template-parts/header/navigation'); ?>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-2 col-md-4 col-sm-7 col-7 align-self-center logo-img-sec">
          <div class="logo text-start pb-0 pb-md-0">
            <?php if ( has_custom_logo() ) : ?>
              <div class="site-logo"><?php the_custom_logo(); ?></div>
            <?php endif; ?>
            <?php $shoes_store_blog_info = get_bloginfo( 'name' ); ?>
              <?php if ( ! empty( $shoes_store_blog_info ) ) : ?>
                <?php if ( is_front_page() && is_home() ) : ?>
                  <?php if( get_theme_mod('shoes_store_logo_title_hide_show',true) == 1){ ?>
                    <p class="site-title mb-0"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                  <?php } ?>
                <?php else : ?>
                  <?php if( get_theme_mod('shoes_store_logo_title_hide_show',true) == 1){ ?>
                    <p class="site-title mb-0"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                  <?php } ?>
                <?php endif; ?>
              <?php endif; ?>
              <?php
                $shoes_store_description = get_bloginfo( 'description', 'display' );
                if ( $shoes_store_description || is_customize_preview() ) :
              ?>
              <?php if( get_theme_mod('shoes_store_tagline_hide_show',false) == 1){ ?>
                <p class="site-description mb-0">
                  <?php echo esc_html($shoes_store_description); ?>
                </p>
              <?php } ?>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 align-items-center d-flex justify-content-end gap-4 topbar-icons">
          <?php if ( class_exists( 'woocommerce' ) ) { ?>
            <div class="cart_shop">
              <a href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('shopping cart','shoes-store'); ?>">
                <i class="<?php echo esc_attr(get_theme_mod('shoes_store_cart_icon','fa-solid fa-cart-shopping')); ?>"></i>
                <span class="screen-reader-text"><?php esc_html_e('Shopping Cart','shoes-store'); ?></span>
                <span class="cart-count"><?php echo esc_html(wp_kses_data( WC()->cart->get_cart_contents_count() ));?></span>
              </a>
            </div>
            <div class="wishlist">
              <?php if ( defined('YITH_WCWL') ) { ?>
                <a class="wishlist_view" href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>" title="<?php esc_attr_e('Wishlist','shoes-store'); ?>">
                  <i class="<?php echo esc_attr(get_theme_mod('shoes_store_heart_icon','fa-solid fa-heart')); ?>"></i>
                  <span class="wishlist-count"><?php
                    if (class_exists('YITH_WCWL_Wishlists')) {
                      $shoes_store_wishlist_count = \YITH_WCWL_Wishlists::get_instance()->count_items_in_wishlist();
                      echo esc_html($shoes_store_wishlist_count);
                  } ?></span>
                </a>
              <?php } ?>
            </div>
            <?php
            if (class_exists('WooCommerce')) {
              $shoes_store_product_found = false;
              if ((is_page() && !is_product_category()) || is_shop()) {
                $shoes_store_category_product_count = new WP_Query(array(
                  'post_type' => 'product',
                  'posts_per_page' => 1,
                  'post_status' => 'publish',
                ));
                if ($shoes_store_category_product_count->have_posts()) {
                  $shoes_store_product_found = true;
                }
                wp_reset_postdata();
              }
              if (is_product_category()) {
                $shoes_store_current_category = get_queried_object();
                $shoes_store_category_product_count = new WP_Query(array(
                  'post_type' => 'product',
                  'posts_per_page' => 1,
                  'post_status' => 'publish',
                  'tax_query' => array(
                    array(
                      'taxonomy' => 'product_cat',
                      'terms' => $shoes_store_current_category->term_id,
                      'field' => 'id',
                      'operator' => 'IN',
                    ),
                  ),
                ));
                if ($shoes_store_category_product_count->have_posts()) {
                  $shoes_store_product_found = true;
                }
                wp_reset_postdata();
              }
              if (is_search() && !have_posts()) {
                $shoes_store_product_found = false;
              }
              if ($shoes_store_product_found) {
                  ?>
                <div id="order-tracking-form" class="order-track position-relative d-flex justify-content-end align-items-center">
                  <i class="<?php echo esc_attr(get_theme_mod('shoes_store_topbar_track_order_icon', 'fa-solid fa-truck-fast')); ?>"></i>
                  <div class="order-track-hover text-left">
                    <?php echo do_shortcode('[woocommerce_order_tracking]'); ?>
                  </div>
                </div>
            <?php }}?>
            <?php if ( is_user_logged_in() ) { ?>
              <a class="myaccount-icon" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>">
                <i class="<?php echo esc_attr(get_theme_mod('shoes_store_topbar_myaccount_icon','fas fa-user')); ?>"></i>
              </a>
            <?php } else { ?>
              <a class="myaccount-icon" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('Login / Register','shoes-store'); ?>">
                <i class="<?php echo esc_attr(get_theme_mod('shoes_store_topbar_myaccount_icon','fas fa-user')); ?>"></i>
              </a>
            <?php } ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <?php if (class_exists('woocommerce')) { ?>
    <div class="container">
      <div class="d-flex justify-content-center">
        <div class="category-box">
          <div class="category-front"></div>
          <div class="top-category">
            <div class="product-category">
              <ul class="product-cat">
                <?php
                $shoes_store_args = array(
                  'orderby'    => 'name',
                  'order'      => 'ASC',
                  'hide_empty' => 1,
                  'parent'     => 0,
                  'number'     => 5,
                );
                $shoes_store_product_categories = get_terms('product_cat', $shoes_store_args);
                if (!empty($shoes_store_product_categories)) {
                  foreach ($shoes_store_product_categories as $shoes_store_product_category) {
                    $shoes_store_product_cat_id = $shoes_store_product_category->term_id;
                    $shoes_store_cat_link = get_term_link($shoes_store_product_category);

                    $shoes_store_sub_args = array(
                      'orderby'    => 'name',
                      'order'      => 'ASC',
                      'hide_empty' => 1,
                      'parent'     => $shoes_store_product_cat_id,
                    );
                    $shoes_store_subcategories = get_terms('product_cat', $shoes_store_sub_args);

                    $shoes_store_parent_class = !empty($shoes_store_subcategories) ? 'parent-category has-subcategories' : 'parent-category';

                    echo '<li class="' . esc_attr($shoes_store_parent_class) . '">';
                    echo '<a href="' . esc_url($shoes_store_cat_link) . '">';
                    echo esc_html($shoes_store_product_category->name);
                    echo '</a>';

                    if (!empty($shoes_store_subcategories)) {
                      echo '<ul class="subcategories">';
                      foreach ($shoes_store_subcategories as $shoes_store_subcategory) {
                        echo '<li>';
                        echo '<a href="' . esc_url(get_term_link($shoes_store_subcategory)) . '">';
                        echo esc_html($shoes_store_subcategory->name);
                        echo '</a>';
                        echo '</li>';
                      }
                      echo '</ul>';
                    }
                    echo '</li>';
                  }
                }
                ?>
              </ul>
            </div>
            <?php if (get_theme_mod('shoes_store_search_hide_show', true)){ ?>
              <div class="search-box">
                <span><a href="#"><i class='<?php echo esc_attr(get_theme_mod('shoes_store_search_open_icon','fas fa-search')); ?>'></i></a></span>
              </div>
              <div class="serach_outer">
                <div class="closepop"><a href="#maincontent"><i class="<?php echo esc_attr(get_theme_mod('shoes_store_search_close_icon','fa fa-window-close')); ?>"></i></a></div>
                <div class="serach_inner">
                  <?php get_product_search_form(); ?>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="category-back"></div>
        </div>
      </div>
    </div>
  <?php } ?>
</div>