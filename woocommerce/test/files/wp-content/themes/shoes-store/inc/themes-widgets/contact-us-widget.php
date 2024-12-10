<?php
/**
 * Custom Contact us Widget
 */

class Shoes_Store_Contact_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'Shoes_Store_Contact_Widget', 
			__('VW Contact us', 'shoes-store'),
			array( 'description' => __( 'Widget for contact us section in sidebar', 'shoes-store' ), ) 
		);
	}
	
	public function widget( $shoes_store_args, $shoes_store_instance ) {
		?>
		<aside class="widget">
			<?php
			$shoes_store_title = isset( $shoes_store_instance['title'] ) ? $shoes_store_instance['title'] : '';
			$shoes_store_phone = isset( $shoes_store_instance['phone'] ) ? $shoes_store_instance['phone'] : '';
			$shoes_store_email = isset( $shoes_store_instance['email'] ) ? $shoes_store_instance['email'] : '';
			$shoes_store_address = isset( $shoes_store_instance['address'] ) ? $shoes_store_instance['address'] : '';
			$shoes_store_timing = isset( $shoes_store_instance['timing'] ) ? $shoes_store_instance['timing'] : '';
			$shoes_store_longitude = isset( $shoes_store_instance['longitude'] ) ? $shoes_store_instance['longitude'] : '';
			$shoes_store_latitude = isset( $shoes_store_instance['latitude'] ) ? $shoes_store_instance['latitude'] : '';
			$shoes_store_contact_form = isset( $shoes_store_instance['contact_form'] ) ? $shoes_store_instance['contact_form'] : '';

	        echo '<div class="custom-contact-us">';
	        if(!empty($shoes_store_title) ){ ?><h3 class="custom_title1"><?php echo esc_html($shoes_store_title); ?></h3><?php } ?>
		        <?php if(!empty($shoes_store_phone) ){ ?>
		        	<div class="row contact-detail">
		        		<div class="col-lg-2 col-md-2 align-self-center">
		        			<span class="custom_details"><i class="fa-solid fa-phone-volume me-2"></i></span>
		        		</div>
		        		<div class="col-lg-10 col-md-10 align-self-center">
		        			<span class="contact-title"><?php echo esc_html('Contact', 'shoes-store'); ?></span><span class="custom_desc"><?php echo esc_html($shoes_store_phone); ?></span>
		        		</div>		        		
		        	</div>
		        <?php } ?>
		        <?php if(!empty($shoes_store_email) ){ ?>
		        	<div class="row contact-detail">
		        		<div class="col-lg-2 col-md-2 align-self-center">
		        			<span class="custom_details"><i class="fa-regular fa-envelope me-2"></i></span>
		        		</div>
		        		<div class="col-lg-10 col-md-10 align-self-center">
		        			<span class="contact-title"><?php echo esc_html('Mail Address', 'shoes-store'); ?></span><span class="custom_desc"><?php echo esc_html($shoes_store_email); ?></span>
		        		</div>
		        	</div>
		        <?php } ?>
		        <?php if(!empty($shoes_store_address) ){ ?>
		        	<div class="row contact-detail">
		        		<div class="col-lg-2 col-md-2 align-self-center">
		        			<span class="custom_details"><i class="fa-solid fa-location-dot me-2"></i></span>
		        		</div>
			        	<div class="col-lg-10 col-md-10 align-self-center">
			        		<span class="contact-title"><?php echo esc_html('Location', 'shoes-store'); ?></span><span class="custom_desc"><?php echo esc_html($shoes_store_address); ?></span>
			        	</div>
			        </div>
			    <?php } ?> 
		        <?php if(!empty($shoes_store_timing) ){ ?><p><span class="custom_details"><?php esc_html_e('Opening Time: ','shoes-store'); ?></span><span class="custom_desc"><?php echo esc_html($shoes_store_timing); ?></span></p><?php } ?>
		        <?php if(!empty($shoes_store_longitude) ){ ?><embed width="100%" height="200px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo esc_html($shoes_store_longitude); ?>,<?php echo esc_html($shoes_store_latitude); ?>&hl=es;z=14&amp;output=embed"></embed><?php } ?>
		        <?php if(!empty($shoes_store_contact_form) ){ ?><?php echo do_shortcode($shoes_store_contact_form); ?><?php } ?>
	        <?php echo '</div>';
			?>
		</aside>
		<?php
	}
	
	// Widget Backend 
	public function form( $shoes_store_instance ) {

		$shoes_store_title= ''; $shoes_store_phone= ''; $shoes_store_email = ''; $shoes_store_address = ''; $shoes_store_timing = ''; $shoes_store_longitude = ''; $shoes_store_latitude = ''; $shoes_store_contact_form = ''; 
		
		$shoes_store_title = isset( $shoes_store_instance['title'] ) ? $shoes_store_instance['title'] : '';
		$shoes_store_phone = isset( $shoes_store_instance['phone'] ) ? $shoes_store_instance['phone'] : '';
		$shoes_store_email = isset( $shoes_store_instance['email'] ) ? $shoes_store_instance['email'] : '';
		$shoes_store_address = isset( $shoes_store_instance['address'] ) ? $shoes_store_instance['address'] : '';
		$shoes_store_timing = isset( $shoes_store_instance['timing'] ) ? $shoes_store_instance['timing'] : '';
		$shoes_store_longitude = isset( $shoes_store_instance['longitude'] ) ? $shoes_store_instance['longitude'] : '';
		$shoes_store_latitude = isset( $shoes_store_instance['latitude'] ) ? $shoes_store_instance['latitude'] : '';
		$shoes_store_contact_form = isset( $shoes_store_instance['contact_form'] ) ? $shoes_store_instance['contact_form'] : '';
		
		?>

		<p>
        	<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','shoes-store'); ?></label>
        	<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($shoes_store_title); ?>">
    	</p>
    	<p>
        	<label for="<?php echo esc_attr($this->get_field_id('phone')); ?>"><?php esc_html_e('Phone Number:','shoes-store'); ?></label>
        	<input class="widefat" id="<?php echo esc_attr($this->get_field_id('phone')); ?>" name="<?php echo esc_attr($this->get_field_name('phone')); ?>" type="text" value="<?php echo esc_attr($shoes_store_phone); ?>">
    	</p>
    	<p>
        	<label for="<?php echo esc_attr($this->get_field_id('email')); ?>"><?php esc_html_e('Email id:','shoes-store'); ?></label>
        	<input class="widefat" id="<?php echo esc_attr($this->get_field_id('email')); ?>" name="<?php echo esc_attr($this->get_field_name('email')); ?>" type="text" value="<?php echo esc_attr($shoes_store_email); ?>">
    	</p>
    	<p>
        	<label for="<?php echo esc_attr($this->get_field_id('address')); ?>"><?php esc_html_e('Address:','shoes-store'); ?></label>
        	<input class="widefat" id="<?php echo esc_attr($this->get_field_id('address')); ?>" name="<?php echo esc_attr($this->get_field_name('address')); ?>" type="text" value="<?php echo esc_attr($shoes_store_address); ?>">
    	</p>
    	<p>
        	<label for="<?php echo esc_attr($this->get_field_id('timing')); ?>"><?php esc_html_e('Opening Time:','shoes-store'); ?></label>
        	<input class="widefat" id="<?php echo esc_attr($this->get_field_id('timing')); ?>" name="<?php echo esc_attr($this->get_field_name('timing')); ?>" type="text" value="<?php echo esc_attr($shoes_store_timing); ?>">
    	</p>
    	<p>
        	<label for="<?php echo esc_attr($this->get_field_id('longitude')); ?>"><?php esc_html_e('Longitude:','shoes-store'); ?></label>
        	<input class="widefat" id="<?php echo esc_attr($this->get_field_id('longitude')); ?>" name="<?php echo esc_attr($this->get_field_name('longitude')); ?>" type="text" value="<?php echo esc_attr($shoes_store_longitude); ?>">
    	</p>
    	<p>
        	<label for="<?php echo esc_attr($this->get_field_id('latitude')); ?>"><?php esc_html_e('Latitude:','shoes-store'); ?></label>
        	<input class="widefat" id="<?php echo esc_attr($this->get_field_id('latitude')); ?>" name="<?php echo esc_attr($this->get_field_name('latitude')); ?>" type="text" value="<?php echo esc_attr($shoes_store_latitude); ?>">
    	</p>
    	<p>
        	<label for="<?php echo esc_attr($this->get_field_id('contact_form')); ?>"><?php esc_html_e('Contact Form Shortcode:','shoes-store'); ?></label>
        	<input class="widefat" id="<?php echo esc_attr($this->get_field_id('contact_form')); ?>" name="<?php echo esc_attr($this->get_field_name('contact_form')); ?>" type="text" value="<?php echo esc_attr($shoes_store_contact_form); ?>">
    	</p>
		
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $shoes_store_new_instance, $shoes_store_old_instance ) {
		$shoes_store_instance = array();	
		$shoes_store_instance['title'] = (!empty($shoes_store_new_instance['title']) ) ? strip_tags($shoes_store_new_instance['title']) : '';
		$shoes_store_instance['phone'] = (!empty($shoes_store_new_instance['phone']) ) ? shoes_store_sanitize_phone_number($shoes_store_new_instance['phone']) : '';
		$shoes_store_instance['email'] = (!empty($shoes_store_new_instance['email']) ) ? sanitize_email($shoes_store_new_instance['email']) : '';
		$shoes_store_instance['address'] = (!empty($shoes_store_new_instance['address']) ) ? strip_tags($shoes_store_new_instance['address']) : '';
		$shoes_store_instance['timing'] = (!empty($shoes_store_new_instance['timing']) ) ? strip_tags($shoes_store_new_instance['timing']) : '';
		$shoes_store_instance['longitude'] = (!empty($shoes_store_new_instance['longitude']) ) ? strip_tags($shoes_store_new_instance['longitude']) : '';
		$shoes_store_instance['latitude'] = (!empty($shoes_store_new_instance['latitude']) ) ? strip_tags($shoes_store_new_instance['latitude']) : '';
		$shoes_store_instance['contact_form'] = (!empty($shoes_store_new_instance['contact_form']) ) ? strip_tags($shoes_store_new_instance['contact_form']) : '';
        
		return $shoes_store_instance;
	}
}
// Register and load the widget
function shoes_store_contact_custom_load_widget() {
	register_widget( 'Shoes_Store_Contact_Widget' );
}
add_action( 'widgets_init', 'shoes_store_contact_custom_load_widget' );