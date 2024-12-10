<?php
/**
 * Custom Social Widget
 */

class Shoes_Store_Social_Widget extends WP_Widget {
	
	function __construct() {
		parent::__construct(
			'Shoes_Store_Social_Widget',
			__('VW Social Icon', 'shoes-store'),
			array( 'description' => __( 'Widget for Social icons section', 'shoes-store' ), ) 
		);
	}

	public function widget( $shoes_store_args, $shoes_store_instance ) { ?>
		<div class="widget">
			<?php
			$shoes_store_title = isset( $shoes_store_instance['title'] ) ? $shoes_store_instance['title'] : '';
			$shoes_store_facebook = isset( $shoes_store_instance['facebook'] ) ? $shoes_store_instance['facebook'] : '';
			$shoes_store_twitter = isset( $shoes_store_instance['twitter'] ) ? $shoes_store_instance['twitter'] : '';
			$shoes_store_instagram = isset( $shoes_store_instance['instagram'] ) ? $shoes_store_instance['instagram'] : '';
			$shoes_store_youtube = isset( $shoes_store_instance['youtube'] ) ? $shoes_store_instance['youtube'] : '';
			$shoes_store_dribbal = isset( $shoes_store_instance['dribbal'] ) ? $shoes_store_instance['dribbal'] : '';
			$shoes_store_linkedin = isset( $shoes_store_instance['linkedin'] ) ? $shoes_store_instance['linkedin'] : '';
			$shoes_store_pinterest = isset( $shoes_store_instance['pinterest'] ) ? $shoes_store_instance['pinterest'] : '';
			$shoes_store_tumblr = isset( $shoes_store_instance['tumblr'] ) ? $shoes_store_instance['tumblr'] : '';
			

	        echo '<div class="custom-social-icons">';

	        if(!empty($shoes_store_title) ){ ?><h3 class="custom_title"><?php echo esc_html($shoes_store_title); ?></h3><?php } ?>
	        <?php if(!empty($shoes_store_facebook) ){ ?><p class="mb-0"><a class="custom_facebook fff" target= "_blank" href="<?php echo esc_url($shoes_store_facebook); ?>"><i class="fab fa-facebook-f"></i><span class="screen-reader-text"><?php esc_html_e( 'Facebook','shoes-store' );?></span></a></p><?php } ?>

	        <?php if(!empty($shoes_store_twitter) ){ ?><p class="mb-0"><a class="custom_twitter" target= "_blank" href="<?php echo esc_url($shoes_store_twitter); ?>"><i class="fa-brands fa-x-twitter"></i><span class="screen-reader-text"><?php esc_html_e( 'Twitter','shoes-store' );?></span></a></p><?php } ?>
	        
	        <?php if(!empty($shoes_store_instagram) ){ ?><p class="mb-0"><a class="custom_instagram" target= "_blank" href="<?php echo esc_url($shoes_store_instagram); ?>"><i class="fab fa-instagram"></i><span class="screen-reader-text"><?php esc_html_e( 'Instagram','shoes-store' );?></span></a></p><?php } ?>

	        <?php if(!empty($shoes_store_youtube) ){ ?><p class="mb-0"><a class="custom_youtube" target= "_blank" href="<?php echo esc_url($shoes_store_youtube); ?>"><i class="fab fa-youtube"></i><span class="screen-reader-text"><?php esc_html_e( 'Youtube','shoes-store' );?></span></a></p><?php } ?>

	        <?php if(!empty($shoes_store_dribbal) ){ ?><p class="mb-0"><a class="custom_dribbal" target= "_blank" href="<?php echo esc_url($shoes_store_dribbal); ?>"><i class="fa-solid fa-basketball"></i><span class="screen-reader-text"><?php esc_html_e( 'Dribbal','shoes-store' );?></span></a></p><?php } ?>

	        <?php if(!empty($shoes_store_linkedin) ){ ?><p class="mb-0"><a class="custom_linkedin" target= "_blank" href="<?php echo esc_url($shoes_store_linkedin); ?>"><i class="fab fa-linkedin-in"></i><span class="screen-reader-text"><?php esc_html_e( 'Linkedin','shoes-store' );?></span></a></p><?php } ?>
	        

	        <?php if(!empty($shoes_store_pinterest) ){ ?><p class="mb-0"><a class="custom_pinterest" target= "_blank" href="<?php echo esc_url($shoes_store_pinterest); ?>"><i class="fab fa-pinterest-p"></i><span class="screen-reader-text"><?php esc_html_e( 'Pinterest','shoes-store' );?></span></a></p><?php } ?>
	        

	        <?php if(!empty($shoes_store_tumblr) ){ ?><p class="mb-0"><a class="custom_tumblr" target= "_blank" href="<?php echo esc_url($shoes_store_tumblr); ?>"><i class="fab fa-tumblr"></i><span class="screen-reader-text"><?php esc_html_e( 'Tumblr','shoes-store' );?></span></a></p><?php } ?>

	        <?php echo '</div>';
			?>
		</div>
		<?php
	}
	
