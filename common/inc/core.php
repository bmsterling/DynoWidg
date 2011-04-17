<?php
require( 'vars.php' );
require( 'functions.php' );
require( 'widget.php' );


add_filter('widget_display_callback', 'DynoWidg_showHide_widget');
add_action( 'widgets_init', 'DynoWidg_load_widget' );
add_action( 'admin_print_scripts', 'DynoWidg_print_scripts');
add_action( 'admin_init', 'DynoWidg_add_css');
?>