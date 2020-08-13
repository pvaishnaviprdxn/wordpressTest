<?php 
$featured_posts = get_field('related_posts');
$title = get_field('title');
if( $featured_posts || $title ) { ?>
  <section class="realted-posts">
    <div class="wrapper">
      <?php
        if ($title) {
          echo $title ? '<h2>'.$title.'</h2>' : null;
        } else {
          echo "<h2>Related Posts</h2>";
        }
      ?>
      <ul>
        <?php foreach( $featured_posts as $featured_post ) {
            $permalink = get_permalink( $featured_post->ID );
            $title = get_the_title( $featured_post->ID );
            $featuredImage = get_the_post_thumbnail($featured_post->ID);
          ?>
            <li>              
              <?php echo $featuredImage ? '<figure class="featured-image">'.$featuredImage.'</figure>' : null; ?>
              <?php if($title) { ?> 
                <h3><a href="<?php echo $permalink ?>"><?php echo $title; ?></a></h3> 
              <?php } ?>
            </li>
        <?php } ?>
      </ul>
    </div>
  </section>
<?php }
?>