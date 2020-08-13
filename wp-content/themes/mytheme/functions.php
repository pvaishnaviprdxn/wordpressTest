<?php 
  //enqueued stylesheets
  function addStylesheet() {
    wp_enqueue_style('theme-style',get_stylesheet_uri(),array(),1.0);
  }
  add_action('wp_enqueue_scripts','addStylesheet');

  

?>