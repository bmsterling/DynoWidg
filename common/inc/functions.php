<?php
function DynoWidg_load_widget() {
	register_widget( 'DynoWidg_Widget' );
}

function DynoWidg_add_css() {
	global $pagenow;
	if (is_admin() && $pagenow == 'widgets.php') {
		$css = plugins_url('/css/style.css', dirname(__FILE__) );
		wp_register_style("DynoWidg_css", $css);
		wp_enqueue_style("DynoWidg_css");
	}
}

function DynoWidg_print_scripts() {
	global $pagenow;
	if (is_admin() && $pagenow == 'widgets.php') {
		$js = plugins_url('/js/core.js', dirname(__FILE__) );
		wp_enqueue_script("DynoWidg_scripts", $js, Array("suggest"));
	}
}

function DynoWidg_singleCheck( $instance ){
	$type = get_post_type();
	if($type != 'page' and $type != 'post'){
		$show = isset($instance['type-'.$type]) ? ($instance['type-'.$type]) : false;
	}

	if(!isset($show)){
		foreach(get_the_category() as $cat){
			if ($show) continue;
			if (isset($instance['cat-'.$cat->cat_ID])){
				$show = $instance['cat-'.$cat->cat_ID];
			}
		} 
	}
}

function DynoWidg_showHide_widget( $instance ){
	global $wp_query;
	
	$show = true;
	
	$is_user_logged_in = is_user_logged_in();
	
	if( isset( $instance['authenicated'] ) && !empty( $instance['authenicated'] ) ){
		if( 
			( $instance['authenicated'] == 'loggedout' && $is_user_logged_in ) 
			&& 
			( $instance['authenicated'] == 'loggedin' && !$is_user_logged_in )
		){
			$show = false;
		}
	}
	else if( is_home() ){
		$show = $is_home = isset($instance['cond-is_home']) ? ($instance['cond-is_home']) : false;
	}
	else if( is_front_page() ){
		$show = $is_front_page = isset($instance['cond-is_front_page']) ? ($instance['cond-is_front_page']) : false;
	}
    else if ( is_single() ){
		$show = $is_single = isset($instance['cond-is_single']) ? ($instance['cond-is_single']) : false;
		
		if( !$show ){
			$show = DynoWidg_singleCheck( $instance );
		}
	}
    else if ( is_sticky() ){
		$show = $is_sticky = isset($instance['cond-is_sticky']) ? ($instance['cond-is_sticky']) : false;
	}
    else if ( is_page() ){
		$show = $is_page = isset($instance['cond-is_page']) ? ($instance['cond-is_page']) : false;
	}
    else if ( is_category() ){
		$show = $is_category = isset($instance['cond-is_category']) ? ($instance['cond-is_category']) : false;
		
		if( !$show ){
	        $show = isset($instance['cat-'.get_query_var('cat')]) ? ($instance['cat-'.get_query_var('cat')]) : false;
		}
	}
    else if ( is_tag() ){
		$show = $is_tag = isset($instance['cond-is_tag']) ? ($instance['cond-is_tag']) : false;
	}
    else if ( is_author() ){
		$show = $is_author = isset($instance['cond-is_author']) ? ($instance['cond-is_author']) : false;
	}
    else if ( is_date() ){
		$show = $is_date = isset($instance['cond-is_date']) ? ($instance['cond-is_date']) : false;
	}
    else if ( is_year() ){
		$show = $is_year = isset($instance['cond-is_year']) ? ($instance['cond-is_year']) : false;
	}
    else if ( is_month() ){
		$show = $is_month = isset($instance['cond-is_month']) ? ($instance['cond-is_month']) : false;
	}
    else if ( is_day() ){
		$show = $is_day = isset($instance['cond-is_day']) ? ($instance['cond-is_day']) : false;
	}
    else if ( is_time() ){
		$show = $is_time = isset($instance['cond-is_time']) ? ($instance['cond-is_time']) : false;
	}
    else if ( is_archive() ){
		$show = $is_archive = isset($instance['cond-is_archive']) ? ($instance['cond-is_archive']) : false;
	}
    else if ( is_search() ){
		$show = $is_search = isset($instance['cond-is_search']) ? ($instance['cond-is_search']) : false;
	}
    else if ( is_404() ){
		$show = $is_404 = isset($instance['cond-is_404']) ? ($instance['cond-is_404']) : false;
	}
    else if ( is_paged() ){
		$show = $is_paged = isset($instance['cond-is_paged']) ? ($instance['cond-is_paged']) : false;
	}
	else if ( is_singular() ){
		$show = $is_singular = isset($instance['cond-is_singular']) ? ($instance['cond-is_singular']) : false;
	}
	else{
		$post_id = $wp_query->get_queried_object_id();
		$show = isset($instance['page-'.$post_id]) ? ($instance['page-'.$post_id]) : false;
	}
	
	if( isset( $instance['specific'] ) && !empty( $instance['specific'] ) ){
		$specific = explode(',', $instance['specific']);
		foreach($specific as $item){
			if( is_numeric( $item ) ){
				if($post_id == (int)$item){
					$show = true;
				}
			}
			else if( is_slug( $item ) ){
				$show = true;
			}
		}
	}
	
	if (
		isset($instance['hideShow']) && 
		(
			($instance['hideShow'] == '1' && $show == false) 
			||
			($instance['hideShow'] == '0' && $show)
		)){
        return false;
	}
    else{}
	
	return $instance;
}

function DynoWidg_get_data(){
	global $DynoWidg_pages, $DynoWidg_category , $DynoWidg_contenttype, $DynoWidg_all;
	$last_saved = get_option('DynoWidg_lastsaved');
	
	if( !$DynoWidg_lastsaved || ( (time() - $last_saved) >= 120 ) ){
		$DynoWidg_pages = get_posts( array('post_type' => 'page', 'post_status' => 'publish', 'numberposts' => 999, 'orderby' => 'title', 'order' => 'ASC'));
		$DynoWidg_category = get_categories();
		$predefined = array(
				'revision',
				'post',
				'page',
				'attachment',
				'nav_menu_item'
			);
		$DynoWidg_contenttype = get_post_types(array(), 'object');
		unset( $DynoWidg_contenttype['revision'] );
		
		$keys = array_keys( $DynoWidg_contenttype );
		
		$DynoWidg_all = get_posts( array('post_type' => $keys, 'post_status' => 'publish', 'numberposts' => 999, 'orderby' => 'title', 'order' => 'ASC'));
		
        foreach( $predefined as $unset){
            unset($DynoWidg_contenttype[$unset]);
		}
		
        update_option('DynoWidg_pages', $DynoWidg_pages);
        update_option('DynoWidg_category', $DynoWidg_category);
        update_option('DynoWidg_contenttype',  $DynoWidg_category);
		update_option('DynoWidg_lastsaved', time());
	}
	else{
        $DynoWidg_pages 		= get_option('DynoWidg_pages');
        $DynoWidg_category 		= get_option('DynoWidg_category');
        $DynoWidg_contenttype 	= get_option('DynoWidg_contenttype');	
	}
}

?>