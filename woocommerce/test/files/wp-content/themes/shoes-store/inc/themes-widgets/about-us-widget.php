<?php
/**
 * Custom About us Widget
 */

class Shoes_Store_About_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'Shoes_Store_About_Widget',
			__('VW About us', 'shoes-store'),
			array( 'description' => __( 'Widget for about us section in sidebar', 'shoes-store' ), ) 
		);
	}
	
	public function widget( $shoes_store_args, $shoes_store_instance ) {
		?>
		<aside class="widget">
			<?php
			$shoes_store_title = isset( $shoes_store_instance['title'] ) ? $shoes_store_instance['title'] : '';
			$shoes_store_author = isset( $shoes_store_instance['author'] ) ? $shoes_store_instance['author'] : '';
			$shoes_store_designation = isset( $shoes_store_instance['designation'] ) ? $shoes_store_instance['designation'] : '';
			$shoes_store_description = isset( $shoes_store_instance['description'] ) ? $shoes_store_instance['description'] : '';
			$shoes_store_read_more_url = isset( $shoes_store_instance['read_more_url'] ) ? $shoes_store_instance['read_more_url'] : '';
			$shoes_store_read_more_text = isset( $shoes_store_instance['read_more_text'] ) ? $shoes_store_instance['read_more_text'] : '';
			$shoes_store_upload_image = isset( $shoes_store_instance['upload_image'] ) ? $shoes_store_instance['upload_image'] : '';

	        echo '<div class="custom-about-us">';
	        if(!empty($shoes_store_title) ){ ?><h3 class="custom_title"><?php echo esc_html($shoes_store_title); ?></h3><?php } ?>
		        <?php if($shoes_store_upload_image): ?>
	      			<img src="<?php echo esc_url($shoes_store_upload_image); ?>" alt="">
				<?php endif; ?>
				<?php if(!empty($shoes_store_author) ){ ?><p class="custom_author"><?php echo esc_html($shoes_store_author); ?></p><?php } ?>
				<?php if(!empty($shoes_store_designation) ){ ?><p class="custom_designation"><?php echo esc_html($shoes_store_designation); ?></p><?php } ?>
		        <?php if(!empty($shoes_store_description) ){ ?><p class="custom_desc"><?php echo esc_html($shoes_store_description); ?></p><?php } ?>
		        <?php if(!empty($shoes_store_read_more_url) ){ ?><div class="more-button"><a class="custom_read_more" href="<?php echo esc_url($shoes_store_read_more_url); ?>"><?php if(!empty($shoes_store_read_more_text) ){ ?><?php echo esc_html($shoes_store_read_more_text); ?><?php } ?></a></div><?php } ?>
	        <?php echo '</div>';
			?>
		</aside>
		<?php
	}
	
	// Widget Backend 
	public function form( $shoes_store_instance ) {	

		$shoes_store_title= ''; $shoes_store_author = ''; $shoes_store_designation = ''; $shoes_store_description= ''; $shoes_store_read_more_text = ''; $shoes_store_read_more_url = ''; $shoes_store_upload_image = '';

		$shoes_store_title = isset( $shoes_store_instance['title'] ) ? $shoes_store_instance['title'] : '';
		$shoes_store_author = isset( $shoes_store_instance['author'] ) ? $shoes_store_instance['author'] : '';
		$shoes_store_designation = isset( $shoes_store_instance['designation'] ) ? $shoes_store_instance['designation'] : '';
		$shoes_store_description = isset( $shoes_store_instance['description'] ) ? $shoes_store_instance['description'] : '';
		$shoes_store_read_more_url = isset( $shoes_store_instance['read_more_url'] ) ? $shoes_store_instance['read_more_url'] : '';
		$shoes_store_read_more_text = isset( $shoes_store_instance['read_more_text'] ) ? $shoes_store_instance['read_more_text'] : '';
		$shoes_store_upload_image = isset( $shoes_store_instance['upload_image'] ) ? $shoes_store_instance['upload_image'] : '';
	?>
		<p>
        <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','shoes-store'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($shoes_store_title); ?>">
    	</p>
    	<p>
        <label for="<?php echo esc_attr($this->get_field_id('author')); ?>"><?php esc_html_e('Author Name:','shoes-store'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('author')); ?>" name="<?php echo esc_attr($this->get_field_name('author')); ?>" type="text" value="<?php echo esc_attr($shoes_store_author); ?>">
    	</p>
    	<p>
        <label for="<?php echo esc_attr($this->get_field_id('designation')); ?>"><?php esc_html_e('Designation:','shoes-store'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('designation')); ?>" name="<?php echo esc_attr($this->get_field_name('designation')); ?>" type="text" value="<?php echo esc_attr($shoes_store_designation); ?>">
    	</p>
    	<p>
        <label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Description:','shoes-store'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>" type="text" value="<?php echo esc_attr($shoes_store_description); ?>">
    	</p>
    	<p>
		<label for="<?php echo esc_attr($this->get_field_id('read_more_text')); ?>"><?php esc_html_e('Button Text:','shoes-store'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('read_more_text')); ?>" name="<?php echo esc_attr($this->get_field_name('read_more_text')); ?>" type="text" value="<?php echo esc_attr($shoes_store_read_more_text); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('read_more_url')); ?>"><?php esc_html_e('Button Url:','shoes-store'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('read_more_url')); ?>" name="<?php echo esc_attr($this->get_field_name('read_more_url')); ?>" type="text" value="<?php echo esc_attr($shoes_store_read_more_url); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'upload_image' )); ?>"><?php esc_html_e( 'Image Url:','shoes-store'); ?></label>
		<?php
			if ( $shoes_store_upload_image != '' ) :
			echo '<img class="custom_media_image" src="' . esc_url($shoes_store_upload_image) . '" style="margin:10px 0;padding:0;max-width:100%;float:left;display:inline-block" /><br />';
			endif;
		?>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'upload_image' ) ); ?>" name="<?php echo esc_attr($this->get_field_name( 'upload_image' )); ?>" type="text" value="<?php echo esc_url( $shoes_store_upload_image ); ?>" />
	   	</p>
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $shoes_store_new_instance, $shoes_store_old_instance ) {
		$shoes_store_instance = array();	
		$shoes_store_instance['title'] = (!empty($shoes_store_new_instance['title']) ) ? strip_tags($shoes_store_new_instance['title']) : '';
		$shoes_store_instance['author'] = ( ! empty( $shoes_store_new_instance['author'] ) ) ? strip_tags($shoes_store_new_instance['author']) : '';
		$shoes_store_instance['designation'] = ( ! empty( $shoes_store_new_instance['designation'] ) ) ? strip_tags($shoes_store_new_instance['designation']) : '';
		$shoes_store_instance['description'] = (!empty($shoes_store_new_instance['description']) ) ? strip_tags($shoes_store_new_instance['description']) : '';
        $shoes_store_instance['read_more_text'] = (!empty($shoes_store_new_instance['read_more_text']) ) ? strip_tags($shoes_store_new_instance['read_more_text']) : '';
        $shoes_store_instance['read_more_url'] = (!empty($shoes_store_new_instance['read_more_url']) ) ? esc_url_raw($shoes_store_new_instance['read_more_url']) : '';
        $shoes_store_instance['upload_image'] = ( ! empty( $shoes_store_new_instance['upload_image'] ) ) ? strip_tags($shoes_store_new_instance['upload_image']) : '';

		return $shoes_store_instance;
	}
}
// Register and load the widget
function shoes_store_about_custom_load_widget() {
	register_widget( 'Shoes_Store_About_Widget' );
}
add_action( 'widgets_init', 'shoes_store_about_custom_load_widget' );