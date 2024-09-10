<?php

namespace Recipe_Manager\Includes;

defined('ABSPATH') || die();

class Ajax {
	public function __construct() {
		add_action('wp_ajax_get_product_by_cat', [$this, 'get_product_by_cat']);
		add_action('wp_ajax_nopriv_get_product_by_cat', [$this, 'get_product_by_cat']);

	}

	public function get_product_by_cat() {
		$cat = $_POST['cat'] ?? '';
		$s = $_POST['s'] ?? '';
		$args = [
			'post_type' => 'recipes',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'tax_query' => [],
		];
		if ("all" !== $cat) {
			$args['tax_query'][] = [
				'taxonomy' => '_categories',
				'field' => 'slug',
				'terms' => $cat,
			];
		}
		if (!empty($s)) {
			$args['s'] = $s;
		}
		$query = new \WP_Query($args);

		ob_start();
		$count = 1;
		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				include RECIPE_PLUGIN_DIR . 'templates/recipe.php';
				$count++;
			}
		}

		wp_reset_postdata(); // Rest Data

		$html = ob_get_clean();

		if (empty($html)) {
			$html =
				'<p style="text-align:center;"  class= "no-found" > No result found </p>';
		}

		wp_send_json(
			[
				'html' => $html,
				'susccess' => true,
			]
		);

		wp_die();
	}
}
