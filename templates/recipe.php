		<?php

		$thumbnail_id = get_post_thumbnail_id(get_the_ID());
		$gallery = get_post_meta(get_the_ID(), '_recipes_gallery', true);
		?>
		<div class="recipe__card">
			<figure class="recipe__card-figure">
				<?php
				// Display the featured image (thumbnail)
				if (!empty($thumbnail_id)) {
					// Get the alt text for the featured image
					$thumbnail_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
					$thumbnail_alt = !empty($thumbnail_alt) ? esc_attr($thumbnail_alt) : '';
					$thumbnail_url =  wp_get_attachment_image_url($thumbnail_id, 'full');
					echo '<a href="' . $thumbnail_url . '" data-gallery="group' . $count . '" class="recipe__card-thumb glightbox">
						<img src="' . $thumbnail_url . '" alt="' . $thumbnail_alt . '" />
					</a>';
				}

				// Display gallery images if available
				if (!empty($gallery) && is_array($gallery)) {
					foreach ($gallery as $image_id) {
						$image_url =  wp_get_attachment_image_url($image_id, 'full');
						echo '<a data-gallery="group' . $count . '" class="hidden glightbox" href="' . $image_url . '"></a>';
					}
				}
				?>
			</figure>
			<div class="recipe__card-context">
				<a href="<?php the_permalink() ?>" class="recipe__card-title">
					<?php echo get_the_title() ?>
				</a>
			</div>
		</div>