<?php
/*
Plugin Name: LTM - Sistema de Banners
Description: Sistema de Banners (Simples e Rotativos) com a possibilidade data de ativação e expiração. 
Author: the LTM Frontend team
Author URI: http://www.grupoltm.com.br
Version: 1.0.0
Source: https://github.com/grupoltm/wordpress-banners
*/


define ( 'ltm_banners_url', plugin_dir_url(__FILE__));
define ( 'ltm_banners_dir',  plugin_dir_path( __FILE__ ));
function ltm_banners_plugin_menu() {
	add_menu_page('LTM - Banners' , 'LTM - Banners', 'manage_options', 'ltm_page_banner', 'ltm_page_banner', ltm_banners_url . '/assets/img/favicon-16x16.png' , 1);		
}
add_action('admin_menu', 'ltm_banners_plugin_menu');


function ltm_banners_table()
{
    global $table_prefix, $wpdb;

    $tblname = 'ltm_banners';
    $wp_track_table = $table_prefix . "$tblname";

    if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table) 
    {

        $sql = "CREATE TABLE `". $wp_track_table . "` ( ";
        $sql .= "  `id`  int(11)   NOT NULL auto_increment, ";
        $sql .= "  `group_id`  varchar(255) NOT NULL, ";
        $sql .= "  `name`  varchar(255)   NOT NULL, ";
        $sql .= "  `link`  varchar(255)   NOT NULL, ";
        $sql .= "  `image`  varchar(255)   NOT NULL, ";
        $sql .= "  `start_date`  date   NOT NULL, ";
        $sql .= "  `end_date`  date   NOT NULL, ";
        $sql .= "  `start_hour`  int(2)   NOT NULL, ";
        $sql .= "  `start_minute`  int(2)   NOT NULL, ";
        $sql .= "  `end_minute`  int(2)   NOT NULL, ";
        $sql .= "  `end_hour`  int(2)   NOT NULL, ";
        $sql .= "  PRIMARY KEY `id` (`id`) "; 
        $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
        
		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
        $r =  dbDelta($sql);
    }
}
ltm_banners_table();
//register_activation_hook( __FILE__, 'ltm_banners_table' );

function ltm_banners_js() {
 if (isset($_GET['page']) && $_GET['page'] == 'ltm_page_banner')
	 {
		
		wp_register_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.js');
		wp_enqueue_script('jquery');
		
		wp_register_script('datepicker', ltm_banners_url.'assets/js/bootstrap-datepicker.js');
		wp_enqueue_script('datepicker');
		
		wp_enqueue_media();
	 }
}

function ltm_banners_styles() {
	if (isset($_GET['page']) && $_GET['page'] == 'ltm_page_banner') {
		 wp_register_style('bootstrap', ltm_banners_url.'assets/css/bootstrap.css');
		 wp_enqueue_style('bootstrap');
		 
		 wp_register_style('datepicker', ltm_banners_url.'assets/css/bootstrap-datepicker.css');
		 wp_enqueue_style('datepicker');
		 
		 wp_register_style('custom', ltm_banners_url.'assets/css/custom.css?v=' . date('his'));
	 }

}

add_action('admin_print_scripts', 'ltm_banners_js');
add_action('admin_print_styles', 'ltm_banners_styles');


function ltm_banners_styles_front()
{
   wp_register_style( 'carousel_css', ltm_banners_url.'assets/css/owl.carousel.min.css', array(), date('his'), 'all' );
   wp_enqueue_style( 'carousel_css' );
   
   	wp_register_script('carousel_js', ltm_banners_url.'assets/js/owl.carousel.min.js', array(), date('his'),  true);
	wp_enqueue_script('carousel_js');
	
	wp_register_script('custom_exec', ltm_banners_url.'assets/js/ltm-banner_f.js', array(), date('his'),  true);
	wp_enqueue_script('custom_exec');
}
add_action( 'wp_enqueue_scripts', 'ltm_banners_styles_front' );
 