	// Widget Backend 
	public function form( $shoes_store_instance ) {

		$shoes_store_title= ''; $shoes_store_facebook = ''; $shoes_store_twitter = ''; $shoes_store_linkedin = '';  $shoes_store_pinterest = '';$shoes_store_tumblr = ''; $shoes_store_instagram = ''; $shoes_store_youtube = ''; 

		$shoes_store_title = isset( $shoes_store_instance['title'] ) ? $shoes_store_instance['title'] : '';
		$shoes_store_facebook = isset( $shoes_store_instance['facebook'] ) ? $shoes_store_instance['facebook'] : '';
		$shoes_store_instagram = isset( $shoes_store_instance['instagram'] ) ? $shoes_store_instance['instagram'] : '';
		$shoes_store_twitter = isset( $shoes_store_instance['twitter'] ) ? $shoes_store_instance['twitter'] : '';
		$shoes_store_youtube = isset( $shoes_store_instance['youtube'] ) ? $shoes_store_instance['youtube'] : '';
		$shoes_store_dribbal = isset( $shoes_store_instance['dribbal'] ) ? $shoes_store_instance['dribbal'] : '';
		$shoes_store_linkedin = isset( $shoes_store_instance['linkedin'] ) ? $shoes_store_instance['linkedin'] : '';
		$shoes_store_pinterest = isset( $shoes_store_instance['pinterest'] ) ? $shoes_store_instance['pinterest'] : '';
		$shoes_store_tumblr = isset( $shoes_store_instance['tumblr'] ) ? $shoes_store_instance['tumblr'] : '';
		
		?>
		<p>
        <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','shoes-store'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($shoes_store_title); ?>">
    	</p>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('facebook')); ?>"><?php esc_html_e('Facebook:','shoes-store'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('facebook')); ?>" name="<?php echo esc_attr($this->get_field_name('facebook')); ?>" type="text" value="<?php echo esc_attr($shoes_store_facebook); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('twitter')); ?>"><?php esc_html_e('Twitter:','shoes-store'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('twitter')); ?>" name="<?php echo esc_attr($this->get_field_name('twitter')); ?>" type="text" value="<?php echo esc_attr($shoes_store_twitter); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('instagram')); ?>"><?php esc_html_e('Instagram:','shoes-store'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram')); ?>" name="<?php echo esc_attr($this->get_field_name('instagram')); ?>" type="text" value="<?php echo esc_attr($shoes_store_instagram); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('youtube')); ?>"><?php esc_html_e('Youtube:','shoes-store'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('youtube')); ?>" name="<?php echo esc_attr($this->get_field_name('youtube')); ?>" type="text" value="<?php echo esc_attr($shoes_store_youtube); ?>">
		</p>
		<label for="<?php echo esc_attr($this->get_field_id('dribbal')); ?>"><?php esc_html_e('Dribbal:','shoes-store'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('dribbal')); ?>" name="<?php echo esc_attr($this->get_field_name('dribbal')); ?>" type="text" value="<?php echo esc_attr($shoes_store_dribbal); ?>">
		</p>

		<label for="<?php echo esc_attr($this->get_field_id('linkedin')); ?>"><?php esc_html_e('Linkedin:','shoes-store'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('linkedin')); ?>" name="<?php echo esc_attr($this->get_field_name('linkedin')); ?>" type="text" value="<?php echo esc_attr($shoes_store_linkedin); ?>">
		</p>
		<p>
		
		<label for="<?php echo esc_attr($this->get_field_id('pinterest')); ?>"><?php esc_html_e('Pinterest:','shoes-store'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('pinterest')); ?>" name="<?php echo esc_attr($this->get_field_name('pinterest')); ?>" type="text" value="<?php echo esc_attr($shoes_store_pinterest); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('tumblr')); ?>"><?php esc_html_e('Tumblr:','shoes-store'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('tumblr')); ?>" name="<?php echo esc_attr($this->get_field_name('tumblr')); ?>" type="text" value="<?php echo esc_attr($shoes_store_tumblr); ?>">
		</p>
		<p>
		
		<?php 
	}
	
	public function update( $shoes_store_new_instance, $shoes_store_old_instance ) {
		$shoes_store_instance = array();
		$shoes_store_instance['title'] = (!empty($shoes_store_new_instance['title']) ) ? strip_tags($shoes_store_new_instance['title']) : '';	
        $shoes_store_instance['facebook'] = (!empty($shoes_store_new_instance['facebook']) ) ? esc_url_raw($shoes_store_new_instance['facebook']) : '';
        $shoes_store_instance['twitter'] = (!empty($shoes_store_new_instance['twitter']) ) ? esc_url_raw($shoes_store_new_instance['twitter']) : '';
        $shoes_store_instance['instagram'] = (!empty($shoes_store_new_instance['instagram']) ) ? esc_url_raw($shoes_store_new_instance['instagram']) : '';
        $shoes_store_instance['youtube'] = (!empty($shoes_store_new_instance['youtube']) ) ? esc_url_raw($shoes_store_new_instance['youtube']) : '';
        $shoes_store_instance['dribbal'] = (!empty($shoes_store_new_instance['dribbal']) ) ? esc_url_raw($shoes_store_new_instance['dribbal']) : '';
        $shoes_store_instance['linkedin'] = (!empty($shoes_store_new_instance['linkedin']) ) ? esc_url_raw($shoes_store_new_instance['linkedin']) : '';
        $shoes_store_instance['pinterest'] = (!empty($shoes_store_new_instance['pinterest']) ) ? esc_url_raw($shoes_store_new_instance['pinterest']) : '';
        $shoes_store_instance['tumblr'] = (!empty($shoes_store_new_instance['tumblr']) ) ? esc_url_raw($shoes_store_new_instance['tumblr']) : '';
     	
     	
		return $shoes_store_instance;
	}
}

function shoes_store_custom_load_widget() {
	register_widget( 'Shoes_Store_Social_Widget' );
}
add_action( 'widgets_init', 'shoes_store_custom_load_widget' );