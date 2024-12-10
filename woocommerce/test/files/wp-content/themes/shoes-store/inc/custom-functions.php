<?php

Class Shoes_Store_My_Recent_Posts_Widget extends WP_Widget_Recent_Posts {
  function widget($shoes_store_args, $shoes_store_instance) {
      if ( ! isset( $shoes_store_args['widget_id'] ) ) {
      $shoes_store_args['widget_id'] = $this->id;
    }
    $shoes_store_title = ( ! empty( $shoes_store_instance['title'] ) ) ? $shoes_store_instance['title'] : __( 'Recent Posts', 'shoes-store' );
    /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
    $shoes_store_title = apply_filters( 'widget_title', $shoes_store_title, $shoes_store_instance, $this->id_base );
    $shoes_store_number = ( ! empty( $shoes_store_instance['number'] ) ) ? absint( $shoes_store_instance['number'] ) : 5;
    if ( ! $shoes_store_number )
        $shoes_store_number = 5;
    $shoes_store_show_date = isset( $shoes_store_instance['show_date'] ) ? $shoes_store_instance['show_date'] : false;
    /**
     * Filter the arguments for the Recent Posts widget.
     *
     * @since 3.4.0
     *
     * @see WP_Query::get_posts()
     *
     * @param array $shoes_store_args An array of arguments used to retrieve the recent posts.
     */
    $shoes_store_r = new WP_Query( apply_filters( 'widget_posts_args', array(
        'posts_per_page'      => $shoes_store_number,
        'no_found_rows'       => true,
        'post_status'         => 'publish',
        'ignore_sticky_posts' => true
    ) ) );
    if ($shoes_store_r->have_posts()) :
    ?>
    <?php echo $shoes_store_args['before_widget']; ?>
    <?php if ( $shoes_store_title ) {
        echo $shoes_store_args['before_title'] . esc_html($shoes_store_title) . $shoes_store_args['after_title'];
    } ?>
    <ul>
      <?php while ( $shoes_store_r->have_posts() ) : $shoes_store_r->the_post(); ?>
      <li>
        <div class="recent-post-box">
          <div class="media post-thumb">
            <?php if(has_post_thumbnail()) { the_post_thumbnail(); } ?>
            <div class="media-body post-content">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              <div class="d-flex date-comment">
               <?php if ( $shoes_store_show_date ) : ?>
                <p class="post-date"><?php the_date(); ?></p>
               <?php endif; ?>
               <div class="date-comment1"><?php comments_number( __('0 Comment', 'shoes-store'), __('0 Comments', 'shoes-store'), __('% Comments', 'shoes-store') ); ?></div>
              </div>
            </div>
          </div>
        </div>
      </li>
      <?php endwhile;
      wp_reset_postdata(); ?>
    </ul>

    <?php echo $shoes_store_args['after_widget'];

    endif;
  }
}
function shoes_store_my_recent_widget_registration() {
  unregister_widget('WP_Widget_Recent_Posts');
  register_widget('Shoes_Store_My_Recent_Posts_Widget');
}
add_action('widgets_init', 'shoes_store_my_recent_widget_registration');
