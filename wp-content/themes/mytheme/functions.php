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

  //custom post type function
  function custom_post_grades() {
    $labels = array (
      'name' => _x('Grades','Post Type General Name', 'mytheme'),
      'singular_name' => _x('Grades','Post Type General Name', 'mytheme'),
      'menu_name' => __('Grades', 'mytheme'),
      'parent_item_colon' => __( 'Parent Grades', 'mytheme' ),
      'all_items'           => __( 'Grades', 'mytheme' ),
      'view_item'           => __( 'View Grade', 'mytheme' ),
      'add_new_item'        => __( 'Add New Grade', 'mytheme' ),
      'add_new'             => __( 'Add New Grade', 'mytheme' ),
      'edit_item'           => __( 'Edit Grade', 'mytheme' ),
      'update_item'         => __( 'Update Grade', 'mytheme' ),
      'search_items'        => __( 'Search Grade', 'mytheme' ),
      'not_found'           => __( 'Not Found', 'mytheme' ),
      'not_found_in_trash'  => __( 'Not found in Trash', 'mytheme' ),
    );
    $args = array (
      'label' => __('Grades', 'mytheme'),
      'description' => __('Grade Details','mytheme'),
      'labels' => $labels,
      // Features this CPT supports in Post Editor
      'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
      'taxonomies' => array('post_tag','category' ),
      'hierarchical'        => false,
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => 5,
      'menu_icon'           => 'dashicons-info',
      'can_export'          => true,
      'has_archive'         => true,
      'exclude_from_search' => false,
      'publicly_queryable'  => true,
      'capability_type'     => 'post',
      'show_in_rest' => true,
    );
    register_post_type( 'grades', $args );
  }
  add_action('init','custom_post_grades',0);

  //option for featured images
  add_theme_support('post-thumbnails');

  //option page acf
  if (function_exists('acf_add_options_page')) {
    $parent = acf_add_options_page(
        array(
            'page_title'  => __('Theme General Settings'),
            'menu_title'  => __('Options'),
            'redirect'    => false,
        )
    );
    $childA = acf_add_options_sub_page(array(
        'page_title'  => __('Common Settings'),
        'menu_title'  => __('Common'),
        'parent_slug' => $parent['menu_slug'],
    ));
  }
?>