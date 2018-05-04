<?php

class ltm_banner_Pages_Widget extends WP_Widget {
     
    function __construct() {
     
        parent::__construct(
             
            // base ID of the widget
            'ltm_banner_pages_widget',
             
            // name of the widget
            __('LTM - Banner', 'ltm_banner' ),
             
            // widget options
            array (
                'description' => __( 'Sistema de Banners (Simples e Rotativos) com a possibilidade data de ativação e expiração.', 'ltm_banner' )
            )
             
        );
         
    }
     
    function form( $instance ) {
        $ltm_banner = $instance[ 'ltm_banners' ];
		global $wpdb;
		$query = "SELECT * FROM {$wpdb->prefix}ltm_banners WHERE (start_date <= '". date('Y-m-d') ."' AND end_date >= '". date('Y-m-d') ."') GROUP BY group_id";
		$ltm_banners = $wpdb->get_results( $query, OBJECT );
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'ltm_banners' ); ?>">Selecione os banners cadastrados</label>
			<select id="<?php echo $this->get_field_name( 'ltm_banners' ); ?>" name="<?php echo $this->get_field_name( 'ltm_banners' ); ?>">
			<?php
			foreach ($ltm_banners as $banner) {
				?>
				<option <?php echo esc_attr( $ltm_banner ) == $banner->group_id ? "selected='true'" : ""; ?> value="<?php echo $banner->group_id ?>"><?php echo $banner->name ?></option>
				<?php
			}
			?>
			</select>
		</p>
		<?php
    }
     
    function update( $new_instance, $old_instance ) {
     
        $instance = $old_instance;
        $instance[ 'ltm_banners' ] = strip_tags( $new_instance[ 'ltm_banners' ] );
        return $instance;
         
    }
     
    function widget( $args, $instance ) {
		
		$ltm_banner = $instance[ 'ltm_banners' ];
		global $wpdb;
		$query = "SELECT * FROM {$wpdb->prefix}ltm_banners WHERE (start_date <= '". date('Y-m-d H:i:s') ."' AND (end_date >= '". date('Y-m-d H:i:s') ."')) AND group_id='". $ltm_banner ."'";
        $ltm_banners = $wpdb->get_results( $query, OBJECT );
		?>
				<div id="<?php echo $args['id'] ?>_<?php echo $ltm_banner ?>" class="owl-carousel slide">
					<?php
						foreach ($ltm_banners as $k => $lb) {
							?>
							<div class="<?php echo $k == 0 ? "active" : "" ?>">
								<img class="d-block w-100" src="<?php echo $lb->image ?>" alt="<?php echo $lb->name ?>">
							</div>
							<?php
						}
					?>
				</div>
		<?php
    }
     
}


function ltm_banner_register_widget() {
 
    register_widget( 'ltm_banner_Pages_Widget' );
 
}
add_action( 'widgets_init', 'ltm_banner_register_widget' );