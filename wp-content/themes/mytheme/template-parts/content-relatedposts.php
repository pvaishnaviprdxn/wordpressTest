<?php 
$featured_posts = get_field('related_posts');
$title = get_field('title');
if( $featured_posts && $title ) { ?>
  <section class="realted-posts">
    <div class="wrapper">
      <h2><?php echo $title; ?></h2>
      <ul>
        <?php foreach( $featured_posts as $featured_post ) {
            $permalink = get_permalink( $featured_post->ID );
            $title = get_the_title( $featured_post->ID );
            $custom_field = get_field( 'content', $featured_post->ID );
            $excerpt = get_the_excerpt($featured_post->ID);
            ?>
            <li>
                <h3><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a></h3>
                <?php echo $excerpt ? '<p>'.$excerpt.'</p>' : null; ?>
            </li>
        <?php } ?>
      </ul>
    </div>
  </section>
<?php }
?>