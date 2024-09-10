<?php

namespace Recipe_Manager\Includes;

defined('ABSPATH') || die();

class Short_Code {
	public function __construct() {
		// Register shortcode
		add_shortcode('recipe', [$this, 'render_recipe']);

	}
	public function render_recipe() {
		ob_start();
		include_once RECIPE_PLUGIN_DIR . 'templates/frontend.php';
		return ob_get_clean();
	}
}