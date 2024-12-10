<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Shoes Store 
 */
?>

<div id="sidebar" <?php if( is_page_template('blog-post-left-sidebar.php')){?> style="float:left;"<?php } ?>>    
    <?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
        <aside id="search" class="widget" role="complementary" aria-label="<?php esc_attr_e( 'firstsidebar', 'shoes-store' ); ?>">
            <h3 class="widget-title"><?php esc_html_e( 'Search', 'shoes-store' ); ?></h3>
            <?php get_search_form(); ?>
        </aside>
        <aside id="archives" class="widget" role="complementary" aria-label="<?php esc_attr_e( 'secondsidebar', 'shoes-store' ); ?>">
            <h3 class="widget-title"><?php esc_html_e( 'Archives', 'shoes-store' ); ?></h3>
            <ul>
                <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
            </ul>
        </aside>
        <aside id="meta" class="widget" role="complementary" aria-label="<?php esc_attr_e( 'thirdsidebar', 'shoes-store' ); ?>">
            <h3 class="widget-title"><?php esc_html_e( 'Meta', 'shoes-store' ); ?></h3>
            <ul>
                <?php wp_register(); ?>
                <li><?php wp_loginout(); ?></li>
                <?php wp_meta(); ?>
            </ul>
        </aside>
        <aside id="categories" class="widget" role="complementary" aria-label="<?php esc_attr_e( 'forthsidebar', 'shoes-store' ); ?>"> 
            <h3 class="widget-title"><?php esc_html_e( 'Categories', 'shoes-store' ); ?></h3>          
            <ul>
                <?php wp_list_categories('title_li=');  ?>
            </ul>
        </aside>
        <aside id="categories-dropdown" class="widget" role="complementary" aria-label="<?php esc_attr_e( 'fifthsidebar', 'shoes-store' ); ?>">
            <h3 class="widget-title"><?php esc_html_e( 'Dropdown Categories', 'shoes-store' ); ?></h3>
            <ul>
                <?php wp_dropdown_categories('title_li=');  ?>
            </ul>
        </aside>
        <aside id="tag-cloud-sec" class="widget" role="complementary" aria-label="<?php esc_attr_e( 'sixthsidebar', 'shoes-store' ); ?>">
            <h3 class="widget-title"><?php esc_html_e( 'Tag Cloud', 'shoes-store' ); ?></h3>
            <ul>
                <?php wp_tag_cloud('title_li=');  ?>
            </ul>
        </aside>
    <?php endif; ?>
</div> 