 <?php
	/*
  Template Name: Single Recipes Post
  Template Post Type: recipes
  */
	get_header();

	$thumbnail_id = get_post_thumbnail_id(get_the_ID());
	$gallery = get_post_meta(get_the_ID(), '_recipes_gallery', true);
	?>
 <section class="single-recipe">
 	<div class="container single-recipe__inner">
 		<div class="single-recipe__figure-wrap">
 			<figure class="single-recipe__figure single-product-slider">
 				<?php
					if (!empty($thumbnail_id)) {
						echo wp_get_attachment_image($thumbnail_id, 'full', false, array('alt' => 'Recipe Thumbnail', 'class' => ''));
					}
					if (!empty($gallery)) {


						// Loop through the gallery images and display them
						foreach ($gallery as $image_id) {
							echo wp_get_attachment_image($image_id, 'full', false, array('alt' => 'Recipe Image', 'class' => ''));
						}
					}
					?>
 			</figure>
 			<figure class="single-recipe__thumb single-product-thumb">
 				<?php
					if (!empty($thumbnail_id)) {
						echo wp_get_attachment_image($thumbnail_id, 'thumbnail', false, array('alt' => 'Recipe Thumbnail', 'class' => ''));
					}
					if (!empty($gallery)) {


						// Loop through the gallery images and display them
						foreach ($gallery as $image_id) {
							echo wp_get_attachment_image($image_id, 'full', false, array('alt' => 'Recipe Image', 'class' => ''));
						}
					}
					?>
 			</figure>
 		</div>
 		<div class="single-recipe__context">
			    <h1 class="single-recipe__title"><?php echo get_the_title(); ?></h1>
 			<?php the_content(); ?>
 		</div>
 	</div>
 </section>
 <?php

 get_footer();