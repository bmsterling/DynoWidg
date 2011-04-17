<?php
class DynoWidg_Widget extends WP_Widget {
	function DynoWidg_Widget(){
		$widget_args = array( 
			'classname' => 'dynowidg-widget', 
			'description' => __('A widget that grabs specific content and shows on specific pages or content types.', 'dynowidg') 
		);
		
		$control_args = array( 
			'width' => 300, 
			'height' => 350, 
			'id_base' => 'dynowidg-widget'
		);
		
		$this->WP_Widget( 
			'dynowidg-widget', __('DynoWidg', 'dynowidg'), 
			$widget_args, $control_args 
		);
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		$title = apply_filters('widget_title', $title, $instance, $this->id_base);
		
		preg_match('/(.*class=")(.*)(".*)/', $before_widget, $before_widget_result);
		

		echo $before_widget_result[1].
				$before_widget_result[2].' '.
				$dcw_cls.
				$before_widget_result[3];
				
		if ( $title && $showheader != '0' ){
			echo $before_title . $title . $after_title;
		}

		$thepost = get_post( $cid );
		
		$thepost->post_content = apply_filters('the_content', $thepost->post_content);
		$thepost->post_content = str_replace(']]>', ']]&gt;', $thepost->post_content);
		echo $thepost->post_content;
		
		echo $after_widget;
	}
	
	function form( $instance ){
		global $DynoWidg_pages, $DynoWidg_category , $DynoWidg_contenttype,$DynoWidg_conditional, $DynoWidg_all;
		
		DynoWidg_get_data();
		
		$instance = wp_parse_args(
						(array) $instance, 
						array( 
							'title' => '',
							'showheader' => true,
							'cls' => '',
							'cid' => -1,
							'hideShow'=> false,
							'loggedout' => false,
							'loggedin' => false,
							'authenicated' => '',
							'specific' => ''
						) 
					);

		include( 'form.php' );
	}

	function update( $new_instance, $old_instance ) {
		global $DynoWidg_pages, $DynoWidg_category , $DynoWidg_contenttype,$DynoWidg_conditional, $DynoWidg_all,$firephp;
		
		DynoWidg_get_data();
		
		$instance = $old_instance;
		print_r( $new_instance );
		$new_instance = wp_parse_args(
						(array) $new_instance, 
						array( 
							'title' => '',
							'showheader' => true,
							'cls' => '',
							'cid' => -1,
							'hideShow'=> false,
							'loggedout' => false,
							'loggedin' => false,
							'authenicated' => false,
							'specific' => ''
						) 
					);
// if ( !class_exists('FB') )
	// require_once( 'F:\My Dropbox\..sites\plugins\Wordpress\wp-content\plugins\wp-firephp/FirePHPCore/fb.php' );
// $firephp = FirePHP::getInstance(true);

					
		$instance['title'] 		= strip_tags($new_instance['title']);
		$instance['showheader'] = strip_tags($new_instance['showheader']);
		$instance['cls'] 		= strip_tags($new_instance['cls']);
		$instance['cid'] 		= strip_tags($new_instance['cid']);
		$instance['hideShow'] 	= strip_tags($new_instance['hideShow']);
		$instance['loggedout'] 	= strip_tags($new_instance['loggedout']);
		$instance['loggedin'] 	= strip_tags($new_instance['loggedin']);
		$instance['specific'] 	= strip_tags($new_instance['specific']);
		$instance['authenicated'] 	= strip_tags($new_instance['authenicated']);
		
		
		
		foreach ($DynoWidg_pages as $page){ 
			$instance['page-'.$page->ID] = isset($new_instance['page-'.$page->ID]) ?  true : false; 
		}
		
		foreach ($DynoWidg_conditional as $key => $label){
			$instance['cond-'. $key] = isset($new_instance['cond-'. $key]) ? true : false; 
		}
		
		foreach ($DynoWidg_category as $cat){ 
			$instance['cat-'.$cat->cat_ID] = isset($new_instance['cat-'.$cat->cat_ID]) ? true : false;   
		}
		
		foreach ($DynoWidg_contenttype as $post_key => $custom_post){ 
			$instance['type-'. $post_key] = isset($new_instance['type-'. $post_key]) ? true : false;
		}

		return $instance;
	}
}
?>