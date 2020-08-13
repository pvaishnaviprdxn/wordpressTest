<?php 
get_header() ?>
<section>
<div class="wrapper">
<?php 
  if(have_posts()) {
    while(have_posts()) {
      the_post(); 
      $permalink = get_the_permalink();
      $title = get_the_title();
      $content = get_the_content();
      echo $title ? '<h1><a href="'.$permalink.'">'.$title.'</a></h1>' : null;
      echo $content ? '<p>'.$content.'</p>' : null;
    }
  }  
get_footer();
?>