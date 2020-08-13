<?php 
get_header();
if(have_posts()) {
  while(have_posts()) {
    the_post();
    $content = get_the_content(); 
    echo $content ? '<div class="wrapper>'.$content.'</div>' : null; 
  } 
} 
get_footer();
?>