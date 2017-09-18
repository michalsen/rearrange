<?php
/*
Plugin Name: Rearrange
Plugin URI: http://localhost
Description: Bad apple
Version:     1
Author: Eric L. Michalsen
Author URI: michalsengroup.com
*/

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

// If admin include admin functions
if('admin'){
    include_once( 'includes/admin/class-rearrange-admin.php' );
}
