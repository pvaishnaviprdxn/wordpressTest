<?php 
  //enqueued stylesheets
  function addstylesheet() {
    wp_enqueue_style('theme-style',get_stylesheet_uri(),array(),1.0);
  }
  add_action('wp_enqueue_scripts','addstylesheet');
  //Registering menu
  register_nav_menus(
    array(
    'primary' => __('Primary Menu'),
  ));
  //changing default menu structure
  function new_menu() {
    $menu_name = 'primary'; // specifing custom menu slug
    if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
      $menu = wp_get_nav_menu_object($locations[$menu_name]);
      $menu_items = wp_get_nav_menu_items($menu->term_id);

      $menu_list = '<nav>' ."\n";
      $menu_list .= "\t\t\t\t". '<ul>' ."\n";
      foreach ((array) $menu_items as $key => $menu_item) {
          $title = $menu_item->title;
          $url = $menu_item->url;
          $menu_list .= "\t\t\t\t\t". '<li><a href="'. $url .'">'. $title .'</a></li>' ."\n";
      }
      $menu_list .= "\t\t\t\t". '</ul>' ."\n";
      $menu_list .= "\t\t\t". '</nav>' ."\n";
    } 
    echo $menu_list;
  }
  //editor change
  add_filter('use_block_editor_for_post', '__return_false');

?>