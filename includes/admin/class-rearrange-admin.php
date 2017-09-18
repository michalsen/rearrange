<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}


class RearrangeAdmin {

  public function __construct() {
    add_action('admin_init', array($this, 'wp_rearrange_admin_init'));
    add_action('admin_menu', array($this, 'admin_menu'));
  }

  public function admin_menu() {
    $page = add_management_page('Rearrange', 'Rearrange ', 'manage_options', 'rearrange', array( $this,'wp_rearrange_settings_page'));
  }


  function wp_rearrange_admin_init() {
    if(is_admin()){
      if ($_REQUEST['action'] == 'forward' ||
          $_REQUEST['action'] == 'back') {
        include(WP_PLUGIN_DIR. '/rearrange/includes/simple_html_dom.php');
        $posts = getPosts();
          foreach ($posts as $key => $value) {
            if (preg_match('/(<img .*?>)/', $value->post_content)) {
            $content = str_get_html($value->post_content);

            foreach($content->find('img') as $element) {
              $newOrderImage .= 'css="' . $element->attr['class'] . '"' ;
              $newOrderImage .= 'src="' . $element->attr['src'] . '"' ;
              $newOrderImage .= 'alt="' . $element->attr['alt'] . '"' ;
              $newOrderImage .= 'width="' . $element->attr['width'] . '"' ;
              $newOrderImage .= 'height="' . $element->attr['height'] . '"' ;
            }
            // $strippedContent = strip_tags($value->post_content, '<img>');
            $strippedContent = preg_replace("/<img[^>]+\>/i", " ", $value->post_content);
            $cleanedstrippedContent = str_replace("&nbsp;", '', $strippedContent);

            if ($_REQUEST['action'] == 'forward') {
              $newOrder = '<img ';
              $newOrder .= $newOrderImage;
              $newOrder .= '>';
              $newOrder .= $cleanedstrippedContent;
            }

            if ($_REQUEST['action'] == 'back') {
              $newOrder = $cleanedstrippedContent;
              $newOrder .= '<img ';
              $newOrder .= $newOrderImage;
              $newOrder .= '>';
            }

            global $wpdb;
            $wpdb->update(
                $wpdb->prefix . 'posts',
                array(
                    'post_content' => $newOrder,
                ),
                array( 'ID' => $value->ID,
                       'post_status' => 'publish')
            );

          }
        }
      }
    }
  }

  public function wp_rearrange_settings_page(){
    include('functions.php');

    include('rearrange_admin.tpl.php');
  }

}


return new RearrangeAdmin();


function getPosts() {
  global $wpdb;
  $sql = 'SELECT ID, post_content FROM ' . $wpdb->prefix . 'posts WHERE post_status = "publish"';
  $posts = $wpdb->get_results($sql);
  return $posts;
}
