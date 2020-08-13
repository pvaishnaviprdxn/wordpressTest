<?php 
  $cat_args = array(
    'post_type' => 'grades',
    'exclude' => array(1),
    'option_All' => 'All',
  );
  $categories = get_categories($cat_args); 
  $term_link = get_term_link( $categories ); 
?>
  <?php if($categories) { ?>
    <section class="categories-dropdown">
      <div class="wrapper">
        <select id="grades-category">
          <option class="grades">All</option>
          <?php 
            foreach($categories as $cat) { ?>
              <option class="grades" value="<?php echo $cat->term_id; ?>"><?php echo $cat->name;?></option>
            <?php }
          ?>
        </select>
      </div>
    </section>
  <?php } ?>
