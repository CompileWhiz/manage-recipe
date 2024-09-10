<?php


$args = array(
	'post_type' => 'recipes',
	'posts_per_page' => -1,
	'orderby'    => 'date',
	'order'      => 'DESC',
);

$query = new WP_Query($args);
$terms = get_terms(array(
	'taxonomy' => '_categories',
	'hide_empty' => true,
	'orderby'    => 'term_id',
	'order'      => 'ASC',
));
?>
<section class="recipe">
	<div class="container">
		<form action="#" class="recipe__filter">
			<div class="recipe__filter-btns-wrap">
				<ul class="recipe__filter-btns">
					<li>
						<a href="#" class="recipe__filter-btn active-btn recipe_cat_btn" data-category="all">
							<?php echo esc_html__('All Recipe', 'recipe-manager'); ?>
						</a>

					</li>

			<?php foreach ($terms as $term) : ?>
				<li>
					<a href="#" class="recipe__filter-btn recipe_cat_btn" data-category="<?php echo esc_attr($term->slug); ?>">
						<?php echo esc_html($term->name); ?></a>
				</li>

			<?php endforeach; ?>
			</ul>
			</div>
			<div class="recipe__filter-field">
				<input type="text" class="recipe__filter-search-input" />
				<button class="recipe__filter-search-submit" type="submit">
					<svg
						xmlns="http://www.w3.org/2000/svg"
						x="0px"
						y="0px"
						width="24"
						height="24"
						viewBox="0 0 30 30">
						<path
							d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z"></path>
					</svg>
				</button>
			</div>
		</form>

		<div class="recipe__cards">
			<?php         // Check if there are any posts
			$count = 1;
			if ($query->have_posts()) {
				while ($query->have_posts()) {
					$query->the_post();
					global $product;
					include RECIPE_PLUGIN_DIR . 'templates/recipe.php';
					$count++;
				}
			}
			// Restore original post data
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>