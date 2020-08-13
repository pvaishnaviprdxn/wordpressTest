<?php 
$title = get_the_title();
$content = get_field('post_content');
$featuredImage = get_the_post_thumbnail($page->ID, 'thumbnail', array( 'class' => 'featured-image' ) );
?>
<?php if($title && $content) { ?>
  <div class="wrapper">
    <?php 
      echo $title ? '<h2>'.$title.'</h2>' : null;
      echo $content ? '<div class="content">'.$content.'</div>' : null;
      echo $featuredImage ? '<figure>'.$featuredImage.'</figure>' : null;
    ?>
  </div>
  <?php
}
get_template_part('template-parts/content','relatedposts'); 
?>