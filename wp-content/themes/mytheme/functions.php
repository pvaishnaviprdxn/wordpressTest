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
          $menu_list .= "\t\t\t\t\t". '<li><a href="'. $url .'">'. $title .' </a></li>' ."\n";
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
  
  function category_scripts() {
    wp_enqueue_script('ajax', get_template_directory_uri().'/assets/script.js',array('jquery'),NULL,true); 
    wp_localize_script( 'ajax', 'wpAjax', array( 'ajaxUrl' => admin_url('admin-ajax.php')));
  }
  add_action('wp_enqueue_scripts', 'category_scripts');


  //dropdown functionality
  function filterAjax() {
    $category = $_POST['category'];
    $postsperpage = 6;
    $args = array('post_type' => 'grades', 'posts_per_page' => $postsperpage);

    if(isset($category)) {
      $args['category__in'] = array($category);
    }
    if($category == 'All') {
      get_template_part('template-parts/content','postcontent');
    } ?>
    <section class="posts-filter">
      <div class="wrapper">
        <ul class="posts-grades">
          <?php 
            $myQuery = new WP_Query($args);
            if($myQuery->have_posts()) {
              while($myQuery->have_posts()) {
                $myQuery->the_post(); 
                $title= get_the_title();
                $excerpt = get_the_excerpt();
                $date = get_the_date();
                $featuredImage = get_the_post_thumbnail($page->ID, 'thumbnail', array( 'class' => 'featured-image' ) ); 
                $showbtn = get_field('cta_buttons');
                $detailslink = get_the_permalink(); ?>
                <?php 
                  if ($title || $excerpt || $featuredImage) { ?>
                    <li>
                      <?php 
                        echo $featuredImage ? '<figure>'.$featuredImage.'</figure>' : null; 
                        echo $title ? '<h2><a href='.$detailslink.'>'.$title.'</a></h2>' : null; 
                        echo $date ? '<span><strong>'.$date.'</strong></span>' : null;
                        echo $excerpt ? '<p>'.$excerpt.'</p>' : null;
                        if ($showbtn) {
                          foreach ($showbtn as $bt ) {
                            $btn = $bt['button'];
                            echo $btn ? '<a href="'.$detailslink.'" class="load-posts">'.$btn.'</a>' : null;
                          }
                        } 
                      ?>
                    </li>
              <?php } 
              }
            }
           ?>
        </ul>
      </div>
    </section>
  <?php }
  add_action('wp_ajax_nopriv_filter','filterAjax');
  add_action('wp_ajax_filter','filterAjax');

  //for all category
  function more_post_ajax() {
    $ppp = (isset($_POST["ppp"])) ? $_POST["ppp"] : 6;
    $page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;

    $args = array(
        'suppress_filters' => true,
        'post_type' => 'grades',
        'posts_per_page' => $ppp,
        'paged'    => $page,
    );
  
    $loop = new WP_Query($args);
    if ($loop->have_posts()) {
      while ($loop->have_posts()) {
        $loop->the_post();
        $title= get_the_title();
        $excerpt = get_the_excerpt();
        $date = get_the_date();
        $featuredImage = get_the_post_thumbnail($page->ID, 'thumbnail', array( 'class' => 'featured-image' ) ); 
        $readbtn = get_field('read_more');
        $detailslink = get_the_permalink(); ?> 
        <?php if ($title && $excerpt && $featuredImage) { ?>
          <div class="wrapper">
            <figure>
              <?php echo $featuredImage; ?>
            </figure>
            <h1><a href="<?php echo $detailslink; ?>"><?php echo $title; ?></a></h1>
            <span class="date"><strong><?php echo $date; ?></strong></span>
            <p><?php echo substr($excerpt,0,20); ?></p>
            <?php if($readbtn) { ?>
              <a href="<?php echo $detailslink; ?>"><?php echo $readbtn; ?></a>
            <?php } ?>
          </div>
        <?php }  
      } 
    } ?>
    <?php wp_reset_postdata();
    die($out);
  }
  
  add_action('wp_ajax_nopriv_more_post_ajax', 'more_post_ajax');
  add_action('wp_ajax_more_post_ajax', 'more_post_ajax');

?>