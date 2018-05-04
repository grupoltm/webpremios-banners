	<?php
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