function ltm_post() {
	
	if ($_POST['page'] == 'ltm_page_banner' && $_POST['task'] == 'ltm_add') {
		
		

		
		global $table_prefix, $wpdb;
		
		$tblname = 'ltm_banners';
		$wp_track_table = $table_prefix . "$tblname";
				
		$banners = $_POST['banners'];
		$arra = array();
		$group_id = md5(uniqid(rand(), true));
		
		
		
		foreach ($banners as $k => $b) {
			if ($k != 0) {
				$arra[0]['group_id'] = $group_id;
				$arra[0]['name'] = $_POST['bannerName'];
				$arra[0]['start_date'] = implode("-", array_reverse( explode("/", $_POST['data_inicio'][$k]))) . " " .  $_POST['hora_inicio'][$k] . ":" . $_POST['minuto_inicio'][$k] . ":00";
				$arra[0]['end_date'] = implode("-", array_reverse( explode("/", $_POST['data_final'][$k]))) . " " .  $_POST['hora_final'][$k] . ":" . $_POST['minuto_final'][$k] . ":00";
				$arra[0]['image'] = $b;
				$arra[0]['link'] = isset($_POST['link'][$k]) ? $_POST['link'][$k] : "#";
				
				$ins = "INSERT INTO " . $wp_track_table . " SET ";
				$crit = array();
				
				
				foreach ($arra[0] as $k=>$a) {
					$crit[] = $k . "='" . $a ."'";
				}
				$ins .= implode(", ", $crit);
				$wpdb->query(
					$ins
				);
				
			}
		}
		
	}
	
	if ($_POST['page'] == 'ltm_page_banner' && $_POST['task'] == 'ltm_edit') {
		

		global $table_prefix, $wpdb;
		
		$tblname = 'ltm_banners';
		$wp_track_table = $table_prefix . "$tblname";
				
		$banners = $_POST['banners'];
		$data_inicio = $_POST['data_inicio'];
		$arra = array();
		$group_id = $_POST['i'];
		

		$wpdb->query( "DELETE FROM $wp_track_table WHERE group_id ='". $group_id ."' " . $atual );
		
		foreach ($data_inicio as $k => $b) {
			if ($k != 0) {
				$arra[0]['group_id'] = $group_id;
				$arra[0]['name'] = $_POST['bannerName'];
				$arra[0]['start_date'] = implode("-", array_reverse( explode("/", $_POST['data_inicio'][$k]))) . " " .  $_POST['hora_inicio'][$k] . ":" . $_POST['minuto_inicio'][$k] . ":00";
				$arra[0]['end_date'] = implode("-", array_reverse( explode("/", $_POST['data_final'][$k]))) . " " .  $_POST['hora_final'][$k] . ":" . $_POST['minuto_final'][$k] . ":00";
				$arra[0]['image'] = isset($_POST['banners_atual'][$k]) ? $_POST['banners_atual'][$k] : $banners[$k];
				
				$arra[0]['link'] = isset($_POST['link'][$k]) ? $_POST['link'][$k] : "#";
				
				$ins = "INSERT INTO " . $wp_track_table . " SET ";
				$crit = array();
				
				
				foreach ($arra[0] as $k=>$a) {
					$crit[] = $k . "='" . $a ."'";
				}
				$ins .= implode(", ", $crit);
				$wpdb->query(
					$ins
				);
				
			}
		}
	}
}
add_action( 'init', 'ltm_post', 10, 3 );
function ltm_get(){
	if ($_GET['page'] == 'ltm_page_banner' && $_GET['task'] == 'ltm_delete') {
		global $table_prefix, $wpdb;
		
		$tblname = 'ltm_banners';
		$wp_track_table = $table_prefix . "$tblname";
		$group_id = $_GET['i'];
		
		
		$query = "DELETE FROM $wp_track_table WHERE group_id ='". $group_id ."'";
		$wpdb->query( $query );
		 wp_redirect( admin_url( 'admin.php?page=ltm_page_banner' ) );
	}
}
add_action( 'init', 'ltm_get', 10, 3 );
function ltm_page_banner() {

	if (isset($_GET['page']) && $_GET['page'] == 'ltm_page_banner' && isset($_GET['task'])) {
		if ($_GET['task'] == 'ltm_add') {
			require(ltm_banners_dir . "pages/form.php");
		}
		if ($_GET['task'] == 'ltm_edit') {
			require(ltm_banners_dir . "pages/form.php");
		}
	} else {
		
		require(ltm_banners_dir . "pages/list.php");
	}
	
}

// Include Widget
require_once(ltm_banners_dir . "inc/widget.php");


?>