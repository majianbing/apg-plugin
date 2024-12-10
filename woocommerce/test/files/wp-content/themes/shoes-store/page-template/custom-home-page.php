<?php
/**
 * Template Name: Custom Home Page
 */
get_header();

?>
<!-- banner section -->
<main id="maincontent" role="main">

  <?php do_action( 'shoes_store_above_slider' ); ?>
  
  <?php 
    $shoes_store_svg_image = file_get_contents(get_template_directory_uri() . '/assets/images/shoes-bg.svg');
    $shoes_store_number = get_theme_mod('shoes_store_slide_number');
    if($shoes_store_number != ''){
  ?>
    <section class="slider-section">
      <div id="slider" class="mw-100 m-auto p-0">
        <div class="container">
          <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-type="multi" data-interval="false">
            <div class="carousel-inner" role="listbox">
              <?php for ($shoes_store_i=1; $shoes_store_i<=$shoes_store_number; $shoes_store_i++) {?>
                <div <?php if($shoes_store_i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
                  <div class="carousel-caption">
                    <div class="inner_carousel text-start">
                      <?php if(get_theme_mod('shoes_store_slider_title'.$shoes_store_i) != ''){ ?>
                        <h1 class="slider-title"><?php echo esc_html(get_theme_mod('shoes_store_slider_title'.$shoes_store_i)); ?></h1>
                      <?php }?>
                      <?php if(get_theme_mod('shoes_store_slider_text'.$shoes_store_i) != ''){ ?>
                        <p class="slider-text my-2"><?php echo esc_html(get_theme_mod('shoes_store_slider_text'.$shoes_store_i)); ?></p>
                      <?php }?>
                    </div>
                  </div>
                  <div class="shoes-img">
                    <?php if ( get_theme_mod('shoes_store_side_img'.$shoes_store_i) != "" ) {?>
                      <img class="slider-carousel-img" src="<?php echo esc_url(get_theme_mod('shoes_store_side_img'.$shoes_store_i)); ?>" alt="<?php echo esc_attr(get_theme_mod('shoes_store_slide_title'.$shoes_store_i, true)); ?>" title="#slidecaption<?php echo esc_html($shoes_store_i); ?>">
                      <div class="shoes-bg"><?php echo $shoes_store_svg_image; ?></div>
                    <?php } ?>
                  </div>
                  <a class="carousel-control-prev" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev" role="button">
                    <span class="carousel-control-prev-icon w-auto h-auto" aria-hidden="true"><i class="<?php echo esc_attr(get_theme_mod('shoes_store_slider_previous_icon','fa-solid fa-angle-left')); ?>" ></i></span>
                    <span class="screen-reader-text"><?php esc_html_e( 'Previous','shoes-store' );?></span>
                  </a>
                  <a class="carousel-control-next" data-bs-target="#carouselExampleIndicators" data-bs-slide="next" role="button">
                    <span class="carousel-control-next-icon w-auto h-auto" aria-hidden="true"><i class="<?php echo esc_attr(get_theme_mod('shoes_store_slider_next_icon','fa-solid fa-angle-right')); ?>" ></i></span>
                    <span class="screen-reader-text"><?php esc_html_e( 'Next','shoes-store' );?></span>
                  </a>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </section>
  <?php }?>
  <?php do_action( 'shoes_store_below_slider' ); ?>

  <!-- New Product Section -->
  <?php if (get_theme_mod('shoes_store_hide_show_products_section', false)) {?>
    <section id="products-section" class="py-5 wow bounceInRight delay-1000" data-wow-duration="3s">
      <div class="container">
        <div class="about-text text-left mb-5">
          <?php if(get_theme_mod('shoes_store_product_section_heading') != ''){ ?>
            <h2 class="products-title text-capitalize mb-3 text-center"><?php echo esc_html(get_theme_mod('shoes_store_product_section_heading')); ?></h2>
          <?php } ?>
        </div>
        <div class="row">
          <?php if ( class_exists( 'WooCommerce' ) ) {
            $shoes_store_selected_category = get_theme_mod('shoes_store_best_product_category', '');
            if (!empty($shoes_store_selected_category)) {
              $shoes_store_args = array( 
                'post_type'      => 'product',
                'product_cat'    => $shoes_store_selected_category,
                'order'          => 'ASC',
                'hide_empty'     => 0,
                'posts_per_page' => 4,
              );
                $shoes_store_loop = new WP_Query($shoes_store_args);
                while ($shoes_store_loop->have_posts()) : $shoes_store_loop->the_post(); global $product; ?>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
                    <div class="product-box">
                      <div class="product-box-img">
                        <?php if ( has_post_thumbnail( $shoes_store_loop->post->ID ) ) {
                          echo get_the_post_thumbnail( $shoes_store_loop->post->ID, 'shop_catalog' );
                        } else {
                          echo '<img src="'.esc_url(woocommerce_placeholder_img_src()).'" />';
                        } ?>
                      </div>
                      <div class="product-box-content mt-3 text-center">
                        <h3 class="product-head"><a href="<?php echo esc_url( get_permalink( $shoes_store_loop->post->ID ) ); ?>"><?php the_title(); ?></a></h3>
                        <span>
                          <?php 
                            if( $product->is_type( 'simple' ) ) { 
                              woocommerce_template_loop_rating( $shoes_store_loop->post, $product ); 
                            } 
                          ?>
                        </span>
                        <p class="product-price mb-lg-3 mb-0 <?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>">
                          <?php echo $product->get_price_html(); ?>
                        </p>
                      </div>
                    </div>
                  </div>
                <?php endwhile;
                wp_reset_postdata();
          }} ?>
        </div>
      </div>
    </section>
  <?php }?>

  <div id="content-vw" class="entry-content">
    <div class="container">
      <?php while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; // end of the loop. 
      ?>
    </div>
  </div>
</main>

<?php get_footer(); ?> 