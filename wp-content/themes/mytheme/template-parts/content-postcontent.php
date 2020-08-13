<section class="posts-filter">
<?php 
$postsperpage = 6;
$args = array('post_type' => 'grades', 'posts_per_page' => $postsperpage);
$myQuery = new WP_Query($args);
if($myQuery->have_posts()) {
  while($myQuery->have_posts()) {
    $myQuery->the_post(); 
    $title= get_the_title();
    $excerpt = get_the_excerpt();
    $date = get_the_date();
    $featuredImage = get_the_post_thumbnail($page->ID, 'thumbnail', array( 'class' => 'featured-image' ) ); 
    $readbtn = get_field('read_more');
    $detailslink = get_the_permalink(); ?>
    
    <?php if ($title || $excerpt || $featuredImage) { ?>
      <div class="wrapper">
        <?php echo $featuredImage ? '<figure>'.$featuredImage.'</figure>' : null; ?>
        <?php echo $title ? '<h1><a href='.$detailslink.'>'.$title.'</a></h1>' : null ?>
        <?php echo $date ? '<span><strong>'.$date.'</strong></span>' : null ?>
        <?php echo $excerpt ? '<p>'.$excerpt.'</p>' : null ?>

        
        
      </div>
    <?php } 
  }
  wp_reset_query();
}
?>
</section>

