<!doctype html>
<html lang="en">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width">
  <title><?php bloginfo('name'); ?></title>
  <?php wp_head(); ?>
</head>
<body>
  <div class="container">
    <header>
      <div class="wrapper">
        <h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
        <?php 
          if (function_exists('new_menu')) { 
            new_menu();  
          }
          else {
            $args = array('theme_location' => 'primary');
            wp_nav_menu($args);
          }
        ?>
      </div>
    </header>
    <main>