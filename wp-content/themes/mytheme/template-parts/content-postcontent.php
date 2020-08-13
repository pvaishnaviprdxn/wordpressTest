<section class="posts-filter">
<div class="wrapper">
<ul class="posts-grades">
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
    $showbtn = get_field('cta_buttons');
    $detailslink = get_the_permalink(); ?>
    <?php if ($title || $excerpt || $featuredImage) { ?>
        <li>
          <?php 
            echo $featuredImage ? '<figure>'.$featuredImage.'</figure>' : null; 
            echo $title ? '<h2><a href='.$detailslink.'>'.$title.'</a></h2>' : null; 
            echo $date ? '<p class="date"><strong>'.$date.'</strong></p>' : null;
            echo $excerpt ? '<p class="excerpt">'.$excerpt.'</p>' : null;
            if ($showbtn) {
              foreach ($showbtn as $bt ) {
                $btn = $bt['button'];
                echo $btn ? '<a href="'.$detailslink.'">'.$btn.'</a>' : null;
              }
            } 
            else { ?>
              <a href="<?php echo $detailslink ?>">Show More</a>
            <?php }
          ?>
        </li>
    <?php } 
  }
  wp_reset_query();
}
?>
</ul>
</div>
</section>



